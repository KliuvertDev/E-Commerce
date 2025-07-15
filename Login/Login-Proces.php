<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = new mysqli("localhost", "root", "", "ecommerce_db");

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $email = $conn->real_escape_string($_POST["email"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["user_role"] = $user["role"];
            header("Location: /proyecto-final/index.php");
            
            exit;
        } else {
            header("Location: login.php?error=Contraseña incorrecta");
            exit;
        }
    } else {
        header("Location: login.php?error=Correo no registrado");
        exit;
    }

    $conn->close();
}
?>
