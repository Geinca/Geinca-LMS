<?php
include('../../auth/db.php');
session_start();

// Fetch departments for dropdown
$dept_stmt = $pdo->query("SELECT department_id, name FROM departments ORDER BY name");
$departments = $dept_stmt->fetchAll(PDO::FETCH_ASSOC);

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $department_id = intval($_POST['department_id']);
  $course_name = trim($_POST['course_name']);
  $course_code = strtoupper(trim($_POST['course_code']));
  $fee_amount = floatval($_POST['fee_amount']);
  $duration_years = intval($_POST['duration_years']);

  if ($department_id && $course_name && $course_code && $fee_amount && $duration_years) {
    $stmt = $pdo->prepare("INSERT INTO courses (department_id, course_name, course_code, fee_amount, duration_years) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$department_id, $course_name, $course_code, $fee_amount, $duration_years]);
    $success = "Course added successfully.";
  } else {
    $error = "All fields are required.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Course | LMS ERP</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-10 px-4">
  <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-semibold text-center mb-4">Add New Course</h2>

    <?php if ($error): ?>
      <div class="bg-red-100 text-red-700 p-3 mb-4 rounded"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
      <div class="bg-green-100 text-green-700 p-3 mb-4 rounded"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <!-- Department -->
      <div>
        <label class="block text-gray-700 font-medium mb-1">Department <span class="text-red-500">*</span></label>
        <select name="department_id" required class="w-full border border-gray-300 rounded px-3 py-2">
          <option value="">-- Select Department --</option>
          <?php foreach ($departments as $dept): ?>
            <option value="<?= $dept['department_id'] ?>"><?= htmlspecialchars($dept['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Course Name -->
      <div>
        <label class="block text-gray-700 font-medium mb-1">Course Name <span class="text-red-500">*</span></label>
        <input type="text" name="course_name" required class="w-full border border-gray-300 rounded px-3 py-2">
      </div>

      <!-- Course Code -->
      <div>
        <label class="block text-gray-700 font-medium mb-1">Course Code <span class="text-red-500">*</span></label>
        <input type="text" name="course_code" required class="w-full border border-gray-300 rounded px-3 py-2 uppercase">
      </div>

      <!-- Fee -->
      <div>
        <label class="block text-gray-700 font-medium mb-1">Fee Amount (₹) <span class="text-red-500">*</span></label>
        <input type="number" step="0.01" name="fee_amount" required class="w-full border border-gray-300 rounded px-3 py-2">
      </div>

      <!-- Duration -->
      <div>
        <label class="block text-gray-700 font-medium mb-1">Duration (Years) <span class="text-red-500">*</span></label>
        <input type="number" name="duration_years" min="1" max="10" required class="w-full border border-gray-300 rounded px-3 py-2">
      </div>

      <!-- Buttons -->
      <div class="flex justify-between mt-6">
        <a href="course-management.php" class="text-gray-600 hover:underline">← Back</a>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Add Course</button>
      </div>
    </form>
  </div>
</body>
</html>
