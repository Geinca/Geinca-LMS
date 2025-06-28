<?php
// session_start();
require_once 'C:/xampp/htdocs/Geinca-LMS/db.php';

// // Redirect if not logged in or not admin
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
//     header("Location: ../login.php");
//     exit;
// }

// Fetch Stats
$total_users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$active_classes = $pdo->query("SELECT COUNT(*) FROM classes")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard | LMS ERP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Header -->
  <header class="ml-64 bg-gray-800 text-white px-6 py-4 flex justify-between items-center shadow-md">
    <h1 class="text-xl font-bold">LMS ERP - Admin Dashboard</h1>
    <div class="space-x-4">
      <span class="text-sm">Welcome, <?= (htmlspecialchars($_SESSION['name'])) ?? "Admin" ?></span>
      <a href="../logout.php" class="text-sm hover:underline">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
    </div>
  </header>

  <div class="flex flex-1">
    <!-- Sidebar -->
    <?php include __DIR__ . '/../partials/sidebar.php'; ?>

    <!-- Main Dashboard -->
    <main class="flex-1 p-6 ml-64">
      <h2 class="text-2xl font-semibold text-gray-800 mb-6">Overview</h2>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Users -->
        <div class="bg-white p-6 rounded-lg shadow-md border">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-700">Total Users</h3>
            <i class="fas fa-users text-indigo-600 text-xl"></i>
          </div>
          <p class="mt-2 text-2xl font-bold text-gray-900"><?= $total_users ?></p>
        </div>

        <!-- Classes -->
        <div class="bg-white p-6 rounded-lg shadow-md border">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-700">Active Classes</h3>
            <i class="fas fa-chalkboard-teacher text-green-600 text-xl"></i>
          </div>
          <p class="mt-2 text-2xl font-bold text-gray-900"><?= $active_classes ?></p>
        </div>

        <!-- Notifications -->
        <div class="bg-white p-6 rounded-lg shadow-md border">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-700">New Notifications</h3>
            <i class="fas fa-bell text-yellow-500 text-xl"></i>
          </div>
          <p class="mt-2 text-2xl font-bold text-gray-900"><?= $new_notifications ?></p>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="mt-8">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <a href="user-management.php" class="bg-indigo-600 text-white p-4 rounded shadow hover:bg-indigo-700 flex items-center justify-between">
            Manage Users <i class="fas fa-user-cog"></i>
          </a>
          <a href="class-timetable.php" class="bg-green-600 text-white p-4 rounded shadow hover:bg-green-700 flex items-center justify-between">
            Class Timetable <i class="fas fa-calendar-alt"></i>
          </a>
          <a href="report-card-generator.php" class="bg-blue-600 text-white p-4 rounded shadow hover:bg-blue-700 flex items-center justify-between">
            Generate Report Cards <i class="fas fa-file-alt"></i>
          </a>
        </div>
      </div>
    </main>
  </div>

</body>
</html>
