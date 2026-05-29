<?php 
require_once 'includes/db.php';
include 'includes/header.php';
?>

<div class="text-center py-5 mb-4">
    <h1 class="display-4 fw-bold">Głodny? <span class="text-primary">Zamów online!</span></h1>
    <p class="text-muted">Najlepsza szama w całej szkole, prosto pod Twoje drzwi klasy.</p>
    <input type="text" id="searchInput" class="form-control form-control-lg rounded-pill search-bar mt-4 text-center" placeholder="🔍 Czego szukasz?">
</div>

<?php if($logged): ?>
<h4 class="fw-bold mb-4"><i class="bi bi-fire text-danger"></i> Gorące Promocje</h4>
<div class="row g-4 mb-5">
    <?php 
    $stmt = $pdo->query("SELECT * FROM products WHERE is_promoted = 1");
    while($p = $stmt->fetch()): 
        $is_available = !isset($p['is_available']) || $p['is_available'];
        $image_path = !empty($p['image']) ? $p['image'] : 'images/default.png';
    ?>
    <div class="col-6 col-md-3 product-item" data-name="<?= strtolower($p['name']) ?>">
        <div class="card h-100 product-card shadow-sm border-0 <?= $is_available ? 'bg-white' : 'bg-light opacity-75' ?>" <?= !$is_available ? 'style="filter: grayscale(0.4);"' : '' ?>>
            <div class="promo-tag <?= $is_available ? 'bg-danger' : 'bg-secondary' ?>">PROMOCJA</div>
            
            <img src="<?= htmlspecialchars($image_path) ?>" class="card-img-top" alt="<?= htmlspecialchars($p['name']) ?>" style="height: 180px; object-fit: cover;">
            
            <div class="card-body p-4 text-center">
                <h6 class="fw-bold mb-3 <?= $is_available ? '' : 'text-muted text-decoration-line-through' ?>"><?= $p['name'] ?></h6>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="<?= $is_available ? 'text-danger' : 'text-muted' ?> fw-bold fs-5"><?= number_format($p['price'], 2) ?> zł</span>
                    
                    <?php if($is_available): ?>
                        <button onclick="addToCart(<?= $p['id'] ?>, '<?= $p['name'] ?>', <?= $p['price'] ?>, event)" class="btn btn-danger btn-sm rounded-circle shadow-sm">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    <?php else: ?>
                        <button class="btn btn-secondary btn-sm rounded-circle shadow-sm" disabled title="Produkt chwilowo niedostępny">
                            <i class="bi bi-dash"></i>
                        </button>
                    <?php endif; ?>
                </div>
                <?php if(!$is_available): ?>
                    <div class="text-danger small mt-2 fw-bold"><i class="bi bi-exclamation-circle me-1"></i>Brak</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div> 
<?php endif; ?>


<h4 class="fw-bold mb-4">Pełna Oferta</h4>
<div class="row g-4 mb-5">
    <?php 
    $query = $logged ? "SELECT * FROM products WHERE is_promoted = 0" : "SELECT * FROM products";
    $stmt = $pdo->query($query);
    
    while($p = $stmt->fetch()): 
        $is_available = !isset($p['is_available']) || $p['is_available'];
        $image_path = !empty($p['image']) ? $p['image'] : 'images/default.png';
    ?>
    <div class="col-6 col-md-3 product-item" data-name="<?= strtolower($p['name']) ?>">
        <div class="card h-100 product-card shadow-sm border-0 <?= $is_available ? 'bg-white' : 'bg-light opacity-75' ?>" <?= !$is_available ? 'style="filter: grayscale(0.4);"' : '' ?>>
            
            <img src="<?= htmlspecialchars($image_path) ?>" class="card-img-top" alt="<?= htmlspecialchars($p['name']) ?>" style="height: 180px; object-fit: cover;">
            
            <div class="card-body p-4 text-center">
                <h6 class="fw-bold mb-3 <?= $is_available ? '' : 'text-muted text-decoration-line-through' ?>"><?= $p['name'] ?></h6>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="<?= $is_available ? 'text-primary' : 'text-muted' ?> fw-bold fs-5"><?= number_format($p['price'], 2) ?> zł</span>
                    
                    <?php if($is_available): ?>
                        <button onclick="addToCart(<?= $p['id'] ?>, '<?= $p['name'] ?>', <?= $p['price'] ?>, event)" class="btn btn-primary btn-sm rounded-circle shadow-sm">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    <?php else: ?>
                        <button class="btn btn-secondary btn-sm rounded-circle shadow-sm" disabled title="Produkt chwilowo niedostępny">
                            <i class="bi bi-dash"></i>
                        </button>
                    <?php endif; ?>
                </div>
                <?php if(!$is_available): ?>
                    <div class="text-danger small mt-2 fw-bold"><i class="bi bi-exclamation-circle me-1"></i>Brak</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<script>
let cart = JSON.parse(localStorage.getItem('cart')) || [];

function updateUI() {
    localStorage.setItem('cart', JSON.stringify(cart));
    
    const badge = document.getElementById('cartBadge');
    if(badge) badge.innerText = cart.length;

    const input = document.getElementById('cartJSONInput');
    if(input) input.value = JSON.stringify(cart);

    let html = "";
    let total = 0;
    cart.forEach((item, index) => {
        total += parseFloat(item.price);
        html += `
            <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light rounded-3">
                <div>
                    <span class="fw-bold">${item.name}</span><br>
                    <small class="text-muted">${parseFloat(item.price).toFixed(2)} zł</small>
                </div>
                <button onclick="removeFromCart(${index})" class="btn btn-link text-danger p-0"><i class="bi bi-trash"></i></button>
            </div>`;
    });
    
    document.getElementById('cartItemsList').innerHTML = html || "<p class='text-center text-muted'>Twój koszyk jest pusty...</p>";
    
    const totalLabel = document.getElementById('cartTotalLabel');
    if(totalLabel) totalLabel.innerText = total.toFixed(2) + " zł";
}

function addToCart(id, name, price, event) {
    cart.push({id, name, price});
    updateUI();

    const btn = event.currentTarget;
    const icon = btn.querySelector('i');
    
    const originalBg = btn.classList.contains('btn-primary') ? 'btn-primary' : 'btn-danger';
    const originalIcon = icon.className;

    btn.classList.remove(originalBg);
    btn.classList.add('btn-success');
    icon.className = 'bi bi-check-lg';

    setTimeout(() => {
        btn.classList.remove('btn-success');
        btn.classList.add(originalBg);
        icon.className = originalIcon;
    }, 800);
}

function removeFromCart(index) {
    cart.splice(index, 1);
    updateUI();
}

updateUI();

document.getElementById('searchInput').addEventListener('input', (e) => {
    let t = e.target.value.toLowerCase();
    document.querySelectorAll('.product-item').forEach(i => {
        i.style.display = i.dataset.name.includes(t) ? 'block' : 'none';
    });
});
</script>

<?php include 'includes/footer.php'; ?>