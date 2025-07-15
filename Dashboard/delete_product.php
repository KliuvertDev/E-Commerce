<?php
$conn = new mysqli("localhost", "root", "", "ecommerce_db");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id = intval($_GET['id']);
$conn->query("DELETE FROM products WHERE id = $id");

$conn->close();
header("Location: dashboard.php");
exit;
