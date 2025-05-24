<?php
// Simulated wishlist items - in a real app, you'd fetch from DB
$wishlist = [
  ["name" => "React.js Bootcamp", "price" => "Free", "image" => "https://via.placeholder.com/80"],
  ["name" => "Smart Fitness Watch", "price" => "$49.99", "image" => "https://via.placeholder.com/80"],
  ["name" => "Noise Cancelling Headphones", "price" => "$89.00", "image" => "https://via.placeholder.com/80"]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Wishlist</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f7fa;
      margin: 0;
      padding: 20px;
    }
    .wishlist-container {
      max-width: 800px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .wishlist-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid #eee;
      padding: 15px 0;
    }
    .item-info {
      display: flex;
      align-items: center;
    }
    .item-info img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 8px;
      margin-right: 15px;
    }
    .item-info h4 {
      margin: 0 0 5px;
      font-size: 18px;
      color: #2c3e50;
    }
    .item-info p {
      margin: 0;
      color: #7f8c8d;
    }
    .item-actions {
      text-align: right;
    }
    .item-actions button {
      padding: 8px 14px;
      margin: 4px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .btn-cart {
      background: #3498db;
      color: white;
    }
    .btn-remove {
      background: #e74c3c;
      color: white;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #34495e;
    }
  </style>
</head>
<body>

  <div class="wishlist-container">
    <h2>My Wishlist</h2>

    <?php foreach ($wishlist as $item): ?>
      <div class="wishlist-item">
        <div class="item-info">
          <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
          <div>
            <h4><?= htmlspecialchars($item['name']) ?></h4>
            <p><?= htmlspecialchars($item['price']) ?></p>
          </div>
        </div>
        <div class="item-actions">
          <button class="btn-cart">Move to Cart</button>
          <button class="btn-remove">Remove</button>
        </div>
      </div>
    <?php endforeach; ?>

    <?php if (empty($wishlist)): ?>
      <p style="text-align:center; color:#7f8c8d;">Your wishlist is empty.</p>
    <?php endif; ?>

  </div>

</body>
</html>
