<?php
session_start();
include '../conexion.php';
include __DIR__ . '/../user/header.php';

$cart = $_SESSION["cart"] ?? [];
$total = 0;

// Eliminar producto del carrito
if (isset($_GET['remove'])) {
    $removeId = $_GET['remove'];
    unset($_SESSION['cart'][$removeId]);
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Carrito</title>
    <link rel="stylesheet" href="styles.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body>
<main style="padding: 30px; max-width: 1000px; margin: auto;">
    <h2 style="font-size: 2rem; margin-bottom: 20px;">Carrito de Compras</h2>

    <?php if (empty($cart)): ?>
        <p>Tu carrito está vacío.</p>
    <?php else: ?>
        <form id="orderForm" action="make_order.php" method="POST" onsubmit="disableButton()">
            <table class="cart-table">
                <tr>
                    <th>Seleccionar</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
                <?php foreach ($cart as $product_id => $quantity): ?>
                    <?php
                    $res = $conn->query("SELECT * FROM products WHERE id = $product_id");
                    $prod = $res->fetch_assoc();
                    $subtotal = $prod["price"] * $quantity;
                    $total += $subtotal;
                    ?>
                    <tr>
                        <td><input type="checkbox" name="selected_products[]" value="<?= $product_id ?>" checked></td>
                        <td>
                            <img src="/PROYECTO-FINAL/<?= htmlspecialchars($prod['image']) ?>" class="cart-item-image">
                            <?= htmlspecialchars($prod["name"]) ?>
                        </td>
                        <td>$<?= number_format($prod["price"], 2) ?></td>
                        <td><?= $quantity ?></td>
                        <td>$<?= number_format($subtotal, 2) ?></td>
                        <td class="cart-actions"><a href="?remove=<?= $product_id ?>">Quitar</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <div class="total-section">
                Total: $<?= number_format($total, 2) ?>
            </div>

            <button type="submit" id="finalizar-pedido">Finalizar Pedido</button>
        </form>
    <?php endif; ?>

    <!-- Productos relacionados -->
    <?php
    $related = $conn->query("SELECT * FROM products ORDER BY RAND() LIMIT 6");
    if ($related && $related->num_rows > 0): ?>
        <section class="related-products">
            <h3>También podría gustarte</h3>
            <div class="related-grid">
                <?php while ($r = $related->fetch_assoc()): ?>
                    <div class="related-card">
                        <img src="/PROYECTO-FINAL/<?= htmlspecialchars($r['image']) ?>" alt="<?= htmlspecialchars($r['name']) ?>">
                        <h4><?= htmlspecialchars($r['name']) ?></h4>
                        <p>$<?= number_format($r['price'], 2) ?></p>
                        <a href="product_detail.php?id=<?= $r['id'] ?>" class="product-btn">Ver producto</a>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    <?php endif; ?>
</main>

<script>
    function disableButton() {
        const btn = document.getElementById("finalizar-pedido");
        btn.disabled = true;
        btn.textContent = "Procesando...";
    }
</script>
</body>
</html>

<?php $conn->close(); ?>
