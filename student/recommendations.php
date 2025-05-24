<?php
// session_start();
// if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
//     header('Location: ../login.php');
//     exit;
// }

// Dummy recommended courses (in real app, generate based on interests/behavior)
$recommended_courses = [
    [
        'id' => 6,
        'title' => 'Advanced JavaScript',
        'description' => 'Deep dive into JS concepts.',
        'image' => 'https://media2.dev.to/dynamic/image/width=1280,height=720,fit=cover,gravity=auto,format=auto/https%3A%2F%2Fdev-to-uploads.s3.amazonaws.com%2Fuploads%2Farticles%2Fqp2018wo6d8ii76kqa6d.png'
    ],
    [
        'id' => 7,
        'title' => 'Machine Learning Basics',
        'description' => 'Intro to ML algorithms.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGN5SYYbs3HomAx4jXEqKzS_6bSTpTDSyabg&s'
    ],
    [
        'id' => 8,
        'title' => 'UI/UX Design Fundamentals',
        'description' => 'Design great user experiences.',
        'image' => 'https://img.freepik.com/free-vector/gradient-ui-ux-background_23-2149052117.jpg'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Recommendations</title>
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
        .sidebar a:hover, .sidebar a.active {
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
        <a href="wishlist.php">Wishlist</a>
        <a href="recommendations.php" class="active">Recommendations</a>
        <a href="course_player.php">Course Player</a>
        <a href="quiz.php">Quiz</a>
        <a href="progress.php">Progress</a>
        <a href="discussion.php">Discussion</a>
        <a href="certificate.php">Certificate</a>
        <a href="../logout.php">Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <h2>Recommended Courses</h2>
        <p class="text-muted">Courses we think you might like based on your interests.</p>

        <?php if (count($recommended_courses) > 0): ?>
            <div class="row">
                <?php foreach ($recommended_courses as $course): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow">
                            <img src="<?= htmlspecialchars($course['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($course['title']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($course['description']) ?></p>
                                <a href="course_player.php?course_id=<?= $course['id'] ?>" class="btn btn-primary btn-sm">View Course</a>
                                <!-- Add Wishlist or Enroll buttons if you want -->
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No recommendations available at the moment.</p>
        <?php endif; ?>
    </div>
</body>
</html>
