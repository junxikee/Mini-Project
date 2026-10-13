<?php
require "../config.php";
require_role("customer");

$id = intval($_GET["id"] ?? 0);
$car = $conn->query("SELECT * FROM cars WHERE id=$id")->fetch_assoc();

if (!$car || $car["stock"] <= 0) {
    die("Car is unavailable. <a href='../index.php'>Back</a>");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uid = $_SESSION["user"]["id"];
    $total = $car["price"];

    $conn->begin_transaction();

    $stmt = $conn->prepare("INSERT INTO orders (user_id,car_id,total,status) VALUES (?,?,?,'Pending')");
    $stmt->bind_param("iid", $uid, $id, $total);
    $stmt->execute();

    $conn->query("UPDATE cars SET stock=stock-1 WHERE id=$id AND stock>0");
    $conn->commit();

    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Purchase | JX HYPERCAR</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body class="auth-page">
<div class="auth-box">
    <div class="logo">JX <span>HYPERCAR</span></div>
    <p class="tag">CONFIRM PURCHASE</p>
    <h2><?= htmlspecialchars($car["name"]) ?></h2>
    <p class="muted"><?= htmlspecialchars($car["brand"]) ?></p>
    <h2 class="price">RM <?= number_format($car["price"],2) ?></h2>
    <form method="post">
        <button class="btn full">Confirm Purchase</button>
    </form>
    <p class="center"><a href="../index.php">Cancel</a></p>
</div>
</body>
</html>