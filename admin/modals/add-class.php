<!-- admin/modals/add-class.php -->
<div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
    <button onclick="closeAddClassModal()" class="absolute top-2 right-3 text-gray-500 hover:text-red-600">
      <i class="fas fa-times"></i>
    </button>

    <h2 class="text-xl font-semibold text-gray-800 mb-4">
      <i class="fas fa-school text-green-600 mr-2"></i>Add / Edit Class
    </h2>

    <form action="#" method="POST" class="space-y-4">
      <div>
        <label class="block text-gray-700 font-medium mb-1">Class Name</label>
        <input type="text" name="class_name" placeholder="E.g. 10-B"
               class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" />
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Class Teacher</label>
        <input type="text" name="class_teacher" placeholder="Mr. Sharma"
               class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" />
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Subjects</label>
        <input type="text" name="subjects" placeholder="Math, Science, English"
               class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" />
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Timings</label>
        <input type="text" name="timing" placeholder="9:00 AM - 3:00 PM"
               class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" />
      </div>

      <div class="text-right pt-4">
        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
          <i class="fas fa-check mr-2"></i>Save Class
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function closeAddClassModal() {
    document.querySelector('.fixed.inset-0.z-50').style.display = 'none';
  }
</script>
