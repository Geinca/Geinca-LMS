<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>EduAssist Support</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/dashboard.css" />
  <style>
    body {
      margin: 0;
      background: #f0f4fb;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      min-height: 100vh;
      color: #333;
    }
    main {
      margin-left: 220px;
      padding: 40px;
      flex: 1;
      overflow-y: auto;
    }
    .support-title {
      text-align: center;
      margin-bottom: 3rem;
      max-width: 700px;
      margin: auto;
    }
    .support-title h1 {
      font-weight: 700;
      color: #1d4ed8;
      font-size: 2.8rem;
      margin-bottom: 0.5rem;
    }
    .support-container {
      display: flex;
      justify-content: center;
      gap: 2rem;
      flex-wrap: wrap;
      max-width: 960px;
      margin: auto;
    }
    .support-card {
      flex: 1 1 320px;
      max-width: 440px;
      border-radius: 20px;
      padding: 35px 30px;
      background: linear-gradient(145deg, #fff, #f0f6ff);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.05);
      cursor: pointer;
      transition: 0.3s ease;
    }
    .support-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 25px 40px rgba(29, 78, 216, 0.2);
    }
    .support-card.light {
      background: linear-gradient(145deg, #dbe9ff, #f0f6ff);
    }
    .support-card.purple {
      background: linear-gradient(145deg, #f3e8ff, #f9f5ff);
    }
    .support-card h3 {
      font-size: 1.7rem;
      margin-bottom: 1.4rem;
      color: #1e3a8a;
      font-weight: 700;
    }
    .support-card ul {
      margin-bottom: 1.6rem;
    }
    .support-card ul li {
      margin-bottom: 0.7rem;
      color: #475569;
    }
    .btn-support {
      border-radius: 10px;
      padding: 12px 28px;
      font-weight: 700;
      font-size: 1rem;
      border: none;
      display: inline-block;
    }
    .btn-support.purple {
      background-color: #8b5cf6;
      color: white;
    }
    .btn-support.purple:hover {
      background-color: #6d28d9;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <h4 class="text-center py-3">Student Panel</h4>
  <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
  <a href="enrolled_courses.php"><i class="fas fa-book"></i> Enrolled Courses</a>
  <a href="wishlist.php"><i class="fas fa-heart"></i> Wishlist</a>
  <a href="recommendations.php"><i class="fas fa-star"></i> Recommendations</a>
  <a href="course_player.php"><i class="fas fa-play-circle"></i> Course Player</a>
  <a href="Doubt.php"><i class="fas fa-question-circle"></i> Doubt Support</a>
  <a href="progress.php"><i class="fas fa-chart-line"></i> Progress</a>
  <a href="discussion.php"><i class="fas fa-comments"></i> Discussion</a>
  <a href="certificate.php"><i class="fas fa-certificate"></i> Certificate</a>
  <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<main>
  <section class="support-title">
    <h1>EduAssist: Your Learning Companion</h1>
    <p>Need answers fast? Our dedicated support team is here to guide your academic journey with clarity and care.</p>
    <h4 class="mt-4">Select Your Support Type</h4>
  </section>

  <section class="support-container">
    <article class="support-card light">
      <h3><i class="fa fa-headset"></i> Account & Course Help</h3>
      <ul>
        <li>Enrollment and payment assistance</li>
        <li>Course curriculum explanations</li>
        <li>Managing your learning dashboard</li>
        <li>Setting up study schedules</li>
      </ul>
      <p><strong>Avg. response time:</strong> &lt; 10 mins</p>
      <a href="#" class="btn btn-support blue">Contact Support</a>
    </article>

    <article class="support-card purple">
      <h3><i class="fa fa-graduation-cap"></i> Academic & Study Queries</h3>
      <ul>
        <li>Connect with subject experts</li>
        <li>Personalized tutoring</li>
        <li>Help with assignments</li>
        <li>Real-time doubt clearing</li>
      </ul>
      <p><strong>Avg. response time:</strong> &lt; 3 mins</p>
      <a href="#" class="btn btn-support purple" id="academicHelpBtn">Get Academic Help</a>
    </article>
  </section>
</main>

<!-- Modal -->
<div class="modal fade" id="doubtModal" tabindex="-1" aria-labelledby="doubtModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="doubtModalLabel">Ask Your Academic Doubt</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="doubtForm">
        <div class="modal-body">
          <div class="mb-3">
            <label for="studentDoubt" class="form-label">Your Question</label>
            <textarea class="form-control" id="studentDoubt" name="doubt" rows="4" required placeholder="Enter your doubt here..."></textarea>
          </div>
          <div id="doubtSuccess" class="text-success fw-bold d-none">Your doubt has been submitted!</div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit Doubt</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

<script>
  // Show modal
  document.getElementById('academicHelpBtn').addEventListener('click', function (e) {
    e.preventDefault();
    const doubtModal = new bootstrap.Modal(document.getElementById('doubtModal'));
    doubtModal.show();
  });

  // Handle form submission
  document.getElementById('doubtForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const doubtText = document.getElementById('studentDoubt').value.trim();
    if (!doubtText) return;

    fetch('submit_doubt.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: 'doubt=' + encodeURIComponent(doubtText)
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        document.getElementById('doubtSuccess').classList.remove('d-none');
        document.getElementById('doubtForm').reset();
        setTimeout(() => {
          const modal = bootstrap.Modal.getInstance(document.getElementById('doubtModal'));
          modal.hide();
          document.getElementById('doubtSuccess').classList.add('d-none');
        }, 2000);
      } else {
        alert(data.message);
      }
    })
    .catch(() => alert('Something went wrong. Please try again later.'));
  });
</script>

</body>
</html>
