<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { display: flex; min-height: 100vh; }
        .main-content { flex-grow: 1; padding: 20px; }
    </style>
</head>
<body>
    <?php include '../partials/sidebar.php'; ?>
    <div class="main-content">
        <?php include '../partials/header.php'; ?>
        <h1>Welcome, Admin</h1>
        <p>This is your admin dashboard. You can manage users and courses here.</p>
    </div>
</body>
</html>
