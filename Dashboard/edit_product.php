<?php
session_start();
include '../conexion.php';

$id = $_GET['id'] ?? 0;
$result = $conn->query("SELECT * FROM products WHERE id = $id");

if (!$result || $result->num_rows === 0) {
    die("Producto no encontrado.");
}

$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST["name"]);
    $description = $conn->real_escape_string($_POST["description"]);
    $price = floatval($_POST["price"]);
    $stock = intval($_POST["stock"]);

    $imagePath = $product['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmp = $_FILES['image']['tmp_name'];
        $imageName = uniqid() . "_" . basename($_FILES['image']['name']);
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
        $targetPath = $targetDir . $imageName;
        move_uploaded_file($tmp, $targetPath);
        $imagePath = $targetPath;
    }

    $sql = "UPDATE products SET name='$name', description='$description', price=$price, stock=$stock, image='$imagePath' WHERE id=$id";

    if ($conn->query($sql)) {
        echo "<script>window.parent.postMessage('closeEditModal', '*');</script>";
        exit;
    } else {
        echo "Error al actualizar: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Raleway', sans-serif;
            background: rgba(0, 0, 0, 0.4);
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .edit-modal {
            background: #ffffff;
            padding: 30px 25px;
            border-radius: 16px;
            width: 90vw;
            max-width: 500px;
            max-height: 90vh;                 /* <---- controla altura máxima */
            overflow-y: auto;                 /* <---- habilita scroll vertical */
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            animation: slideUp 0.3s ease-out;
            box-sizing: border-box;
        }



        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        h2 {
            text-align: center;
            color: #111827;
            margin-bottom: 20px;
            font-weight: 700;
        }

        label {
            display: block;
            margin: 12px 0 6px;
            font-weight: 600;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            background-color: #f9fafb;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus {
            border-color: #51b1ff;
            outline: none;
        }

        textarea {
            resize: vertical;
            min-height: 70px;
        }

        input[type="submit"],
        .cancel-button {
            display: block;
            width: 100%;
            padding: 11px;
            border: none;
            font-size: 15px;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 12px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"] {
            background-color: #3b82f6;
            color: white;
        }

        input[type="submit"]:hover {
            background-color: #2563eb;
        }

        .cancel-button {
            background-color: #f3f4f6;
            color: #374151;
        }

        .cancel-button:hover {
            background-color: #e5e7eb;
        }

        img.preview {
            max-width: 100%;
            border-radius: 8px;
            margin-top: 8px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>
    <div class="edit-modal">
        <h2>Editar Producto</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Nombre:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

            <label>Descripción:</label>
            <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea>

            <label>Precio:</label>
            <input type="number" name="price" step="0.01" value="<?= $product['price'] ?>" required>

            <label>Stock:</label>
            <input type="number" name="stock" value="<?= $product['stock'] ?>" required>

            <label>Imagen actual:</label>
            <?php if ($product['image']): ?>
                <img class="preview" src="/PROYECTO-FINAL/<?= $product['image'] ?>" alt="Imagen actual">
            <?php endif; ?>

            <label>Nueva imagen:</label>
            <input type="file" name="image">

            <input type="submit" value="Actualizar">
            <button type="button" class="cancel-button" onclick="window.parent.postMessage('closeEditModal', '*')">Cancelar</button>
        </form>
    </div>
</body>

</html>