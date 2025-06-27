<?php
require_once 'C:/xampp/htdocs/geinca/Geinca-LMS/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id    = $_POST['user_id'];
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $role  = $_POST['role'];

    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
    $stmt->execute([$name, $email, $role, $id]);

    header("Location: ../user-management.php");
    exit;
}
?>
