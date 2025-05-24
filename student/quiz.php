<?php
// session_start();
// if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
//     header('Location: ../login.php');
//     exit;
// }

$course_id = 1; // hardcoded for demo

// Dummy quiz data
$quiz = [
    'course_id' => 1,
    'questions' => [
        1 => [
            'question' => 'What is the output of `echo 2 + 2;` in PHP?',
            'options' => ['2', '4', '22', 'Error'],
            'correct' => 1,
        ],
        2 => [
            'question' => 'Which keyword is used to declare a function in PHP?',
            'options' => ['function', 'def', 'func', 'declare'],
            'correct' => 0,
        ],
        3 => [
            'question' => 'What symbol is used to concatenate strings in PHP?',
            'options' => ['+', '.', '&', '*'],
            'correct' => 1,
        ],
    ]
];

$score = null;
$total = count($quiz['questions']);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;
    foreach ($quiz['questions'] as $qid => $q) {
        if (isset($_POST['answer'][$qid]) && intval($_POST['answer'][$qid]) === $q['correct']) {
            $score++;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Quiz - Student Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { display: flex; min-height: 100vh; }
        .sidebar {
            width: 250px; background: #343a40; color: white; padding-top: 20px;
        }
        .sidebar a {
            color: white; display: block; padding: 10px 20px; text-decoration: none;
        }
        .sidebar a:hover, .sidebar a.active { background: #495057; }
        .content { flex: 1; padding: 30px; background: #f8f9fa; }
    </style>
</head>
<body>
<div class="sidebar">
    <h4 class="text-center mb-4">Student Panel</h4>
    <a href="dashboard.php">Dashboard</a>
    <a href="enrolled_courses.php">Enrolled Courses</a>
    <a href="wishlist.php">Wishlist</a>
    <a href="recommendations.php">Recommendations</a>
    <a href="course_player.php">Course Player</a>
    <a href="quiz.php" class="active">Quiz</a>
    <a href="progress.php">Progress</a>
    <a href="discussion.php">Discussion</a>
    <a href="certificate.php">Certificate</a>
    <a href="../logout.php">Logout</a>
</div>

<div class="content">
    <h2>Quiz for Course ID: <?= $course_id ?></h2>

    <?php if ($score !== null): ?>
        <div class="alert alert-info">
            You scored <strong><?= $score ?></strong> out of <strong><?= $total ?></strong>!
        </div>
        <a href="quiz.php" class="btn btn-primary">Retake Quiz</a>
    <?php else: ?>
        <form method="POST">
            <?php foreach ($quiz['questions'] as $qid => $q): ?>
                <div class="mb-4">
                    <h5><?= $qid ?>. <?= htmlspecialchars($q['question']) ?></h5>
                    <?php foreach ($q['options'] as $index => $option): ?>
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="answer[<?= $qid ?>]"
                                id="q<?= $qid ?>o<?= $index ?>"
                                value="<?= $index ?>"
                                required
                            >
                            <label class="form-check-label" for="q<?= $qid ?>o<?= $index ?>">
                                <?= htmlspecialchars($option) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-success">Submit Quiz</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
