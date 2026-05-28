<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$logged = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zegowska Szama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --main-color: #0d47a1; --accent-color: #ffc107; }
        
        html, body { height: 100%; }
        body { display: flex; flex-direction: column; background-color: #f4f7f6; font-family: 'Inter', sans-serif; }
        .content-wrapper { flex: 1 0 auto; }
        footer { flex-shrink: 0; }

        .navbar { background: var(--main-color) !important; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .product-card { transition: all 0.3s; border: none; border-radius: 20px; overflow: hidden; }
        .product-card:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
        .promo-tag { background: #d32f2f; color: white; padding: 5px 15px; border-radius: 0 0 0 20px; position: absolute; top: 0; right: 0; font-size: 0.75rem; font-weight: bold; z-index: 10; }
        .btn-rounded { border-radius: 50px; }

        @media (max-width: 991.98px) {
            .navbar-collapse { background: var(--main-color); padding: 1rem; border-radius: 15px; margin-top: 10px; }
            .nav-link { border-bottom: 1px solid rgba(255,255,255,0.1); padding: 10px 0; }
        }
    </style>
</head>
<body>

<div class="content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/index.php"><i class="bi bi-shop-window me-2 text-warning"></i>Zegowska Szama</a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#szamaNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="szamaNav">
                <div class="navbar-nav ms-auto align-items-center">
                    <a class="nav-link" href="/index.php">Oferta</a>
                    <?php if($logged): ?>
                        <a class="nav-link" href="/my_orders.php">Moje zamówienia</a>
                        <?php if($_SESSION['role'] == 'admin'): ?>
                            <div class="nav-item dropdown ms-lg-2 w-100 text-center text-lg-start">
                                <a class="nav-link dropdown-toggle text-warning fw-bold" href="#" data-bs-toggle="dropdown">Panel Admina</a>
                                <ul class="dropdown-menu shadow border-0" style="border-radius:15px;">
                                    <li><a class="dropdown-item" href="/admin/products.php">Produkty</a></li>
                                    <li><a class="dropdown-item" href="/admin/orders.php">Zamówienia</a></li>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <a href="/logout.php" class="btn btn-sm btn-outline-light btn-rounded mt-2 mt-lg-0 ms-lg-3 px-3">Wyloguj</a>
                    <?php else: ?>
                        <a href="/login.php" class="btn btn-sm btn-warning btn-rounded fw-bold px-4 mt-2 mt-lg-0 ms-lg-2">Zaloguj się</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
