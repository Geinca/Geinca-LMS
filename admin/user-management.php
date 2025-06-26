<?php
// admin/user-management.php
include('../auth/db.php');
session_start();

// Check filter for user status
$status = ($_GET['show'] ?? 'active') === 'inactive' ? 'inactive' : 'active';

// Fetch users based on status
$stmt = $pdo->prepare("SELECT user_id, name, email, role FROM users WHERE status = ? ORDER BY created_at DESC");
$stmt->execute([$status]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Management | Admin | LMS ERP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

<!-- Header -->
<header class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center shadow-md">
  <h1 class="text-xl font-bold">User Management</h1>
  <a href="dashboard.php" class="text-sm hover:underline"><i class="fas fa-arrow-left mr-1"></i> Back to Dashboard</a>
</header>

<div class="flex flex-1">
  <!-- Sidebar -->
  <?php include('../components/admin-sidebar.php'); ?>

  <!-- Main Content -->
  <main class="flex-1 p-6">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-semibold text-gray-800">All <?= ucfirst($status) ?> Users</h2>
      <div class="space-x-4">
        <a href="modals/add-edit-user.php" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
          <i class="fas fa-user-plus mr-2"></i>Add User
        </a>
        <a href="?show=<?= $status === 'active' ? 'inactive' : 'active' ?>" class="text-sm text-gray-600 underline">
          <?= $status === 'active' ? 'View Inactive Users' : 'View Active Users' ?>
        </a>
      </div>
    </div>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
      <table class="min-w-full text-sm text-left">
        <thead class="bg-gray-200 text-gray-600 uppercase">
          <tr>
            <th class="px-6 py-3">Name</th>
            <th class="px-6 py-3">Email</th>
            <th class="px-6 py-3">Role</th>
            <th class="px-6 py-3">Status</th>
            <th class="px-6 py-3">Actions</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          <?php foreach ($users as $user): ?>
            <tr class="border-b hover:bg-gray-50">
              <td class="px-6 py-4"><?= htmlspecialchars($user['name']) ?></td>
              <td class="px-6 py-4"><?= htmlspecialchars($user['email']) ?></td>
              <td class="px-6 py-4 capitalize"><?= htmlspecialchars($user['role']) ?></td>
              <td class="px-6 py-4">
                <?php if ($status === 'active'): ?>
                  <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">Active</span>
                <?php else: ?>
                  <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">Inactive</span>
                <?php endif; ?>
              </td>
              <td class="px-6 py-4 space-x-2">
                <?php if ($status === 'active'): ?>
                  <a href="modals/add-edit-user.php?id=<?= $user['user_id'] ?>" class="text-blue-600 hover:underline" title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="delete-user.php?id=<?= $user['user_id'] ?>" onclick="return confirm('Are you sure you want to deactivate this user?')" class="text-red-600 hover:underline" title="Deactivate">
                    <i class="fas fa-trash"></i>
                  </a>
                <?php else: ?>
                  <a href="restore-user.php?id=<?= $user['user_id'] ?>" onclick="return confirm('Restore this user?')" class="text-green-600 hover:underline" title="Restore">
                    <i class="fas fa-undo"></i>
                  </a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>
</body>
</html>
