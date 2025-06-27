<?php
$role = $_SESSION['user_role'] ?? 'admin';
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!-- Sidebar -->
<div class="bg-gray-900 text-white p-4 h-screen w-64 fixed top-0 left-0 flex flex-col justify-between shadow-lg z-50">
    <!-- Sidebar Header -->
    <div>
        <div class="flex items-center mb-6">
            <i class="fas fa-chalkboard fa-2x text-blue-400 mr-3"></i>
            <h4 class="text-xl font-bold">LMS Dashboard</h4>
        </div>

        <!-- Sidebar Menu -->
        <ul class="space-y-2">
            <?php if ($role == 'admin'): ?>
                <li>
                    <a href="../admin/dashboard.php"
                       class="flex items-center px-4 py-2 rounded-lg <?= ($currentPage == 'dashboard.php') ? 'bg-gray-800 text-white' : 'hover:bg-gray-700 text-gray-300' ?>">
                        <i class="fas fa-th-large mr-3"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="../admin/user-management.php"
                       class="flex items-center px-4 py-2 rounded-lg <?= ($currentPage == 'manage_users.php') ? 'bg-gray-800 text-white' : 'hover:bg-gray-700 text-gray-300' ?>">
                        <i class="fas fa-users-cog mr-3"></i> Manage Users
                    </a>
                </li>
                <li>
                    <a href="../admin/course-management.php"
                       class="flex items-center px-4 py-2 rounded-lg <?= ($currentPage == 'manage_courses.php') ? 'bg-gray-800 text-white' : 'hover:bg-gray-700 text-gray-300' ?>">
                        <i class="fas fa-book mr-3"></i> Manage Courses
                    </a>
                </li>
                <li>
                    <a href="../admin/manage_courses.php"
                       class="flex items-center px-4 py-2 rounded-lg <?= ($currentPage == 'manage_courses.php') ? 'bg-gray-800 text-white' : 'hover:bg-gray-700 text-gray-300' ?>">
                        <i class="fas fa-book mr-3"></i> Manage Classes
                    </a>
                </li>
            <?php elseif ($role == 'instructor'): ?>
                <li>
                    <a href="../instructor/dashboard.php"
                       class="flex items-center px-4 py-2 rounded-lg <?= ($currentPage == 'dashboard.php') ? 'bg-gray-800 text-white' : 'hover:bg-gray-700 text-gray-300' ?>">
                        <i class="fas fa-chalkboard-teacher mr-3"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="../instructor/my_courses.php"
                       class="flex items-center px-4 py-2 rounded-lg <?= ($currentPage == 'my_courses.php') ? 'bg-gray-800 text-white' : 'hover:bg-gray-700 text-gray-300' ?>">
                        <i class="fas fa-book-reader mr-3"></i> My Courses
                    </a>
                </li>
                <li>
                    <a href="../instructor/create_course.php"
                       class="flex items-center px-4 py-2 rounded-lg <?= ($currentPage == 'create_course.php') ? 'bg-gray-800 text-white' : 'hover:bg-gray-700 text-gray-300' ?>">
                        <i class="fas fa-plus-circle mr-3"></i> Create Course
                    </a>
                </li>
            <?php elseif ($role == 'student'): ?>
                <li>
                    <a href="../student/dashboard.php"
                       class="flex items-center px-4 py-2 rounded-lg <?= ($currentPage == 'dashboard.php') ? 'bg-gray-800 text-white' : 'hover:bg-gray-700 text-gray-300' ?>">
                        <i class="fas fa-home mr-3"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="../student/enrolled_courses.php"
                       class="flex items-center px-4 py-2 rounded-lg <?= ($currentPage == 'enrolled_courses.php') ? 'bg-gray-800 text-white' : 'hover:bg-gray-700 text-gray-300' ?>">
                        <i class="fas fa-book-open mr-3"></i> Enrolled Courses
                    </a>
                </li>
                <li>
                    <a href="../student/browse_courses.php"
                       class="flex items-center px-4 py-2 rounded-lg <?= ($currentPage == 'browse_courses.php') ? 'bg-gray-800 text-white' : 'hover:bg-gray-700 text-gray-300' ?>">
                        <i class="fas fa-search mr-3"></i> Browse Courses
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Sidebar Footer -->
    <div class="border-t border-gray-700 pt-4 mt-6">
        <div class="flex items-center space-x-3">
            <div class="bg-blue-500 rounded-full h-10 w-10 flex items-center justify-center">
                <span class="text-white font-bold">
                    <?= strtoupper(substr($_SESSION['name'] ?? 'U', 0, 1)) ?>
                </span>
            </div>
            <div>
                <p class="font-semibold"><?= htmlspecialchars($_SESSION['name'] ?? 'User') ?></p>
                <p class="text-gray-400 text-sm capitalize"><?= $role ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Optional: add padding/margin to main content to prevent overlap -->
<!-- <div class="ml-64"></div> -->
