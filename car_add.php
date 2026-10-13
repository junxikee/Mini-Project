<?php
require "../config.php";
require_role("admin");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name=trim($_POST["name"]); $brand=trim($_POST["brand"]);
    $price=floatval($_POST["price"]); $stock=intval($_POST["stock"]);
    $stmt=$conn->prepare("INSERT INTO cars(name,brand,price,stock) VALUES(?,?,?,?)");
    $stmt->bind_param("ssdi",$name,$brand,$price,$stock);
    $stmt->execute();
    header("Location: dashboard.php"); exit;
}
?>
```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Car</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="auth-page">
    <div class="auth-box">
        <!-- Page Title -->
        <h2>Add Hypercar</h2>

        <!-- Add Car Form -->
        <form method="post">

            <!-- Car Name -->
            <input
                type="text"
                name="name"
                placeholder="Car Name"
                required
            >

            <!-- Car Brand -->
            <input
                type="text"
                name="brand"
                placeholder="Brand"
                required
            >

            <!-- Car Price -->
            <input
                type="number"
                name="price"
                step="0.01"
                placeholder="Price"
                required
            >

            <!-- Stock Quantity -->
            <input
                type="number"
                name="stock"
                placeholder="Stock"
                required
            >

            <!-- Submit Button -->
            <button type="submit" class="btn full">
                Add Car
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