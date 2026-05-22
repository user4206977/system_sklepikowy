<?php
require_once '../includes/db.php';
session_start();

// Zabezpieczenie: tylko admin ma wstęp
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Obsługa aktualizacji statusu
if (isset($_POST['update_status'])) {
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$_POST['status'], $_POST['order_id']]);
}

// Pobieramy zamówienia wraz z adresem email użytkownika
$orders = $pdo->query("SELECT o.*, u.email FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC")->fetchAll();

include '../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Zarządzanie Zamówieniami</h2>
    <span class="badge bg-primary">Panel Pracownika Sklepiku</span>
</div>
