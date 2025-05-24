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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="css/dashboard.css">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .course-video {
      border-radius: 20px;
      overflow: hidden;
    }
    .course-video iframe {
      width: 100%;
      height: 400px;
      border: none;
      border-radius: 20px;
    }
    .course-title {
      font-weight: bold;
      font-size: 1.8rem;
    }
    .tabs {
      margin-top: 30px;
    }
    .content-list {
      background: white;
      border-radius: 16px;
      padding: 20px;
      max-height: 600px;
      overflow-y: auto;
      box-shadow: 0 0 12px rgba(0,0,0,0.05);
    }
    .content-item {
      border-radius: 12px;
      padding: 15px;
      margin-bottom: 12px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .content-item.active {
      background: #111827;
      color: white;
    }
    .content-item.green {
      background: #e6ffe6;
    }
    .content-item.light {
      background: #f1f1f1;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
 <div class="sidebar">
    <h4 class="text-center py-3">Student Panel</h4>
    <a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
    <a href="enrolled_courses.php"><i class="fas fa-book"></i><span>Enrolled Courses</span></a>
    <a href="wishlist.php"><i class="fas fa-heart"></i><span>Wishlist</span></a>
    <a href="recommendations.php"><i class="fas fa-star"></i><span>Recommendations</span></a>
    <a href="course_player.php"><i class="fas fa-play-circle"></i><span>Course Player</span></a>
    <a href="quiz.php"><i class="fas fa-question-circle"></i><span>Quiz</span></a>
    <a href="progress.php"><i class="fas fa-chart-line"></i><span>Progress</span></a>
    <a href="discussion.php"><i class="fas fa-comments"></i><span>Discussion</span></a>
    <a href="certificate.php"><i class="fas fa-certificate"></i><span>Certificate</span></a>
    <a href="../logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
</div>


<div class="container py-5">
  <div class="row">
    <div class="col-lg-8">
      <div class="course-title mb-3"><?php echo $course; ?> Course</div>
      <div class="course-video mb-4">
        <iframe src="<?php echo $videoUrl; ?>"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
      </div>

      <ul class="nav nav-tabs tabs">
        <li class="nav-item"><a class="nav-link active" href="#">Overview</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Description</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Tools</a></li>
        <li class="nav-item"><a class="nav-link" href="#">FAQ</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Reviews</a></li>
      </ul>

      <div class="mt-4">
        <h5>About this course</h5>
        <p>
          Learn <?php echo $course; ?> and become job-ready. This course includes hands-on training,
          real-world examples, and portfolio projects. Start mastering essential tools today.
        </p>

        <div class="row">
          <div class="col-md-6">
            <p><strong>Skill Level:</strong> Beginner to Advanced</p>
            <p><strong>Language:</strong> English</p>
            <p><strong>Captions:</strong> EN, DE, FR, ES</p>
          </div>
          <div class="col-md-6">
            <p><strong>Students:</strong> 127,432</p>
            <p><strong>Certificate:</strong> Yes</p>
            <p><strong>Duration:</strong> 23 hours</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Side Content -->
    <div class="col-lg-4">
      <div class="content-list">
        <h5 class="mb-4">Course Content</h5>

        <div class="content-item green">
          <div>
            <strong>Section 1</strong><br />
            <small>Introduction</small>
          </div>
          <span>13min</span>
        </div>

        <div class="content-item green">
          <div>
            <strong>Section 2</strong><br />
            <small>Basics & Setup</small>
          </div>
          <span>27min</span>
        </div>

        <div class="content-item green">
          <div>
            <strong>Section 3</strong><br />
            <small>Common Mistakes</small>
          </div>
          <span>39min</span>
        </div>

        <div class="content-item active">
          <div>
            <strong>Section 4</strong><br />
            <small>Design & Tools</small>
          </div>
          <span>41min</span>
        </div>

        <div class="content-item light">
          <div>
            <strong>Section 5</strong><br />
            <small>Layouts</small>
          </div>
          <span>11min</span>
        </div>

        <div class="content-item light">
          <div>
            <strong>Exercise 1</strong><br />
            <small>Mini Project</small>
          </div>
          <span>60min</span>
        </div>

        <div class="content-item light">
          <div>
            <strong>Section 6</strong><br />
            <small>Advanced Topics</small>
          </div>
          <span>52min</span>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
