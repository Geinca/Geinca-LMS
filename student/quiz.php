<?php
session_start();

// Dummy user session
$_SESSION['user_id'] = 101;
$_SESSION['username'] = "John Doe";

$course_id = 1;
$price = 30;

$quiz = [
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
];

$score = null;
$total = count($quiz);

// Handle quiz submission only if payment done
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['quiz_access']) && $_SESSION['quiz_access'] === true) {
    $score = 0;
    foreach ($quiz as $qid => $q) {
        if (isset($_POST['answer'][$qid]) && intval($_POST['answer'][$qid]) === $q['correct']) {
            $score++;
        }
    }
    $_SESSION['score'] = $score;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Quiz - Student Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        body { display: flex; min-height: 100vh; margin:0; }
        .content { flex: 1; padding: 30px; background: #f8f9fa; }
    </style>
</head>
<body>
<?php include './partials/sidebar.php'; ?>

<div class="content">
    <h2>Quiz for Course ID: <?= $course_id ?></h2>

    <?php if (!isset($_SESSION['quiz_access']) || $_SESSION['quiz_access'] !== true): ?>
        <!-- Payment Prompt -->
        <div class="alert alert-warning">
            You need to pay ₹<?= $price ?> to access this quiz.
        </div>
        <button class="btn btn-primary" onclick="payNow()">Pay ₹<?= $price ?> & Start Quiz</button>

    <?php elseif (isset($_SESSION['score'])): ?>
        <!-- Score Display -->
        <div class="alert alert-info">
            You scored <strong><?= $_SESSION['score'] ?></strong> out of <strong><?= $total ?></strong>!
        </div>
        <a href="generate_certificate.php" class="btn btn-success">Download Certificate</a>
        <a href="quiz.php?reset=true" class="btn btn-warning">Retake Quiz</a>

    <?php else: ?>
        <!-- Quiz Form -->
        <form method="POST">
            <?php foreach ($quiz as $qid => $q): ?>
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

<script>
function payNow() {
    var options = {
        "key": "rzp_test_PID2AI2BLrj6s6", // Replace with your Razorpay test/live key
        "amount": 30,
        "currency": "INR",
        "name": "Course Access",
        "description": "Quiz Subscription Access",
        "handler": function (response){
            window.location.href = "payment_success.php?pid=" + response.razorpay_payment_id;
        },
        "prefill": {
            "name": "<?= $_SESSION['username'] ?>",
            "email": "student@example.com"
        },
        "theme": {
            "color": "#00aeef"
        }
    };
    var rzp = new Razorpay(options);
    rzp.open();
}
</script>
</body>
</html>

<?php
if (isset($_GET['reset'])) {
    unset($_SESSION['score']);
    unset($_SESSION['quiz_access']);
    unset($_SESSION['payment_id']);
    header("Location: quiz.php");
    exit;
}
?>
