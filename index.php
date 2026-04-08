<?php 
require_once 'includes/db.php';
include 'includes/header.php';
?>

<div class="text-center py-5 mb-4">
    <h1 class="display-4 fw-bold">G艂odny? <span class="text-primary">Zam贸w online!</span></h1>
    <p class="text-muted">Najlepsza szama w ca艂ej szkole, prosto pod Twoje drzwi klasy.</p>
    <input type="text" id="searchInput" class="form-control form-control-lg rounded-pill search-bar mt-4 text-center" placeholder="馃攳 Czego szukasz?">
</div>

<?php if($logged): ?>
<h4 class="fw-bold mb-4"><i class="bi bi-fire text-danger"></i> Gor膮ce Promocje</h4>
<div class="row g-4 mb-5">
    <?php 
    $stmt = $pdo->query("SELECT * FROM products WHERE is_promoted = 1");
    while($p = $stmt->fetch()): ?>
    <div class="col-6 col-md-3 product-item" data-name="<?= strtolower($p['name']) ?>">
        <div class="card h-100 product-card shadow-sm border-0 bg-white">
            <div class="promo-tag">PROMOCJA</div>
            <div class="card-body p-4 text-center">
                <h6 class="fw-bold mb-3"><?= $p['name'] ?></h6>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-danger fw-bold fs-5"><?= number_format($p['price'], 2) ?> z艂</span>
                    <button onclick="addToCart(<?= $p['id'] ?>, '<?= $p['name'] ?>', <?= $p['price'] ?>, event)" class="btn btn-danger btn-sm rounded-circle shadow-sm"><i class="bi bi-plus-lg"></i></button>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>
<?php endif; ?>

<h4 class="fw-bold mb-4">Pe艂na Oferta</h4>
<div class="row g-4 mb-5">
    <?php 
    $stmt = $pdo->query("SELECT * FROM products WHERE is_promoted = 0");
    while($p = $stmt->fetch()): ?>
    <div class="col-6 col-md-3 product-item" data-name="<?= strtolower($p['name']) ?>">
        <div class="card h-100 product-card shadow-sm border-0 bg-white">
            <div class="card-body p-4 text-center">
                <h6 class="fw-bold mb-3"><?= $p['name'] ?></h6>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-primary fw-bold fs-5"><?= number_format($p['price'], 2) ?> z艂</span>
                    <button onclick="addToCart(<?= $p['id'] ?>, '<?= $p['name'] ?>', <?= $p['price'] ?>, event)" class="btn btn-primary btn-sm rounded-circle shadow-sm"><i class="bi bi-plus-lg"></i></button>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>