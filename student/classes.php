<?php
// Database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=lms', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Automatically update expired live sessions
try {
    $updateStmt = $pdo->prepare("UPDATE lessons SET is_live = 0 WHERE is_live = 1 AND live_end < NOW()");
    $updateStmt->execute();
} catch (PDOException $e) {
    error_log("Error updating live sessions: " . $e->getMessage());
}

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle Razorpay payment verification (server-side)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['razorpay_payment_id'])) {
    session_start();
    
    $courseId = (int)$_POST['courseId'];
    $subscriptionType = $_POST['subscriptionType'];
    $email = $_POST['email'];
    
    // Calculate expiry date
    $expiryDate = new DateTime();
    if ($subscriptionType === 'monthly') {
        $expiryDate->modify('+30 days');
    } else {
        $expiryDate->modify('+365 days');
    }
    
    // Store enrollment in database
    try {
        $stmt = $pdo->prepare("INSERT INTO user_courses (user_email, course_id, subscription_type, expiry_date) 
                              VALUES (?, ?, ?, ?) 
                              ON DUPLICATE KEY UPDATE 
                              subscription_type = VALUES(subscription_type), 
                              expiry_date = VALUES(expiry_date)");
        $stmt->execute([$email, $courseId, $subscriptionType, $expiryDate->format('Y-m-d H:i:s')]);
        
        // Also store in session for immediate access
        $_SESSION['enrolled'][$courseId] = [
            'type' => $subscriptionType,
            'expiry' => $expiryDate->format('Y-m-d H:i:s'),
            'email' => $email
        ];
        
        // Return success response
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    } catch (PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        exit;
    }
}

// Function to convert YouTube/Vimeo URLs to embed format
function convertToEmbedUrl($url) {
    if (empty($url)) return '';
    
    if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
        return "https://www.youtube.com/embed/{$matches[1]}?autoplay=1&rel=0";
    }
    elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
        return "https://www.youtube.com/embed/{$matches[1]}?autoplay=1&rel=0";
    }
    elseif (preg_match('/vimeo\.com\/([0-9]+)/', $url, $matches)) {
        return "https://player.vimeo.com/video/{$matches[1]}?autoplay=1";
    }
    return $url;
}

// Validate course ID
$courseId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($courseId <= 0) {
    die("Invalid course ID");
}

// Check enrollment status
session_start();
$isEnrolled = false;
$subscriptionType = null;
$expiryDate = null;

// First check session
if (isset($_SESSION['enrolled'][$courseId])) {
    $expiryDate = new DateTime($_SESSION['enrolled'][$courseId]['expiry']);
    $currentDate = new DateTime();
    
    if ($currentDate <= $expiryDate) {
        $isEnrolled = true;
        $subscriptionType = $_SESSION['enrolled'][$courseId]['type'];
    } else {
        unset($_SESSION['enrolled'][$courseId]);
    }
}

// If not in session or expired, check database
if (!$isEnrolled && isset($_SESSION['user_email'])) {
    try {
        $stmt = $pdo->prepare("SELECT subscription_type, expiry_date 
                              FROM user_courses 
                              WHERE user_email = ? AND course_id = ?");
        $stmt->execute([$_SESSION['user_email'], $courseId]);
        $enrollment = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($enrollment) {
            $expiryDate = new DateTime($enrollment['expiry_date']);
            $currentDate = new DateTime();
            
            if ($currentDate <= $expiryDate) {
                $isEnrolled = true;
                $subscriptionType = $enrollment['subscription_type'];
                // Store in session for faster access
                $_SESSION['enrolled'][$courseId] = [
                    'type' => $subscriptionType,
                    'expiry' => $enrollment['expiry_date'],
                    'email' => $_SESSION['user_email']
                ];
            }
        }
    } catch (PDOException $e) {
        error_log("Enrollment check error: " . $e->getMessage());
    }
}

try {
    // Get course details
    $stmt = $pdo->prepare("SELECT id, title, description FROM courses WHERE id = ?");
    $stmt->execute([$courseId]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$course) {
        die("Course with ID $courseId not found in the database.");
    }

    // Get lessons for this course
   $lessons = $pdo->prepare("SELECT id, course_id, title, description, video_url, duration, position, 
                         is_preview, date, time, is_live, live_date, live_end 
                         FROM lessons 
                         WHERE course_id = ? 
                         AND (is_live = 0 OR (is_live = 1 AND live_date <= NOW() AND live_end >= NOW()))
                         ORDER BY position");
$lessons->execute([$courseId]);
$section = [
    'lessons' => $lessons->fetchAll(PDO::FETCH_ASSOC),
    'title' => $course['title']
];
    
    // Check for live lessons
    $currentDateTime = new DateTime();
    foreach ($section['lessons'] as &$lesson) {
        $lesson['is_live_now'] = false;
        
        if ($lesson['is_live']) {
            try {
                $liveStart = new DateTime($lesson['live_date']);
                $liveEnd = new DateTime($lesson['live_end']);
                
                if ($currentDateTime >= $liveStart && $currentDateTime <= $liveEnd) {
                    $lesson['is_live_now'] = true;
                }
            } catch (Exception $e) {
                error_log("Invalid date format for lesson {$lesson['id']}: " . $e->getMessage());
            }
        }
    }
    unset($lesson);
    
    // Mark first lesson as free preview if not enrolled
    if (!empty($section['lessons']) && !$isEnrolled) {
        $section['lessons'][0]['is_preview'] = true;
    }

    // Set default video (first lesson)
    $currentVideo = [
        'url' => '',
        'embed_url' => '',
        'title' => 'Select a lesson',
        'description' => '',
        'is_locked' => false,
        'is_live' => false,
        'live_date' => null,
        'live_end' => null
    ];

    if (!empty($section['lessons'][0])) {
        $firstLesson = $section['lessons'][0];
        $currentVideo = [
            'url' => $firstLesson['video_url'],
            'embed_url' => convertToEmbedUrl($firstLesson['video_url']),
            'title' => $firstLesson['title'],
            'description' => $firstLesson['description'],
            'is_locked' => false,
            'is_live' => $firstLesson['is_live_now'],
            'live_date' => $firstLesson['live_date'],
            'live_end' => $firstLesson['live_end']
        ];
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($course['title']) ?> - Learning Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Your existing styles */
        .lesson-item.active { background-color: #EFF6FF; border-left: 4px solid #3B82F6; }
        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
        }
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }
        .locked-lesson {
            position: relative;
            background-color: #f9fafb;
        }
        .locked-lesson::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.8);
        }
        .lock-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
        }
        .subscription-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .subscription-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-color: #3B82F6;
        }
        .subscription-card.recommended {
            border-color: #10B981;
            position: relative;
            overflow: hidden;
        }
        .recommended-badge {
            position: absolute;
            top: 0;
            right: 0;
            background: #10B981;
            color: white;
            padding: 2px 10px;
            font-size: 12px;
            transform: translate(25%, -50%) rotate(45deg);
            transform-origin: bottom left;
            width: 100px;
            text-align: center;
        }
        /* .live-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #ff0000;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            z-index: 10;
        } */
        .live-views {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(0,0,0,0.6);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            z-index: 10;
        }

      .live-badge {
    background-color: #ff0000;
    color: white;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    margin-bottom: 5px;
}

.upcoming-badge {
    background-color: #3B82F6;
    color: white;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 12px;
    animation: pulse 2s infinite;
}

.ended-badge {
    background-color: #6B7280;
    color: white;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 12px;
    opacity: 0.8;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.6; }
    100% { opacity: 1; }
}



    </style>
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Video Player Section -->
            <div class="lg:w-2/3">
                <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
                    <div class="video-container">
                        <?php if ($currentVideo['embed_url']): ?>
                            <?php if ($currentVideo['is_live']): ?>
                                <div class="live-badge">LIVE</div>
                                <div class="live-views" id="liveViews"><?= rand(100, 500) ?> watching</div>
                            <?php endif; ?>
                            <iframe src="<?= htmlspecialchars($currentVideo['embed_url']) ?>" 
                                    id="videoPlayer"
                                    frameborder="0"
                                    allowfullscreen>
                            </iframe>
                        <?php else: ?>
                            <div class="absolute inset-0 flex items-center justify-center bg-gray-100">
                                <div class="text-center">
                                    <i class="fas fa-play-circle text-5xl text-gray-400 mb-4"></i>
                                    <p class="text-gray-500">Select a lesson to begin</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="p-6">
                        <h2 id="lessonTitle" class="text-2xl font-bold mb-2"><?= htmlspecialchars($currentVideo['title']) ?></h2>
                        <p id="lessonDescription" class="text-gray-600"><?= htmlspecialchars($currentVideo['description']) ?></p>
                        
                        <?php if ($currentVideo['is_live']): ?>
                            <div class="mt-2 flex items-center text-sm text-red-600">
                                <i class="fas fa-circle mr-2 animate-pulse"></i>
                                <span>Live now - Ends at <?= date('h:i A', strtotime($currentVideo['live_end'])) ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($isEnrolled): ?>
                            <div class="mt-4 p-3 bg-green-50 text-green-800 rounded-lg text-sm">
                                <i class="fas fa-check-circle mr-2"></i>
                                You have <?= $subscriptionType ?> access until <?= $expiryDate->format('d M Y') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Course Description and Payment Options -->
            <div class="lg:w-1/3">
                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">About This Course</h2>
                    <p class="text-gray-600"><?= htmlspecialchars($course['description']) ?></p>
                    
                    <?php if (!$isEnrolled): ?>
                        <!-- Subscription Options -->
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold mb-4">Choose Your Plan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Monthly Plan -->
                                <div class="subscription-card bg-white p-6 rounded-lg shadow-md border">
                                    <h4 class="text-xl font-bold mb-2">Monthly Plan</h4>
                                    <p class="text-3xl font-bold text-blue-600 mb-2">₹30</p>
                                    <p class="text-gray-600 mb-4">Access for 30 days</p>
                                    <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition enroll-button" 
                                            data-type="monthly" 
                                            data-price="30"
                                            data-course-id="<?= $courseId ?>">
                                        Choose Monthly
                                    </button>
                                </div>
                                
                                <!-- Yearly Plan -->
                                <div class="subscription-card recommended bg-white p-6 rounded-lg shadow-md border">
                                    <div class="recommended-badge">SAVE 17%</div>
                                    <h4 class="text-xl font-bold mb-2">Yearly Plan</h4>
                                    <p class="text-3xl font-bold text-green-600 mb-2">₹365</p>
                                    <p class="text-gray-600 mb-4">Access for 365 days</p>
                                    <button class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition enroll-button" 
                                            data-type="yearly" 
                                            data-price="365"
                                            data-course-id="<?= $courseId ?>">
                                        Choose Yearly
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Lessons Sidebar -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden sticky top-4">
                    <div class="p-4 border-b">
                        <h3 class="text-lg font-semibold">Course Content</h3>
                        <p class="text-sm text-gray-500 mt-1"><?= count($section['lessons'] ?? []) ?> lessons</p>
                        <?php if (!$isEnrolled): ?>
                            <div class="mt-2 text-sm text-yellow-600">
                                <i class="fas fa-lock mr-1"></i> Only first lesson is free
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="divide-y divide-gray-200">
                        <?php if (!empty($section['lessons'])): ?>
                         <?php foreach ($section['lessons'] as $index => $lesson): 
    $isLocked = !$isEnrolled && $index > 0;
    $embedUrl = $isLocked ? '' : convertToEmbedUrl($lesson['video_url']);
    $isLiveNow = $lesson['is_live_now'] ?? false;
?>
    <div class="lesson-item px-4 py-3 cursor-pointer transition-colors relative <?= ($lesson['video_url'] === $currentVideo['url']) ? 'active' : '' ?> <?= $isLocked ? 'locked-lesson' : 'hover:bg-blue-50' ?>"
        data-embed-url="<?= htmlspecialchars($embedUrl) ?>"
        data-lesson-title="<?= htmlspecialchars($lesson['title']) ?>"
        data-lesson-desc="<?= htmlspecialchars($lesson['description']) ?>"
        data-is-locked="<?= $isLocked ? 'true' : 'false' ?>"
        data-is-live="<?= $isLiveNow ? 'true' : 'false' ?>"
        data-live-date="<?= htmlspecialchars($lesson['live_date'] ?? '') ?>"
        data-live-end="<?= htmlspecialchars($lesson['live_end'] ?? '') ?>">
                                    
                                    <?php if ($isLocked): ?>
                                        <div class="lock-icon">
                                            <i class="fas fa-lock text-gray-400 text-xl"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="flex items-center justify-between <?= $isLocked ? 'opacity-50' : '' ?>">
                                        <div class="flex items-center">
                                            <i class="fas <?= $isLocked ? 'fa-lock' : 'fa-play-circle' ?> text-gray-400 mr-3"></i>
                                            <span><?= htmlspecialchars($lesson['title']) ?></span>
                                        </div>
                                        <span class="text-sm text-gray-500">
                                            <?= gmdate("i:s", $lesson['duration']) ?>
                                        </span>
                                    </div>
                                    <?php if ($index === 0 && !$isEnrolled): ?>
                                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full ml-8 mt-1 inline-block">Free Preview</span>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enrollment Modal -->
    <div id="enrollmentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 max-w-md w-full">
            <h3 class="text-xl font-bold mb-4" id="modalTitle">Confirm Enrollment</h3>
            <p class="mb-4">You are about to purchase <span id="subscriptionTypeText"></span> access for ₹<span id="subscriptionPrice"></span>.</p>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Enter your email:</label>
                <input type="email" id="userEmail" class="w-full px-3 py-2 border rounded-lg" placeholder="your@email.com">
            </div>
            
            <div class="flex justify-end space-x-3">
                <button id="cancelEnrollment" class="px-4 py-2 border rounded-lg">Cancel</button>
                <button id="confirmEnrollment" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Proceed to Payment</button>
            </div>
        </div>
    </div>

    <!-- Payment Success Modal -->
    <div id="paymentSuccessModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 max-w-md w-full text-center">
            <div class="text-green-500 text-5xl mb-4">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3 class="text-xl font-bold mb-2">Payment Successful!</h3>
            <p class="text-gray-600 mb-4">You now have full access to this course.</p>
            <button id="closeSuccessModal" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Continue Learning</button>
        </div>
    </div>

    <!-- Payment Failure Modal -->
    <div id="paymentFailureModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 max-w-md w-full text-center">
            <div class="text-red-500 text-5xl mb-4">
                <i class="fas fa-times-circle"></i>
            </div>
            <h3 class="text-xl font-bold mb-2">Payment Failed</h3>
            <p class="text-gray-600 mb-4" id="failureMessage">There was an issue processing your payment.</p>
            <button id="closeFailureModal" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Try Again</button>
        </div>
    </div>


    <!-- comments -->
     <!-- Fake Engagement Section -->
<div class="fixed bottom-0 right-0 w-full md:w-96 bg-white shadow-lg border-t border-gray-200 hidden" id="liveEngagement">
    <div class="p-4">
        <!-- Like Counter -->
        <div class="flex items-center mb-4">
            <button id="likeButton" class="text-2xl mr-2 focus:outline-none">
                <i class="far fa-heart"></i>
            </button>
            <span id="likeCount" class="font-semibold">0</span>
        </div>
        
        <!-- Live Comments Section -->
        <div class="mb-2">
            <h4 class="font-bold text-gray-700 mb-2">Live Chat</h4>
            <div class="h-64 overflow-y-auto border rounded-lg p-2 bg-gray-50" id="commentSection">
                <!-- Comments will appear here -->
            </div>
        </div>
        
        <!-- Fake Comment Input -->
        <div class="flex items-center">
            <input type="text" id="fakeCommentInput" class="flex-grow border rounded-l-lg px-3 py-2" placeholder="Add a comment...">
            <button id="fakeCommentBtn" class="bg-blue-500 text-white px-4 py-2 rounded-r-lg">Send</button>
        </div>
    </div>
</div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if user is logged in
            function isLoggedIn() {
                return localStorage.getItem('loggedIn') === 'true';
            }
            
            // Show login required popup
            function showLoginRequired() {
                alert('Please login to enroll in this course');
            }
            
            let selectedPlan = null;
            const enrollButtons = document.querySelectorAll('.enroll-button');
            const enrollmentModal = document.getElementById('enrollmentModal');
            const userEmailInput = document.getElementById('userEmail');
            const confirmEnrollment = document.getElementById('confirmEnrollment');
            
            // Set user email if logged in
            const userEmail = localStorage.getItem('userEmail');
            if (userEmail) {
                userEmailInput.value = userEmail;
            }
            
            // Handle enrollment button clicks
            enrollButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (!isLoggedIn()) {
                        showLoginRequired();
                        return;
                    }
                    
                    const planType = this.getAttribute('data-type');
                    const planPrice = this.getAttribute('data-price');
                    const courseId = this.getAttribute('data-course-id');
                    
                    // Store selected plan details
                    selectedPlan = {
                        type: planType,
                        price: planPrice,
                        courseId: courseId,
                        title: "<?= htmlspecialchars($course['title']) ?> - " + (planType === 'monthly' ? '30-day access' : '1-year access')
                    };
                    
                    // Update modal content
                    document.getElementById('subscriptionTypeText').textContent = 
                        planType === 'monthly' ? '30-day' : '1-year';
                    document.getElementById('subscriptionPrice').textContent = planPrice;
                    
                    // Show modal
                    enrollmentModal.classList.remove('hidden');
                });
            });
            
            // Cancel enrollment
            document.getElementById('cancelEnrollment').addEventListener('click', function() {
                enrollmentModal.classList.add('hidden');
            });
            
                       // Close failure modal
            document.getElementById('closeFailureModal').addEventListener('click', function() {
                document.getElementById('paymentFailureModal').classList.add('hidden');
            });

            // Confirm enrollment and process payment
            confirmEnrollment.addEventListener('click', function() {
                const email = userEmailInput.value.trim();
                
                if (!email) {
                    alert('Please enter your email address');
                    return;
                }
                
                const options = {
                    key: "rzp_test_kaFNrjpuEwSDoI", // Replace with your Razorpay test key
                    amount: selectedPlan.price * 100, // Razorpay uses paise
                    currency: "INR",
                    name: "Learning Portal",
                    description: selectedPlan.title,
                    image: "https://via.placeholder.com/150", // Your logo
                    handler: function(response) {
                        verifyPayment(response, email, selectedPlan);
                    },
                    prefill: {
                        name: localStorage.getItem('userName') || "Customer",
                        email: email,
                        contact: "9876543210"
                    },
                    notes: {
                        course_id: selectedPlan.courseId,
                        subscription_type: selectedPlan.type
                    },
                    theme: {
                        color: "#3399cc"
                    }
                };
                
                const rzp = new Razorpay(options);
                rzp.open();
                enrollmentModal.classList.add('hidden');
                
                rzp.on('payment.failed', function(response) {
                    document.getElementById('failureMessage').textContent = 
                        response.error.description || "Payment failed. Please try again.";
                    document.getElementById('paymentFailureModal').classList.remove('hidden');
                });
            });
            
            function verifyPayment(response, email, plan) {
                const formData = new FormData();
                formData.append('razorpay_payment_id', response.razorpay_payment_id);
                formData.append('razorpay_order_id', response.razorpay_order_id);
                formData.append('razorpay_signature', response.razorpay_signature);
                formData.append('courseId', plan.courseId);
                formData.append('subscriptionType', plan.type);
                formData.append('email', email);
                
                fetch(window.location.href, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('paymentSuccessModal').classList.remove('hidden');
                        // Refresh page after 3 seconds to show unlocked content
                        setTimeout(() => window.location.reload(), 3000);
                    } else {
                        document.getElementById('failureMessage').textContent = 
                            "Payment verification failed. Please contact support.";
                        document.getElementById('paymentFailureModal').classnt.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('failureMessage').textContent = 
                        "Error verifying payment. Please contact support.";
                    document.getElementById('paymentFailureModal').classList.remove('hidden');
                });
            }

            // Lesson selection functionality
            const lessonItems = document.querySelectorAll('.lesson-item');
            const videoPlayer = document.getElementById('videoPlayer');
            const lessonTitle = document.getElementById('lessonTitle');
            const lessonDescription = document.getElementById('lessonDescription');
            
            lessonItems.forEach(item => {
                item.addEventListener('click', function() {
                    const isLocked = this.getAttribute('data-is-locked') === 'true';
                    const embedUrl = this.getAttribute('data-embed-url');
                    const title = this.getAttribute('data-lesson-title');
                    const description = this.getAttribute('data-lesson-desc');
                    const isLive = this.getAttribute('data-is-live') === 'true';
                    
                    if (isLocked) {
                        if (!isLoggedIn()) {
                            showLoginRequired();
                        } else {
                            alert('Please enroll in the course to access this lesson');
                        }
                    } else {
                        // Update video player
                        if (videoPlayer) videoPlayer.src = embedUrl;
                        // Update lesson info
                        lessonTitle.textContent = title;
                        lessonDescription.textContent = description;
                        
                        // Update active state
                        lessonItems.forEach(i => i.classList.remove('active'));
                        this.classList.add('active');
                    }
                });
            });
            
            // Auto-select first lesson
            if (lessonItems.length > 0) {
                lessonItems[0].click();
            }
        });





      // Add this right after your existing JavaScript code

// Function to update live status in real-time
function updateLiveStatus() {
    const now = new Date();
    
    document.querySelectorAll('.lesson-item').forEach(item => {
        const liveDate = item.getAttribute('data-live-date');
        const liveEnd = item.getAttribute('data-live-end');
        
        if (!liveDate || !liveEnd) return;
        
        const startTime = new Date(liveDate);
        const endTime = new Date(liveEnd);
        
        // Remove any existing badges/countdowns
        item.querySelector('.live-badge')?.remove();
        item.querySelector('.live-views')?.remove();
        item.querySelector('.countdown')?.remove();
        item.querySelector('.live-ended')?.remove();
        
        // Check current status
        if (now >= startTime && now <= endTime) {
            // Lesson is live now
            item.setAttribute('data-is-live', 'true');
            
            // Add live badge if this is the active lesson
            if (item.classList.contains('active')) {
                const liveBadge = document.createElement('div');
                liveBadge.className = 'live-badge';
                liveBadge.textContent = 'LIVE';
                item.appendChild(liveBadge);
                
                const liveViews = document.createElement('div');
                liveViews.className = 'live-views';
                liveViews.id = 'liveViews';
                liveViews.textContent = `${Math.floor(Math.random() * 400) + 100} watching`;
                item.appendChild(liveViews);
            }
            checkEngagement();
        } 
        else if (now < startTime) {
            // Lesson is upcoming
            const timeDiff = startTime - now;
            const hours = Math.floor(timeDiff / (1000 * 60 * 60));
            const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
            
            const countdown = document.createElement('span');
            countdown.className = 'countdown text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full ml-8 mt-1 inline-block';
            countdown.textContent = `Live in ${hours}h ${minutes}m`;
            item.appendChild(countdown);
        }
        else if (now > endTime) {
            // Lesson live session has ended
            item.setAttribute('data-is-live', 'false');
            
            const endedBadge = document.createElement('span');
            endedBadge.className = 'live-ended text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded-full ml-8 mt-1 inline-block';
            endedBadge.textContent = 'Live Ended';
            item.appendChild(endedBadge);
        }
    });
}

// Run initially and every 30 seconds
updateLiveStatus();
setInterval(updateLiveStatus, 30000);

// Update video player when lesson goes live/ends
function checkActiveLessonStatus() {
    const activeLesson = document.querySelector('.lesson-item.active');
    if (!activeLesson) return;
    
    const isLive = activeLesson.getAttribute('data-is-live') === 'true';
    const embedUrl = activeLesson.getAttribute('data-embed-url');
    
    if (isLive && videoPlayer.src !== embedUrl) {
        videoPlayer.src = embedUrl;
    }
}

// Check every 15 seconds
setInterval(checkActiveLessonStatus, 15000);





// Add this to your script section
function monitorLiveLessons() {
    const now = new Date();
    
    // Check all lessons for live status
    document.querySelectorAll('.lesson-item').forEach(item => {
        const liveDateStr = item.getAttribute('data-live-date');
        const liveEndStr = item.getAttribute('data-live-end');
        
        if (!liveDateStr || !liveEndStr) return;
        
        const liveDate = new Date(liveDateStr);
        const liveEnd = new Date(liveEndStr);
        
        // Remove all status indicators
        item.querySelector('.live-badge')?.remove();
        item.querySelector('.live-views')?.remove();
        item.querySelector('.upcoming-badge')?.remove();
        item.querySelector('.ended-badge')?.remove();
        
        // Check current time against live window
        if (now >= liveDate && now <= liveEnd) {
            // Lesson is currently live
            item.style.display = 'block';
            item.setAttribute('data-is-live', 'true');
            
            const liveBadge = document.createElement('div');
            liveBadge.className = 'live-badge';
            liveBadge.innerHTML = '<i class="fas fa-circle mr-1"></i> LIVE';
            item.prepend(liveBadge);
            
            if (item.classList.contains('active')) {
                const videoPlayer = document.getElementById('videoPlayer');
                if (videoPlayer) {
                    videoPlayer.src = item.getAttribute('data-embed-url');
                }
            }
        } 
        else if (now < liveDate) {
            // Lesson is upcoming
            item.style.display = 'none'; // Hide until live time
        }
        else {
            // Lesson has ended
            item.style.display = 'block';
            item.setAttribute('data-is-live', 'false');
            
            const endedBadge = document.createElement('div');
            endedBadge.className = 'ended-badge text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded';
            endedBadge.textContent = 'Live Ended';
            item.prepend(endedBadge);
        }
    });
}


// comments
// Add this to your existing JavaScript

// Fake comments data
const fakeComments = [
    { name: "Rahul Sharma", text: "Amazing explanation bhai!" },
    { name: "Priya Patel", text: "Kya baat hai, mast samjha rahe ho" },
    { name: "Amit Singh", text: "Ye concept clear ho gaya" },
    { name: "Neha Gupta", text: "Please next topic bhi aise hi samjhaiye" },
    { name: "Vikas Kumar", text: "Sir, doubt hai thoda" },
    { name: "Anjali Mishra", text: "Recording milegi kya?" },
    { name: "Sanjay Verma", text: "Like karo sab log" },
    { name: "Pooja Reddy", text: "Thank you sir!" }
];

// Fake names for random comments
const fakeNames = [
    "Rohit", "Sneha", "Aryan", "Divya", "Karan", "Ananya", 
    "Vivek", "Shreya", "Raj", "Mehak", "Alok", "Ishita"
];

// Initialize engagement system
function initEngagement() {
    const engagementPanel = document.getElementById('liveEngagement');
    const commentSection = document.getElementById('commentSection');
    const likeButton = document.getElementById('likeButton');
    const likeCount = document.getElementById('likeCount');
    const fakeCommentBtn = document.getElementById('fakeCommentBtn');
    
    let likes = 0;
    let isLiked = false;
    
    // Show engagement panel only during live
    const activeLesson = document.querySelector('.lesson-item.active');
    if (activeLesson && activeLesson.getAttribute('data-is-live') === 'true') {
        engagementPanel.classList.remove('hidden');
        
        // Start auto comments
        startAutoComments();
        
        // Auto-increase likes
        setInterval(() => {
            likes += Math.floor(Math.random() * 3);
            likeCount.textContent = likes.toLocaleString();
        }, 3000);
    } else {
        engagementPanel.classList.add('hidden');
    }
    
    // Like button functionality
    likeButton.addEventListener('click', () => {
        if (isLiked) {
            likes--;
            likeButton.innerHTML = '<i class="far fa-heart"></i>';
        } else {
            likes++;
            likeButton.innerHTML = '<i class="fas fa-heart text-red-500"></i>';
        }
        isLiked = !isLiked;
        likeCount.textContent = likes.toLocaleString();
    });
    
    // Fake comment button
    fakeCommentBtn.addEventListener('click', () => {
        const input = document.getElementById('fakeCommentInput');
        if (input.value.trim()) {
            addComment("You", input.value);
            input.value = '';
            
            // Auto-reply after 2 seconds
            setTimeout(() => {
                const reply = getRandomReply();
                addComment("Instructor", reply);
            }, 2000);
        }
    });
}

// Start auto comments
function startAutoComments() {
    const commentSection = document.getElementById('commentSection');
    
    // Initial comments
    fakeComments.forEach((comment, index) => {
        setTimeout(() => {
            addComment(comment.name, comment.text);
        }, index * 3000);
    });
    
    // Keep adding random comments
    setInterval(() => {
        const randomName = fakeNames[Math.floor(Math.random() * fakeNames.length)];
        const randomText = getRandomComment();
        addComment(randomName, randomText);
    }, 5000);
}

// Add comment to section
function addComment(name, text) {
    const commentSection = document.getElementById('commentSection');
    const commentDiv = document.createElement('div');
    commentDiv.className = 'mb-2';
    commentDiv.innerHTML = `
        <span class="font-semibold">${name}:</span>
        <span class="text-gray-700">${text}</span>
    `;
    commentSection.appendChild(commentDiv);
    commentSection.scrollTop = commentSection.scrollHeight;
}

// Random comment generator
function getRandomComment() {
    const comments = [
        "Nice explanation!",
        "Thank you sir!",
        "Clear ho gaya",
        "Please repeat that",
        "Mast hai!",
        "👏👏👏",
        "Recording de dena",
        "Next topic kab hai?",
        "Doubt clear ho gaya",
        "Like for good teaching"
    ];
    return comments[Math.floor(Math.random() * comments.length)];
}

// Random reply generator
function getRandomReply() {
    const replies = [
        "Thank you!",
        "Sure, will cover that",
        "Any other doubts?",
        "Glad it helped!",
        "Recording will be shared",
        "Next topic coming soon",
        "Yes, correct!",
        "Good question!"
    ];
    return replies[Math.floor(Math.random() * replies.length)];
}

// Call this when live lesson starts
function checkEngagement() {
    const activeLesson = document.querySelector('.lesson-item.active');
    if (activeLesson && activeLesson.getAttribute('data-is-live') === 'true') {
        initEngagement();
    } else {
        document.getElementById('liveEngagement').classList.add('hidden');
    }
}


// Function to check if live session has ended
function checkLiveStatus() {
    const activeLesson = document.querySelector('.lesson-item.active');
    if (!activeLesson) return;
    
    const liveEnd = activeLesson.getAttribute('data-live-end');
    if (!liveEnd) return;
    
    const now = new Date();
    const endTime = new Date(liveEnd);
    
    if (now > endTime) {
        // Refresh the page to update status
        window.location.reload();
    }
}

// Check every 30 seconds (adjust as needed)
setInterval(checkLiveStatus, 30000);


    </script>
</body>
</html>