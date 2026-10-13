<?php
require "config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user"] = $user;

        if ($user["role"] === "admin") header("Location: admin/dashboard.php");
        elseif ($user["role"] === "staff") header("Location: staff/dashboard.php");
        else header("Location: customer/dashboard.php");
        exit;
    }

    $error = "Invalid email or password.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login | JX HYPERCAR</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-page">
<div class="auth-box">
    <div class="logo">JX <span>HYPERCAR</span></div>
    <h2>Welcome Back</h2>
    <p class="muted">Sign in to your account.</p>

    <?php if ($error): ?><div class="alert"><?= $error ?></div><?php endif; ?>

    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button class="btn full">Login</button>
    </form>

    <p class="muted center">No account? <a href="register.php">Register</a></p>
    <p class="center"><a href="index.php">← Back to website</a></p>
</div>
</body>
</html>