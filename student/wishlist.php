<?php
$wishlist = [
  ["id" => 1, "name" => "React.js Bootcamp", "price" => "Free", "image" => "https://via.placeholder.com/300x180?text=React.js+Bootcamp"],
  ["id" => 2, "name" => "Smart Watch", "price" => "$59.99", "image" => "https://via.placeholder.com/300x180?text=Smart+Watch"],
  ["id" => 3, "name" => "Wireless Headphones", "price" => "$79.00", "image" => "https://via.placeholder.com/300x180?text=Wireless+Headphones"]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Wishlist</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link rel="stylesheet" href="css/dashboard.css">
  <style>
 * {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Body */
body {
  background: #f7fafc;
}

/* Title */
h1 {
  text-align: center;
  font-size: 3rem;
  color: #2d3748;
  margin: 60px 0 30px;
  font-weight: bold;
}

/* Wishlist Grid */
.wishlist-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 30px;
  max-width: 1200px;
  margin: auto;
  padding: 0 20px 60px;
}

/* Card */
.card {
  background: #fff;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
  display: flex;
  flex-direction: column;
  position: relative;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-8px);
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.12);
}

.card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-bottom: 1px solid #e2e8f0;
}

/* Card Content */
.card-content {
  padding: 20px;
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.card h3 {
  font-size: 1.3rem;
  color: #1a202c;
  margin-bottom: 10px;
}

.card p {
  font-size: 1.05rem;
  color: #4a5568;
  margin-bottom: 20px;
}

/* Buttons */
.actions {
  display: flex;
  gap: 10px;
}

.actions button {
  flex: 1;
  padding: 12px 16px;
  font-size: 0.95rem;
  font-weight: 600;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.25s ease, transform 0.2s ease;
}

.actions button:hover {
  transform: scale(1.04);
}

.move-btn {
  background: linear-gradient(135deg, #3b82f6, #2563eb);
  color: #fff;
}

.move-btn:hover {
  background: linear-gradient(135deg, #2563eb, #1d4ed8);
}

.remove-btn {
  background: linear-gradient(135deg, #ef4444, #dc2626);
  color: #fff;
}

.remove-btn:hover {
  background: linear-gradient(135deg, #dc2626, #b91c1c);
}

/* Moved Label */
.moved-label {
  background-color: #10b981;
  color: white;
  font-size: 12px;
  padding: 6px 12px;
  border-radius: 20px;
  position: absolute;
  top: 16px;
  right: 16px;
  display: none;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
  animation: popIn 0.3s ease forwards;
}

@keyframes popIn {
  0% {
    transform: scale(0.5);
    opacity: 0;
  }
  100% {
    transform: scale(1);
    opacity: 1;
  }
}

/* Empty Message */
.empty {
  text-align: center;
  font-size: 1.5rem;
  color: #a0aec0;
  margin-top: 80px;
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


  <h1>My Wishlist</h1>

  <div class="wishlist-grid" id="wishlist">
    <?php foreach ($wishlist as $item): ?>
      <div class="card" data-id="<?= $item['id'] ?>">
        <span class="moved-label">Moved to Cart</span>
        <img src="<?= $item['image'] ?>" alt="<?= htmlspecialchars($item['name']) ?>">
        <div class="card-content">
          <h3><?= htmlspecialchars($item['name']) ?></h3>
          <p><?= htmlspecialchars($item['price']) ?></p>
          <div class="actions">
            <button class="move-btn">Move to Cart</button>
            <button class="remove-btn">Remove</button>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div id="emptyMsg" class="empty" style="display: none;">Your wishlist is currently empty.</div>

  <script>
    const wishlistContainer = document.getElementById('wishlist');
    const emptyMessage = document.getElementById('emptyMsg');

    wishlistContainer.addEventListener('click', function (e) {
      if (e.target.classList.contains('remove-btn')) {
        const card = e.target.closest('.card');
        card.remove();
        checkIfEmpty();
      }

      if (e.target.classList.contains('move-btn')) {
        const card = e.target.closest('.card');
        const movedLabel = card.querySelector('.moved-label');
        movedLabel.style.display = 'inline-block';
        e.target.disabled = true;
        e.target.textContent = "Moved";
      }
    });

    function checkIfEmpty() {
      if (wishlistContainer.querySelectorAll('.card').length === 0) {
        emptyMessage.style.display = 'block';
      }
    }
  </script>

</body>
</html>
