<?php
include('../../auth/db.php');

$dept_id = $_GET['id'] ?? null;
$edit_mode = $dept_id !== null;

// Fetch HOD options
$hod_stmt = $pdo->prepare("SELECT user_id, name FROM users WHERE role = 'teacher' ORDER BY name");
$hod_stmt->execute();
$teachers = $hod_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch department for editing
if ($edit_mode) {
  $stmt = $pdo->prepare("SELECT * FROM departments WHERE department_id = ?");
  $stmt->execute([$dept_id]);
  $dept = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$dept) {
    die("Department not found.");
  }
} else {
  $dept = ['name' => '', 'head_id' => null];
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $head_id = $_POST['head_id'] !== '' ? intval($_POST['head_id']) : null;

  if ($edit_mode) {
    $stmt = $pdo->prepare("UPDATE departments SET name = ?, head_id = ? WHERE department_id = ?");
    $stmt->execute([$name, $head_id, $dept_id]);
  } else {
    $stmt = $pdo->prepare("INSERT INTO departments (name, head_id) VALUES (?, ?)");
    $stmt->execute([$name, $head_id]);
    
  }

  header("Location: ../classes-management.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $edit_mode ? 'Edit' : 'Add' ?> Department | LMS ERP</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center p-6">
  <div class="bg-white w-full max-w-md p-6 rounded shadow-md">
    <h2 class="text-xl font-semibold mb-4"><?= $edit_mode ? 'Edit' : 'Add New' ?> Department</h2>
    <form method="POST" class="space-y-4">
      <!-- Department Name -->
      <div>
        <label class="block text-gray-700 font-medium mb-1">Department Name <span class="text-red-500">*</span></label>
        <input type="text" name="name" required value="<?= htmlspecialchars($dept['name']) ?>" class="w-full border border-gray-300 rounded px-3 py-2">
      </div>

      <!-- HOD Dropdown -->
      <div>
        <label class="block text-gray-700 font-medium mb-1">Head of Department</label>
        <select name="head_id" class="w-full border border-gray-300 rounded px-3 py-2">
          <option value="">-- Select Teacher --</option>
          <?php foreach ($teachers as $teacher): ?>
            <option value="<?= $teacher['user_id'] ?>" <?= ($dept['head_id'] == $teacher['user_id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($teacher['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Buttons -->
      <div class="flex justify-between items-center mt-6">
        <a href="../department-management.php" class="text-gray-600 hover:underline">← Cancel</a>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          <?= $edit_mode ? 'Update' : 'Add' ?>
        </button>
      </div>
    </form>
  </div>
</body>
</html>
