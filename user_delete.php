<?php
require "../config.php";
require_role("admin");
$id=intval($_GET["id"] ?? 0);
if ($id != $_SESSION["user"]["id"]) $conn->query("DELETE FROM users WHERE id=$id AND role!='admin'");
header("Location: dashboard.php");
exit;
?>