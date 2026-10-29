<?php
require_once '../db.php'; require_admin();
$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
if (!$id) { header('Location: dashboard.php'); exit; }
$stmt = $conn->prepare("SELECT * FROM orders WHERE id=?"); $stmt->bind_param('i',$id); $stmt->execute(); $order=$stmt->get_result()->fetch_assoc();
if (!$order) { http_response_code(404); exit('Order not found.'); }
$stmt = $conn->prepare("SELECT item_name,price,quantity FROM order_items WHERE order_id=?"); $stmt->bind_param('i',$id); $stmt->execute(); $items=$stmt->get_result();
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Order details</title><link rel="stylesheet" href="../style.css"></head><body><main class="wrap"><section class="panel"><h1>Order #<?=e($order['id'])?></h1><p>Customer: <?=e($order['customer_name'])?></p><p>Table: <?=e($order['table_number'])?></p><p>Status: <?=e($order['status'])?></p><table><thead><tr><th>Item</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr></thead><tbody><?php while($i=$items->fetch_assoc()):?><tr><td><?=e($i['item_name'])?></td><td>₹<?=number_format((float)$i['price'],2)?></td><td><?=e($i['quantity'])?></td><td>₹<?=number_format((float)$i['price']*(int)$i['quantity'],2)?></td></tr><?php endwhile;?></tbody></table><h3>Total: ₹<?=number_format((float)$order['total'],2)?></h3><a class="btn" href="dashboard.php">Back to Orders</a></section></main></body></html>