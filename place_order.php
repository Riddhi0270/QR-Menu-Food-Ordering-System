<?php
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php'); exit; }
$name = trim($_POST['customer_name'] ?? '');
$table = trim($_POST['table_number'] ?? '');
$raw = $_POST['cart_json'] ?? '';
if ($name === '' || mb_strlen($name) > 100 || $table === '' || mb_strlen($table) > 20) {
    http_response_code(400); exit('Please enter a valid name and table number. <a href="index.php">Go back</a>');
}
$cart = json_decode($raw, true);
if (!is_array($cart) || count($cart) < 1 || count($cart) > 30) {
    http_response_code(400); exit('Cart is empty or invalid. <a href="index.php">Go back</a>');
}
try {
    $conn->begin_transaction();
    $clean = []; $total = 0.0;
    $stmt = $conn->prepare("SELECT id,name,price FROM menu_items WHERE id=? AND available=1");
    foreach ($cart as $line) {
        $id = filter_var($line['id'] ?? null, FILTER_VALIDATE_INT);
        $qty = filter_var($line['quantity'] ?? null, FILTER_VALIDATE_INT);
        if (!$id || !$qty || $qty < 1 || $qty > 20) throw new RuntimeException('Invalid item or quantity.');
        $stmt->bind_param('i', $id); $stmt->execute();
        $item = $stmt->get_result()->fetch_assoc();
        if (!$item) throw new RuntimeException('One of the selected items is not available.');
        $price = (float)$item['price']; $total += $price * $qty;
        $clean[] = ['id'=>(int)$item['id'],'name'=>$item['name'],'price'=>$price,'quantity'=>$qty];
    }
    if ($total <= 0 || $total > 100000) throw new RuntimeException('Order total is invalid.');
    $stmtOrder = $conn->prepare("INSERT INTO orders (customer_name,table_number,total) VALUES (?,?,?)");
    $stmtOrder->bind_param('ssd', $name, $table, $total); $stmtOrder->execute();
    $orderId = $conn->insert_id;
    $stmtLine = $conn->prepare("INSERT INTO order_items (order_id,menu_item_id,item_name,price,quantity) VALUES (?,?,?,?,?)");
    foreach ($clean as $line) {
        $stmtLine->bind_param('iisdi', $orderId, $line['id'], $line['name'], $line['price'], $line['quantity']);
        $stmtLine->execute();
    }
    $conn->commit();
} catch (Throwable $e) {
    $conn->rollback();
    http_response_code(400);
    exit('Order could not be placed: '.e($e->getMessage()).' <a href="index.php">Go back</a>');
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Order placed</title><link rel="stylesheet" href="style.css"></head><body><main class="wrap"><section class="panel"><h1>✅ Order placed successfully!</h1><p>Your order number is <strong>#<?=e($orderId)?></strong>.</p><p>Name: <?=e($name)?></p><p>Table: <?=e($table)?></p><p>Total: <strong>₹<?=number_format($total,2)?></strong></p><p>Status: <span class="tag">Pending</span></p><a class="btn" href="index.php">Back to Menu</a></section></main></body></html>