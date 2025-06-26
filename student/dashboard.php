<?php
// session_start();
// if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
//     header('Location: ./login.php');
//     exit;
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
/>
    <link rel="stylesheet" href="css/dashboard.css" />
</head>
<body>
   <?php include './partials/sidebar.php'; ?>


    <!-- Main Content -->
    <div class="content">
        <h2>Welcome, Student!</h2>
        <p class="text-muted">Here is an overview of your learning progress.</p>

        <div class="row mt-4">
            <div class="col-md-4 mb-3">
                <div class="card shadow p-3">
                    <h5>Total Enrolled Courses</h5>
                    <h3>3</h3>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow p-3">
                    <h5>Courses in Wishlist</h5>
                    <h3>5</h3>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow p-3">
                    <h5>Certificates Earned</h5>
                    <h3>1</h3>
                </div>
            </div>
        </div>

  <div class="dashboard-cards-row">
    <!-- Progress Report -->
    <section class="progress-card">
        <h2>PROGRESS REPORT</h2>
        <div class="radial-progress" style="background: conic-gradient(#00AEEF 0% 70%, #e0e0e0 70% 100%);">
            <span>7.06</span>
        </div>
        <p class="label">Average Performance</p>
        <p>Practice Gym: <span class="highlight">81%</span></p>
        <p>Streak: <span class="highlight">1 🔥</span></p>
        <a href="#">Open Report</a>
    </section>

    <!-- Upcoming Sessions -->
    <section class="upcoming-card">
        <h2>UPCOMING</h2>
        <ul>
            <li><span>Today - 7:00 PM</span> <button>JOIN</button></li>
            <li><span>Saturday - 10:30 AM</span> <button>JOIN</button></li>
            <li><span>Monday - 10:30 AM</span> <button>JOIN</button></li>
            <li><span>Monday - 7:00 PM</span> <button>JOIN</button></li>
        </ul>
    </section>

   <!-- upcoming  video section  -->
 <section class="upcoming-videos-section">
  <h2>Upcoming Videos</h2>
  <div class="videos-scroll-container">
     <div class="videos-scroll-wrapper">
      <div class="video-card">
      <img src="https://via.placeholder.com/400x220.png?text=Video+2" alt="Video 2" />
      <div class="video-info">
        <div class="video-header">
          <h4>Video Title 2</h4>
          <span class="badge intermediate">Intermediate</span>
        </div>
        <p>Release Date: June 5, 2025</p>
        <button class="notify-btn">Notify Me</button>
      </div>
    </div>

    <div class="video-card">
      <img src="https://via.placeholder.com/400x220.png?text=Video+2" alt="Video 2" />
      <div class="video-info">
        <div class="video-header">
          <h4>Video Title 2</h4>
          <span class="badge intermediate">Intermediate</span>
        </div>
        <p>Release Date: June 5, 2025</p>
        <button class="notify-btn">Notify Me</button>
      </div>
    </div>
    <div class="video-card">
      <img src="https://via.placeholder.com/400x220.png?text=Video+2" alt="Video 2" />
      <div class="video-info">
        <div class="video-header">
          <h4>Video Title 2</h4>
          <span class="badge intermediate">Intermediate</span>
        </div>
        <p>Release Date: June 5, 2025</p>
        <button class="notify-btn">Notify Me</button>
      </div>
    </div>
    <div class="video-card">
      <img src="https://via.placeholder.com/400x220.png?text=Video+2" alt="Video 2" />
      <div class="video-info">
        <div class="video-header">
          <h4>Video Title 2</h4>
          <span class="badge intermediate">Intermediate</span>
        </div>
        <p>Release Date: June 5, 2025</p>
        <button class="notify-btn">Notify Me</button>
      </div>
    </div>
     </div>
    

    

    


   
  </div>
</section>



</div>

    </div>
</body>
</html>
