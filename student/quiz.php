<?php
session_start();

// Dummy user session
$_SESSION['user_id'] = 101;
$_SESSION['username'] = "John Doe";

// Demo quiz data
$quizzes = [
    1 => [
        'title' => 'PHP Fundamentals Quiz',
        'date' => '2025-07-15',
        'time' => '10:00 AM',
        'duration' => '30 minutes',
        'price' => 30,
        'description' => 'Test your knowledge of PHP basics',
        'paid' => isset($_SESSION['quiz_paid'][1]) // Check if paid for this quiz
    ],
    2 => [
        'title' => 'JavaScript Intermediate Quiz',
        'date' => '2025-07-20',
        'time' => '02:00 PM',
        'duration' => '45 minutes',
        'price' => 30,
        'description' => 'JavaScript concepts and DOM manipulation',
        'paid' => isset($_SESSION['quiz_paid'][2])
    ],
    3 => [
        'title' => 'Database Concepts Quiz',
        'date' => '2025-07-25',
        'time' => '11:30 AM',
        'duration' => '40 minutes',
        'price' => 30,
        'description' => 'SQL queries and database design',
        'paid' => isset($_SESSION['quiz_paid'][3])
    ]
];

// Demo questions data
$questions = [
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

// Process quiz submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quiz_id'])) {
    $quiz_id = intval($_POST['quiz_id']);
    if (isset($_SESSION['quiz_paid'][$quiz_id]) && $_SESSION['quiz_paid'][$quiz_id] === true) {
        $score = 0;
        foreach ($questions as $qid => $q) {
            if (isset($_POST['answer'][$qid]) && intval($_POST['answer'][$qid]) === $q['correct']) {
                $score++;
            }
        }
        $_SESSION['quiz_score'][$quiz_id] = $score;
    }
}

// Handle payment success (simulated)
if (isset($_GET['payment_success']) && isset($_GET['quiz_id'])) {
    $quiz_id = intval($_GET['quiz_id']);
    $_SESSION['quiz_paid'][$quiz_id] = true;
    header("Location: quizzes.php?quiz_id=".$quiz_id);
    exit;
}

// Handle reset
if (isset($_GET['reset'])) {
    $quiz_id = intval($_GET['reset']);
    unset($_SESSION['quiz_score'][$quiz_id]);
    header("Location: quizzes.php?quiz_id=".$quiz_id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Quizzes - Student Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        body { display: flex; min-height: 100vh; margin:0; }
        .content { flex: 1; padding: 30px; background: #f8f9fa; }
        .quiz-card {
            transition: transform 0.2s;
            border-left: 4px solid #4f46e5;
        }
        .quiz-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .quiz-badge {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #4f46e5;
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <?php include '../partials/sidebar.php'; ?>

    <div class="content ml-64">
        <h1 class="text-2xl font-bold mb-6">Upcoming Quizzes</h1>
        
        <?php if (isset($_GET['quiz_id'])) {
            $quiz_id = intval($_GET['quiz_id']);
            $quiz = $quizzes[$quiz_id];
            
            if (isset($_SESSION['quiz_score'][$quiz_id])): ?>
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4"><?= htmlspecialchars($quiz['title']) ?></h2>
                    <div class="alert alert-success">
                        You scored <strong><?= $_SESSION['quiz_score'][$quiz_id] ?></strong> out of <strong><?= count($questions) ?></strong>!
                    </div>
                    <div class="flex space-x-3">
                        <a href="generate_certificate.php?quiz_id=<?= $quiz_id ?>" class="btn btn-success">
                            <i class="fas fa-download mr-2"></i> Download Certificate
                        </a>
                        <a href="quizzes.php?reset=<?= $quiz_id ?>" class="btn btn-warning">
                            <i class="fas fa-redo mr-2"></i> Retake Quiz
                        </a>
                        <a href="quizzes.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Quizzes
                        </a>
                    </div>
                </div>
            <?php elseif ($quiz['paid']): ?>
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4"><?= htmlspecialchars($quiz['title']) ?></h2>
                    <p class="mb-4"><?= htmlspecialchars($quiz['description']) ?></p>
                    
                    <form method="POST" class="mt-4">
                        <input type="hidden" name="quiz_id" value="<?= $quiz_id ?>">
                        <?php foreach ($questions as $qid => $q): ?>
                            <div class="mb-6 p-4 border rounded-lg">
                                <h5 class="font-medium text-lg mb-2"><?= $qid ?>. <?= htmlspecialchars($q['question']) ?></h5>
                                <?php foreach ($q['options'] as $index => $option): ?>
                                    <div class="form-check mb-2">
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
                        <button type="submit" class="btn btn-success px-6 py-2 rounded-lg">
                            <i class="fas fa-paper-plane mr-2"></i> Submit Quiz
                        </button>
                    </form>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4"><?= htmlspecialchars($quiz['title']) ?></h2>
                    <div class="alert alert-warning">
                        You need to pay ₹<?= $quiz['price'] ?> to access this quiz.
                    </div>
                    <button class="btn btn-primary" onclick="payNow(<?= $quiz_id ?>)">
                        <i class="fas fa-lock-open mr-2"></i> Pay ₹<?= $quiz['price'] ?> & Start Quiz
                    </button>
                    <a href="quizzes.php" class="btn btn-secondary ml-2">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Quizzes
                    </a>
                </div>
            <?php endif;
        } else { ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($quizzes as $id => $quiz): ?>
                    <div class="quiz-card bg-white rounded-lg shadow overflow-hidden relative">
                        <?php if ($quiz['paid']): ?>
                            <div class="quiz-badge">
                                <i class="fas fa-check"></i>
                            </div>
                        <?php endif; ?>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2"><?= htmlspecialchars($quiz['title']) ?></h3>
                            <p class="text-gray-600 mb-4"><?= htmlspecialchars($quiz['description']) ?></p>
                            
                            <div class="flex items-center text-sm text-gray-500 mb-2">
                                <i class="fas fa-calendar-day mr-2"></i>
                                <span><?= $quiz['date'] ?> at <?= $quiz['time'] ?></span>
                            </div>
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <i class="fas fa-clock mr-2"></i>
                                <span><?= $quiz['duration'] ?></span>
                            </div>
                            
                            <?php if ($quiz['paid']): ?>
                                <a href="quizzes.php?quiz_id=<?= $id ?>" class="w-full btn btn-success">
                                    <i class="fas fa-play mr-2"></i> Start Quiz
                                </a>
                            <?php else: ?>
                                <button onclick="payNow(<?= $id ?>)" class="w-full btn btn-primary">
                                    <i class="fas fa-lock mr-2"></i> Pay ₹<?= $quiz['price'] ?> to Unlock
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php } ?>
    </div>

    <script>
    function payNow(quizId) {
        var options = {
            "key": "rzp_test_PID2AI2BLrj6s6", // Replace with your Razorpay test/live key
            "amount": 30 * 100, // 30 rupees in paise
            "currency": "INR",
            "name": "Quiz Access Payment",
            "description": "Payment for quiz access",
            "handler": function (response){
                window.location.href = "quizzes.php?payment_success=1&quiz_id=" + quizId;
            },
            "prefill": {
                "name": "<?= $_SESSION['username'] ?>",
                "email": "student@example.com"
            },
            "theme": {
                "color": "#4f46e5"
            }
        };
        var rzp = new Razorpay(options);
        rzp.open();
    }
    </script>
</body>
</html>