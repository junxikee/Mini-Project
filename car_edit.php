<?php
require "../config.php";
require_role("staff");
$id=intval($_GET["id"] ?? 0);
$car=$conn->query("SELECT * FROM cars WHERE id=$id")->fetch_assoc();
if (!$car) die("Car not found.");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name=trim($_POST["name"]); $brand=trim($_POST["brand"]); $price=floatval($_POST["price"]); $stock=intval($_POST["stock"]);
    $stmt=$conn->prepare("UPDATE cars SET name=?,brand=?,price=?,stock=? WHERE id=?");
    $stmt->bind_param("ssdii",$name,$brand,$price,$stock,$id); $stmt->execute();
    header("Location: dashboard.php"); exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Car</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="auth-page">
    <div class="auth-box">
        <h2>Edit Hypercar</h2>

        <form method="post">

            <input
                type="text"
                name="name"
                value="<?= htmlspecialchars($car["name"]) ?>"
                placeholder="Car Name"
                required
            >

            <input
                type="text"
                name="brand"
                value="<?= htmlspecialchars($car["brand"]) ?>"
                placeholder="Brand"
                required
            >

            <input
                type="number"
                name="price"
                step="0.01"
                value="<?= htmlspecialchars($car["price"]) ?>"
                placeholder="Price"
                required
            >

            <input
                type="number"
                name="stock"
                value="<?= htmlspecialchars($car["stock"]) ?>"
                placeholder="Stock"
                required
            >
            <button type="submit" class="btn full">
                Save Changes
            </button>
        </form>
        <p class="center">
            <a href="dashboard.php">Back</a>
        </p>
    </div>
</body>
</html>
