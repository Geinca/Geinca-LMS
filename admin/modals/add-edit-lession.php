<?php
require_once '../../auth/db.php';

// Initialize lesson data
$lesson = [
    'id' => '',
    'section_id' => '',
    'title' => '',
    'description' => '',
    'video_url' => '',
    'duration' => 0,
    'position' => 1,
    'is_preview' => 0
];

// Fetch lesson data if editing
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM lessons WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $lesson = $stmt->fetch(PDO::FETCH_ASSOC) ?: $lesson;
}

// Fetch sections for dropdown
$sections = $pdo->query("SELECT s.id, s.title, c.title AS course_title 
                         FROM sections s
                         JOIN classes c ON s.class_id = c.id
                         ORDER BY c.title, s.position")->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lessonData = [
        'section_id' => $_POST['section_id'],
        'title' => trim($_POST['title']),
        'description' => trim($_POST['description']),
        'video_url' => trim($_POST['video_url']),
        'duration' => (int)$_POST['duration'],
        'position' => (int)$_POST['position'],
        'is_preview' => isset($_POST['is_preview']) ? 1 : 0
    ];

    try {
        if (!empty($lesson['id'])) {
            // Update existing lesson
            $stmt = $pdo->prepare("UPDATE lessons SET 
                section_id = ?, title = ?, description = ?, video_url = ?,
                duration = ?, position = ?, is_preview = ?
                WHERE id = ?");
            $stmt->execute(array_merge(array_values($lessonData), [$lesson['id']]));
        } else {
            // Create new lesson
            $stmt = $pdo->prepare("INSERT INTO lessons 
                (section_id, title, description, video_url, duration, position, is_preview, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->execute(array_values($lessonData));
        }
        
        header("Location: ../lessons.php?success=1");
        exit;
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $lesson['id'] ? 'Edit' : 'Add' ?> Lesson</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
</head>
<body class="bg-gray-100">
  <div class="max-w-3xl mx-auto my-10 bg-white p-8 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6"><?= $lesson['id'] ? 'Edit' : 'Add' ?> Lesson</h2>
    
    <form method="POST">
      <div class="mb-4">
        <label class="block text-gray-700 mb-2 font-medium">Section*</label>
        <select name="section_id" class="w-full px-4 py-2 border rounded-lg" required>
          <option value="">— Select Section —</option>
          <?php foreach ($sections as $section): ?>
            <option value="<?= $section['id'] ?>" 
              <?= $section['id'] == $lesson['section_id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($section['course_title']) ?> - <?= htmlspecialchars($section['title']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      
      <div class="mb-4">
        <label class="block text-gray-700 mb-2 font-medium">Title*</label>
        <input type="text" name="title" value="<?= htmlspecialchars($lesson['title']) ?>" 
               class="w-full px-4 py-2 border rounded-lg" required>
      </div>
      
      <div class="mb-4">
        <label class="block text-gray-700 mb-2 font-medium">Description</label>
        <textarea name="description" id="description" class="w-full px-4 py-2 border rounded-lg"><?= 
            htmlspecialchars($lesson['description']) ?></textarea>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-gray-700 mb-2 font-medium">Video URL</label>
          <input type="url" name="video_url" value="<?= htmlspecialchars($lesson['video_url']) ?>" 
                 class="w-full px-4 py-2 border rounded-lg" 
                 placeholder="https://youtube.com/watch?v=... or https://vimeo.com/...">
        </div>
        
        <div>
          <label class="block text-gray-700 mb-2 font-medium">Duration (seconds)</label>
          <input type="number" name="duration" value="<?= htmlspecialchars($lesson['duration']) ?>" 
                 class="w-full px-4 py-2 border rounded-lg">
        </div>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
          <label class="block text-gray-700 mb-2 font-medium">Position in Section</label>
          <input type="number" name="position" value="<?= htmlspecialchars($lesson['position']) ?>" 
                 class="w-full px-4 py-2 border rounded-lg" min="1">
        </div>
        
        <div class="flex items-center">
          <input type="checkbox" name="is_preview" id="is_preview" 
                 class="mr-2 h-5 w-5" <?= $lesson['is_preview'] ? 'checked' : '' ?>>
          <label for="is_preview" class="text-gray-700 font-medium">Available as preview</label>
        </div>
      </div>
      
      <div class="flex justify-between">
        <a href="../lessons.php" class="bg-gray-300 text-gray-800 px-6 py-3 rounded-lg">Cancel</a>
        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
          <?= $lesson['id'] ? 'Update' : 'Create' ?> Lesson
        </button>
      </div>
    </form>
  </div>

  <script>
    CKEDITOR.replace('description');
  </script>
</body>
</html>