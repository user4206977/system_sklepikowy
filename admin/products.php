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