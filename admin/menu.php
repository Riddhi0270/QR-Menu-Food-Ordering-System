<?php
require_once '../db.php'; require_admin();
$message = ''; $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = $_POST['action'] ?? '';
    if ($action === 'add') {
        $name=trim($_POST['name']??''); $desc=trim($_POST['description']??''); $cat=trim($_POST['category']??'Other');
        $price=filter_var($_POST['price']??null,FILTER_VALIDATE_FLOAT);
        if ($name==='' || mb_strlen($name)>100 || mb_strlen($desc)>255 || $cat==='' || mb_strlen($cat)>60 || $price===false || $price<=0 || $price>100000) $error='Please enter valid item details and price.';
        else { $stmt=$conn->prepare("INSERT INTO menu_items(name,description,category,price) VALUES(?,?,?,?)"); $stmt->bind_param('sssd',$name,$desc,$cat,$price); $stmt->execute(); $message='Food item added successfully.'; }
    } elseif ($action === 'delete') {
        $id=filter_var($_POST['id']??null,FILTER_VALIDATE_INT);
        if ($id) { $stmt=$conn->prepare("DELETE FROM menu_items WHERE id=?"); $stmt->bind_param('i',$id); $stmt->execute(); $message='Food item deleted.'; }
        else $error='Invalid item.';
    } elseif ($action === 'toggle') {
        $id=filter_var($_POST['id']??null,FILTER_VALIDATE_INT);
        if ($id) { $stmt=$conn->prepare("UPDATE menu_items SET available=1-available WHERE id=?"); $stmt->bind_param('i',$id); $stmt->execute(); $message='Availability updated.'; }
    }
}
$items=$conn->query("SELECT * FROM menu_items ORDER BY category,name");
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Manage Menu</title><link rel="stylesheet" href="../style.css"></head><body><header><strong>Manage Menu</strong><nav><a href="dashboard.php">Orders</a><a href="menu.php">Menu</a><a href="logout.php">Logout</a></nav></header><main class="wrap"><section class="panel"><h1>Add Food Item</h1><?php if($message):?><div class="notice"><?=e($message)?></div><?php endif;?><?php if($error):?><div class="error"><?=e($error)?></div><?php endif;?><form method="post"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>"><input type="hidden" name="action" value="add"><label>Food name</label><input name="name" maxlength="100" required><label>Description</label><input name="description" maxlength="255"><label>Category</label><input name="category" maxlength="60" value="Snacks" required><label>Price (₹)</label><input name="price" type="number" min="0.01" max="100000" step="0.01" required><button>Add Item</button></form></section><h2>Current Menu Items</h2><div class="panel" style="overflow-x:auto"><table><thead><tr><th>Name</th><th>Category</th><th>Price</th><th>Availability</th><th>Actions</th></tr></thead><tbody><?php while($i=$items->fetch_assoc()):?><tr><td><?=e($i['name'])?></td><td><?=e($i['category'])?></td><td>₹<?=number_format((float)$i['price'],2)?></td><td><?=$i['available']?'Available':'Unavailable'?></td><td><div class="actions"><form method="post"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>"><input type="hidden" name="action" value="toggle"><input type="hidden" name="id" value="<?=e($i['id'])?>"><button class="btn secondary" type="submit">Toggle</button></form><form method="post" onsubmit="return confirm('Delete this item?')"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?=e($i['id'])?>"><button class="btn danger" type="submit">Delete</button></form></div></td></tr><?php endwhile;?></tbody></table></div></main></body></html>