<!-- admin/attendance-reports.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Attendance Reports | Admin | LMS ERP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center shadow">
    <h1 class="text-xl font-bold">Attendance Reports</h1>
    <a href="dashboard.php" class="text-sm hover:underline"><i class="fas fa-arrow-left mr-1"></i>Back to Dashboard</a>
  </header>

  <div class="flex flex-1">
    <!-- Sidebar -->
    <?php include('../components/admin-sidebar.php'); ?>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <h2 class="text-2xl font-semibold text-gray-800 mb-6">View Attendance Summary</h2>

      <div class="bg-white p-6 rounded-lg shadow-md max-w-5xl">
        <form class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
          <div>
            <label class="block text-sm font-medium text-gray-700">Select Class</label>
            <select class="w-full border px-3 py-2 rounded">
              <option>10-A</option>
              <option>10-B</option>
              <option>11-C</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Month</label>
            <select class="w-full border px-3 py-2 rounded">
              <option>June 2025</option>
              <option>May 2025</option>
              <option>April 2025</option>
            </select>
          </div>
          <div class="flex items-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">
              <i class="fas fa-search mr-1"></i>View Report
            </button>
          </div>
        </form>

        <!-- Table -->
        <div class="overflow-x-auto">
          <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-200 text-gray-600 uppercase">
              <tr>
                <th class="px-6 py-3">Roll No</th>
                <th class="px-6 py-3">Name</th>
                <th class="px-6 py-3">Days Present</th>
                <th class="px-6 py-3">Days Absent</th>
                <th class="px-6 py-3">Attendance %</th>
              </tr>
            </thead>
            <tbody class="text-gray-700">
              <tr class="border-b">
                <td class="px-6 py-4">25</td>
                <td class="px-6 py-4">John Doe</td>
                <td class="px-6 py-4">22</td>
                <td class="px-6 py-4">2</td>
                <td class="px-6 py-4">91.6%</td>
              </tr>
              <tr class="border-b">
                <td class="px-6 py-4">32</td>
                <td class="px-6 py-4">Jane Smith</td>
                <td class="px-6 py-4">20</td>
                <td class="px-6 py-4">4</td>
                <td class="px-6 py-4">83.3%</td>
              </tr>
              <!-- More rows -->
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
