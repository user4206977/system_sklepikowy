<?php
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("<div class='container mt-5'><div class='alert alert-danger'>Brak dostępu! Musisz być administratorem.</div></div>");
}