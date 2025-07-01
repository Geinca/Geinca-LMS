<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session and check login
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$pdo = new PDO('mysql:host=localhost;dbname=lms', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ATTR_ERRMODE_EXCEPTION);

// Get user's enrolled courses with class details
$stmt = $pdo->prepare("
    SELECT uc.*, c.title, c.description, c.thumbnail 
    FROM user_courses uc
    JOIN classes c ON uc.course_id = c.id
    WHERE uc.user_id = ? AND uc.is_active = 1 AND uc.expiry_date > NOW()
    ORDER BY uc.enrolled_at DESC
");
$stmt->execute([$_SESSION['user_id']]);
$enrolledCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Learning - LearnHub</title>
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/navpro.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .course-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .progress-bar {
            height: 6px;
            background-color: #e5e7eb;
            border-radius: 3px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background-color: #3B82F6;
            border-radius: 3px;
        }
    </style>
</head>
<body class="bg-gray-50">
    <header id="header">
        <nav class="navbar">
            <a href="index.php" class="logo">
                <i class="fas fa-graduation-cap"></i>
                <span>LearnHub</span>
            </a>
            
            <ul class="nav-links">
                <li><a href="classes.php">Courses</a></li>
                <li><a href="my_learning.php" class="font-semibold text-blue-600">My Learning</a></li>
                <li><a href="#">Teach</a></li>
                <li><a href="#">Business</a></li>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="login-btn">Login</a></li>
                    <li><a href="signup.php" class="signup-btn">Sign Up</a></li>
                <?php endif; ?>
            </ul>
            
            <div class="nav-actions">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search for courses">
                </div>
                
                <div class="user-avatar">
                    <?= isset($_SESSION['user_name']) ? strtoupper(substr($_SESSION['user_name'], 0, 1)) : '?' ?>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">My Learning</h1>
            <div class="text-sm text-gray-500">
                <?= count($enrolledCourses) ?> enrolled course(s)
            </div>
        </div>
        
        <?php if(empty($enrolledCourses)): ?>
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <i class="fas fa-book-open text-5xl text-gray-400 mb-4"></i>
                <h2 class="text-xl font-semibold mb-2">No courses enrolled yet</h2>
                <p class="text-gray-600 mb-4">Explore our courses and start learning today!</p>
                <a href="classes.php" class="px-4 py-2 bg-blue-600 text-white rounded-lg inline-block hover:bg-blue-700 transition">
                    Browse Courses
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach($enrolledCourses as $course): ?>
                    <div class="course-card bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="relative">
                            <img src="<?= htmlspecialchars($course['thumbnail'] ?? 'assets/images/course-placeholder.jpg') ?>" 
                                 alt="<?= htmlspecialchars($course['title']) ?>" 
                                 class="w-full h-48 object-cover">
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                                <span class="text-white font-semibold">
                                    <?= $course['subscription_type'] === 'monthly' ? '30-Day Access' : '1-Year Access' ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2"><?= htmlspecialchars($course['title']) ?></h3>
                            <p class="text-gray-600 mb-4 line-clamp-2"><?= htmlspecialchars($course['description']) ?></p>
                            
                            <!-- Progress bar (you can implement actual progress tracking) -->
                            <div class="mb-4">
                                <div class="flex justify-between text-sm text-gray-500 mb-1">
                                    <span>Progress</span>
                                    <span>25%</span> <!-- Replace with actual progress -->
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 25%"></div>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <p class="text-sm text-gray-500">Enrolled on</p>
                                    <p class="text-sm font-medium">
                                        <?= date('d M Y', strtotime($course['enrolled_at'])) ?>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">Expires on</p>
                                    <p class="text-sm font-medium">
                                        <?= date('d M Y', strtotime($course['expiry_date'])) ?>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex space-x-2">
                                <a href="classes.php?id=<?= $course['course_id'] ?>" 
                                   class="flex-1 text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                    Continue
                                </a>
                                <button class="px-3 py-2 border rounded-lg hover:bg-gray-50">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>