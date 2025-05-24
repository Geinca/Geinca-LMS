<?php
// Example data (you could fetch these from a database)
$courseProgress = 65; // percent
$quizzesPassed = 8;
$quizzesTotal = 10;
$assignmentsSubmitted = 5;
$assignmentsTotal = 7;
$averageScore = 4.2; // out of 5
$badges = ["🏅", "🎖️", "📚"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Student Progress Dashboard</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background: #f9fafb;
    padding: 30px;
    display: flex;
    justify-content: center;
  }
  .dashboard-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 8px 15px rgba(0,0,0,0.1);
    width: 350px;
    padding: 25px;
  }
  h2 {
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 20px;
    text-align: center;
  }
  .section {
    margin-bottom: 20px;
  }
  .label {
    font-weight: 600;
    color: #34495e;
    margin-bottom: 6px;
  }
  /* Progress Bar */
  .progress-bar {
    background: #e1e4ea;
    border-radius: 20px;
    height: 22px;
    position: relative;
    overflow: hidden;
  }
  .progress-fill {
    background: #3498db;
    height: 100%;
    border-radius: 20px 0 0 20px;
    text-align: center;
    color: white;
    font-weight: 600;
    line-height: 22px;
    transition: width 0.5s ease;
  }
  /* Star Rating */
  .stars {
    color: #f1c40f;
    font-size: 20px;
    display: inline-block;
  }
  .stars .empty {
    color: #ccc;
  }
  /* Badges */
  .badges {
    font-size: 26px;
    text-align: center;
  }
</style>
</head>
<body>

<div class="dashboard-card">
  <h2>Student Progress Dashboard</h2>

  <div class="section">
    <div class="label">Course Completion</div>
    <div class="progress-bar" role="progressbar" aria-valuenow="<?= $courseProgress ?>" aria-valuemin="0" aria-valuemax="100">
      <div class="progress-fill" style="width: <?= $courseProgress ?>%">
        <?= $courseProgress ?>%
      </div>
    </div>
  </div>

  <div class="section">
    <div class="label">Quizzes Passed</div>
    <div><?= $quizzesPassed ?> / <?= $quizzesTotal ?></div>
  </div>

  <div class="section">
    <div class="label">Assignments Submitted</div>
    <div><?= $assignmentsSubmitted ?> / <?= $assignmentsTotal ?></div>
  </div>

  <div class="section">
    <div class="label">Average Score</div>
    <div class="stars">
      <?php
      // Print filled stars
      for ($i = 1; $i <= floor($averageScore); $i++) {
        echo "&#9733;"; // filled star ★
      }
      // Print half star if needed
      if ($averageScore - floor($averageScore) >= 0.5) {
        echo "&#9733;"; // using filled star for half (simplified)
        $i++;
      }
      // Print empty stars
      for (; $i <= 5; $i++) {
        echo "<span class='empty'>&#9733;</span>"; // empty star ☆ styled lighter
      }
      ?>
      <span style="color:#34495e; font-weight:600; margin-left:8px;">
        <?= number_format($averageScore, 1) ?> / 5
      </span>
    </div>
  </div>

  <div class="section">
    <div class="label">Badges Earned</div>
    <div class="badges">
      <?php foreach ($badges as $badge) {
        echo $badge . " ";
      } ?>
    </div>
  </div>
</div>

</body>
</html>
