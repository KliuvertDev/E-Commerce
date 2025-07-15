<?php
session_start();
include 'conexion.php';
include 'user/header.php';
// Obtener todas las categorías
$categorias = $conn->query("SELECT * FROM categories");

// Preparar array para almacenar productos por categoría
while ($cat = $categorias->fetch_assoc()) {
    $catId = $cat['id'];
    $catNombre = $cat['name'];

    // OBTENER 2 PRODUCTOS POR CATEGORÍA USANDO products_category
    $productos = $conn->query("
        SELECT p.* FROM products p
        JOIN product_category pc ON p.id = pc.product_id
        WHERE pc.category_id = $catId
        LIMIT 3
    ");

    $productosPorCategoria[$catNombre] = $productos;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ecommerce</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body>
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-2">
                    <h1>
                        No sigas las tendencias.<br />
                        Crealas.
                    </h1>
                    <p>
                        La consistencia es la nueva moda. Moda que trabaja tan duro como tú.
                    </p>
                    <a href="Buscador/search.php" class="btn">Buscar Productos</a>
                </div>
                <div class="col-2">
                    <img src="assets/hero-section.png" />
                </div>
            </div>
    </section>
    <br>
    <br>
    <?php foreach ($productosPorCategoria as $categoria => $productos): ?>
        <h2 class="section-title"><?= htmlspecialchars($categoria) ?></h2>
        <div class="grid">
            <?php while ($p = $productos->fetch_assoc()): ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="product-image" />

                    <div class="product-content">
                        <h3 class="product-name"><?= htmlspecialchars($p['name']) ?></h3>

                        <div class="rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </div>

                        <p class="product-price">$<?= number_format($p['price'], 2) ?></p>

                        <a href="Buscador/product_detail.php?id=<?= $p['id'] ?>" class="product-btn">Ver producto</a>
                    </div>
                </div>

            <?php endwhile; ?>
        </div>
    <?php endforeach; ?>

    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-col">
                <h4>Tienda Online</h4>
                <p>Moda que trabaja tan duro como tú. Consistente. Elegante. Auténtica.</p>
            </div>

            <div class="footer-col">
                <h4>Enlaces útiles</h4>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="Buscador/search.php">Productos</a></li>
                    <li><a href="Buscador/cart.php">Carrito</a></li>
                    <li><a href="Login/register.php">Registrarse</a></li>
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