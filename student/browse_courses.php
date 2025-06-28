<?php
// session_start();
// if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
//     header('Location: ../login.php');
//     exit;
// }

// In a real app, you'd fetch courses from database
$courses = [
    [
        "id" => 1,
        "title" => "UI UX Design",
        "videos" => 130,
        "rating" => "4.5 (223)",
        "price" => 1, // ₹1 for demo
        "img" => "https://th.bing.com/th/id/OIP.doYHfVKgVncrGIL5jmSOMgHaE8?w=276&h=184&c=7&r=0&o=5&dpr=1.3&pid=1.7"
    ],
    [
        "id" => 2,
        "title" => "Python",
        "videos" => 130,
        "rating" => "4.5 (30)",
        "price" => 1,
        "img" => "https://th.bing.com/th/id/OIP.XTRl4rwNqniKlEtc6swCMgHaE8?w=231&h=180&c=7&r=0&o=5&dpr=1.3&pid=1.7"
    ],
    [
        "id" => 3,
        "title" => "Figma",
        "videos" => 130,
        "rating" => "4.5 (200)",
        "price" => 1,
        "img" => "https://kajabi-storefronts-production.kajabi-cdn.com/kajabi-storefronts-production/sites/2147591000/images/kbN4A0GPTNGOna0NjzxY_file.jpg"
    ],
    [
        "id" => 4,
        "title" => "iOS Development",
        "videos" => 130,
        "rating" => "4.5 (23)",
        "price" => 1,
        "img" => "https://www.webdschool.com/img/ios-app-development.jpg"
    ],
    [
        "id" => 5,
        "title" => "Android App",
        "videos" => 130,
        "rating" => "4.5 (123)",
        "price" => 1,
        "img" => "https://images.prismic.io//intuzwebsite/2caf3e7f-1704-42e2-908f-3d089da3e3ac_The+Ultimate+Guide+to+Android+App+Development.png?w=1200&q=75&auto=format,compress&fm=png8"
    ],
    [
        "id" => 6,
        "title" => "Digital Marketing",
        "videos" => 130,
        "rating" => "4.5 (123)",
        "price" => 1,
        "img" => "https://digitallearning.eletsonline.com/wp-content/uploads/2019/04/Digital-Marketing.jpg"
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>All Courses</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="bg-gray-50 font-sans text-gray-800">
    <?php include '../partials/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="ml-64 md:ml-64 p-4 md:p-8">
        <h2 class="text-2xl md:text-3xl font-bold text-left mb-8 text-gray-800">All Courses</h2>
        
        <?php if (isset($_GET['payment_success']) && isset($_GET['course_id'])): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>Payment successful! You are now enrolled in the course.</p>
                <a href="course_player.php?course_id=<?= htmlspecialchars($_GET['course_id']) ?>" 
                   class="text-blue-600 hover:underline mt-2 inline-block">
                    Start Learning Now
                </a>
            </div>
        <?php endif; ?>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach ($courses as $course): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 h-full flex flex-col">
                    <img src="<?= htmlspecialchars($course['img']) ?>" 
                         class="w-full h-48 object-cover" 
                         alt="<?= htmlspecialchars($course['title']) ?>"
                         onerror="this.onerror=null; this.src='https://via.placeholder.com/300x150?text=Course';">
                    
                    <div class="p-4 flex-grow flex flex-col">
                        <h5 class="text-lg font-bold text-blue-800 truncate mb-2">
                            <?= htmlspecialchars($course['title']) ?>
                        </h5>
                        <p class="text-gray-600 mb-2"><?= $course['videos'] ?> Videos</p>
                        <p class="text-gray-800 font-semibold mt-auto">₹<?= $course['price'] ?></p>
                    </div>
                    
                    <div class="px-4 py-3 bg-gray-50 flex justify-between items-center">
                        <span class="text-y-400 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span class="ml-1"><?= htmlspecialchars($course['rating']) ?></span>
                        </span>
                        
                        <button onclick="payNow(<?= $course['id'] ?>, '<?= htmlspecialchars(addslashes($course['title'])) ?>')" 
                                class="bg-blue-800 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm font-medium transition-colors">
                            Enroll Now (₹<?= $course['price'] ?>)
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
    function payNow(courseId, courseTitle) {
        var options = {
            "key": "rzp_test_PID2AI2BLrj6s6", // Replace with your Razorpay test key
            "amount": 1 * 100, // ₹1 in paise
            "currency": "INR",
            "name": "Course Enrollment",
            "description": "Payment for " + courseTitle,
            "image": "https://your-logo-url.com/logo.png", // Add your logo
            "handler": function (response) {
                // On successful payment
                window.location.href = "<?= $_SERVER['PHP_SELF'] ?>?payment_success=1&course_id=" + courseId;
            },
            "prefill": {
                "name": "Student Name", // You can prefill with actual student name
                "email": "student@example.com",
                "contact": "9999999999"
            },
            "theme": {
                "color": "#4f46e5"
            }
        };
        
        var rzp = new Razorpay(options);
        rzp.open();
        
        rzp.on('payment.failed', function (response) {
            alert("Payment failed. Please try again.");
            console.error(response.error);
        });
    }
    </script>
</body>
</html>