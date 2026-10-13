<?php
require "../config.php";
require_role("customer");
$orders = $conn->query("SELECT orders.*, cars.name AS car_name FROM orders JOIN cars ON orders.car_id=cars.id WHERE orders.user_id=".$_SESSION["user"]["id"]." ORDER BY orders.id DESC");
?>
<!DOCTYPE html>
<html>
<head><title>Customer Dashboard</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<?php include "../partials_nav.php"; ?>
<div class="dashboard">
    <div class="topbar">
        <div><p class="tag">CUSTOMER PORTAL</p><h1>Welcome, <?= htmlspecialchars($_SESSION["user"]["name"]) ?></h1></div>
        <a class="btn" href="../index.php">Browse Cars</a>
    </div>

    <div class="stats"><div class="stat"><small>MY ORDERS</small><strong><?= $orders->num_rows ?></strong></div></div>

    <div class="panel">
        <h2>My Purchases</h2>
        <table>
            <tr><th>Car</th><th>Amount</th><th>Status</th><th>Date</th></tr>
            <?php while ($o = $orders->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($o["car_name"]) ?></td>
                <td>RM <?= number_format($o["total"],2) ?></td>
                <td><span class="badge"><?= htmlspecialchars($o["status"]) ?></span></td>
                <td><?= $o["created_at"] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>
</body>
</html>