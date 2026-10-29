<?php
require_once '../db.php';
if (is_admin()) { header('Location: dashboard.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $conn->prepare("SELECT id,username,password_hash FROM admins WHERE username=?");
    $stmt->bind_param('s',$username); $stmt->execute();
    $admin = $stmt->get_result()->fetch_assoc();
    if ($admin && password_verify($password, $admin['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int)$admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header('Location: dashboard.php'); exit;
    }
    $error = 'Invalid username or password.';
}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Login</title><link rel="stylesheet" href="../style.css"></head><body><main class="wrap"><section class="panel" style="max-width:480px;margin:auto"><h1>Admin Login</h1><p class="muted">Green Leaf Cafe · Management panel</p><?php if($error):?><div class="error"><?=e($error)?></div><?php endif;?><form method="post"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>"><label>Username</label><input name="username" required maxlength="50"><label>Password</label><input type="password" name="password" required><button type="submit">Login</button></form><a href="../index.php">← Back to menu</a></section></main></body></html>