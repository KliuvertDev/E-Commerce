<?php
session_start();
session_unset(); // Borra todas las variables de sesión
session_destroy(); // Destruye la sesión actual

// Redirige al login (ajusta la ruta según tu proyecto)
header("Location: login.php");
exit;
