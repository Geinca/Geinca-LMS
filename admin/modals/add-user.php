<!-- admin/modals/add-user.php -->
<div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-xl p-6 relative">
    <button onclick="closeAddUserModal()" class="absolute top-2 right-3 text-gray-500 hover:text-red-600">
      <i class="fas fa-times"></i>
    </button>

    <h2 class="text-xl font-semibold text-gray-800 mb-4">
      <i class="fas fa-user-plus text-blue-600 mr-2"></i>Add New User
    </h2>

    <form action="#" method="POST" class="space-y-4">
      <div>
        <label class="block mb-1 font-medium text-gray-700">Full Name</label>
        <input type="text" name="full_name" required
               class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <div>
        <label class="block mb-1 font-medium text-gray-700">Email</label>
        <input type="email" name="email" required
               class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <div>
        <label class="block mb-1 font-medium text-gray-700">Phone Number</label>
        <input type="tel" name="phone"
               class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <div>
        <label class="block mb-1 font-medium text-gray-700">Role</label>
        <select name="role"
                class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="student">Student</option>
          <option value="teacher">Teacher</option>
          <option value="parent">Parent</option>
          <option value="admin">Admin</option>
        </select>
      </div>

      <div>
        <label class="block mb-1 font-medium text-gray-700">Password</label>
        <input type="password" name="password" required
               class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <div class="text-right pt-4">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
          <i class="fas fa-save mr-2"></i>Save User
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function closeAddUserModal() {
    document.querySelector('.fixed.inset-0.z-50').style.display = 'none';
  }
</script>
