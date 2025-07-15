<?php
include '../conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name        = $_POST['name'];
    $description = $_POST['description'];
    $price       = $_POST['price'];
    $stock       = $_POST['stock'];
    $category_id = $_POST['category_id'];

    // Guardar imagen
    $filename = $_FILES['image']['name'];
    $imagePath = 'uploads/' . uniqid() . '_' . basename($filename);
    move_uploaded_file($_FILES['image']['tmp_name'], '../' . $imagePath);

    // Insertar en `products`
    $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdis", $name, $description, $price, $stock, $imagePath);
    $stmt->execute();
    $product_id = $stmt->insert_id;

    // Insertar en `product_category`
    $stmt = $conn->prepare("INSERT INTO product_category (product_id, category_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $product_id, $category_id);
    $stmt->execute();

    // Redirigir
    // header("Location: ../Dashboard/dashboard.php");
    header("Location: ./Producto-Formulario.php");
    exit;
}
