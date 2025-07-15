<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Realizar Pago</title>
</head>
<body>
    <h2>Confirmar Pago</h2>
    <form method="POST" action="make_order.php">
        <!-- Puedes obtener este total dinámicamente si tienes un carrito -->
        <label>Total a pagar:</label><br>
        <input type="number" name="total" step="0.01" value="100.00" required><br><br>
        <input type="submit" value="Pagar ahora">
    </form>
</body>
</html>
