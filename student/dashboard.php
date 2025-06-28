<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
    header('Location: ../login.php');
    exit;
}

// Demo data - in a real app, fetch from database
$student = [
  'name' => 'Alex Johnson',
  'courses_enrolled' => 4,
  'courses_completed' => 1,
  'certificates' => 1,
  'wishlist' => 3,
  'average_score' => 7.06,
  'streak' => 1
];

$upcomingClasses = [
  ['title' => 'Advanced JavaScript Concepts', 'time' => 'Today - 7:00 PM'],
  ['title' => 'React Fundamentals', 'time' => 'Saturday - 10:30 AM'],
  ['title' => 'Node.js Crash Course', 'time' => 'Monday - 10:30 AM'],
  ['title' => 'Database Design', 'time' => 'Monday - 7:00 PM']
];

$recentCourses = [
  [
    'title' => 'UI UX Design',
    'progress' => 65,
    'last_accessed' => '2 days ago',
    'img' => 'https://th.bing.com/th/id/OIP.doYHfVKgVncrGIL5jmSOMgHaE8?w=276&h=184&c=7&r=0&o=5&dpr=1.3&pid=1.7'
  ],
  [
    'title' => 'Python Programming',
    'progress' => 30,
    'last_accessed' => '1 week ago',
    'img' => 'https://th.bing.com/th/id/OIP.XTRl4rwNqniKlEtc6swCMgHaE8?w=231&h=180&c=7&r=0&o=5&dpr=1.3&pid=1.7'
  ]
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Student Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    .radial-progress {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      font-size: 1.5rem;
      position: relative;
    }

    .radial-progress span {
      position: relative;
      z-index: 2;
    }

    .course-progress-bar {
      height: 8px;
      border-radius: 4px;
      background-color: #e0e0e0;
      overflow: hidden;
    }

    .course-progress-fill {
      height: 100%;
      background-color: #00AEEF;
      border-radius: 4px;
    }
  </style>
</head>

<body class="bg-gray-50">
  <div class="flex">
    <!-- Sidebar -->
    <?php include '../partials/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 p-6 md:p-8 ml-64">
      <!-- Header -->
      <div class="flex justify-between items-center mb-8 ml-8">
        <div>
          <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Welcome, <?= $student['name'] ?>!</h1>
          <p class="text-gray-600">Here's your learning dashboard</p>
        </div>
        <div class="flex items-center space-x-2">
          <span class="text-sm text-gray-500">Streak: <?= $student['streak'] ?> days</span>
          <span class="text-orange-500">🔥</span>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
              <i class="fas fa-book-open"></i>
            </div>
            <div>
              <p class="text-gray-500 text-sm">Enrolled Courses</p>
              <p class="text-2xl font-bold text-blue-600"><?= $student['courses_enrolled'] ?></p>
            </div>
          </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
              <i class="fas fa-check-circle"></i>
            </div>
            <div>
              <p class="text-gray-500 text-sm">Completed</p>
              <p class="text-2xl font-bold text-purple-600"><?= $student['courses_completed'] ?></p>
            </div>
          </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
              <i class="fas fa-certificate"></i>
            </div>
            <div>
              <p class="text-gray-500 text-sm">Certificates</p>
              <p class="text-2xl font-bold text-green-600"><?= $student['certificates'] ?></p>
            </div>
          </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
          <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
              <i class="fas fa-heart"></i>
            </div>
            <div>
              <p class="text-gray-500 text-sm">Wishlist</p>
              <p class="text-2xl font-bold text-yellow-600"><?= $student['wishlist'] ?></p>
            </div>
          </div>
        </div>
      </div>

      <!-- Dashboard Content -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Progress Report -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
          <h2 class="text-xl font-bold text-gray-800 mb-4">PROGRESS REPORT</h2>
          <div class="flex flex-col items-center">
            <div class="radial-progress mb-4">
              <span><?= $student['average_score'] ?></span>
            </div>
            <p class="text-gray-500 mb-2">Average Performance</p>
            <p class="mb-4">Practice Gym: <span class="font-bold text-blue-600">81%</span></p>
            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
              Open Report <i class="fas fa-chevron-right ml-1 text-sm"></i>
            </a>
          </div>
        </div>

        <!-- Upcoming Classes -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">UPCOMING CLASSES</h2>
            <a href="#" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
          </div>
          <ul class="space-y-4">
            <?php foreach ($upcomingClasses as $index => $class): ?>
              <li class="flex justify-between items-center p-3 hover:bg-gray-50 rounded-lg">
                <div>
                  <p class="font-medium text-gray-800"><?= $class['title'] ?></p>
                  <p class="text-sm text-gray-500"><?= $class['time'] ?></p>
                </div>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition-colors">
                  JOIN
                </button>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Recent Courses -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">RECENT COURSES</h2>
            <a href="courses.php" class="text-sm text-blue-600 hover:text-blue-800">Browse More</a>
          </div>
          <div class="space-y-4">
            <?php foreach ($recentCourses as $course): ?>
              <div class="flex items-center p-3 hover:bg-gray-50 rounded-lg">
                <img src="<?= $course['img'] ?>"
                  class="w-12 h-12 object-cover rounded-md mr-4"
                  alt="<?= $course['title'] ?>"
                  onerror="this.onerror=null; this.src='https://via.placeholder.com/100?text=Course';">
                <div class="flex-grow">
                  <p class="font-medium text-gray-800"><?= $course['title'] ?></p>
                  <div class="flex items-center mt-1">
                    <div class="course-progress-bar flex-grow mr-2">
                      <div class="course-progress-fill" style="width: <?= $course['progress'] ?>%"></div>
                    </div>
                    <span class="text-sm text-gray-600"><?= $course['progress'] ?>%</span>
                  </div>
                </div>
                <a href="course_player.php?course=<?= urlencode($course['title']) ?>"
                  class="text-blue-600 hover:text-blue-800 ml-4">
                  <i class="fas fa-play"></i>
                </a>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Weekly Progress Chart -->
      <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mt-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">WEEKLY PROGRESS</h2>
        <div class="h-64">
          <canvas id="progressChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Weekly Progress Chart
    const ctx = document.getElementById('progressChart').getContext('2d');
    const progressChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6'],
        datasets: [{
          label: 'Course Progress',
          data: [5, 15, 25, 40, 50, 65],
          backgroundColor: 'rgba(0, 174, 239, 0.1)',
          borderColor: 'rgba(0, 174, 239, 1)',
          borderWidth: 2,
          tension: 0.3,
          fill: true,
          pointBackgroundColor: 'rgba(0, 174, 239, 1)',
          pointRadius: 4,
          pointHoverRadius: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            max: 100,
            ticks: {
              callback: function(value) {
                return value + '%';
              }
            }
          }
        },
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return context.parsed.y + '% completion';
              }
            }
          }
        }
      }
    });
  </script>
</body>

</html>