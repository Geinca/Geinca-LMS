<?php
session_start();
require_once '../auth/db.php';

// Restrict to admin only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header('Location: ../auth/login.php');
  exit;
}

// Fetch classes, subjects, exams dynamically for filter dropdowns
$classes = $pdo->query("SELECT DISTINCT class_id FROM classes ORDER BY class_id")->fetchAll(PDO::FETCH_COLUMN);
$subjects = $pdo->query("SELECT subject_id, name FROM subjects ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
$exams = $pdo->query("SELECT DISTINCT type FROM exams ORDER BY type")->fetchAll(PDO::FETCH_COLUMN);

// Optionally handle filter form submission (GET method assumed)
$selected_class = $_GET['class_name'] ?? '';
$selected_subject = $_GET['subject_id'] ?? '';
$selected_exam = $_GET['exam_type'] ?? '';

// Build query for fetching results - simplified example, adapt as needed
$results = [];
if ($selected_class && $selected_subject && $selected_exam) {
    $sql = "SELECT r.result_id, s.roll_no, u.name AS student_name, r.marks, r.grade
            FROM results r
            JOIN students s ON r.student_id = s.student_id
            JOIN users u ON s.user_id = u.user_id
            JOIN exams e ON r.exam_id = e.exam_id
            JOIN subjects sub ON e.subject_id = sub.subject_id
            WHERE s.class_name = ? AND sub.subject_id = ? AND e.type = ?
            ORDER BY s.roll_no";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$selected_class, $selected_subject, $selected_exam]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Result Manager | Admin | LMS ERP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center shadow">
    <h1 class="text-xl font-bold">Result Manager</h1>
    <a href="dashboard.php" class="text-sm hover:underline"><i class="fas fa-arrow-left mr-1"></i>Back to Dashboard</a>
  </header>

  <div class="flex flex-1">
    <!-- Sidebar -->
    <?php include('../components/admin-sidebar.php'); ?>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Manage Student Results</h2>
      </div>

      <!-- Filter -->
      <div class="bg-white p-4 rounded shadow mb-4">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700" for="class_name">Class</label>
            <select id="class_name" name="class_name" class="w-full border rounded px-3 py-2" required>
              <option value="">Select Class</option>
              <?php foreach ($classes as $class): ?>
                <option value="<?= htmlspecialchars($class) ?>" <?= ($class === $selected_class) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($class) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700" for="subject_id">Subject</label>
            <select id="subject_id" name="subject_id" class="w-full border rounded px-3 py-2" required>
              <option value="">Select Subject</option>
              <?php foreach ($subjects as $subject): ?>
                <option value="<?= $subject['subject_id'] ?>" <?= ($subject['subject_id'] == $selected_subject) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($subject['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700" for="exam_type">Exam</label>
            <select id="exam_type" name="exam_type" class="w-full border rounded px-3 py-2" required>
              <option value="">Select Exam</option>
              <?php foreach ($exams as $exam): ?>
                <option value="<?= htmlspecialchars($exam) ?>" <?= ($exam === $selected_exam) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($exam) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="flex items-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
              <i class="fas fa-search mr-2"></i>Fetch Results
            </button>
          </div>
        </form>
      </div>

      <!-- Results Table -->
      <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full text-sm text-left">
          <thead class="bg-gray-200 text-gray-600 uppercase">
            <tr>
              <th class="px-6 py-3">Roll No</th>
              <th class="px-6 py-3">Student Name</th>
              <th class="px-6 py-3">Marks</th>
              <th class="px-6 py-3">Grade</th>
              <th class="px-6 py-3">Actions</th>
            </tr>
          </thead>
          <tbody class="text-gray-700">
            <?php if (count($results) > 0): ?>
              <?php foreach ($results as $row): ?>
                <tr class="border-b">
                  <td class="px-6 py-4"><?= htmlspecialchars($row['roll_no']) ?></td>
                  <td class="px-6 py-4"><?= htmlspecialchars($row['student_name']) ?></td>
                  <td class="px-6 py-4"><?= htmlspecialchars($row['marks']) ?></td>
                  <td class="px-6 py-4"><?= htmlspecialchars($row['grade']) ?></td>
                  <td class="px-6 py-4 space-x-2">
                    <a href="modals/edit-result.php?id=<?= $row['result_id'] ?>" class="text-blue-600 hover:underline"><i class="fas fa-edit"></i></a>
                    <a href="delete-result.php?id=<?= $row['result_id'] ?>" onclick="return confirm('Are you sure to delete this result?')" class="text-red-600 hover:underline"><i class="fas fa-trash"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center py-4 text-gray-500">No results found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</body>
</html>
