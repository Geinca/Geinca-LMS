<?php

require_once 'C:/xampp/htdocs/Geinca-LMS/db.php';

try {
    // Check filter for user status
    $status = ($_GET['show'] ?? 'active') === 'inactive' ? 'inactive' : 'active';

    // Fetch users based on status
    $stmt = $pdo->prepare("SELECT id, name, email, role, status, created_at FROM users WHERE status = ? ORDER BY created_at DESC");
    $stmt->execute([$status]);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($users === false) {
        throw new Exception("Failed to fetch users");
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Management | Admin | LMS ERP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Header -->
  <header class="ml-64 bg-gray-800 text-white px-6 py-4 flex justify-between items-center shadow-md">
    <h1 class="text-xl font-bold">User Management</h1>
    <a href="dashboard.php" class="text-sm hover:underline"><i class="fas fa-arrow-left mr-1"></i> Back to Dashboard</a>
  </header>

  <div class="flex flex-1">
    <!-- Sidebar -->
    <?php include __DIR__ . '/../partials/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="flex-1 p-6 ml-64">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">All <?= ucfirst($status) ?> Users</h2>
        <div class="space-x-4 flex items-center">

          <!-- modals for add user -->
          <div x-data="{ open: false }">
            <!-- Trigger Button goes here -->
            <button @click="open = true" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
              <i class="fas fa-user-plus mr-2"></i>Add User
            </button>

            <!-- Modal -->
            <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" x-cloak>
              <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
                <h2 class="text-lg font-bold mb-4">Add User</h2>
                <form method="POST" action="modals/add-user.php">
                  <div class="mb-4">
                    <label class="block font-medium mb-1">Full Name</label>
                    <input type="text" name="fullname" class="w-full border border-gray-300 px-3 py-2 rounded-md" required>
                  </div>
                  <div class="mb-4">
                    <label class="block font-medium mb-1">Email</label>
                    <input type="email" name="email" class="w-full border border-gray-300 px-3 py-2 rounded-md" required>
                  </div>
                  <div class="mb-4">
                    <label class="block font-medium mb-1">Password</label>
                    <input type="password" name="password" class="w-full border border-gray-300 px-3 py-2 rounded-md" required>
                  </div>
                  <div class="mb-4">
                    <label class="block font-medium mb-1">Role</label>
                    <select name="role" class="w-full border border-gray-300 px-3 py-2 rounded-md" required>
                      <option value="student">Student</option>
                      <option value="instructor">Instructor</option>
                    </select>
                  </div>
                  <div class="flex justify-end space-x-2">
                    <button type="button" @click="open = false" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Add</button>
                  </div>
                </form>

                <!-- Close button -->
                <button @click="open = false" class="absolute top-3 right-4 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
              </div>
            </div>
          </div>




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
                  <?php if ($user['status'] === 'active'): ?>
                    <button onclick="openEditModal(<?= $user['id'] ?>, '<?= $user['name'] ?>', '<?= $user['email'] ?>', '<?= $user['role'] ?>')" class="text-blue-600 hover:underline" title="Edit">
                      <i class="fas fa-edit"></i>
                    </button>
                    <!-- Delete Button -->
                    <form method="POST" action="./modals/delete-user.php" onsubmit="return confirm('Are you sure?')" class="inline">
                      <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                      <button type="submit" class="text-red-600 hover:underline" title="Delete">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                    </a>
                  <?php else: ?>
                    <a href="restore-user.php?id=<?= $user['id'] ?>" onclick="return confirm('Restore this user?')" class="text-green-600 hover:underline" title="Restore">
                      <i class="fas fa-undo"></i>
                    </a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <!-- Edit Modal -->
        <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
          <div class="bg-white p-6 rounded shadow-lg w-full max-w-md relative">
            <button onclick="closeEditModal()" class="absolute top-2 right-2 text-gray-500 hover:text-red-600 text-xl">&times;</button>
            <h2 class="text-lg font-semibold mb-4">Edit User</h2>
            <form action="./modals/update-user.php" method="POST">
              <input type="hidden" name="user_id" id="editUserId">
              <div class="mb-3">
                <label class="block text-sm font-medium">Name</label>
                <input type="text" name="name" id="editName" class="w-full border px-3 py-2 rounded" required>
              </div>
              <div class="mb-3">
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" id="editEmail" class="w-full border px-3 py-2 rounded" required>
              </div>
              <div class="mb-4">
                <label class="block text-sm font-medium">Role</label>
                <select name="role" id="editRole" class="w-full border px-3 py-2 rounded">
                  <option value="student">Student</option>
                  <option value="instructor">Instructor</option>
                </select>
              </div>
              <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Update</button>
            </form>
          </div>
        </div>

      </div>
    </main>
  </div>


  <!-- Alpine js -->
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

  <script>
    function openEditModal(id, name, email, role) {
      document.getElementById('editUserId').value = id;
      document.getElementById('editName').value = name;
      document.getElementById('editEmail').value = email;
      document.getElementById('editRole').value = role;
      document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
      document.getElementById('editModal').classList.add('hidden');
    }
  </script>


</body>

</html>