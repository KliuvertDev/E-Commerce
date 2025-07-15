<?php
session_start();
include '../conexion.php';
include 'header.php';

// Asegurarse de que haya una sesión activa
if (!isset($_SESSION['user_id'])) {
    header('Location: /proyecto-final/Login/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Obtener datos del usuario
$stmt = $conn->prepare("SELECT name, email, role, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Perfil</title>
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

    <div class="profile-container">
        <div class="profile-avatar">
            <?= strtoupper(substr($user['name'], 0, 1)) ?>
        </div>
        <h2>Mi Perfil</h2>

        <div class="profile-info">
            <label>Nombre completo</label>
            <p><?= htmlspecialchars($user['name']) ?></p>

            <label>Correo electrónico</label>
            <p><?= htmlspecialchars($user['email']) ?></p>

            <label>Rol</label>
            <p><?= ucfirst($user['role']) ?></p>

            <label>Miembro desde</label>
            <p><?= date("d/m/Y", strtotime($user['created_at'])) ?></p>
        </div>

        <div class="profile-actions">
            <a href="/proyecto-final/Login/logout.php">Cerrar sesión</a>
        </div>
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