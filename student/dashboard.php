<?php
session_start();
require_once 'C:/xampp/htdocs/geinca/Geinca-LMS/db.php';// Use require instead of include for critical files

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
    header('Location: ../login.php');
    exit;
}

try {
    // Query to count enrolled courses for current user
    $userId = $_SESSION['user_id'];
    
    // Corrected query - assuming you have an enrollment table
    $stmt = $pdo->prepare("SELECT COUNT(*) AS course_count FROM courses WHERE user_id = ?");
    $stmt->execute([$userId]); // Using positional parameter
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $courseCount = $result ? $result['course_count'] : 0;
    
} catch(PDOException $e) {
    // Log error and set default value
    error_log("Database error: " . $e->getMessage());
    $courseCount = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Student Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <style>
        .radial-progress {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.5rem;
            position: relative;
        }
        .radial-progress span {
            position: relative;
            z-index: 2;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex">
        <!-- Sidebar would be included here -->
        <?php include '../partials/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 p-8 ml-64">
            <h1 class="text-3xl font-bold text-gray-800">Welcome, Student!</h1>
            <p class="text-gray-500 mb-8">Here is an overview of your learning progress.</p>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-gray-500 font-medium">Total Enrolled Courses</h3>
                    <p class="text-3xl font-bold text-blue-600 mt-2"><?= $courseCount ?></p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-gray-500 font-medium">Courses in Wishlist</h3>
                    <p class="text-3xl font-bold text-purple-600 mt-2">5</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-gray-500 font-medium">Certificates Earned</h3>
                    <p class="text-3xl font-bold text-green-600 mt-2">1</p>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Progress Report -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 lg:col-span-1">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">PROGRESS REPORT</h2>
                    <div class="flex flex-col items-center">
                        <div class="radial-progress mb-4" style="background: conic-gradient(#00AEEF 0% 70%, #e0e0e0 70% 100%);">
                            <span>7.06</span>
                        </div>
                        <p class="text-gray-500 mb-2">Average Performance</p>
                        <p class="mb-2">Practice Gym: <span class="font-bold text-blue-600">81%</span></p>
                        <p class="mb-4">Streak: <span class="font-bold text-orange-500">1 🔥</span></p>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Open Report</a>
                    </div>
                </div>

                <!-- Upcoming Sessions -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 lg:col-span-1">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">UPCOMING CLASSES</h2>
                    <ul class="space-y-4">
                        <li class="flex justify-between items-center">
                            <span class="text-gray-600">Today - 7:00 PM</span>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">JOIN</button>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="text-gray-600">Saturday - 10:30 AM</span>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">JOIN</button>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="text-gray-600">Monday - 10:30 AM</span>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">JOIN</button>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="text-gray-600">Monday - 7:00 PM</span>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">JOIN</button>
                        </li>
                    </ul>
                </div>

                <!-- Upcoming Videos -->
               
            </div>
        </div>
    </div>
</body>
</html>