<!-- admin/notifications.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Notifications Manager | Admin | LMS ERP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center shadow">
    <h1 class="text-xl font-bold">Notifications Manager</h1>
    <a href="dashboard.php" class="text-sm hover:underline"><i class="fas fa-arrow-left mr-1"></i>Back to Dashboard</a>
  </header>

  <div class="flex flex-1">
    <!-- Sidebar -->
    <?php include('../components/admin-sidebar.php'); ?>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <h2 class="text-2xl font-semibold text-gray-800 mb-6">Manage Notifications</h2>

      <!-- Send Notification Button -->
      <div class="mb-4">
        <a href="modals/send-notification.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          <i class="fas fa-paper-plane mr-1"></i>Send New Notification
        </a>
      </div>

      <!-- Notifications Table -->
      <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full text-sm text-left">
          <thead class="bg-gray-200 text-gray-700 uppercase">
            <tr>
              <th class="px-6 py-3">Title</th>
              <th class="px-6 py-3">Message</th>
              <th class="px-6 py-3">Target</th>
              <th class="px-6 py-3">Date</th>
              <th class="px-6 py-3">Action</th>
            </tr>
          </thead>
          <tbody class="text-gray-700">
            <tr class="border-b">
              <td class="px-6 py-4 font-medium">Exam Reminder</td>
              <td class="px-6 py-4">Final exams begin next Monday</td>
              <td class="px-6 py-4">Students</td>
              <td class="px-6 py-4">15 Jun 2025</td>
              <td class="px-6 py-4">
                <button class="text-red-600 hover:text-red-800">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </td>
            </tr>
            <tr class="border-b">
              <td class="px-6 py-4 font-medium">Fee Due</td>
              <td class="px-6 py-4">Last date to pay fee is 30 Jun</td>
              <td class="px-6 py-4">Parents</td>
              <td class="px-6 py-4">10 Jun 2025</td>
              <td class="px-6 py-4">
                <button class="text-red-600 hover:text-red-800">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </td>
            </tr>
            <!-- Add more rows dynamically -->
          </tbody>
        </table>
      </div>
    </main>
  </div>
</body>
</html>
