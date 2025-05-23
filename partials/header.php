<?php
if (!isset($_SESSION)) session_start();
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">LMS Dashboard</a>
    <div class="d-flex">
      <span class="navbar-text text-white me-3">
        Logged in as: <?= ucfirst($_SESSION['user_role']) ?>
      </span>
      <a href="../logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
  </div>
</nav>
