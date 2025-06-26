<!-- admin/report-card-generator.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Report Card Generator | Admin | LMS ERP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center shadow">
    <h1 class="text-xl font-bold">Report Card Generator</h1>
    <a href="dashboard.php" class="text-sm hover:underline"><i class="fas fa-arrow-left mr-1"></i>Back to Dashboard</a>
  </header>

  <div class="flex flex-1">
    <!-- Sidebar -->
    <?php include('../components/admin-sidebar.php'); ?>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Generate Report Cards</h2>
      </div>

      <!-- Form -->
      <div class="bg-white p-6 rounded-lg shadow-md max-w-4xl">
        <form class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Class</label>
            <select class="w-full border px-3 py-2 rounded">
              <option>Select Class</option>
              <option>10-A</option>
              <option>10-B</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Exam</label>
            <select class="w-full border px-3 py-2 rounded">
              <option>Select Exam</option>
              <option>Mid-Term</option>
              <option>Final</option>
            </select>
          </div>
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Term</label>
            <input type="text" placeholder="e.g. 2024-25 Term 1" class="w-full border px-3 py-2 rounded">
          </div>
          <div class="md:col-span-2 text-right mt-4">
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
              <i class="fas fa-file-pdf mr-2"></i>Generate PDFs
            </button>
          </div>
        </form>
      </div>

      <!-- Generated List (if applicable) -->
      <div class="mt-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recently Generated</h3>
        <div class="bg-white rounded shadow overflow-x-auto">
          <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-200 text-gray-600 uppercase">
              <tr>
                <th class="px-6 py-3">Class</th>
                <th class="px-6 py-3">Exam</th>
                <th class="px-6 py-3">Generated On</th>
                <th class="px-6 py-3">Action</th>
              </tr>
            </thead>
            <tbody class="text-gray-700">
              <tr class="border-b">
                <td class="px-6 py-4">10-A</td>
                <td class="px-6 py-4">Mid-Term</td>
                <td class="px-6 py-4">16 Jun 2025</td>
                <td class="px-6 py-4">
                  <a href="#" class="text-blue-600 hover:underline"><i class="fas fa-download mr-1"></i>Download</a>
                </td>
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
