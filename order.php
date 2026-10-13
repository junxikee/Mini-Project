<?php
require "../config.php";
require_role("staff");
$id=intval($_GET["id"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $status=$_POST["status"];
    $stmt=$conn->prepare("UPDATE orders SET status=? WHERE id=?");
    $stmt->bind_param("si",$status,$id); $stmt->execute();
    header("Location: dashboard.php"); exit;
}
$o=$conn->query("SELECT orders.*, users.name AS user_name, cars.name AS car_name FROM orders JOIN users ON orders.user_id=users.id JOIN cars ON orders.car_id=cars.id WHERE orders.id=$id")->fetch_assoc();
?>
```php
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Order</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="auth-page">
    <div class="auth-box">

        <!-- Order Title -->
        <h2>Manage Order #<?= $id ?></h2>

        <!-- Order Details -->
        <p>
            Customer:
            <?= htmlspecialchars($o["user_name"]) ?>
        </p>
        <p>
            Car:
            <?= htmlspecialchars($o["car_name"]) ?>
        </p>
        <p class="price">
            RM <?= number_format($o["total"], 2) ?>
        </p>

        <!-- Update Order Status -->
        <form method="post">
            <select name="status" required>
                <option value="Pending">Pending</option>
                <option value="Completed">Completed</option>
                <option value="Cancelled">Cancelled</option>
            </select>
            <button type="submit" class="btn full">
                Update Order
            </button>
        </form>

        <!-- Back to Dashboard -->
        <p class="center">
            <a href="dashboard.php">Back</a>
        </p>
    </div>

</body>
</html>
```