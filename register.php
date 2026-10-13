<?php
require "config.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();

    if ($check->get_result()->num_rows > 0) {
        $msg = "Email already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name,email,password,role) VALUES (?,?,?,'customer')");
        $stmt->bind_param("sss", $name, $email, $password);
        $stmt->execute();
        header("Location: login.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register | JX HYPERCAR</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-page">
<div class="auth-box">
    <div class="logo">JX <span>HYPERCAR</span></div>
    <h2>Create Account</h2>
    <?php if ($msg): ?><div class="alert"><?= $msg ?></div><?php endif; ?>

    <form method="post">
        <input name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required minlength="6">
        <button class="btn full">Create Account</button>
    </form>
    <p class="center"><a href="login.php">Already have an account?</a></p>
</div>
</body>
</html>