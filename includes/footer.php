</div> </div> <footer class="text-center py-4 border-top bg-white">
    <div class="container">
        <p class="mb-0 text-muted">&copy; 2026 <strong>Zegowska Szama</strong> - Maciej Strzelec, Wojciech Złonkiewicz, Wojciech Strzezik</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Globalna funkcja do aktualizacji UI (licznik i modal)
    function updateGlobalUI() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const badge = document.getElementById('cartBadge');
        const input = document.getElementById('cartJSONInput');
        const list = document.getElementById('cartItemsList');
        const totalLabel = document.getElementById('cartTotalLabel');
 
</body>
</html>
