<?php
session_start();
include '../conexion.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    echo "Usuario no autenticado.";
    exit;
}

$user_id = $_SESSION['user_id'];
$cart = $_SESSION['cart'] ?? [];
$selected = $_POST['selected_products'] ?? [];

if (empty($selected)) {
    echo "No seleccionaste productos.";
    exit;
}

// Verificar que los productos seleccionados existan en el carrito
$valid_selection = false;
foreach ($selected as $product_id) {
    if (isset($cart[$product_id])) {
        $valid_selection = true;
        break;
    }
}

if (!$valid_selection) {
    echo "Los productos seleccionados no están en tu carrito.";
    exit;
}

// Crear el pedido
$conn->query("INSERT INTO orders (user_id, total, status) VALUES ($user_id, 0, 'pending')");
$order_id = $conn->insert_id;

$total = 0;

foreach ($selected as $product_id) {
    if (!isset($cart[$product_id])) continue;

    $quantity = intval($cart[$product_id]);

    $res = $conn->query("SELECT price FROM products WHERE id = $product_id");
    if ($res && $row = $res->fetch_assoc()) {
        $price = floatval($row["price"]);
        $subtotal = $price * $quantity;

        // Insertar los productos en order_items
        $conn->query("INSERT INTO order_items (order_id, product_id, quantity, price)
                      VALUES ($order_id, $product_id, $quantity, $price)");

        $total += $subtotal;

        // Eliminar del carrito
        unset($_SESSION['cart'][$product_id]);
    }
}


$conn->query("UPDATE orders SET total = $total WHERE id = $order_id");


$conn->close();

header("Location: /proyecto-final/Buscador/order_success.php?order_id=$order_id");
exit;
