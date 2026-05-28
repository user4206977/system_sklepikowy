<?php
require_once 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$userId]);
$myOrders = $stmt->fetchAll();
?>

<h2 class="mb-4">Moje Zamówienia</h2>

<?php if (empty($myOrders)): ?>
    <div class="alert alert-info">Nie masz jeszcze żadnych zamówień.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-bordered shadow-sm">
            <thead class="table-light">
                <tr>
                    <th>Nr zamówienia</th>
                    <th>Data</th>
                    <th>Suma</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($myOrders as $order): ?>
                <tr>
                    <td>#<?= $order['id'] ?></td>
                    <td><?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></td>
                    <td><?= $order['total_price'] ?> zł</td>
                    <td>
                        <?php 
                        $statusClass = 'bg-secondary';
                        if ($order['status'] == 'oczekujące') $statusClass = 'bg-warning text-dark';
                        if ($order['status'] == 'gotowe') $statusClass = 'bg-success';
                        if ($order['status'] == 'w realizacji') $statusClass = 'bg-info text-dark';
                        ?>
                        <span class="badge <?= $statusClass ?>"><?= strtoupper($order['status']) ?></span>
                    </td>
                </tr>