<?php
// Local XAMPP defaults. Change these if your MySQL setup differs.
$DB_HOST = 'localhost';
$DB_NAME = 'qr_food_ordering';
$DB_USER = 'root';
$DB_PASS = '';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    $conn->set_charset('utf8mb4');
} catch (Throwable $e) {
    http_response_code(500);
    exit('Database connection failed. Check that MySQL is running and database.sql was imported. Details: ' .
        htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
}
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
function is_admin() {
    return isset($_SESSION['admin_id']);
}
function require_admin() {
    if (!is_admin()) {
        header('Location: login.php');
        exit;
    }
}
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
function verify_csrf() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sent = $_POST['csrf_token'] ?? '';
        if (!is_string($sent) || !hash_equals(csrf_token(), $sent)) {
            http_response_code(403);
            exit('Invalid form token. Please go back and try again.');
        }
    }
}
