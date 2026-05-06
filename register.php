<?php
// register.php
require_once 'includes/db.php';
include 'includes/header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hashowanie hasła (wymóg projektu)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (email, password_hash) VALUES (:email, :password)");
        $stmt->execute(['email' => $email, 'password' => $hashed_password]);
        $message = "<div class='alert alert-success'>Konto założone! Możesz się <a href='/login.php'>zalogować</a>.</div>";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Błąd unikalności (email już istnieje)
            $message = "<div class='alert alert-danger'>Ten adres e-mail jest już zajęty.</div>";
        } else {
            $message = "<div class='alert alert-danger'>Wystąpił błąd: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="text-center mb-4">Rejestracja</h2>
        <?= $message ?>
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="register.php">
                    <div class="mb-3">
                        <label for="email" class="form-label">Adres e-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Hasło</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">Zarejestruj się</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
