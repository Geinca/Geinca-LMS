<?php
$role = $_SESSION['user_role'] ?? 'guest';
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<div class="fixed inset-y-0 left-0 w-64 bg-gray-800 text-white shadow-lg transform transition-all duration-300 ease-in-out z-50">
    <div class="flex flex-col h-full">
        <!-- Sidebar Header -->
        <div class="p-4 border-b border-gray-700 flex items-center space-x-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <h2 class="text-xl font-bold">LMS Dashboard</h2>
        </div>

        <!-- Sidebar Menu -->
        <nav class="flex-1 overflow-y-auto py-4 px-2">
            <ul class="space-y-1">
                <?php if ($role == 'admin'): ?>
                    <li>
                        <a href="../admin/dashboard.php" class="<?= ($currentPage == 'dashboard.php') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700' ?> flex items-center p-3 rounded-lg transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="../admin/manage_users.php" class="<?= ($currentPage == 'manage_users.php') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700' ?> flex items-center p-3 rounded-lg transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Manage Users
                        </a>
                    </li>
                    <li>
                        <a href="../admin/manage_courses.php" class="<?= ($currentPage == 'manage_courses.php') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700' ?> flex items-center p-3 rounded-lg transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Manage Courses
                        </a>
                    </li>

                <?php elseif ($role == 'instructor'): ?>
                    <li>
                        <a href="../instructor/dashboard.php" class="<?= ($currentPage == 'dashboard.php') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700' ?> flex items-center p-3 rounded-lg transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="../instructor/my_courses.php" class="<?= ($currentPage == 'my_courses.php') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700' ?> flex items-center p-3 rounded-lg transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            My Courses
                        </a>
                    </li>
                    <li>
                        <a href="../instructor/create_course.php" class="<?= ($currentPage == 'create_course.php') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700' ?> flex items-center p-3 rounded-lg transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Create Course
                        </a>
                    </li>

                <?php elseif ($role == 'student'): ?>
                    <li>
                        <a href="../student/dashboard.php" class="<?= ($currentPage == 'dashboard.php') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700' ?> flex items-center p-3 rounded-lg transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="../student/enrolled_courses.php" class="<?= ($currentPage == 'enrolled_courses.php') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700' ?> flex items-center p-3 rounded-lg transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            Enrolled Courses
                        </a>
                    </li>
                    <li>
                        <a href="../student/browse_courses.php" class="<?= ($currentPage == 'browse_courses.php') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700' ?> flex items-center p-3 rounded-lg transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Browse Courses
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-gray-700">
            <div class="flex items-center space-x-3">
                <div class="h-10 w-10 rounded-full bg-indigo-500 flex items-center justify-center">
                    <span class="text-white font-semibold"><?= strtoupper(substr($_SESSION['name'] ?? 'U', 0, 1)) ?></span>
                </div>
                <div>
                    <p class="text-sm font-medium"><?= htmlspecialchars($_SESSION['name'] ?? 'User') ?></p>
                    <p class="text-xs text-gray-400 capitalize"><?= $role ?></p>
                </div>
            </div>
        </div>
    </div>
</div>