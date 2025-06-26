<?php
include('../auth/db.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  die("Invalid subject ID.");
}

$subject_id = intval($_GET['id']);

try {
  // Optional: Check for dependent rows (e.g., classes, exams)
  $check = $pdo->prepare("SELECT COUNT(*) FROM classes WHERE subject_id = ?");
  $check->execute([$subject_id]);
  if ($check->fetchColumn() > 0) {
    die("Cannot delete subject. It has related classes.");
  }

  // Perform deletion
  $stmt = $pdo->prepare("DELETE FROM subjects WHERE subject_id = ?");
  $stmt->execute([$subject_id]);

  header("Location: subject-management.php");
  exit;
} catch (PDOException $e) {
  die("Error deleting subject: " . $e->getMessage());
}
