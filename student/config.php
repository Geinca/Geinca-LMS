<?php
// Razorpay Configuration
define('rzp_test_kaFNrjpuEwSDoI', 'rzp_test_kaFNrjpuEwSDoI');
define('flkylVJOpBSo3U8Opqsp2w6v', 'flkylVJOpBSo3U8Opqsp2w6v');

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'lms');
define('DB_USER', 'root');
define('DB_PASS', '');

// Include Razorpay library
require 'razorpay-php/Razorpay.php';

use Razorpay\Api\Api;

// Start session
session_start();
?>