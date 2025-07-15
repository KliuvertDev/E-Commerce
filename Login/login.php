<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://unpkg.com/htmx.org@2.0.4"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesion</title>
    <link rel="stylesheet" href="../Login/styles.css">
    <link rel="x-icon" href="favicon.ico" type="image/x-icon">
    <style>
        
    </style>
</head>
<body>
    <main>
    <form method="POST" action="Login-Proces.php">
        <h2 style="text-align: center;">Iniciar Sesión</h2>

        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>

        <label>Correo electrónico:</label>
        <input type="email" name="email" required>

        <label>Contraseña:</label>
        <input type="password" name="password" required>
        
        <input type="submit" value="Ingresar">
        <a href="register.html">Registrar</a>
    </form>
    </main>
</body>
</html>
