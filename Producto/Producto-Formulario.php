<?php
session_start();
include '../conexion.php';
include __DIR__ . '/../user/header.php';

// Obtener categorías
$categorias = $conn->query("SELECT id, name FROM categories");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="StyleProducto.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body>
    <main>
        <h1>Agregar Nuevo Producto</h1>
        <form action="Producto-Proces.php" method="POST" enctype="multipart/form-data">
            <label for="name">Nombre del producto</label>
            <input type="text" id="name" name="name" placeholder="Ej. Camiseta básica" required>

            <label for="description">Descripción</label>
            <textarea id="description" name="description" placeholder="Escribe una breve descripción del producto..." required></textarea>

            <label for="price">Precio</label>
            <input type="number" id="price" name="price" step="0.01" placeholder="Ej. 49.99" required>

            <label for="stock">Stock disponible</label>
            <input type="number" id="stock" name="stock" placeholder="Ej. 100" required>

            <label for="image">Imagen del producto</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <label for="category_id">Categoría</label>
            <select id="category_id" name="category_id" required>
                <option value="">Selecciona una categoría</option>
                <?php while ($cat = $categorias->fetch_assoc()): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endwhile; ?>
            </select>

            <button type="submit">Agregar producto</button>
        </form>
    </main>

    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-col">
                <h4>Tienda Online</h4>
                <p>Moda que trabaja tan duro como tú. Consistente. Elegante. Auténtica.</p>
            </div>

            <div class="footer-col">
                <h4>Enlaces útiles</h4>
                <ul>
                    <li><a href="/proyecto-final/index.php">Inicio</a></li>
                    <li><a href="/proyecto-final/Buscador/search.php">Productos</a></li>
                    <li><a href="/proyecto-final/Buscador/cart.php">Carrito</a></li>
                    <li><a href="/proyecto-final/Login/register.php">Registrarse</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Síguenos</h4>
                <div class="social-icons">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?= date("Y") ?> Tienda Online. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>

</html>