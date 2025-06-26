<!-- admin/modals/send-notification.php -->
<div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
    <button onclick="closeSendNotificationModal()" class="absolute top-2 right-3 text-gray-500 hover:text-red-600">
      <i class="fas fa-times"></i>
    </button>

    <h2 class="text-xl font-semibold text-gray-800 mb-4">
      <i class="fas fa-bell text-yellow-500 mr-2"></i>Send Notification
    </h2>

    <form action="#" method="POST" class="space-y-4">
      <div>
        <label class="block text-gray-700 font-medium mb-1">Recipient Group</label>
        <select name="recipient" class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-yellow-400">
          <option value="all">All Users</option>
          <option value="students">Students</option>
          <option value="teachers">Teachers</option>
          <option value="parents">Parents</option>
        </select>
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Title</label>
        <input type="text" name="title" placeholder="Enter notification title"
               class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-yellow-400">
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Message</label>
        <textarea name="message" rows="4" placeholder="Type your message here..."
                  class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-yellow-400"></textarea>
      </div>

      <div class="text-right pt-4">
        <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600">
          <i class="fas fa-paper-plane mr-2"></i>Send
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function closeSendNotificationModal() {
    document.querySelector('.fixed.inset-0.z-50').style.display = 'none';
  }
</script>
