<?php
require_once 'C:/xampp/htdocs/geinca/Geinca-LMS/db.php';

// Get class ID from URL
$classId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch class details
$class = $pdo->prepare("SELECT id, title, description FROM classes WHERE id = ?");
$class->execute([$classId]);
$class = $class->fetch(PDO::FETCH_ASSOC);

if (!$class) {
    die("Class not found");
}

// Fetch all sections for this class
$sections = $pdo->prepare("
    SELECT 
        s.id, 
        s.title AS section_title, 
        s.position AS section_number,
        COUNT(l.id) AS lesson_count
    FROM sections s
    LEFT JOIN lessons l ON s.id = l.section_id
    WHERE s.class_id = ?
    GROUP BY s.id
    ORDER BY s.position
");
$sections->execute([$classId]);
$sections = $sections->fetchAll(PDO::FETCH_ASSOC);

// Get the first video URL (for initial display)
$firstVideo = $pdo->prepare("
    SELECT l.video_url 
    FROM lessons l
    JOIN sections s ON l.section_id = s.id
    WHERE s.class_id = ?
    ORDER BY s.position, l.position
    LIMIT 1
");
$firstVideo->execute([$classId]);
$firstVideo = $firstVideo->fetch(PDO::FETCH_ASSOC);
$videoUrl = $firstVideo ? $firstVideo['video_url'] : '';

// For each section, get its lessons
foreach ($sections as &$section) {
    $lessons = $pdo->prepare("
        SELECT 
            id, 
            title, 
            description, 
            video_url,
            duration,
            position,
            is_preview
        FROM lessons
        WHERE section_id = ?
        ORDER BY position
    ");
    $lessons->execute([$section['id']]);
    $section['lessons'] = $lessons->fetchAll(PDO::FETCH_ASSOC);
    
    // Add video_url to section for the first lesson (for section click)
    if (!empty($section['lessons'])) {
        $section['video_url'] = $section['lessons'][0]['video_url'];
    }
}
unset($section); // Break the reference
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo htmlspecialchars($class['title']); ?> - Course Player</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-50 font-sans">
  <div class="flex">
    <?php include '../partials/sidebar.php'; ?>

    <div class="flex-1 p-6 md:p-8 ml-64 md:ml-64">
      <div class="flex flex-col lg:flex-row gap-8">
        <div class="lg:w-2/3">
          <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4"><?php echo htmlspecialchars($class['title']); ?></h1>

          <div class="rounded-2xl overflow-hidden shadow-lg mb-6">
            <?php if ($videoUrl): ?>
            <iframe
              src="<?php echo htmlspecialchars($videoUrl); ?>"
              id="courseVideo"
              class="w-full h-64 md:h-96 lg:h-[400px]"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen>
            </iframe>
            <?php else: ?>
            <div class="w-full h-64 md:h-96 lg:h-[400px] bg-gray-200 flex items-center justify-center">
              <p class="text-gray-500">No video available</p>
            </div>
            <?php endif; ?>
          </div>

          <div class="border-b border-gray-200 mb-6">
            <nav class="flex space-x-4">
              <a href="#" class="py-4 px-1 border-b-2 font-medium text-sm border-blue-500 text-blue-600">Overview</a>
              <a href="#" class="py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">Description</a>
              <a href="#" class="py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">Tools</a>
              <a href="#" class="py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">FAQ</a>
              <a href="#" class="py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">Reviews</a>
            </nav>
          </div>

          <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-3">About this class</h2>
            <p class="text-gray-600 mb-4">
              <?php echo htmlspecialchars($class['description'] ?: "Learn ".$class['title']." and become job-ready. This class includes hands-on training, real-world examples, and portfolio projects."); ?>
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <p class="text-gray-700"><strong class="text-gray-800">Skill Level:</strong> Beginner to Advanced</p>
                <p class="text-gray-700"><strong class="text-gray-800">Language:</strong> English</p>
                <p class="text-gray-700"><strong class="text-gray-800">Captions:</strong> EN, DE, FR, ES</p>
              </div>
              <div>
                <?php 
                $totalDuration = 0;
                $totalLessons = 0;
                foreach ($sections as $section) {
                    $totalLessons += count($section['lessons']);
                    foreach ($section['lessons'] as $lesson) {
                        $totalDuration += (int)$lesson['duration'];
                    }
                }
                ?>
                <p class="text-gray-700"><strong class="text-gray-800">Lessons:</strong> <?php echo $totalLessons; ?></p>
                <p class="text-gray-700"><strong class="text-gray-800">Certificate:</strong> Yes</p>
                <p class="text-gray-700"><strong class="text-gray-800">Duration:</strong> <?php echo gmdate("H:i:s", $totalDuration); ?></p>
              </div>
            </div>
          </div>
        </div>

        <div class="lg:w-1/3">
          <div class="bg-white rounded-xl shadow-md p-6 overflow-y-auto max-h-[600px]">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Class Content</h3>
            <div class="space-y-3">
              <?php foreach ($sections as $section): ?>
                <div class="bg-green-50 rounded-lg p-4 cursor-pointer transition-all duration-200 hover:bg-green-100">
                  <div class="flex justify-between items-center">
                    <strong class="text-gray-800">Section <?php echo $section['section_number']; ?>: <?php echo htmlspecialchars($section['section_title']); ?></strong>
                    <span class="text-sm text-gray-500"><?php echo count($section['lessons']); ?> lessons</span>
                  </div>
                  
                  <div class="mt-2 pl-4 space-y-2">
                    <?php foreach ($section['lessons'] as $lesson): ?>
                      <div class="lesson-item p-2 rounded flex justify-between items-center cursor-pointer transition-all duration-200 hover:bg-blue-50"
                        data-url="<?php echo htmlspecialchars($lesson['video_url']); ?>"
                        data-lesson-id="<?php echo $lesson['id']; ?>">
                        <div class="flex items-center">
                          <i class="fas fa-play-circle text-gray-500 mr-2"></i>
                          <span><?php echo htmlspecialchars($lesson['title']); ?></span>
                          <?php if ($lesson['is_preview']): ?>
                            <span class="ml-2 bg-green-100 text-green-800 px-2 py-0.5 rounded-full text-xs">Preview</span>
                          <?php endif; ?>
                        </div>
                        <span class="text-sm text-gray-500"><?php echo gmdate("i:s", $lesson['duration']); ?></span>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const lessonItems = document.querySelectorAll('.lesson-item');
    const videoFrame = document.getElementById('courseVideo');

    lessonItems.forEach(item => {
      item.addEventListener('click', () => {
        // Switch video
        const newUrl = item.getAttribute('data-url');
        const lessonId = item.getAttribute('data-lesson-id');
        
        if (newUrl) {
          videoFrame.src = newUrl;
          
          // Remove 'active' styles from all
          lessonItems.forEach(i => i.classList.remove('bg-blue-100', 'ring-2', 'ring-blue-500'));
          
          // Add 'active' style to clicked one
          item.classList.add('bg-blue-100', 'ring-2', 'ring-blue-500');
          
          // Send progress update to server
          fetch('update_progress.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `lesson_id=${lessonId}&class_id=<?php echo $class['id']; ?>`
          }).then(res => res.text()).then(data => {
            console.log("Progress updated:", data);
          });
        }
      });
    });
  </script>
</body>
</html>