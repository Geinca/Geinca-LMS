<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
    header('Location: ../login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Enrolled Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: #fff;
        }
        .sidebar a {
            color: #fff;
            padding: 15px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            flex: 1;
            padding: 30px;
            background-color: #f8f9fa;
        }
        .card img {
            height: 180px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center py-3">Student Panel</h4>
        <a href="dashboard.php">Dashboard</a>
        <a href="enrolled_courses.php" class="bg-secondary">Enrolled Courses</a>
        <a href="wishlist.php">Wishlist</a>
        <a href="recommendations.php">Recommendations</a>
        <a href="course_player.php">Course Player</a>
        <a href="quiz.php">Quiz</a>
        <a href="progress.php">Progress</a>
        <a href="discussion.php">Discussion</a>
        <a href="certificate.php">Certificate</a>
        <a href="../logout.php">Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <h2>Enrolled Courses</h2>
        <p class="text-muted">Here are the courses you are currently enrolled in.</p>

        <div class="row">
            <!-- Dummy Course 1 -->
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <img src="https://miro.medium.com/v2/resize:fit:600/0*DdcDyaHk2n4yIDQI.png" class="card-img-top" alt="Course 1">
                    <div class="card-body">
                        <h5 class="card-title">HTML & CSS Basics</h5>
                        <p class="card-text">Build strong foundations in front-end development.</p>
                        <a href="course_player.php?course_id=1" class="btn btn-primary btn-sm">Start Course</a>
                    </div>
                </div>
            </div>

            <!-- Dummy Course 2 -->
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <img src="https://bairesdev.mo.cloudinary.net/blog/2023/08/What-Is-JavaScript-Used-For.jpg?tx=w_1920,q_auto" class="card-img-top" alt="Course 2">
                    <div class="card-body">
                        <h5 class="card-title">JavaScript Mastery</h5>
                        <p class="card-text">Take your JavaScript skills to the next level.</p>
                        <a href="course_player.php?course_id=2" class="btn btn-primary btn-sm">Start Course</a>
                    </div>
                </div>
            </div>

            <!-- Dummy Course 3 -->
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <img src="https://i0.wp.com/www.virtono.com/community/wp-content/uploads/2016/08/php___mysql_wallpaper_by_milesandryprower-d9o6yat.png?fit=1024%2C576&ssl=1" class="card-img-top" alt="Course 3">
                    <div class="card-body">
                        <h5 class="card-title">PHP & MySQL</h5>
                        <p class="card-text">Learn backend development with PHP and MySQL.</p>
                        <a href="course_player.php?course_id=3" class="btn btn-primary btn-sm">Start Course</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
