<?php
require "config.php";
$cars = $conn->query("SELECT * FROM cars ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>JX HYPERCAR</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<nav class="nav">
    <div class="logo">JX <span>HYPERCAR</span></div>
    <div>
        <a href="index.php">Home</a>
        <?php if (is_login()): ?>
            <a href="customer/dashboard.php">Dashboard</a>
            <a href="logout.php" class="btn small">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php" class="btn small">Register</a>
        <?php endif; ?>
    </div>
</nav>

<section class="hero">
    <p class="tag">PREMIUM AUTOMOTIVE DEALERSHIP</p>
    <h1>Drive Beyond<br><span>Limits.</span></h1>
    <p>Discover exclusive hypercars and manage your purchase with JX HYPERCAR.</p>
    <a href="#cars" class="btn">Explore Hypercars</a>
</section>

<section id="cars" class="section">
    <div class="section-title">
        <div>
            <p class="tag">OUR COLLECTION</p>
            <h2>Featured Hypercars</h2>
        </div>
    </div>

    <div class="grid">
        <?php while ($car = $cars->fetch_assoc()): ?>
        <div class="card">
            <div class="car-img">
                <span><?= htmlspecialchars($car["brand"]) ?></span>
            </div>
            <div class="card-body">
                <p class="muted"><?= htmlspecialchars($car["brand"]) ?></p>
                <h3><?= htmlspecialchars($car["name"]) ?></h3>
                <p class="price">RM <?= number_format($car["price"], 2) ?></p>
                <p class="muted">Stock: <?= $car["stock"] ?></p>
                <?php if ($car["stock"] > 0): ?>
                    <a class="btn full" href="customer/buy.php?id=<?= $car["id"] ?>">Purchase</a>
                <?php else: ?>
                    <button class="btn full disabled">Sold Out</button>
                <?php endif; ?>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<footer>© 2026 JX HYPERCAR · Dealership Sales Management System</footer>
</body>
</html>