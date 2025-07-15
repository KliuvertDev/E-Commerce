<?php
$order_id = $_GET['order_id'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedido Exitoso</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8fafc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .modal {
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
            animation: fadeIn 0.4s ease-out;
        }

        .modal h2 {
            color: #2e7d32;
            margin-bottom: 12px;
        }

        .modal p {
            color: #333;
            margin-bottom: 16px;
        }

        .modal strong {
            color: #007bff;
        }

        .close-btn {
            background-color: #51b1ff;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
        }

        .close-btn:hover {
            background-color: #75c1ff;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="modal">
        <h2>¡Gracias por tu compra!</h2>
        <p>Tu pedido fue procesado correctamente.</p>
        <?php if ($order_id): ?>
            <p>ID del pedido: <strong><?= htmlspecialchars($order_id) ?></strong></p>
        <?php else: ?>
            <p>No se recibió ID del pedido.</p>
        <?php endif; ?>
        <button class="close-btn" onclick="window.location.href='/proyecto-final/index.php'">Cerrar</button>
    </div>
</body>
</html>
