<?php
session_start();
require_once '../auth/db.php';

// Optional: Restrict access to admin only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Fetch class timetable entries
$sql = "SELECT 
          c.class_id,
          s.name AS subject_name,
          c.start_time,
          c.end_time,
          c.meeting_link,
          u.name AS teacher_name
        FROM classes c
        JOIN subjects s ON c.subject_id = s.subject_id
        JOIN teachers t ON s.teacher_id = t.teacher_id
        JOIN users u ON u.user_id = t.teacher_id
        ORDER BY c.start_time";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Class Timetable | Admin | LMS ERP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center shadow-md">
    <h1 class="text-xl font-bold">Class Timetable Management</h1>
    <a href="dashboard.php" class="text-sm hover:underline"><i class="fas fa-arrow-left mr-1"></i> Back to Dashboard</a>
  </header>

  <div class="flex flex-1">
    <!-- Sidebar -->
    <?php include('../components/admin-sidebar.php'); ?>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Timetable Overview</h2>
        <a href="modals/add-edit-class.php" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
          <i class="fas fa-plus mr-2"></i>Add Class Slot
        </a>
      </div>

      <!-- Timetable Table -->
      <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full text-sm text-left">
          <thead class="bg-gray-200 text-gray-600 uppercase">
            <tr>
              <th class="px-6 py-3">Subject</th>
              <th class="px-6 py-3">Time</th>
              <th class="px-6 py-3">Teacher</th>
              <th class="px-6 py-3">Meeting Link</th>
              <th class="px-6 py-3">Actions</th>
            </tr>
          </thead>
          <tbody class="text-gray-700">
            <?php foreach ($classes as $class): ?>
              <tr class="border-b">
                <td class="px-6 py-4"><?= htmlspecialchars($class['subject_name']) ?></td>
                <td class="px-6 py-4"><?= date("g:i A", strtotime($class['start_time'])) ?> - <?= date("g:i A", strtotime($class['end_time'])) ?></td>
                <td class="px-6 py-4"><?= htmlspecialchars($class['teacher_name']) ?></td>
                <td class="px-6 py-4">
                  <a href="<?= htmlspecialchars($class['meeting_link']) ?>" target="_blank" class="text-blue-600 underline">Join</a>
                </td>
                <td class="px-6 py-4 space-x-2">
                  <a href="modals/add-edit-class.php?id=<?= $class['class_id'] ?>" class="text-blue-600 hover:underline"><i class="fas fa-edit"></i></a>
                  <a href="delete-class.php?id=<?= $class['class_id'] ?>" onclick="return confirm('Are you sure to delete this class slot?')" class="text-red-600 hover:underline"><i class="fas fa-trash"></i></a>
                </td>
              </tr>
            <?php endforeach; ?>
            <?php if (count($classes) === 0): ?>
              <tr><td colspan="5" class="text-center py-4 text-gray-500">No class slots found.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</body>
</html>
