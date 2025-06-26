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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/dashboard.css" />
  <link rel="stylesheet" href="css/enroll.css" />
  <style>
    body {
      background-color: #F9FAFB;
      font-family: 'Segoe UI', sans-serif;
      color: #1F2937;
    }
    .card-img-top {
      height: 180px;
      object-fit: cover;
      border-top-left-radius: 0.5rem;
      border-top-right-radius: 0.5rem;
    }
    .card-title {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      font-weight: bold;
      color: #1E40AF;
    }
    .card-body {
      background-color: #FFFFFF;
    }
    .card-footer {
      background-color: #F1F5F9;
    }
    .btn-primary {
      background-color: #1E40AF;
      border: none;
    }
    .btn-primary:hover {
      background-color: #3749c8;
    }
    .sidebar {
      width: 60px;
      background-color: #FFFFFF;
      border-right: 1px solid #e0e0e0;
      padding: 0 10px;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      overflow-x: hidden;
      transition: width 0.3s ease;
      white-space: nowrap;
    }
    .sidebar:hover {
      width: 250px;
      z-index: 10;
    }
    .sidebar h4 {
      font-size: 20px;
      font-weight: bold;
      color: #1E40AF;
      margin-bottom: 30px;
      opacity: 0;
      transition: opacity 0.3s ease;
      text-align: center;
      padding: 0 10px;
    }
    .sidebar:hover h4 {
      opacity: 1;
    }
    .sidebar a {
      display: flex;
      align-items: center;
      padding: 12px 10px;
      margin-bottom: 10px;
      border-radius: 8px;
      color: #1F2937;
      font-weight: 500;
      text-decoration: none;
      transition: background 0.3s ease, color 0.3s ease;
      overflow: hidden;
    }
    .sidebar a i {
      min-width: 30px;
      font-size: 18px;
      text-align: center;
    }
    .sidebar a span {
      display: none;
      margin-left: 10px;
      white-space: nowrap;
    }
    .sidebar:hover a span {
      display: inline;
    }
    .sidebar a:hover,
    .sidebar a.active {
      background-color: #F59E0B;
      color: #1F2937;
    }
    .container {
      margin-left: 70px;
    }
    @media (max-width: 768px) {
      .sidebar {
        position: relative;
        width: 100%;
        height: auto;
        display: flex;
        flex-direction: row;
        overflow-x: auto;
      }
      .sidebar a {
        flex: 1;
        justify-content: center;
        font-size: 14px;
        padding: 10px;
      }
      .container {
        margin-left: 0;
        padding: 20px;
      }
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
    <a href="Doubt.php"><i class="fas fa-question-circle"></i><span>Doubt Support</span></a>
    <a href="progress.php"><i class="fas fa-chart-line"></i><span>Progress</span></a>
    <a href="discussion.php"><i class="fas fa-comments"></i><span>Discussion</span></a>
    <a href="certificate.php"><i class="fas fa-certificate"></i><span>Certificate</span></a>
    <a href="../logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
</div>


  <div class="container my-5">
    <h2 class="text-center mb-4">Popular Courses</h2>
    <div class="row g-4">
      <?php
        $courses = [
          ["title" => "UI UX Design", "videos" => 130, "rating" => "4.5 (223)", "img" => "https://th.bing.com/th/id/OIP.doYHfVKgVncrGIL5jmSOMgHaE8?w=276&h=184&c=7&r=0&o=5&dpr=1.3&pid=1.7"],
          ["title" => "Python", "videos" => 130, "rating" => "4.5 (30)", "img" => "https://th.bing.com/th/id/OIP.XTRl4rwNqniKlEtc6swCMgHaE8?w=231&h=180&c=7&r=0&o=5&dpr=1.3&pid=1.7"],
          ["title" => "Figma", "videos" => 130, "rating" => "4.5 (200)", "img" => "https://cdn.prod.website-files.com/59e16042ec229e00016d3a66/64309e803065d50a0999485d_Figma-rebrand-assets_Blog-listing.webp"],
          ["title" => "iOS Development", "videos" => 130, "rating" => "4.5 (23)", "img" => "data:image/jpeg;base64,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"],
          ["title" => "Android App", "videos" => 130, "rating" => "4.5 (123)", "img" => "https://via.placeholder.com/300x150?text=Android"],
          ["title" => "Digital Marketing", "videos" => 130, "rating" => "4.5 (123)", "img" => "https://via.placeholder.com/300x150?text=Marketing"]
        ];

        foreach ($courses as $course) {
          echo '
          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100 shadow-sm">
              <img src="'.$course['img'].'" class="card-img-top" alt="'.$course['title'].'" 
                onerror="this.onerror=null; this.src=\'https://via.placeholder.com/300x150?text=Course\';">
              <div class="card-body d-flex flex-column justify-content-between">
                <h5 class="card-title">'.$course['title'].'</h5>
                <p class="card-text">'.$course['videos'].' Videos</p>
              </div>
              <div class="card-footer d-flex justify-content-between align-items-center">
                <span class="text-warning">⭐ '.$course['rating'].'</span>
                <a href="course_player.php?course='.urlencode($course['title']).'" class="btn btn-primary btn-sm">Enroll now</a>
              </div>
            </div>
          </div>';
        }
      ?>
    </div>
  </div>
</body>
</html>