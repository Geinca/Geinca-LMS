<!-- admin/ai-configuration.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AI Configuration | Admin | LMS ERP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center shadow">
    <h1 class="text-xl font-bold">AI Configuration</h1>
    <a href="dashboard.php" class="text-sm hover:underline"><i class="fas fa-arrow-left mr-1"></i>Back to Dashboard</a>
  </header>

  <div class="flex flex-1">
    <!-- Sidebar -->
    <?php include('../components/admin-sidebar.php'); ?>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <h2 class="text-2xl font-semibold text-gray-800 mb-6">AI Settings & Thresholds</h2>

      <div class="bg-white p-6 rounded-lg shadow-md max-w-4xl">
        <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700">Suggestion Frequency</label>
            <select class="w-full border px-3 py-2 rounded">
              <option>Weekly</option>
              <option>Monthly</option>
              <option>After Exams</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Performance Threshold (%)</label>
            <input type="number" min="0" max="100" value="40" class="w-full border px-3 py-2 rounded">
          </div>
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Default Advice Message</label>
            <textarea class="w-full border px-3 py-2 rounded" rows="3">Focus on weak areas and review study materials regularly.</textarea>
          </div>
          <div class="md:col-span-2 text-right">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
              <i class="fas fa-save mr-2"></i>Save Configuration
            </button>
          </div>
        </form>
      </div>

      <!-- Info Section -->
      <div class="mt-8 bg-yellow-50 p-4 border-l-4 border-yellow-400 rounded text-sm text-gray-700">
        <p><strong>Note:</strong> AI suggestions are generated based on exam scores, attendance, and assignment performance. Adjust thresholds to control sensitivity.</p>
      </div>
    </main>
  </div>
</body>
</html>
