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
  <?php include './partials/sidebar.php' ?>

  <!-- Main Content -->
  <div class="container my-5">
    <h2 class="text-center mb-4">Popular Courses</h2>
    <div class="row g-4">
      <?php
      $courses = [
        [
          "title" => "UI UX Design",
          "videos" => 130,
          "rating" => "4.5 (223)",
          "img" => "https://th.bing.com/th/id/OIP.doYHfVKgVncrGIL5jmSOMgHaE8?w=276&h=184&c=7&r=0&o=5&dpr=1.3&pid=1.7"
        ],
        [
          "title" => "Python",
          "videos" => 130,
          "rating" => "4.5 (30)",
          "img" => "https://th.bing.com/th/id/OIP.XTRl4rwNqniKlEtc6swCMgHaE8?w=231&h=180&c=7&r=0&o=5&dpr=1.3&pid=1.7"
        ],
        [
          "title" => "Figma",
          "videos" => 130,
          "rating" => "4.5 (200)",
          "img" => "https://kajabi-storefronts-production.kajabi-cdn.com/kajabi-storefronts-production/sites/2147591000/images/kbN4A0GPTNGOna0NjzxY_file.jpg"
        ],
        [
          "title" => "iOS Development",
          "videos" => 130,
          "rating" => "4.5 (23)",
          "img" => "https://www.webdschool.com/img/ios-app-development.jpg"
        ],
        [
          "title" => "Android App",
          "videos" => 130,
          "rating" => "4.5 (123)",
          "img" => "https://images.prismic.io//intuzwebsite/2caf3e7f-1704-42e2-908f-3d089da3e3ac_The+Ultimate+Guide+to+Android+App+Development.png?w=1200&q=75&auto=format,compress&fm=png8"
        ],
        [
          "title" => "Digital Marketing",
          "videos" => 130,
          "rating" => "4.5 (123)",
          "img" => "https://digitallearning.eletsonline.com/wp-content/uploads/2019/04/Digital-Marketing.jpg"
        ]
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