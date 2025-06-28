<?php
session_start();

// Demo data - in a real app, you'd fetch this from a database
$student = [
    'name' => 'Alex Johnson',
    'course' => 'Web Development Bootcamp',
    'start_date' => '2025-01-15',
    'target_completion' => '2025-06-30'
];

$progress = [
    'completion' => 65,
    'quizzes' => ['passed' => 8, 'total' => 10],
    'assignments' => ['submitted' => 5, 'total' => 7],
    'average_score' => 4.2,
    'badges' => ["🏅 Quick Learner", "🎖️ Perfect Score", "📚 Bookworm"],
    'last_active' => '2025-05-20'
];

// Weekly progress data for the chart
$weeklyProgress = [
    ['week' => 'Week 1', 'progress' => 5],
    ['week' => 'Week 2', 'progress' => 15],
    ['week' => 'Week 3', 'progress' => 25],
    ['week' => 'Week 4', 'progress' => 40],
    ['week' => 'Week 5', 'progress' => 50],
    ['week' => 'Week 6', 'progress' => 65]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Progress Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .progress-ring__circle {
            transition: stroke-dashoffset 0.5s ease;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }
    </style>
</head>
<body class="bg-gray-50">
    <?php include '../partials/sidebar.php'; ?>

    <div class="ml-64 p-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Progress Report</h1>
                    <p class="text-gray-600">Track your learning journey</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Last active: <?= $progress['last_active'] ?></p>
                    <p class="font-medium"><?= $student['name'] ?></p>
                </div>
            </div>

            <!-- Main Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Course Progress -->
                <div class="bg-white rounded-xl shadow p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Course Progress</h3>
                            <p class="text-sm text-gray-500"><?= $student['course'] ?></p>
                        </div>
                        <span class="text-2xl font-bold text-blue-600"><?= $progress['completion'] ?>%</span>
                    </div>
                    <div class="relative h-4 bg-gray-200 rounded-full">
                        <div class="absolute top-0 left-0 h-full bg-blue-600 rounded-full" 
                             style="width: <?= $progress['completion'] ?>%"></div>
                    </div>
                    <div class="flex justify-between mt-2 text-sm text-gray-500">
                        <span>Started <?= $student['start_date'] ?></span>
                        <span>Target <?= $student['target_completion'] ?></span>
                    </div>
                </div>

                <!-- Quizzes -->
                <div class="bg-white rounded-xl shadow p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Quizzes</h3>
                            <p class="text-sm text-gray-500">Assessment results</p>
                        </div>
                        <span class="text-2xl font-bold text-green-600">
                            <?= $progress['quizzes']['passed'] ?>/<?= $progress['quizzes']['total'] ?>
                        </span>
                    </div>
                    <div class="relative h-4 bg-gray-200 rounded-full">
                        <div class="absolute top-0 left-0 h-full bg-green-600 rounded-full" 
                             style="width: <?= ($progress['quizzes']['passed']/$progress['quizzes']['total'])*100 ?>%"></div>
                    </div>
                    <div class="flex justify-between mt-2">
                        <span class="text-sm text-green-600 font-medium">
                            <?= number_format(($progress['quizzes']['passed']/$progress['quizzes']['total'])*100, 1) ?>% success rate
                        </span>
                        <a href="#" class="text-sm text-blue-600 hover:underline">View all</a>
                    </div>
                </div>

                <!-- Assignments -->
                <div class="bg-white rounded-xl shadow p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Assignments</h3>
                            <p class="text-sm text-gray-500">Submitted work</p>
                        </div>
                        <span class="text-2xl font-bold text-purple-600">
                            <?= $progress['assignments']['submitted'] ?>/<?= $progress['assignments']['total'] ?>
                        </span>
                    </div>
                    <div class="relative h-4 bg-gray-200 rounded-full">
                        <div class="absolute top-0 left-0 h-full bg-purple-600 rounded-full" 
                             style="width: <?= ($progress['assignments']['submitted']/$progress['assignments']['total'])*100 ?>%"></div>
                    </div>
                    <div class="flex justify-between mt-2">
                        <span class="text-sm text-gray-500">
                            <?= $progress['assignments']['total'] - $progress['assignments']['submitted'] ?> remaining
                        </span>
                        <a href="#" class="text-sm text-blue-600 hover:underline">View all</a>
                    </div>
                </div>
            </div>

            <!-- Progress Chart -->
            <div class="bg-white rounded-xl shadow p-6 mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Weekly Progress</h3>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 text-sm bg-gray-100 rounded-lg">Weekly</button>
                        <button class="px-3 py-1 text-sm text-gray-500 hover:bg-gray-100 rounded-lg">Monthly</button>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="progressChart"></canvas>
                </div>
            </div>

            <!-- Additional Metrics -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Average Score -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Average Score</h3>
                    <div class="flex items-center justify-center">
                        <div class="relative w-32 h-32">
                            <svg class="w-full h-full" viewBox="0 0 100 100">
                                <circle class="text-gray-200" stroke-width="8" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50" />
                                <circle class="text-yellow-400" stroke-width="8" stroke-dasharray="<?= $progress['average_score']/5*251 ?>,251" stroke-linecap="round" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50" />
                            </svg>
                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
                                <span class="text-3xl font-bold text-gray-800"><?= number_format($progress['average_score'], 1) ?></span>
                                <span class="block text-sm text-gray-500">out of 5</span>
                            </div>
                        </div>
                        <div class="ml-6">
                            <div class="flex items-center mb-2">
                                <div class="w-8 text-yellow-400">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= floor($progress['average_score'])): ?>
                                            <i class="fas fa-star"></i>
                                        <?php elseif ($i - $progress['average_score'] < 1): ?>
                                            <i class="fas fa-star-half-alt"></i>
                                        <?php else: ?>
                                            <i class="far fa-star"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <p class="text-gray-600">Your performance is better than 78% of students</p>
                        </div>
                    </div>
                </div>

                <!-- Badges Earned -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Badges Earned</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <?php foreach ($progress['badges'] as $badge): ?>
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <div class="text-3xl mb-2"><?= substr($badge, 0, 3) ?></div>
                                <p class="text-sm font-medium text-gray-700"><?= substr($badge, 4) ?></p>
                            </div>
                        <?php endforeach; ?>
                        <div class="text-center p-4 border-2 border-dashed border-gray-300 rounded-lg">
                            <div class="text-2xl mb-2 text-gray-400"><i class="fas fa-lock"></i></div>
                            <p class="text-sm font-medium text-gray-500">Keep learning to unlock</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activity</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-4">
                            <i class="fas fa-book"></i>
                        </div>
                        <div>
                            <p class="font-medium">Completed "JavaScript Functions" lesson</p>
                            <p class="text-sm text-gray-500">2 days ago</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 mr-4">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <p class="font-medium">Submitted Assignment #5</p>
                            <p class="text-sm text-gray-500">4 days ago</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 mr-4">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div>
                            <p class="font-medium">Earned "Quick Learner" badge</p>
                            <p class="text-sm text-gray-500">1 week ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Progress Chart
        const ctx = document.getElementById('progressChart').getContext('2d');
        const progressChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode(array_column($weeklyProgress, 'week')) ?>,
                datasets: [{
                    label: 'Progress',
                    data: <?= json_encode(array_column($weeklyProgress, 'progress')) ?>,
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: 'rgba(59, 130, 246, 1)',
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