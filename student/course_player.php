<?php
// session_start();
// if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
//     header('Location: ../login.php');
//     exit;
// }

$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 1;
$lecture_id = isset($_GET['lecture_id']) ? intval($_GET['lecture_id']) : 1;

$courses = [
    1 => [
        'title' => 'Introduction to Programming',
        'lectures' => [
            1 => [
                'title' => 'Lecture 1: Variables and Data Types',
                'video_url' => '../course/Variables-and-Data-Types.mp4',
                'materials' => [
                    ['name' => 'Lecture Notes PDF', 'file' => 'materials/lecture1-notes.pdf'],
                    ['name' => 'Example Code', 'file' => 'materials/lecture1-code.zip']
                ]
            ],
            2 => [
                'title' => 'Lecture 2: Control Structures',
                'video_url' => 'https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4',
                'materials' => [
                    ['name' => 'Lecture Slides', 'file' => 'materials/lecture2-slides.pdf']
                ]
            ]
        ]
    ]
];

if (!isset($courses[$course_id])) {
    die('Course not found');
}
if (!isset($courses[$course_id]['lectures'][$lecture_id])) {
    $lecture_id = array_key_first($courses[$course_id]['lectures']);
}

$course = $courses[$course_id];
$lecture = $course['lectures'][$lecture_id];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Course Player - <?= htmlspecialchars($course['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: #fff;
        }
        .sidebar a {
            color: #fff;
            padding: 15px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
        }
        .content {
            flex: 1;
            padding: 30px;
            background-color: #f8f9fa;
        }
        .lecture-list {
            max-height: 400px;
            overflow-y: auto;
        }
        .materials a {
            display: block;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4 class="text-center py-3">Student Panel</h4>
        <a href="dashboard.php">Dashboard</a>
        <a href="enrolled_courses.php">Enrolled Courses</a>
        <a href="wishlist.php">Wishlist</a>
        <a href="recommendations.php">Recommendations</a>
        <a href="course_player.php?course_id=<?= $course_id ?>" class="active">Course Player</a>
        <a href="quiz.php">Quiz</a>
        <a href="progress.php">Progress</a>
        <a href="discussion.php">Discussion</a>
        <a href="certificate.php">Certificate</a>
        <a href="../logout.php">Logout</a>
    </div>

    <div class="content">
        <h2><?= htmlspecialchars($course['title']) ?></h2>

        <div class="row">
            <div class="col-md-8">
                <h5><?= htmlspecialchars($lecture['title']) ?></h5>
                <video width="100%" height="400" controls>
                    <source src="<?= htmlspecialchars($lecture['video_url']) ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>

                <h6 class="mt-4">Downloadable Materials</h6>
                <div class="materials">
                    <?php foreach ($lecture['materials'] as $material): ?>
                        <a href="<?= htmlspecialchars($material['file']) ?>" download><?= htmlspecialchars($material['name']) ?></a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-md-4">
                <h5>Lecture List</h5>
                <div class="lecture-list list-group">
                    <?php foreach ($course['lectures'] as $id => $lec): ?>
                        <a href="course_player.php?course_id=<?= $course_id ?>&lecture_id=<?= $id ?>"
                           class="list-group-item list-group-item-action <?= ($id == $lecture_id) ? 'active' : '' ?>">
                           <?= htmlspecialchars($lec['title']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
