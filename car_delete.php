<?php
require "../config.php";
require_role("admin");
$id=intval($_GET["id"] ?? 0);
$conn->query("DELETE FROM cars WHERE id=$id");
header("Location: dashboard.php");
exit;
?>