<?php
session_start();
include '../conexion.php';
include 'header.php';

$user_id = $_SESSION['user_id'];
$orders = $conn->query("SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pedidos</title>
    <link rel="stylesheet" href="styles-user.css" />
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

    <div class="orders-container">
        <h2>Mis Pedidos</h2>

        <?php if ($orders->num_rows === 0): ?>
            <p style="text-align:center;">No has realizado pedidos.</p>
        <?php else: ?>
            <?php while ($order = $orders->fetch_assoc()): ?>
                <div class="order-card">
                    <?php
                    $status = strtolower($order["status"]);
                    $status_class = match ($status) {
                        'completed' => 'completed',
                        'cancelled' => 'cancelled',
                        default => 'pending'
                    };
                    ?>
                    <h3>Pedido #<?= $order["id"] ?> - <span class="badge <?= $status_class ?>"><?= ucfirst($status) ?></span></h3>
                    <p>Fecha: <?= date('d/m/Y H:i', strtotime($order["created_at"])) ?> &nbsp; | &nbsp; Total: <strong>$<?= number_format($order["total"], 2) ?></strong></p>

                    <?php
                    $order_id = $order["id"];
                    $items = $conn->query("
                    SELECT p.name, p.image, oi.quantity, p.price, (oi.quantity * p.price) AS subtotal
                    FROM order_items oi
                    JOIN products p ON oi.product_id = p.id
                    WHERE oi.order_id = $order_id
                ");
                    ?>

                    <table>
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($item = $items->fetch_assoc()): ?>
                                <tr>
                                    <td data-label="Imagen"><img src="/PROYECTO-FINAL/<?= htmlspecialchars($item["image"]) ?>" alt="<?= htmlspecialchars($item["name"]) ?>"></td>
                                    <td data-label="Producto"><?= htmlspecialchars($item["name"]) ?></td>
                                    <td data-label="Precio">$<?= number_format($item["price"], 2) ?></td>
                                    <td data-label="Cantidad"><?= $item["quantity"] ?></td>
                                    <td data-label="Subtotal">$<?= number_format($item["subtotal"], 2) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>

        <?php $conn->close(); ?>
    </div>
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