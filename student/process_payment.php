<?php
require 'config.php'; // Your database and Razorpay config
session_start();

header('Content-Type: application/json');

// Verify user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

// Verify payment signature
$attributes = [
    'razorpay_order_id' => $input['razorpay_order_id'],
    'razorpay_payment_id' => $input['razorpay_payment_id'],
    'razorpay_signature' => $input['razorpay_signature']
];

try {
    $api = new Razorpay\Api\Api(rzp_test_kaFNrjpuEwSDoI, flkylVJOpBSo3U8Opqsp2w6v);
    $api->utility->verifyPaymentSignature($attributes);
    
    // Payment verified - create enrollment
    $pdo = new PDO('mysql:host=localhost;dbname=lms', 'root', '');
    
    // Calculate expiry date
    $expiryDate = new DateTime();
    if ($input['subscriptionType'] === 'monthly') {
        $expiryDate->add(new DateInterval('P30D'));
    } else {
        $expiryDate->add(new DateInterval('P1Y'));
    }
    
    // Save enrollment
    $stmt = $pdo->prepare("INSERT INTO user_courses 
                          (user_id, course_id, subscription_type, amount_paid, payment_id, expiry_date, is_active) 
                          VALUES (?, ?, ?, ?, ?, ?, 1)
                          ON DUPLICATE KEY UPDATE 
                          subscription_type = VALUES(subscription_type),
                          amount_paid = VALUES(amount_paid),
                          payment_id = VALUES(payment_id),
                          expiry_date = VALUES(expiry_date),
                          is_active = 1");
    
    $stmt->execute([
        $input['userId'],
        $input['courseId'],
        $input['subscriptionType'],
        $input['amount'],
        $input['razorpay_payment_id'],
        $expiryDate->format('Y-m-d')
    ]);
    
    echo json_encode(['success' => true]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>