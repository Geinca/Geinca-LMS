<?php
include('../auth/db.php');

// Fetch subjects with related data
$stmt = $pdo->prepare("
  SELECT 
    s.subject_id,
    s.name AS subject_name,
    s.course_id,
    co.course_code,
    co.course_name,
    d.name AS department_name,
    u.name AS teacher_name
  FROM subjects s
  JOIN courses co ON s.course_id = co.course_id
  JOIN departments d ON co.department_id = d.department_id
  JOIN teachers t ON s.teacher_id = t.teacher_id
  JOIN users u ON t.teacher_id = u.user_id
");
$stmt->execute();
$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Subject Management | Admin | LMS ERP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center shadow-md">
    <h1 class="text-xl font-bold">Subject Management</h1>
    <a href="dashboard.php" class="text-sm hover:underline"><i class="fas fa-arrow-left mr-1"></i> Back to Dashboard</a>
  </header>

  <div class="flex flex-1">
    <!-- Sidebar -->
    <?php include('../components/admin-sidebar.php'); ?>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">All Subjects</h2>
        <a href="modals/add-edit-subject.php" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
          <i class="fas fa-plus mr-2"></i>Add Subject
        </a>
      </div>

      <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full text-sm text-left">
          <thead class="bg-gray-200 text-gray-600 uppercase">
            <tr>
              <th class="px-6 py-3">Subject Name</th>
              <th class="px-6 py-3">Course Code</th>
              <th class="px-6 py-3">Department</th>
              <th class="px-6 py-3">Assigned Teacher</th>
              <th class="px-6 py-3">Actions</th>
            </tr>
          </thead>
          <tbody class="text-gray-700">
            <?php foreach ($subjects as $subject): ?>
              <tr class="border-b">
                <td class="px-6 py-4"><?= htmlspecialchars($subject['subject_name']) ?></td>
                <td class="px-6 py-4"><?= htmlspecialchars($subject['course_code']) ?></td>
                <td class="px-6 py-4"><?= htmlspecialchars($subject['department_name']) ?></td>
                <td class="px-6 py-4"><?= htmlspecialchars($subject['teacher_name']) ?></td>
                <td class="px-6 py-4 space-x-2">
                  <a href="modals/add-edit-subject.php?id=<?= $subject['subject_id'] ?>" class="text-blue-600 hover:underline"><i class="fas fa-edit"></i></a>
                  <a href="delete-subject.php?id=<?= $subject['subject_id'] ?>" onclick="return confirm('Delete subject?')" class="text-red-600 hover:underline"><i class="fas fa-trash"></i></a>
                </td>
              </tr>
            <?php endforeach; ?>
            <?php if (count($subjects) === 0): ?>
              <tr>
                <td colspan="5" class="text-center px-6 py-4 text-gray-500">No subjects found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</body>
</html>
