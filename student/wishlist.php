<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
    header('Location: ../login.php');
    exit;
}

// For now, dummy wishlist courses (in a real app, you'd fetch from DB)
$wishlist_courses = [
    [
        'id' => 4,
        'title' => 'React for Beginners',
        'description' => 'Learn ReactJS fundamentals.',
        'image' => 'https://cloudmatetechnologies.com/wp-content/uploads/2024/06/react.js.png'
    ],
    [
        'id' => 5,
        'title' => 'Python Data Science',
        'description' => 'Explore data science with Python.',
        'image' => 'https://assets.skyfilabs.com/images/blog/good-mini-project-ideas-based-on-python-language-for-engineering-students.webp'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Wishlist</title>
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
        <a href="enrolled_courses.php">Enrolled Courses</a>
        <a href="wishlist.php" class="bg-secondary">Wishlist</a>
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
        <h2>Your Wishlist</h2>
        <p class="text-muted">Courses you have saved for later enrollment.</p>

        <?php if (count($wishlist_courses) > 0): ?>
            <div class="row">
                <?php foreach ($wishlist_courses as $course): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow">
                            <img src="<?= htmlspecialchars($course['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($course['title']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($course['description']) ?></p>
                                <a href="course_player.php?course_id=<?= $course['id'] ?>" class="btn btn-primary btn-sm">View Course</a>
                                <!-- Add Remove button if you want -->
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>You have no courses in your wishlist.</p>
        <?php endif; ?>
    </div>
</body>
</html>
