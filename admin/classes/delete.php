<?php
require_once '../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Check if there are dependent courses
$stmt = $pdo->prepare("SELECT COUNT(*) FROM courses WHERE class_id = ?");
$stmt->execute([$id]);
$count = $stmt->fetchColumn();

if ($count > 0) {
    session_start();
    $_SESSION['error'] = "Cannot delete class because it has dependent courses.";
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("DELETE FROM classes WHERE id = ?");
$stmt->execute([$id]);

header("Location: index.php");
exit;
?>