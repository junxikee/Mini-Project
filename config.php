<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db   = "jx_dealership";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

function is_login() {
    return isset($_SESSION["user"]);
}

function role($name) {
    return isset($_SESSION["user"]) && $_SESSION["user"]["role"] === $name;
}

function require_role($name) {
    if (!role($name)) {
        header("Location: ../login.php");
        exit;
    }
}
?>