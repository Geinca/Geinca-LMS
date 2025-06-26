<?php
include('../../auth/db.php');

// Fetch all courses
$course_stmt = $pdo->query("SELECT course_id, course_name FROM courses ORDER BY course_name");
$courses = $course_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all teachers (users with role = 'teacher')
$teacher_stmt = $pdo->query("
  SELECT t.teacher_id, u.name 
  FROM teachers t 
  JOIN users u ON t.teacher_id = u.user_id 
  ORDER BY u.name
");
$teachers = $teacher_stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $course_id = intval($_POST['course_id']);
  $teacher_id = intval($_POST['teacher_id']);

  if ($name && $course_id && $teacher_id) {
    $stmt = $pdo->prepare("INSERT INTO subjects (name, course_id, teacher_id) VALUES (?, ?, ?)");
    $stmt->execute([$name, $course_id, $teacher_id]);

    $success = "Subject added successfully.";
  } else {
    $error = "All fields are required.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Subject | LMS ERP</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4 py-10">
  <div class="bg-white max-w-md w-full p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4 text-center">Add New Subject</h2>

    <?php if ($error): ?>
      <div class="bg-red-100 text-red-700 p-2 rounded mb-4"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
      <div class="bg-green-100 text-green-700 p-2 rounded mb-4"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <!-- Subject Name -->
      <div>
        <label class="block text-gray-700 font-medium mb-1">Subject Name <span class="text-red-500">*</span></label>
        <input type="text" name="name" required class="w-full border border-gray-300 rounded px-3 py-2">
      </div>

      <!-- Course Dropdown -->
      <div>
        <label class="block text-gray-700 font-medium mb-1">Course <span class="text-red-500">*</span></label>
        <select name="course_id" required class="w-full border border-gray-300 rounded px-3 py-2">
          <option value="">-- Select Course --</option>
          <?php foreach ($courses as $course): ?>
            <option value="<?= $course['course_id'] ?>"><?= htmlspecialchars($course['course_name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Teacher Dropdown -->
      <div>
        <label class="block text-gray-700 font-medium mb-1">Assigned Teacher <span class="text-red-500">*</span></label>
        <select name="teacher_id" required class="w-full border border-gray-300 rounded px-3 py-2">
          <option value="">-- Select Teacher --</option>
          <?php foreach ($teachers as $teacher): ?>
            <option value="<?= $teacher['teacher_id'] ?>"><?= htmlspecialchars($teacher['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Submit -->
      <div class="flex justify-between mt-6">
        <a href="../subject-management.php" class="text-gray-600 hover:underline">← Cancel</a>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
          Add Subject
        </button>
      </div>
    </form>
  </div>
</body>
</html>
