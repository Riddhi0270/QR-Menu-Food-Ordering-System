<?php
require_once '../db.php'; require_admin();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: dashboard.php'); exit; }
verify_csrf();
$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
$status = $_POST['status'] ?? '';
$allowed = ['Pending','Preparing','Ready','Completed','Cancelled'];
if (!$id || !in_array($status,$allowed,true)) { http_response_code(400); exit('Invalid order update.'); }
$stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
$stmt->bind_param('si',$status,$id); $stmt->execute();
header('Location: dashboard.php'); exit;
