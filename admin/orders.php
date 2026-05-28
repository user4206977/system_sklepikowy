<?php
require_once '../includes/db.php';
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

if (isset($_POST['update_status'])) {
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$_POST['status'], $_POST['order_id']]);
}

$orders = $pdo->query("SELECT o.*, u.email FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC")->fetchAll();

include '../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Zarządzanie Zamówieniami</h2>
    <span class="badge bg-primary">Panel Pracownika Sklepiku</span>
</div>

<div class="table-responsive">
    <table class="table table-bordered bg-white shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Klient</th>
                <th>Zawartość zamówienia (Produkty)</th>
                <th>Suma</th>
                <th>Status</th>
                <th>Akcja</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($orders as $o): ?>
            <tr>
                <td><strong>#<?= $o['id'] ?></strong><br><small class="text-muted"><?= $o['created_at'] ?></small></td>
                <td><?= htmlspecialchars($o['email']) ?></td>
                <td>