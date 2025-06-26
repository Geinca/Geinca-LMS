<?php
include('../auth/db.php');

// Fetch department data
$query = "
  SELECT 
    d.department_id, 
    d.name AS dept_name,
    u.name AS hod_name,
    (
      SELECT COUNT(*) 
      FROM subjects s 
      JOIN courses c ON s.course_id = c.course_id
      WHERE c.department_id = d.department_id
    ) AS subject_count
  FROM departments d
  LEFT JOIN users u ON d.head_id = u.user_id
 
  ORDER BY d.name
";
$stmt = $pdo->prepare($query);
$stmt->execute();
$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Department Management | Admin | LMS ERP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

<!-- Header -->
<header class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center shadow-md">
  <h1 class="text-xl font-bold">Classes Management</h1>
  <a href="dashboard.php" class="text-sm hover:underline"><i class="fas fa-arrow-left mr-1"></i> Back to Dashboard</a>
</header>

<div class="flex flex-1">
  <!-- Sidebar -->
  <?php include('../components/admin-sidebar.php'); ?>

  <!-- Main Content -->
  <main class="flex-1 p-6">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-semibold text-gray-800">All Classes</h2>
      <a href="modals/add-edit-department.php" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Add Class
      </a>
    </div>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
      <table class="min-w-full text-sm text-left">
        <thead class="bg-gray-200 text-gray-600 uppercase">
          <tr>
            <th class="px-6 py-3">Class</th>
            <th class="px-6 py-3">Instructor</th>
            <th class="px-6 py-3">No. of Subjects</th>
            <th class="px-6 py-3">Actions</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          <?php foreach ($departments as $dept): ?>
            <tr class="border-b hover:bg-gray-50">
              <td class="px-6 py-4"><?= htmlspecialchars($dept['dept_name']) ?></td>
              <td class="px-6 py-4"><?= $dept['hod_name'] ? htmlspecialchars($dept['hod_name']) : '—' ?></td>
              <td class="px-6 py-4"><?= $dept['subject_count'] ?></td>
              <td class="px-6 py-4 space-x-2">
                <a href="modals/add-edit-department.php?id=<?= $dept['department_id'] ?>" class="text-blue-600 hover:underline" title="Edit">
                  <i class="fas fa-edit"></i>
                </a>
                <a href="delete-department.php?id=<?= $dept['department_id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Are you sure you want to delete this department?')" title="Delete">
                  <i class="fas fa-trash"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php if (count($departments) === 0): ?>
            <tr>
              <td colspan="4" class="px-6 py-4 text-center text-gray-500">No departments found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>
</body>
</html>
