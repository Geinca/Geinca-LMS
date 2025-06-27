<?php
require_once 'C:/xampp/htdocs/geinca/Geinca-LMS/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['user_id'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: ../user-management.php");
    exit;
}
?>
