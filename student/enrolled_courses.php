<?php
// session_start();
// if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
//     header('Location: ../login.php');
//     exit;
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Enrolled Courses</title>
      <link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/enroll.css">
 
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

   <!-- Content -->
<div class="content">
  <h2>Enrolled Courses</h2>
  <p class="text-muted">Here are the courses you are currently enrolled in.</p>

  <div class="row">
    <!-- Course 1 -->
    <div class="col-md-4 mb-4">
      <div class="card shadow">
        <img src="https://miro.medium.com/v2/resize:fit:600/0*DdcDyaHk2n4yIDQI.png" class="card-img-top" alt="Course 1">
        <div class="card-body">
          <h5 class="card-title">HTML & CSS Basics</h5>
          <p class="card-text">Build strong foundations in front-end development.</p>
          <a href="course_player.php?course_id=1" class="btn btn-primary btn-sm">Start Course</a>
        </div>
      </div>
    </div>

    <!-- Course 2 -->
    <div class="col-md-4 mb-4">
      <div class="card shadow">
        <img src="https://bairesdev.mo.cloudinary.net/blog/2023/08/What-Is-JavaScript-Used-For.jpg?tx=w_1920,q_auto" class="card-img-top" alt="Course 2">
        <div class="card-body">
          <h5 class="card-title">JavaScript Mastery</h5>
          <p class="card-text">Take your JavaScript skills to the next level.</p>
          <a href="course_player.php?course_id=2" class="btn btn-primary btn-sm">Start Course</a>
        </div>
      </div>
    </div>

    <!-- Course 3 -->
    <div class="col-md-4 mb-4">
      <div class="card shadow">
        <img src="https://i0.wp.com/www.virtono.com/community/wp-content/uploads/2016/08/php___mysql_wallpaper_by_milesandryprower-d9o6yat.png?fit=1024%2C576&ssl=1" class="card-img-top" alt="Course 3">
        <div class="card-body">
          <h5 class="card-title">PHP & MySQL</h5>
          <p class="card-text">Learn backend development with PHP and MySQL.</p>
          <a href="course_player.php?course_id=3" class="btn btn-primary btn-sm">Start Course</a>
        </div>
      </div>
    </div>

    <!-- Course 4 -->
    <div class="col-md-4 mb-4">
      <div class="card shadow">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/05/React-icon.svg/1024px-React-icon.svg.png" class="card-img-top" alt="Course 4">
        <div class="card-body">
          <h5 class="card-title">React Fundamentals</h5>
          <p class="card-text">Build interactive UIs with React and components.</p>
          <a href="course_player.php?course_id=4" class="btn btn-primary btn-sm">Start Course</a>
        </div>
      </div>
    </div>

    <!-- Course 5 -->
    <div class="col-md-4 mb-4">
      <div class="card shadow">
        <img src="https://www.learnpython.org/assets/images/learnpython.png" class="card-img-top" alt="Course 5">
        <div class="card-body">
          <h5 class="card-title">Python for Beginners</h5>
          <p class="card-text">An introduction to Python programming language.</p>
          <a href="course_player.php?course_id=5" class="btn btn-primary btn-sm">Start Course</a>
        </div>
      </div>
    </div>

    <!-- Course 6 -->
    <div class="col-md-4 mb-4">
      <div class="card shadow">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS0GF9oHCtOZHgNWUgWZRu2NeVZ9KOy2sEGSA&usqp=CAU" class="card-img-top" alt="Course 6">
        <div class="card-body">
          <h5 class="card-title">Database Design</h5>
          <p class="card-text">Learn how to structure and manage relational databases.</p>
          <a href="course_player.php?course_id=6" class="btn btn-primary btn-sm">Start Course</a>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
