<h2>Twój Koszyk</h2>
<div id="cartContents" class="list-group mb-4">
    </div>

<div class="card p-3 shadow-sm">
    <h4>Suma: <span id="totalPrice">0.00</span> zł</h4>
    <form id="orderForm" method="POST">
        <input type="hidden" name="cart_data" id="cartDataInput">
        <button type="button" onclick="submitOrder()" class="btn btn-success btn-lg w-100 mt-3">Złóż zamówienie i odbierz w sklepiku</button>
    </form>