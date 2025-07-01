<?php
header('Content-Type: application/json');
session_start();
require_once __DIR__ . '/../includes/db_connect.php';

$data = json_decode(file_get_contents('php://input'), true);

$email = trim($data['email']);
$password = $data['password'];

// Validate inputs
if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Email and password are required']);
    exit;
}

// Find user by email
$stmt = $pdo->prepare("SELECT id, name, email, password_hash, role, status FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'User not found']);
    exit;
}

// Check if user is active
if ($user['status'] != 'active') {
    echo json_encode(['success' => false, 'message' => 'Your account is not active. Please contact support.']);
    exit;
}

// Verify password
if (!password_verify($password, $user['password_hash'])) {
    echo json_encode(['success' => false, 'message' => 'Incorrect password']);
    exit;
}

// Set session variables
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name'];
$_SESSION['user_email'] = $user['email'];
$_SESSION['user_role'] = $user['role'];

// Remove sensitive data before returning
unset($user['password_hash']);
unset($user['status']);

echo json_encode([
    'success' => true,
    'message' => 'Login successful',
    'user' => $user
]);
?>