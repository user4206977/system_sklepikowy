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
                    <ul class="list-unstyled mb-0">
                        <?php
                        // Pobieranie szczegółów produktów dla tego konkretnego zamówienia
                        $stmtItems = $pdo->prepare("
                            SELECT oi.quantity, p.name 
                            FROM order_items oi 
                            JOIN products p ON oi.product_id = p.id 
                            WHERE oi.order_id = ?
                        ");
                        $stmtItems->execute([$o['id']]);
                        $items = $stmtItems->fetchAll();
                        
                        foreach($items as $item): ?>
                            <li><i class="bi bi-check2-short"></i> <?= $item['quantity'] ?>x <strong><?= $item['name'] ?></strong></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td class="fw-bold"><?= number_format($o['total_price'], 2) ?> zł</td>
                <td>
                    <?php 
                        $badgeClass = 'bg-warning text-dark';
                        if($o['status'] == 'gotowe') $badgeClass = 'bg-success';
                        if($o['status'] == 'w realizacji') $badgeClass = 'bg-info';
                        if($o['status'] == 'odebrane') $badgeClass = 'bg-secondary';
                    ?>
                    <span class="badge <?= $badgeClass ?>"><?= strtoupper($o['status']) ?></span>
                </td>
                <td>
                    <form method="POST" class="d-flex gap-2">
                        <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                        <select name="status" class="form-select form-select-sm">
                            <option value="oczekujące" <?= $o['status'] == 'oczekujące' ? 'selected' : '' ?>>Oczekujące</option>
                            <option value="w realizacji" <?= $o['status'] == 'w realizacji' ? 'selected' : '' ?>>W realizacji</option>
                            <option value="gotowe" <?= $o['status'] == 'gotowe' ? 'selected' : '' ?>>Gotowe</option>
                            <option value="odebrane" <?= $o['status'] == 'odebrane' ? 'selected' : '' ?>>Odebrane</option>
                        </select>
                        <button name="update_status" class="btn btn-sm btn-primary">Zmień</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
setTimeout(function(){
   window.location.reload();
}, 30000); 

const lastCheck = new Date().toLocaleTimeString();
console.log("Ostatnie sprawdzenie zamówień: " + lastCheck);
</script>

<?php include '../includes/footer.php'; ?>