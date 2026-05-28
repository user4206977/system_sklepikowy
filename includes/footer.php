</div> </div> <footer class="text-center py-4 border-top bg-white">
    <div class="container">
        <p class="mb-0 text-muted">&copy; 2026 <strong>Zegowska Szama</strong> - Maciej Strzelec, Wojciech Złonkiewicz, Wojciech Strzezik</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function updateGlobalUI() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const badge = document.getElementById('cartBadge');
        const input = document.getElementById('cartJSONInput');
        const list = document.getElementById('cartItemsList');
        const totalLabel = document.getElementById('cartTotalLabel');

        if(badge) {
            badge.innerText = cart.length;
            badge.classList.add('cart-bounce');
            setTimeout(() => badge.classList.remove('cart-bounce'), 400);
        }

        if(input) input.value = JSON.stringify(cart);

        if(list) {
            let html = "";
            let total = 0;
            cart.forEach((item, index) => {
                total += parseFloat(item.price);
                html += `
                <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded-3">
                    <div>
                        <span class="fw-bold">${item.name}</span><br>
                        <small class="text-muted">${parseFloat(item.price).toFixed(2)} zł</small>
                    </div>
                </div>`;