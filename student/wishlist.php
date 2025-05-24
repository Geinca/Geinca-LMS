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
}



/* Title */
h1 {
  text-align: center;
  font-size: 2.5rem;
  color: #1a202c;
  margin-bottom: 40px;
}

/* Wishlist Grid */
.wishlist-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 30px;
  max-width: 1200px;
  margin: 40px auto;
}

/* Card */
.card {
  background: #ffffff;
  border-radius: 18px;
  overflow: hidden;
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.05);
  display: flex;
  flex-direction: column;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
  position: relative;
}

.card:hover {
  transform: translateY(-6px);
  box-shadow: 0 16px 28px rgba(0, 0, 0, 0.08);
}

.card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

/* Card Content */
.card-content {
  padding: 20px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  flex: 1;
}

.card h3 {
  font-size: 1.2rem;
  color: #2d3748;
  margin-bottom: 8px;
}

.card p {
  font-size: 1rem;
  color: #718096;
  margin-bottom: 16px;
}

/* Buttons */
.actions {
  display: flex;
  gap: 10px;
}

.actions button {
  flex: 1;
  padding: 12px 16px;
  font-size: 14px;
  font-weight: 600;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  transition: background 0.2s ease;
}

.move-btn {
  background-color: #3b82f6;
  color: white;
}

.move-btn:hover {
  background-color: #2563eb;
}

.remove-btn {
  background-color: #ef4444;
  color: white;
}

.remove-btn:hover {
  background-color: #dc2626;
}

/* Moved Label */
.moved-label {
  background-color: #10b981;
  color: white;
  font-size: 13px;
  padding: 4px 10px;
  border-radius: 9999px;
  position: absolute;
  top: 14px;
  right: 14px;
  display: none;
}

/* Empty Message */
.empty {
  text-align: center;
  font-size: 20px;
  color: #a0aec0;
  margin-top: 60px;
}

  </style>
</head>
<body>

  <!-- Optional Sidebar -->
  <div class="sidebar">
    <h4>Student Panel</h4>
    <a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="enrolled_courses.php"><i class="fas fa-book"></i> Enrolled Courses</a>
    <a href="wishlist.php"><i class="fas fa-heart"></i> Wishlist</a>
    <a href="recommendations.php"><i class="fas fa-star"></i> Recommendations</a>
    <a href="course_player.php"><i class="fas fa-play-circle"></i> Course Player</a>
    <a href="quiz.php"><i class="fas fa-question-circle"></i> Quiz</a>
    <a href="progress.php"><i class="fas fa-chart-line"></i> Progress</a>
    <a href="discussion.php"><i class="fas fa-comments"></i> Discussion</a>
    <a href="certificate.php"><i class="fas fa-certificate"></i> Certificate</a>
    <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
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
