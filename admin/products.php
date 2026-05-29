<?php
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("<div class='container mt-5'><div class='alert alert-danger'>Brak dostępu! Musisz być administratorem.</div></div>");
}

if (isset($_POST['add'])) {
    $stmt = $pdo->prepare("INSERT INTO products (name, price, is_promoted, is_available) VALUES (?, ?, ?, 1)");
    $stmt->execute([$_POST['name'], $_POST['price'], isset($_POST['promoted']) ? 1 : 0]);
    header("Location: products.php");
    exit;
}

if (isset($_POST['update_status'])) {
    $product_id = $_POST['product_id'];
    $is_promoted = isset($_POST['is_promoted']) ? 1 : 0;
    $is_available = isset($_POST['is_available']) ? 1 : 0;
    
    $stmt = $pdo->prepare("UPDATE products SET is_promoted = ?, is_available = ? WHERE id = ?");
    $stmt->execute([$is_promoted, $is_available, $product_id]);
    header("Location: products.php");
    exit;
}

if (isset($_POST['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$_POST['product_id']]);
    header("Location: products.php");
    exit;
}

$products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
include '../includes/header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold"><i class="bi bi-egg-fried text-primary me-2"></i>Zarządzanie Produktami</h2>
    <span class="badge bg-primary px-3 py-2 rounded-pill">Panel Sprzedawcy</span>
</div>

<div class="card shadow-sm border-0 mb-5" style="border-radius: 20px;">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-3"><i class="bi bi-plus-circle me-2 text-success"></i>Dodaj nowy produkt</h5>
        <form method="POST" enctype="multipart/form-data" class="row g-3 align-items-center">
            <div class="col-md-3">
                <input type="text" name="name" class="form-control rounded-pill" placeholder="Nazwa (np. Zapiekanka)" required>
            </div>
            <div class="col-md-2">
                <div class="input-group">
                    <input type="number" step="0.01" name="price" class="form-control rounded-start-pill" placeholder="Cena" required>
                    <span class="input-group-text rounded-end-pill">zł</span>
                </div>
            </div>
            <div class="col-md-3">
                <input type="file" name="image" class="form-control rounded-pill" accept="image/*" title="Wybierz zdjęcie produktu (opcjonalnie)">
            </div>
            <div class="col-md-2 text-center text-md-start">
                <div class="form-check form-switch d-inline-block mt-2">
                    <input type="checkbox" name="promoted" class="form-check-input" id="p" value="1">
                    <label class="form-check-label fw-bold text-danger" for="p">🔥 Promocja</label>
                </div>
            </div>
            <div class="col-md-2">
                <button name="add" class="btn btn-success w-100 btn-rounded fw-bold py-2 shadow-sm">Dodaj</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 bg-white">
            <thead class="table-dark">
                <tr>
                    <th class="ps-4">ID</th>
                    <th>Produkt</th>
                    <th>Cena</th>
                    <th class="text-center">Statusy (Zaznacz i zapisz)</th>
                    <th class="text-end pe-4">Akcje</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($products as $p): 
                    $image_path = !empty($p['image']) ? '../' . $p['image'] : '../images/default.png';
                ?>
                <tr>
                    <td class="ps-4 text-muted">#<?= $p['id'] ?></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="<?= htmlspecialchars($image_path) ?>" alt="img" class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover; border: 1px solid #ddd;">
                            <strong class="text-dark"><?= htmlspecialchars($p['name']) ?></strong>
                        </div>
                    </td>
                    <td class="fw-bold text-primary"><?= number_format($p['price'], 2) ?> zł</td>
                    <td>
                        <form method="POST" class="d-flex justify-content-center gap-4 align-items-center m-0">
                            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">

                            <div class="form-check form-switch m-0">
                                <input type="checkbox" name="is_promoted" class="form-check-input" id="promo-<?= $p['id'] ?>" <?= $p['is_promoted'] ? 'checked' : '' ?>>
                                <label class="form-check-label small <?= $p['is_promoted'] ? 'text-danger fw-bold' : 'text-muted' ?>" for="promo-<?= $p['id'] ?>">Promocja</label>
                            </div>
                            
                            <div class="form-check form-switch m-0">
                                <input type="checkbox" name="is_available" class="form-check-input" id="avail-<?= $p['id'] ?>" <?= (!isset($p['is_available']) || $p['is_available']) ? 'checked' : '' ?>>
                                <label class="form-check-label small <?= (!isset($p['is_available']) || $p['is_available']) ? 'text-success fw-bold' : 'text-muted' ?>" for="avail-<?= $p['id'] ?>">W sklepie</label>
                            </div>
                            
                            <button type="submit" name="update_status" class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-0" title="Zapisz zmiany statusu">
                                <i class="bi bi-save"></i>
                            </button>
                        </form>
                    </td>
                    <td class="text-end pe-4">
                        <form method="POST" onsubmit="return confirm('Czy na pewno chcesz usunąć produkt: <?= htmlspecialchars($p['name']) ?>?');" class="d-inline m-0">
                            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                            <button type="submit" name="delete" class="btn btn-sm btn-danger rounded-circle p-2" title="Usuń produkt">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </td>