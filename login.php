<?php
require_once 'includes/db.php';
include 'includes/header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Weryfikacja zahashowanego hasła
    if ($user && password_verify($password, $user['password_hash'])) {
        // Utrzymanie sesji (wymóg projektu)
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['email'] = $user['email'];
        
        // Przekierowanie za pomocą skryptu, aby uniknąć problemów z header()
        echo "<script>window.location='/index.php';</script>";
        exit;
    } else {
        $message = "<div class='alert alert-danger'>Nieprawidłowy e-mail lub hasło.</div>";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="text-center mb-4">Logowanie</h2>
        <?= $message ?>
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="login.php">
                    <div class="mb-3">
                        <label for="email" class="form-label">Adres e-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Hasło</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100 py-2">Zaloguj się</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="/register.php">Nie masz konta? Zarejestruj się</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>