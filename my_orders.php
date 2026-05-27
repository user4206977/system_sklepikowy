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