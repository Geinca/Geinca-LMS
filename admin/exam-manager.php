<?php
session_start();
require_once '../auth/db.php';

// Restrict access to admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../auth/login.php");
  exit;
}

// Fetch exam data
$sql = "SELECT 
          e.exam_id,
          s.name AS subject_name,
          e.type,
          e.exam_date
        FROM exams e
        JOIN subjects s ON e.subject_id = s.subject_id
        ORDER BY e.exam_date DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$exams = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Exam Manager | Admin | LMS ERP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center shadow-md">
    <h1 class="text-xl font-bold">Exam Manager</h1>
    <a href="dashboard.php" class="text-sm hover:underline"><i class="fas fa-arrow-left mr-1"></i> Back to Dashboard</a>
  </header>

  <div class="flex flex-1">
    <!-- Sidebar -->
    <?php include('../components/admin-sidebar.php'); ?>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Upcoming Exams</h2>
        <a href="modals/add-exam.php" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
          <i class="fas fa-plus mr-2"></i>Schedule New Exam
        </a>
      </div>

      <!-- Exam Table -->
      <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full text-sm text-left">
          <thead class="bg-gray-200 text-gray-600 uppercase">
            <tr>
              <th class="px-6 py-3">Exam Name</th>
              <th class="px-6 py-3">Class</th>
              <th class="px-6 py-3">Subject</th>
              <th class="px-6 py-3">Date</th>
              <th class="px-6 py-3">Time</th>
              <th class="px-6 py-3">Duration</th>
              <th class="px-6 py-3">Actions</th>
            </tr>
          </thead>
          <tbody class="text-gray-700">
            <?php if (count($exams) === 0): ?>
              <tr><td colspan="7" class="text-center py-4 text-gray-500">No exams scheduled.</td></tr>
            <?php else: ?>
              <?php foreach ($exams as $exam): ?>
                <tr class="border-b">
                  <td class="px-6 py-4"><?= htmlspecialchars($exam['exam_name']) ?></td>
                  <td class="px-6 py-4"><?= htmlspecialchars($exam['class_name']) ?></td>
                  <td class="px-6 py-4"><?= htmlspecialchars($exam['subject_name']) ?></td>
                  <td class="px-6 py-4"><?= htmlspecialchars($exam['exam_date']) ?></td>
                  <td class="px-6 py-4"><?= date("g:i A", strtotime($exam['exam_time'])) ?></td>
                  <td class="px-6 py-4"><?= htmlspecialchars($exam['duration']) ?></td>
                  <td class="px-6 py-4 space-x-2">
                    <a href="modals/add-exam.php?id=<?= $exam['exam_id'] ?>" class="text-blue-600 hover:underline"><i class="fas fa-edit"></i></a>
                    <a href="delete-exam.php?id=<?= $exam['exam_id'] ?>" onclick="return confirm('Delete this exam?')" class="text-red-600 hover:underline"><i class="fas fa-trash"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</body>
</html>
