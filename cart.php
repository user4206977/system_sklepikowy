<?php
require_once 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-warning'>Musisz się <a href='login.php'>zalogować</a>, aby złożyć zamówienie.</div>";
    include 'includes/footer.php';
    exit;
}

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