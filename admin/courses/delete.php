<?php
require_once '../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Check if there are dependent lessons
$stmt = $pdo->prepare("SELECT COUNT(*) FROM lessons WHERE course_id = ?");
$stmt->execute([$id]);
$count = $stmt->fetchColumn();

if ($count > 0) {
    session_start();
    $_SESSION['error'] = "Cannot delete course because it has dependent lessons.";
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("DELETE FROM courses WHERE id = ?");
$stmt->execute([$id]);

header("Location: index.php");
exit;
?>