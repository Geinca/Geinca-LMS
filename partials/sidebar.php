<?php
$role = $_SESSION['user_role'] ?? 'guest';
?>

<div class="d-flex flex-column p-3 text-bg-dark" style="width: 250px; height: 100vh;">
    <h4 class="text-white">Menu</h4>
    <ul class="nav nav-pills flex-column mb-auto">
        <?php if ($role == 'admin'): ?>
            <li><a href="../admin/dashboard.php" class="nav-link text-white">Dashboard</a></li>
            <li><a href="../admin/manage_users.php" class="nav-link text-white">Manage Users</a></li>
            <li><a href="../admin/manage_courses.php" class="nav-link text-white">Manage Courses</a></li>

        <?php elseif ($role == 'instructor'): ?>
            <li><a href="../instructor/dashboard.php" class="nav-link text-white">Dashboard</a></li>
            <li><a href="../instructor/my_courses.php" class="nav-link text-white">My Courses</a></li>
            <li><a href="../instructor/create_course.php" class="nav-link text-white">Create Course</a></li>

        <?php elseif ($role == 'student'): ?>
            <li><a href="../student/dashboard.php" class="nav-link text-white">Dashboard</a></li>
            <li><a href="../student/enrolled_courses.php" class="nav-link text-white">Enrolled Courses</a></li>
            <li><a href="../student/browse_courses.php" class="nav-link text-white">Browse Courses</a></li>
        <?php endif; ?>
    </ul>
</div>
