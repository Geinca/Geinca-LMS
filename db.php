<?php
$host = 'localhost';      // or '127.0.0.1'
$db   = 'lms';     // your database name
$user = 'root';           // default XAMPP username
$pass = '';               // default XAMPP password (empty)
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    return $pdo;  // Return the connection object
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}