<?php
session_start();
include '../user/header.php';
$conn = new mysqli("localhost", "root", "", "ecommerce_db");

$id = $_GET["id"] ?? 0;
$result = $conn->query("SELECT * FROM products WHERE id = $id");
$product = $result->fetch_assoc();

if (!$product) {
    die("Producto no encontrado");
}
// Obtener productos relacionados
$related = $conn->query("SELECT p.* FROM products p
    JOIN product_category pc ON p.id = pc.product_id
    WHERE pc.category_id = (SELECT category_id FROM product_category WHERE product_id = $id)
    AND p.id != $id
    LIMIT 4");
if (!$related) {
    die("Error al obtener productos relacionados: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detalle del producto</title>
    <link rel="stylesheet" href="styles.css" />
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
    <div class="product-detail-page">
        <div class="product-detail-grid">

            <!-- Imagen del producto -->
            <div class="product-image-preview">
                <img src="/PROYECTO-FINAL/<?= htmlspecialchars($product["image"]) ?>" alt="<?= htmlspecialchars($product["name"]) ?>">
            </div>

            <!-- Detalles -->
            <div class="product-info">
                <nav class="breadcrumb">Home / <?= htmlspecialchars($product["category"] ?? 'Producto') ?></nav>

                <h1 class="product-title"><?= htmlspecialchars($product["name"]) ?></h1>

                <p class="product-price">$<?= number_format($product["price"], 2) ?></p>

                <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
                    <!--
                        // Tallas si aplica 
                        <select name="size" class="product-select">
                            <option disabled selected>Selecciona Talla</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                        </select>
                        >
                        <!-- Cantidad -->
                    <input type="number" name="quantity" min="1" value="1" class="quantity-input" />

                    <input type="hidden" name="product_id" value="<?= $product["id"] ?>">

                    <button type="submit" class="btn-add-cart">Agregar al carrito</button>
                </form>

                <div class="product-description">
                    <h3>Detalles del Producto</h3>
                    <p><?= nl2br(htmlspecialchars($product["description"])) ?></p>
                </div>
            </div>
        </div>
    </div>

    <?php if ($related && $related->num_rows > 0): ?>
        <section class="related-products">
            <h2 class="section-title">Productos Relacionados</h2>
            <div class="grid">
                <?php while ($r = $related->fetch_assoc()): ?>
                    <div class="product-card">
                        <img src="/PROYECTO-FINAL/<?= htmlspecialchars($r['image']) ?>" alt="<?= htmlspecialchars($r['name']) ?>" class="product-image" />
                        <div class="product-content">
                            <h3 class="product-name"><?= htmlspecialchars($r['name']) ?></h3>
                            <p class="product-price">$<?= number_format($r['price'], 2) ?></p>
                            <a href="product_detail.php?id=<?= $r['id'] ?>" class="product-btn">Ver producto</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    <?php endif; ?>
    <br>

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
    <script>
        document.querySelector('.add-to-cart-form')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);

            const res = await fetch('add_to_cart.php', {
                method: 'POST',
                body: formData
            });

            const data = await res.json();
            if (data.success) {
                const cart = document.getElementById('mini-cart');
                cart.classList.add('show');

                const content = data.cart.map(p => `
      <div class="mini-cart-item">
        <img src="/PROYECTO-FINAL/${p.image}" alt="${p.name}">
        <div>
          <strong>${p.name}</strong><br>
          <span>${p.quantity} × $${parseFloat(p.price).toFixed(2)}</span>
        </div>
      </div>
    `).join('');

                document.getElementById('mini-cart-content').innerHTML = content;
            }
        });
    </script>



</body>

</html>