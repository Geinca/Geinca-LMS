<?php
$course = isset($_GET['course']) ? htmlspecialchars($_GET['course']) : 'UI UX Design';

// Define course => video URL map
$videos = [
  "UI UX Design" => "https://www.youtube.com/embed/Ovj4hFxko7c",
  "Python" => "https://www.youtube.com/embed/_uQrJ0TkZlc",
  "Figma" => "https://www.youtube.com/embed/jwCmIBJ8Jtc",
  "iOS Development" => "https://www.youtube.com/embed/5VbAwhBBHsg",
  "Android App" => "https://www.youtube.com/embed/fis26HvvDII",
  "Digital Marketing" => "https://www.youtube.com/embed/nL1z2a1Y4nA"
];

$videoUrl = $videos[$course] ?? "https://www.youtube.com/embed/dQw4w9WgXcQ";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo $course; ?> - Course Player</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-50 font-sans">
  <!-- Sidebar would be included here -->
  <div class="flex">
    <?php include '../partials/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 p-6 md:p-8 ml-0 md:ml-20">
      <div class="flex flex-col lg:flex-row gap-8">
        <!-- Left Column (Video & Details) -->
        <div class="lg:w-2/3">
          <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4"><?php echo $course; ?> Course</h1>
          
          <!-- Video Player -->
          <div class="rounded-2xl overflow-hidden shadow-lg mb-6">
            <iframe 
              src="<?php echo $videoUrl; ?>"
              class="w-full h-64 md:h-96 lg:h-[400px]"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen>
            </iframe>
          </div>

          <!-- Tabs -->
          <div class="border-b border-gray-200 mb-6">
            <nav class="flex space-x-4">
              <a href="#" class="py-4 px-1 border-b-2 font-medium text-sm border-blue-500 text-blue-600">Overview</a>
              <a href="#" class="py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">Description</a>
              <a href="#" class="py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">Tools</a>
              <a href="#" class="py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">FAQ</a>
              <a href="#" class="py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">Reviews</a>
            </nav>
          </div>

          <!-- Course Details -->
          <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-3">About this course</h2>
            <p class="text-gray-600 mb-4">
              Learn <?php echo $course; ?> and become job-ready. This course includes hands-on training,
              real-world examples, and portfolio projects. Start mastering essential tools today.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <p class="text-gray-700"><strong class="text-gray-800">Skill Level:</strong> Beginner to Advanced</p>
                <p class="text-gray-700"><strong class="text-gray-800">Language:</strong> English</p>
                <p class="text-gray-700"><strong class="text-gray-800">Captions:</strong> EN, DE, FR, ES</p>
              </div>
              <div>
                <p class="text-gray-700"><strong class="text-gray-800">Students:</strong> 127,432</p>
                <p class="text-gray-700"><strong class="text-gray-800">Certificate:</strong> Yes</p>
                <p class="text-gray-700"><strong class="text-gray-800">Duration:</strong> 23 hours</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Column (Course Content) -->
        <div class="lg:w-1/3">
          <div class="bg-white rounded-xl shadow-md p-6 overflow-y-auto max-h-[600px]">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Course Content</h3>
            
            <!-- Course Sections -->
            <div class="space-y-3">
              <div class="bg-green-50 rounded-lg p-4 flex justify-between items-center">
                <div>
                  <strong class="text-gray-800">Section 1</strong>
                  <p class="text-sm text-gray-600">Introduction</p>
                </div>
                <span class="text-sm text-gray-500">13min</span>
              </div>

              <div class="bg-green-50 rounded-lg p-4 flex justify-between items-center">
                <div>
                  <strong class="text-gray-800">Section 2</strong>
                  <p class="text-sm text-gray-600">Basics & Setup</p>
                </div>
                <span class="text-sm text-gray-500">27min</span>
              </div>

              <div class="bg-green-50 rounded-lg p-4 flex justify-between items-center">
                <div>
                  <strong class="text-gray-800">Section 3</strong>
                  <p class="text-sm text-gray-600">Common Mistakes</p>
                </div>
                <span class="text-sm text-gray-500">39min</span>
              </div>

              <div class="bg-gray-900 text-white rounded-lg p-4 flex justify-between items-center">
                <div>
                  <strong>Section 4</strong>
                  <p class="text-sm text-gray-300">Design & Tools</p>
                </div>
                <span class="text-sm">41min</span>
              </div>

              <div class="bg-gray-100 rounded-lg p-4 flex justify-between items-center">
                <div>
                  <strong class="text-gray-800">Section 5</strong>
                  <p class="text-sm text-gray-600">Layouts</p>
                </div>
                <span class="text-sm text-gray-500">11min</span>
              </div>

              <div class="bg-gray-100 rounded-lg p-4 flex justify-between items-center">
                <div>
                  <strong class="text-gray-800">Exercise 1</strong>
                  <p class="text-sm text-gray-600">Mini Project</p>
                </div>
                <span class="text-sm text-gray-500">60min</span>
              </div>

              <div class="bg-gray-100 rounded-lg p-4 flex justify-between items-center">
                <div>
                  <strong class="text-gray-800">Section 6</strong>
                  <p class="text-sm text-gray-600">Advanced Topics</p>
                </div>
                <span class="text-sm text-gray-500">52min</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>