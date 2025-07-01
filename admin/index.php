<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

// Count stats
$classesCount = $pdo->query("SELECT COUNT(*) FROM classes")->fetchColumn();
$coursesCount = $pdo->query("SELECT COUNT(*) FROM courses")->fetchColumn();
$lessonsCount = $pdo->query("SELECT COUNT(*) FROM lessons")->fetchColumn();
?>

<h1>Admin Dashboard</h1>

<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Classes</h5>
                <p class="card-text display-4"><?= $classesCount ?></p>
                <a href="classes/" class="text-white">View all classes</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Courses</h5>
                <p class="card-text display-4"><?= $coursesCount ?></p>
                <a href="courses/" class="text-white">View all courses</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Lessons</h5>
                <p class="card-text display-4"><?= $lessonsCount ?></p>
                <a href="lessons/" class="text-white">View all lessons</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>