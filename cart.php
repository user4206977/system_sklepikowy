<?php
require_once 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-warning'>Musisz się <a href='login.php'>zalogować</a>, aby złożyć zamówienie.</div>";
    include 'includes/footer.php';
    exit;
}

// Obsługa zapisu zamówienia do bazy
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_data'])) {
    $cart = json_decode($_POST['cart_data'], true);

    if (!empty($cart)) {
        $total = 0;
        foreach($cart as $item) $total += $item['price'];

        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 'oczekujące')");
        $stmt->execute([$_SESSION['user_id'], $total]);
        $orderId = $pdo->lastInsertId();

        $stmtItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase) VALUES (?, ?, 1, ?)");
        foreach ($cart as $item) {
            $stmtItem->execute([$orderId, $item['id'], $item['price']]);
        }
        echo "<script>localStorage.removeItem('cart'); alert('Zamówienie złożone!'); window.location='index.php';</script>";
    }
}
?>

<h2>Twój Koszyk</h2>
<div id="cartContents" class="list-group mb-4">
    </div>

<div class="card p-3 shadow-sm">
    <h4>Suma: <span id="totalPrice">0.00</span> zł</h4>
    <form id="orderForm" method="POST">
        <input type="hidden" name="cart_data" id="cartDataInput">
        <button type="button" onclick="submitOrder()" class="btn btn-success btn-lg w-100 mt-3">Złóż zamówienie i odbierz w sklepiku</button>
    </form>
    <button onclick="clearCart()" class="btn btn-outline-danger btn-sm mt-2">Wyczyść koszyk</button>
</div>

<script>
function renderCart() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let container = document.getElementById('cartContents');
    let total = 0;
    container.innerHTML = '';

    if (cart.length === 0) {
        container.innerHTML = '<p class="text-muted">Koszyk jest pusty.</p>';
    }