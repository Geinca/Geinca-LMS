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
    <link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
/>
    <link rel="stylesheet" href="css/dashboard.css" />
    <style>
        body { display: flex; min-height: 100vh; }
        
        .content { flex: 1; padding: 30px; background: #f8f9fa; }
    </style>
</head>
<body>
<?php include './partials/sidebar.php' ?>

<div class="content">
    <h2>Quiz   a for Course ID: <?= $course_id ?></h2>

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
            <button type="submit" class="btn" style="background-color: #00aeef;color:#f8f9fa">Submit Quiz</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
