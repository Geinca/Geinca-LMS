<!-- <?php
// session_start();
// if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
//     header('Location: ./login.php');
//     exit;
// }
?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Dashboard</title>
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
        .card {
            border-radius: 15px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center py-3">Student Panel</h4>
        <a href="dashboard.php">Dashboard</a>
        <a href="enrolled_courses.php">Enrolled Courses</a>
        <a href="wishlist.php">Wishlist</a>
        <a href="recommendations.php">Recommendations</a>
        <a href="course_player.php">Course Player</a>
        <a href="quiz.php">Quiz</a>
        <a href="progress.php">Progress</a>
        <a href="discussion.php">Discussion</a>
        <a href="certificate.php">Certificate</a>
        <a href="../logout.php">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>Welcome, Student!</h2>
        <p class="text-muted">Here is an overview of your learning progress.</p>

        <div class="row mt-4">
            <div class="col-md-4 mb-3">
                <div class="card shadow p-3">
                    <h5>Total Enrolled Courses</h5>
                    <h3>3</h3>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow p-3">
                    <h5>Courses in Wishlist</h5>
                    <h3>5</h3>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow p-3">
                    <h5>Certificates Earned</h5>
                    <h3>1</h3>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
