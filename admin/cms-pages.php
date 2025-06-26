<!-- admin/cms-pages.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>CMS Pages | Admin | LMS ERP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center shadow">
    <h1 class="text-xl font-bold">CMS Pages</h1>
    <a href="dashboard.php" class="text-sm hover:underline"><i class="fas fa-arrow-left mr-1"></i>Back to Dashboard</a>
  </header>

  <div class="flex flex-1">
    <!-- Sidebar -->
    <?php include('../components/admin-sidebar.php'); ?>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <h2 class="text-2xl font-semibold text-gray-800 mb-6">Manage Content Pages</h2>

      <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
        <table class="min-w-full text-sm text-left">
          <thead class="bg-gray-200 text-gray-700 uppercase">
            <tr>
              <th class="px-6 py-3">Page Name</th>
              <th class="px-6 py-3">Slug</th>
              <th class="px-6 py-3">Last Updated</th>
              <th class="px-6 py-3">Actions</th>
            </tr>
          </thead>
          <tbody class="text-gray-700">
            <tr class="border-b">
              <td class="px-6 py-4 font-medium">About Us</td>
              <td class="px-6 py-4">/about</td>
              <td class="px-6 py-4">14 Jun 2025</td>
              <td class="px-6 py-4">
                <a href="edit-page.php?page=about" class="text-blue-600 hover:underline mr-4"><i class="fas fa-edit"></i> Edit</a>
                <button class="text-red-600 hover:text-red-800"><i class="fas fa-trash-alt"></i> Delete</button>
              </td>
            </tr>
            <tr class="border-b">
              <td class="px-6 py-4 font-medium">Privacy Policy</td>
              <td class="px-6 py-4">/privacy-policy</td>
              <td class="px-6 py-4">10 Jun 2025</td>
              <td class="px-6 py-4">
                <a href="edit-page.php?page=privacy-policy" class="text-blue-600 hover:underline mr-4"><i class="fas fa-edit"></i> Edit</a>
                <button class="text-red-600 hover:text-red-800"><i class="fas fa-trash-alt"></i> Delete</button>
              </td>
            </tr>
            <!-- More rows as needed -->
          </tbody>
        </table>

        <div class="mt-4 text-right">
          <a href="edit-page.php" class="inline-block bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700">
            <i class="fas fa-plus mr-1"></i>Add New Page
          </a>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
