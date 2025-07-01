<?php
require_once '../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM lessons WHERE id = ?");
$stmt->execute([$id]);

header("Location: index.php");
exit;
?>