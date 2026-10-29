<?php
require_once 'db.php';
$result = $conn->query("SELECT id,name,description,category,price FROM menu_items WHERE available=1 ORDER BY category,name");
$items = [];
while ($row = $result->fetch_assoc()) $items[] = $row;
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>QR Menu | Green Leaf Cafe</title><link rel="stylesheet" href="style.css"></head>
<body><header><div><strong>🍽️ Green Leaf Cafe</strong><div class="muted" style="color:#d6e7df">Digital Menu & Food Ordering</div></div><nav><a href="#menu">Menu</a><a href="#cart">My Cart</a><a href="admin/login.php">Admin</a></nav></header>
<main class="wrap"><section class="hero"><span class="tag">SCAN • SELECT • ORDER</span><h1>Welcome to our digital menu</h1><p>Explore our menu, add your favourites to the cart and place your order in a few simple steps.</p><p class="muted">Demo project for QR-based food ordering. Prices are in Indian Rupees (₹).</p></section>
<h2 id="menu">Our Menu</h2>
<div class="grid">
<?php foreach ($items as $item): ?>
<article class="card"><span class="tag"><?=e($item['category'])?></span><h3><?=e($item['name'])?></h3><p class="muted"><?=e($item['description'])?></p><p class="price">₹<?=number_format((float)$item['price'],2)?></p>
<label for="qty-<?=$item['id']?>">Quantity</label><input id="qty-<?=$item['id']?>" type="number" min="1" max="20" value="1">
<button type="button" class="add-to-cart" data-id="<?=$item['id']?>" data-name="<?=e($item['name'])?>" data-price="<?=htmlspecialchars((string)(float)$item['price'], ENT_QUOTES, 'UTF-8')?>" data-qty-id="qty-<?=$item['id']?>">Add to Cart</button>
</article>
<?php endforeach; ?>
</div>
<section class="panel" id="cart" style="margin-top:28px"><h2>🛒 Your Cart</h2><div id="cart-items"><p class="muted">Your cart is empty.</p></div><h3>Total: ₹<span id="cart-total">0.00</span></h3>
<form id="order-form" method="post" action="place_order.php" onsubmit="return prepareOrder()">
<label for="customer_name">Your name</label><input id="customer_name" name="customer_name" maxlength="100" required>
<label for="table_number">Table number</label><input id="table_number" name="table_number" maxlength="20" required placeholder="e.g. 4">
<input type="hidden" id="cart_json" name="cart_json">
<button type="submit">Place Order</button>
</form><p class="muted">Please check your cart before placing the order.</p></section></main>
<footer>Green Leaf Cafe · Digital QR-Based Menu & Food Ordering System</footer>
<script>
let cart = [];

document.querySelectorAll('.add-to-cart').forEach(button => {
  button.addEventListener('click', () => {
    const qtyInput = document.getElementById(button.dataset.qtyId);
    addToCart(
      Number(button.dataset.id),
      button.dataset.name,
      Number(button.dataset.price),
      qtyInput.value
    );
  });
});

function addToCart(id,name,price,qty) {
  qty = Number(qty);
  if (!Number.isInteger(qty) || qty < 1 || qty > 20) { alert('Please enter quantity from 1 to 20.'); return; }
  const existing = cart.find(x => x.id === id);
  if (existing) existing.quantity = Math.min(20, existing.quantity + qty);
  else cart.push({id:Number(id),name:String(name),price:Number(price),quantity:qty});
  renderCart();
}
function changeQty(id,value) {
  const qty = Number(value); const item = cart.find(x=>x.id===id);
  if (!item) return;
  if (!Number.isInteger(qty) || qty < 1 || qty > 20) { alert('Quantity must be 1–20.'); renderCart(); return; }
  item.quantity = qty; renderCart();
}
function removeItem(id) { cart = cart.filter(x=>x.id!==id); renderCart(); }
function renderCart() {
  const holder = document.getElementById('cart-items');
  if (!cart.length) { holder.innerHTML = '<p class="muted">Your cart is empty.</p>'; }
  else { holder.innerHTML = cart.map(x => `<div class="cart-row"><div><strong>${escapeHtml(x.name)}</strong><br><span class="muted">₹${x.price.toFixed(2)} each</span></div><input aria-label="Quantity" type="number" min="1" max="20" value="${x.quantity}" onchange="changeQty(${x.id},this.value)"><button class="btn danger" type="button" onclick="removeItem(${x.id})">Remove</button></div>`).join(''); }
  document.getElementById('cart-total').textContent = cart.reduce((s,x)=>s+x.price*x.quantity,0).toFixed(2);
}
function escapeHtml(s) { return String(s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])); }
function prepareOrder() {
  const name = document.getElementById('customer_name').value.trim();
  const table = document.getElementById('table_number').value.trim();
  if (!name || !table) { alert('Please enter your name and table number.'); return false; }
  if (!cart.length) { alert('Please add at least one item to your cart.'); return false; }
  document.getElementById('cart_json').value = JSON.stringify(cart.map(x=>({id:x.id,quantity:x.quantity})));
  return true;
}
</script></body></html>