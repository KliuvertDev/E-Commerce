<?php
session_start();
$conn = new mysqli("localhost", "root", "", "ecommerce_db");

$id = (int)($_POST["product_id"] ?? 0);
$quantity = (int)($_POST["quantity"] ?? 1);

if (!$id) {
    echo json_encode(['success' => false, 'message' => 'ID inválido']);
    exit;
}

// Crear el carrito si no existe
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

// Agregar o incrementar cantidad
if (isset($_SESSION["cart"][$id])) {
    $_SESSION["cart"][$id] += $quantity;
} else {
    $_SESSION["cart"][$id] = $quantity;
}

// Obtiene detalles de los productos del carrito
$cartDetails = [];

foreach ($_SESSION["cart"] as $prodId => $qty) {
    $res = $conn->query("SELECT id, name, image, price FROM products WHERE id = $prodId");
    if ($res && $row = $res->fetch_assoc()) {
        $cartDetails[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'image' => $row['image'],
            'price' => $row['price'],
            'quantity' => $qty
        ];
    }
}

echo json_encode([
    'success' => true,
    'cart' => $cartDetails
]);
exit;
