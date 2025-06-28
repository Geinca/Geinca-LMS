<?php
require_once 'C:/xampp/htdocs/geinca/Geinca-LMS/db.php';

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

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if this is a course creation request
    if (isset($_POST['add_course'])) {
        try {
            $stmt = $pdo->prepare("INSERT INTO classes (title, description, created_at) 
                                  VALUES (?, ?, NOW())");
            $stmt->execute([
                trim($_POST['course_title']),
                trim($_POST['course_description'])
            ]);
            
            // Return the new course ID
            $newCourseId = $pdo->lastInsertId();
            echo json_encode(['success' => true, 'course_id' => $newCourseId]);
            exit;
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit;
        }
    }
    
    // Check if this is a section creation request
    if (isset($_POST['add_section'])) {
        try {
            $stmt = $pdo->prepare("INSERT INTO sections (class_id, title, position, created_at) 
                                  VALUES (?, ?, ?, NOW())");
            $stmt->execute([
                $_POST['class_id'],
                trim($_POST['section_title']),
                (int)$_POST['section_position']
            ]);
            
            // Return the new section ID
            $newSectionId = $pdo->lastInsertId();
            echo json_encode(['success' => true, 'section_id' => $newSectionId]);
            exit;
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit;
        }
    }
    
    // Handle lesson creation/update
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
        if (!empty($_POST['lesson_id'])) {
            // Update existing lesson
            $stmt = $pdo->prepare("UPDATE lessons SET 
                section_id = ?, title = ?, description = ?, video_url = ?,
                duration = ?, position = ?, is_preview = ?
                WHERE id = ?");
            $stmt->execute(array_merge(array_values($lessonData), [$_POST['lesson_id']]));
        } else {
            // Create new lesson
            $stmt = $pdo->prepare("INSERT INTO lessons 
                (section_id, title, description, video_url, duration, position, is_preview, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->execute(array_values($lessonData));
        }
        
        header("Location: lessons.php?success=1");
        exit;
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}

// Fetch all lessons with their section information
try {
    $query = "SELECT 
                l.id, 
                l.section_id, 
                l.title, 
                l.description, 
                l.video_url, 
                l.duration, 
                l.position, 
                l.is_preview, 
                l.created_at,
                s.title AS section_title,
                c.title AS course_title
              FROM lessons l
              JOIN sections s ON l.section_id = s.id
              JOIN classes c ON s.class_id = c.id
              ORDER BY c.title, s.position, l.position";
    
    $lessons = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Fetch sections for dropdown
$sections = $pdo->query("SELECT s.id, s.title, c.title AS course_title, c.id AS class_id
                         FROM sections s
                         JOIN classes c ON s.class_id = c.id
                         ORDER BY c.title, s.position")->fetchAll(PDO::FETCH_ASSOC);

// Fetch classes for section creation
$classes = $pdo->query("SELECT id, title FROM classes ORDER BY title")->fetchAll(PDO::FETCH_ASSOC);

// Function to format duration (seconds to H:MM:SS)
function formatDuration($seconds) {
    return gmdate("H:i:s", $seconds);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lesson Management | Admin | LMS ERP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

<!-- Header -->
<header class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center shadow-md">
  <h1 class="text-xl font-bold">Lesson Management</h1>
  <a href="dashboard.php" class="text-sm hover:underline"><i class="fas fa-arrow-left mr-1"></i> Back to Dashboard</a>
</header>

<div class="flex flex-1">
  <!-- Sidebar -->
  <?php include __DIR__ . '/../partials/sidebar.php'; ?>

  <!-- Main Content -->
  <main class="flex-1 p-6">
    <?php if (isset($_GET['success'])): ?>
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        Lesson saved successfully!
      </div>
    <?php endif; ?>
    
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-semibold text-gray-800">All Lessons</h2>
      <button onclick="openLessonModal()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Add Lesson
      </button>
    </div>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
      <table class="min-w-full text-sm text-left">
        <thead class="bg-gray-200 text-gray-600 uppercase">
          <tr>
            <th class="px-6 py-3">Course</th>
            <th class="px-6 py-3">Section</th>
            <th class="px-6 py-3">Lesson</th>
            <th class="px-6 py-3">Video</th>
            <th class="px-6 py-3">Duration</th>
            <th class="px-6 py-3">Preview</th>
            <th class="px-6 py-3">Actions</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          <?php foreach ($lessons as $lesson): ?>
            <tr class="border-b hover:bg-gray-50">
              <td class="px-6 py-4"><?= htmlspecialchars($lesson['course_title']) ?></td>
              <td class="px-6 py-4"><?= htmlspecialchars($lesson['section_title']) ?></td>
              <td class="px-6 py-4">
                <div class="font-medium"><?= htmlspecialchars($lesson['title']) ?></div>
                <?php if (!empty($lesson['description'])): ?>
                  <div class="text-gray-500 text-sm mt-1"><?= htmlspecialchars(substr($lesson['description'], 0, 50)) ?>...</div>
                <?php endif; ?>
              </td>
              <td class="px-6 py-4">
                <?php if (!empty($lesson['video_url'])): ?>
                  <a href="<?= htmlspecialchars($lesson['video_url']) ?>" 
                     target="_blank" 
                     class="text-blue-600 hover:underline flex items-center">
                    <i class="fas fa-play-circle mr-1"></i> Watch
                  </a>
                <?php else: ?>
                  <span class="text-gray-400">No video</span>
                <?php endif; ?>
              </td>
              <td class="px-6 py-4"><?= formatDuration($lesson['duration']) ?></td>
              <td class="px-6 py-4">
                <?php if ($lesson['is_preview']): ?>
                  <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Yes</span>
                <?php else: ?>
                  <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">No</span>
                <?php endif; ?>
              </td>
              <td class="px-6 py-4 space-x-2">
                <button onclick="openLessonModal(
                  '<?= $lesson['id'] ?>',
                  '<?= $lesson['section_id'] ?>',
                  '<?= addslashes($lesson['title']) ?>',
                  `<?= addslashes($lesson['description']) ?>`,
                  '<?= addslashes($lesson['video_url']) ?>',
                  '<?= $lesson['duration'] ?>',
                  '<?= $lesson['position'] ?>',
                  '<?= $lesson['is_preview'] ?>'
                )" class="text-blue-600 hover:underline" title="Edit">
                  <i class="fas fa-edit"></i>
                </button>
                <a href="delete-lesson.php?id=<?= $lesson['id'] ?>" 
                   class="text-red-600 hover:underline" 
                   onclick="return confirm('Are you sure you want to delete this lesson?')" 
                   title="Delete">
                  <i class="fas fa-trash"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php if (empty($lessons)): ?>
            <tr>
              <td colspan="7" class="px-6 py-4 text-center text-gray-500">No lessons found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>

<!-- Lesson Modal -->
<div id="lessonModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white rounded-lg w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
    <div class="p-6">
      <div class="flex justify-between items-center mb-4">
        <h3 id="modalTitle" class="text-xl font-bold">Add New Lesson</h3>
        <button onclick="closeLessonModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
      </div>
      
      <form id="lessonForm" method="POST" class="space-y-4">
        <input type="hidden" name="lesson_id" id="lesson_id">
        
        <div>
          <div class="flex justify-between items-center mb-2">
            <label for="section_id" class="block text-gray-700 font-medium">Section*</label>
            <button type="button" onclick="openSectionModal()" class="text-sm text-blue-600 hover:underline">
              <i class="fas fa-plus mr-1"></i>Add New Section
            </button>
          </div>
          <select name="section_id" id="section_id" class="w-full px-4 py-2 border rounded-lg" required>
            <option value="">— Select Section —</option>
            <?php foreach ($sections as $section): ?>
              <option value="<?= $section['id'] ?>" data-class-id="<?= $section['class_id'] ?>">
                <?= htmlspecialchars($section['course_title']) ?> - <?= htmlspecialchars($section['title']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        
        <div>
          <label for="title" class="block text-gray-700 mb-2 font-medium">Title*</label>
          <input type="text" name="title" id="title" class="w-full px-4 py-2 border rounded-lg" required>
        </div>
        
        <div>
          <label for="description" class="block text-gray-700 mb-2 font-medium">Description</label>
          <textarea name="description" id="description" class="w-full px-4 py-2 border rounded-lg"></textarea>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="video_url" class="block text-gray-700 mb-2 font-medium">Video URL</label>
            <input type="url" name="video_url" id="video_url" class="w-full px-4 py-2 border rounded-lg" 
                   placeholder="https://youtube.com/watch?v=... or https://vimeo.com/...">
          </div>
          
          <div>
            <label for="duration" class="block text-gray-700 mb-2 font-medium">Duration (seconds)</label>
            <input type="number" name="duration" id="duration" class="w-full px-4 py-2 border rounded-lg" value="0">
          </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="position" class="block text-gray-700 mb-2 font-medium">Position in Section</label>
            <input type="number" name="position" id="position" class="w-full px-4 py-2 border rounded-lg" value="1" min="1">
          </div>
          
          <div class="flex items-center">
            <input type="checkbox" name="is_preview" id="is_preview" class="mr-2 h-5 w-5">
            <label for="is_preview" class="text-gray-700 font-medium">Available as preview</label>
          </div>
        </div>
        
        <div class="flex justify-end space-x-3 pt-4">
          <button type="button" onclick="closeLessonModal()" class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg">
            Cancel
          </button>
          <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            Save Lesson
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Section Creation Modal -->
<div id="sectionModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white rounded-lg w-full max-w-md mx-4">
    <div class="p-6">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold">Add New Section</h3>
        <button onclick="closeSectionModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
      </div>
      
      <form id="sectionForm" class="space-y-4">
        <div>
          <div class="flex justify-between items-center mb-2">
            <label for="class_id" class="block text-gray-700 font-medium">Course*</label>
            <button type="button" onclick="openCourseModal()" class="text-sm text-blue-600 hover:underline">
              <i class="fas fa-plus mr-1"></i>Add New Course
            </button>
          </div>
          <select name="class_id" id="class_id" class="w-full px-4 py-2 border rounded-lg" required>
            <option value="">— Select Course —</option>
            <?php foreach ($classes as $class): ?>
              <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['title']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        
        <div>
          <label for="section_title" class="block text-gray-700 mb-2 font-medium">Section Title*</label>
          <input type="text" name="section_title" id="section_title" class="w-full px-4 py-2 border rounded-lg" required>
        </div>
        
        <div>
          <label for="section_position" class="block text-gray-700 mb-2 font-medium">Position*</label>
          <input type="number" name="section_position" id="section_position" class="w-full px-4 py-2 border rounded-lg" value="1" min="1" required>
        </div>
        
        <div class="flex justify-end space-x-3 pt-4">
          <button type="button" onclick="closeSectionModal()" class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg">
            Cancel
          </button>
          <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            Save Section
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Course Creation Modal -->
<div id="courseModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white rounded-lg w-full max-w-md mx-4">
    <div class="p-6">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold">Add New Course</h3>
        <button onclick="closeCourseModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
      </div>
      
      <form id="courseForm" class="space-y-4">
        <div>
          <label for="course_title" class="block text-gray-700 mb-2 font-medium">Course Title*</label>
          <input type="text" name="course_title" id="course_title" class="w-full px-4 py-2 border rounded-lg" required>
        </div>
        
        <div>
          <label for="course_description" class="block text-gray-700 mb-2 font-medium">Description</label>
          <textarea name="course_description" id="course_description" class="w-full px-4 py-2 border rounded-lg"></textarea>
        </div>
        
        <div class="flex justify-end space-x-3 pt-4">
          <button type="button" onclick="closeCourseModal()" class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg">
            Cancel
          </button>
          <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            Save Course
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Initialize CKEditor
let editor;
function initEditor() {
  if (editor) {
    editor.destroy();
  }
  editor = CKEDITOR.replace('description');
}

// Open modal for new lesson
function openLessonModal(id = '', sectionId = '', title = '', description = '', videoUrl = '', duration = 0, position = 1, isPreview = 0) {
  const modal = document.getElementById('lessonModal');
  const form = document.getElementById('lessonForm');
  
  // Set form values
  document.getElementById('lesson_id').value = id;
  document.getElementById('section_id').value = sectionId;
  document.getElementById('title').value = title;
  document.getElementById('video_url').value = videoUrl;
  document.getElementById('duration').value = duration;
  document.getElementById('position').value = position;
  document.getElementById('is_preview').checked = isPreview == 1;
  
  // Update modal title
  document.getElementById('modalTitle').textContent = id ? 'Edit Lesson' : 'Add New Lesson';
  
  // Initialize CKEditor after a small delay to ensure DOM is ready
  setTimeout(() => {
    initEditor();
    if (description) {
      editor.setData(description);
    } else {
      editor.setData('');
    }
  }, 100);
  
  // Show modal
  modal.classList.remove('hidden');
  document.body.classList.add('overflow-hidden');
}

// Close lesson modal
function closeLessonModal() {
  const modal = document.getElementById('lessonModal');
  modal.classList.add('hidden');
  document.body.classList.remove('overflow-hidden');
}

// Open section creation modal
function openSectionModal() {
  const modal = document.getElementById('sectionModal');
  modal.classList.remove('hidden');
}

// Close section creation modal
function closeSectionModal() {
  const modal = document.getElementById('sectionModal');
  modal.classList.add('hidden');
}

// Open course creation modal
function openCourseModal() {
  const modal = document.getElementById('courseModal');
  modal.classList.remove('hidden');
}

// Close course creation modal
function closeCourseModal() {
  const modal = document.getElementById('courseModal');
  modal.classList.add('hidden');
}

// Handle section form submission
document.getElementById('sectionForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  const formData = new FormData(this);
  formData.append('add_section', '1');
  
  fetch(window.location.href, {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Add the new section to the dropdown
      const classId = document.getElementById('class_id').value;
      const className = document.getElementById('class_id').options[document.getElementById('class_id').selectedIndex].text;
      const sectionTitle = document.getElementById('section_title').value;
      
      const option = document.createElement('option');
      option.value = data.section_id;
      option.textContent = `${className} - ${sectionTitle}`;
      option.setAttribute('data-class-id', classId);
      option.selected = true;
      
      const select = document.getElementById('section_id');
      select.appendChild(option);
      
      // Close the modal and reset the form
      closeSectionModal();
      this.reset();
    } else {
      alert('Error: ' + (data.error || 'Failed to create section'));
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('An error occurred while creating the section');
  });
});

// Handle course form submission
document.getElementById('courseForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  const formData = new FormData(this);
  formData.append('add_course', '1');
  
  fetch(window.location.href, {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Add the new course to the dropdown in section modal
      const courseTitle = document.getElementById('course_title').value;
      
      const option = document.createElement('option');
      option.value = data.course_id;
      option.textContent = courseTitle;
      option.selected = true;
      
      const select = document.getElementById('class_id');
      select.appendChild(option);
      
      // Close the modal and reset the form
      closeCourseModal();
      this.reset();
    } else {
      alert('Error: ' + (data.error || 'Failed to create course'));
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('An error occurred while creating the course');
  });
});

// Initialize modal on page load if we want to add new lesson from URL
document.addEventListener('DOMContentLoaded', function() {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has('add')) {
    openLessonModal();
  }
});
</script>
</body>
</html>