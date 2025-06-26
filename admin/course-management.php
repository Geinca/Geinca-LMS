<?php
include('../auth/db.php');
session_start();

// Handle delete request
if (isset($_GET['delete'])) {
  $delete_id = intval($_GET['delete']);
  $stmt = $pdo->prepare("DELETE FROM courses WHERE course_id = ?");
  $stmt->execute([$delete_id]);
  header("Location: course-management.php");
  exit;
}

// Fetch all courses
$stmt = $pdo->query("
  SELECT course_id, department_id, course_name, course_code, fee_amount, duration_years
  FROM courses
  ORDER BY course_name
");
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Course Management | LMS ERP</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">

  <!-- Top Header -->
  <header class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center shadow-md">
    <h1 class="text-xl font-bold">LMS ERP - Admin Dashboard</h1>
    <div class="space-x-4">
      <span class="text-sm">Welcome, <?= htmlspecialchars($_SESSION['name'] ?? 'Admin') ?></span>
      <a href="../auth/logout.php" class="text-sm hover:underline">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
    </div>
  </header>

  <!-- Sidebar + Main Content Layout -->
  <div class="flex">

    <!-- Sidebar -->
    <?php include('../components/admin-sidebar.php'); ?>

    <!-- Main Section -->
    <main class="flex-1 p-6">
      <div class="bg-white shadow rounded p-6 max-w-6xl mx-auto">

        <!-- Page Header -->
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-semibold text-gray-800">Course Management</h2>
          <a href="modals/add-course.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Add Course
          </a>
        </div>

        <!-- Course Table -->
        <?php if (empty($courses)): ?>
          <p class="text-gray-600">No courses found.</p>
        <?php else: ?>
          <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 text-sm text-left">
              <thead class="bg-gray-100 text-gray-700 font-medium">
                <tr>
                  <th class="p-3 border">#</th>
                  <th class="p-3 border">Course Name</th>
                  <th class="p-3 border">Code</th>
                  <th class="p-3 border">Department ID</th>
                  <th class="p-3 border">Fee (₹)</th>
                  <th class="p-3 border">Duration</th>
                  <th class="p-3 border text-right">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($courses as $index => $course): ?>
                  <tr class="border-t hover:bg-gray-50">
                    <td class="p-3"><?= $index + 1 ?></td>
                    <td class="p-3"><?= htmlspecialchars($course['course_name']) ?></td>
                    <td class="p-3"><?= htmlspecialchars($course['course_code']) ?></td>
                    <td class="p-3"><?= $course['department_id'] ?></td>
                    <td class="p-3">₹<?= number_format($course['fee_amount']) ?></td>
                    <td class="p-3"><?= $course['duration_years'] ?> yr</td>
                    <td class="p-3 text-right space-x-3">
                      <a href="edit-course.php?id=<?= $course['course_id'] ?>" class="text-blue-600 hover:underline">
                        Edit
                      </a>
                      <a href="?delete=<?= $course['course_id'] ?>" onclick="return confirm('Delete this course?');" class="text-red-600 hover:underline">
                        Delete
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>

      </div>
    </main>
  </div>

</body>
</html>
