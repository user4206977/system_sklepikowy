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