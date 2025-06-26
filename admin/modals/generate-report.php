<!-- admin/modals/generate-report.php -->
<div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-xl p-6 relative">
    <button onclick="closeGenerateReportModal()" class="absolute top-2 right-3 text-gray-500 hover:text-red-600">
      <i class="fas fa-times"></i>
    </button>

    <h2 class="text-xl font-semibold text-gray-800 mb-4">
      <i class="fas fa-file-alt text-purple-600 mr-2"></i>Generate Report Card
    </h2>

    <form action="#" method="POST" class="space-y-4">
      <div>
        <label class="block text-gray-700 font-medium mb-1">Student Name</label>
        <input type="text" name="student_name" placeholder="Enter student full name"
               class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-purple-500">
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Class</label>
        <input type="text" name="class" placeholder="10-B"
               class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-purple-500">
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Term</label>
        <select name="term" class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-purple-500">
          <option value="Term 1">Term 1</option>
          <option value="Term 2">Term 2</option>
          <option value="Final">Final</option>
        </select>
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Upload Marks CSV</label>
        <input type="file" name="marks_csv"
               class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-purple-500">
      </div>

      <div class="text-right pt-4">
        <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded hover:bg-purple-700">
          <i class="fas fa-file-export mr-2"></i>Generate
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function closeGenerateReportModal() {
    document.querySelector('.fixed.inset-0.z-50').style.display = 'none';
  }
</script>

