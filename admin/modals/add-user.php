<?php
require_once 'C:/xampp/htdocs/geinca/Geinca-LMS/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $role     = $_POST['role'];

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash, role, status) VALUES (?, ?, ?, ?, 'active')");
    $stmt->execute([$fullname, $email, $password_hash, $role]);

    header("Location: ../user-management.php"); // or user list
    exit;
}
?>
