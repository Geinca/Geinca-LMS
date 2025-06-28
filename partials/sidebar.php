<?php
$role = $_SESSION['user_role'] ?? 'student';
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!-- Modern Sidebar -->
<div class="bg-gradient-to-b from-gray-900 to-gray-800 text-white p-6 h-screen w-72 fixed top-0 left-0 flex flex-col justify-between shadow-2xl z-50 transition-all duration-300 ease-in-out transform hover:shadow-xl">
    <!-- Sidebar Header -->
    <div>
        <div class="flex items-center mb-8 pl-2">
            <div class="bg-blue-500 p-3 rounded-xl shadow-lg mr-3">
                <i class="fas fa-chalkboard text-white text-xl"></i>
            </div>
            <h4 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-blue-200">
                LMS Dashboard
            </h4>
        </div>

        <!-- Sidebar Menu -->
        <ul class="space-y-3">
            <?php if ($role == 'admin'): ?>
                <li>
                    <a href="../admin/dashboard.php"
                       class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 <?= ($currentPage == 'dashboard.php') ? 
                       'bg-gradient-to-r from-blue-600 to-blue-400 text-white shadow-lg' : 
                       'hover:bg-gray-700 text-gray-300 hover:text-white hover:translate-x-1' ?>">
                        <div class="w-8 text-center mr-3">
                            <i class="fas fa-th-large"></i>
                        </div>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="../admin/user-management.php"
                       class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 <?= ($currentPage == 'manage_users.php') ? 
                       'bg-gradient-to-r from-blue-600 to-blue-400 text-white shadow-lg' : 
                       'hover:bg-gray-700 text-gray-300 hover:text-white hover:translate-x-1' ?>">
                        <div class="w-8 text-center mr-3">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <span>Manage Users</span>
                    </a>
                </li>
                <li>
                    <a href="../admin/course-management.php"
                       class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 <?= ($currentPage == 'manage_courses.php') ? 
                       'bg-gradient-to-r from-blue-600 to-blue-400 text-white shadow-lg' : 
                       'hover:bg-gray-700 text-gray-300 hover:text-white hover:translate-x-1' ?>">
                        <div class="w-8 text-center mr-3">
                            <i class="fas fa-book"></i>
                        </div>
                        <span>Manage Courses</span>
                    </a>
                </li>
                <li>
                    <a href="../admin/classes-management.php"
                       class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 <?= ($currentPage == 'classes-management.php') ? 
                       'bg-gradient-to-r from-blue-600 to-blue-400 text-white shadow-lg' : 
                       'hover:bg-gray-700 text-gray-300 hover:text-white hover:translate-x-1' ?>">
                        <div class="w-8 text-center mr-3">
                            <i class="fas fa-chalkboard"></i>
                        </div>
                        <span>Manage Classes</span>
                    </a>
                </li>

            <?php elseif ($role == 'instructor'): ?>
                <li>
                    <a href="../instructor/dashboard.php"
                       class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 <?= ($currentPage == 'dashboard.php') ? 
                       'bg-gradient-to-r from-blue-600 to-blue-400 text-white shadow-lg' : 
                       'hover:bg-gray-700 text-gray-300 hover:text-white hover:translate-x-1' ?>">
                        <div class="w-8 text-center mr-3">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="../instructor/my_courses.php"
                       class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 <?= ($currentPage == 'my_courses.php') ? 
                       'bg-gradient-to-r from-blue-600 to-blue-400 text-white shadow-lg' : 
                       'hover:bg-gray-700 text-gray-300 hover:text-white hover:translate-x-1' ?>">
                        <div class="w-8 text-center mr-3">
                            <i class="fas fa-book-reader"></i>
                        </div>
                        <span>My Courses</span>
                    </a>
                </li>
                <li>
                    <a href="../instructor/create_course.php"
                       class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 <?= ($currentPage == 'create_course.php') ? 
                       'bg-gradient-to-r from-blue-600 to-blue-400 text-white shadow-lg' : 
                       'hover:bg-gray-700 text-gray-300 hover:text-white hover:translate-x-1' ?>">
                        <div class="w-8 text-center mr-3">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <span>Create Course</span>
                    </a>
                </li>

            <?php elseif ($role == 'student'): ?>
                <li>
                    <a href="../student/dashboard.php"
                       class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 <?= ($currentPage == 'dashboard.php') ? 
                       'bg-gradient-to-r from-blue-600 to-blue-400 text-white shadow-lg' : 
                       'hover:bg-gray-700 text-gray-300 hover:text-white hover:translate-x-1' ?>">
                        <div class="w-8 text-center mr-3">
                            <i class="fas fa-home"></i>
                        </div>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="../student/enrolled_courses.php"
                       class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 <?= ($currentPage == 'enrolled_courses.php') ? 
                       'bg-gradient-to-r from-blue-600 to-blue-400 text-white shadow-lg' : 
                       'hover:bg-gray-700 text-gray-300 hover:text-white hover:translate-x-1' ?>">
                        <div class="w-8 text-center mr-3">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <span>Enrolled Courses</span>
                    </a>
                </li>
                <li>
                    <a href="../student/browse_courses.php"
                       class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 <?= ($currentPage == 'browse_courses.php') ? 
                       'bg-gradient-to-r from-blue-600 to-blue-400 text-white shadow-lg' : 
                       'hover:bg-gray-700 text-gray-300 hover:text-white hover:translate-x-1' ?>">
                        <div class="w-8 text-center mr-3">
                            <i class="fas fa-search"></i>
                        </div>
                        <span>Browse Courses</span>
                    </a>
                </li>
                <li>
                    <a href="../student/classes.php"
                       class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 <?= ($currentPage == 'classes.php') ? 
                       'bg-gradient-to-r from-blue-600 to-blue-400 text-white shadow-lg' : 
                       'hover:bg-gray-700 text-gray-300 hover:text-white hover:translate-x-1' ?>">
                        <div class="w-8 text-center mr-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <span>My Classes</span>
                    </a>
                </li>
                <li>
                    <a href="../student/exam.php"
                       class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 <?= ($currentPage == 'exam.php') ? 
                       'bg-gradient-to-r from-blue-600 to-blue-400 text-white shadow-lg' : 
                       'hover:bg-gray-700 text-gray-300 hover:text-white hover:translate-x-1' ?>">
                        <div class="w-8 text-center mr-3">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <span>Ongoing Exams</span>
                    </a>
                </li>
                <li>
                    <a href="../student/quiz.php"
                       class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 <?= ($currentPage == 'quiz.php') ? 
                       'bg-gradient-to-r from-blue-600 to-blue-400 text-white shadow-lg' : 
                       'hover:bg-gray-700 text-gray-300 hover:text-white hover:translate-x-1' ?>">
                        <div class="w-8 text-center mr-3">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <span>Ongoing Quizzes</span>
                    </a>
                </li>
                <li>
                    <a href="../student/progress.php"
                       class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 <?= ($currentPage == 'progress.php') ? 
                       'bg-gradient-to-r from-blue-600 to-blue-400 text-white shadow-lg' : 
                       'hover:bg-gray-700 text-gray-300 hover:text-white hover:translate-x-1' ?>">
                        <div class="w-8 text-center mr-3">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <span>Progress Card</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Sidebar Footer -->
    <div class="border-t border-gray-700 pt-4 mt-6">
        <div class="flex items-center space-x-4 p-3 rounded-xl hover:bg-gray-700 transition-all duration-200">
            <div class="relative">
                <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-blue-300 flex items-center justify-center shadow-md">
                    <span class="text-white font-bold text-lg">
                        <?= strtoupper(substr($_SESSION['name'] ?? 'U', 0, 1)) ?>
                    </span>
                    <div class="absolute bottom-0 right-0 h-3 w-3 bg-green-500 rounded-full border-2 border-gray-800"></div>
                </div>
            </div>
            <div>
                <p class="font-semibold text-white"><?= htmlspecialchars($_SESSION['name'] ?? 'User') ?></p>
                <p class="text-gray-300 text-sm capitalize"><?= $role ?></p>
            </div>
            <div class="ml-auto">
                <a href="../logout.php" class="text-gray-300 hover:text-white transition-colors">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Optional: add padding/margin to main content to prevent overlap -->
<!-- <div class="ml-72"></div> -->