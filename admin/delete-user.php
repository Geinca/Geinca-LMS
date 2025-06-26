<?php
// admin/delete-user.php
include('../auth/db.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $user_id = intval($_GET['id']);

  // Soft delete: mark user as inactive
  $stmt = $pdo->prepare("UPDATE users SET status = 'inactive' WHERE user_id = ?");
  $stmt->execute([$user_id]);
}

header("Location: user-management.php");
exit;
