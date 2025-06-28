<?php
session_start();
require_once 'C:/xampp/htdocs/geinca/Geinca-LMS/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo "Unauthorized";
    exit;
}

$userId = $_SESSION['user_id'];
$courseId = intval($_POST['course_id'] ?? 0);
$sectionNumber = intval($_POST['section_number'] ?? 0);

// Fetch current progress
$stmt = $pdo->prepare("SELECT completed_section FROM user_progress WHERE user_id = ? AND course_id = ?");
$stmt->execute([$userId, $courseId]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    if ($sectionNumber > $row['completed_section']) {
        $stmt = $pdo->prepare("UPDATE user_progress SET completed_section = ? WHERE user_id = ? AND course_id = ?");
        $stmt->execute([$sectionNumber, $userId, $courseId]);
    }
} else {
    $stmt = $pdo->prepare("INSERT INTO user_progress (user_id, course_id, completed_section) VALUES (?, ?, ?)");
    $stmt->execute([$userId, $courseId, $sectionNumber]);
}

echo "Progress updated";
?>
