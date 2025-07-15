<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header class="site-header">
    <div class="logo"><a href="/proyecto-final/index.php"><strong>Tienda Online</strong></a></div>

    <nav id="nav" class="nav-links">
        <a href="/proyecto-final/index.php">Inicio</a>
        <a href="/proyecto-final/Buscador/search.php">Buscar</a>

        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                <!-- Admin dropdown -->
                <div class="dropdown">
                    <button class="dropbtn"><i class="fa fa-user-shield"></i> Admin</button>
                    <div class="dropdown-content">
                        <a href="/proyecto-final/producto/Producto-Formulario.php">Agregar Producto</a>
                        <a href="/proyecto-final/Dashboard/dashboard.php">Admin Dashboard</a>
                        <a href="/proyecto-final/Buscador/cart.php">Mi Carrito</a>
                        <a href="/proyecto-final/Login/logout.php">Cerrar Sesión</a>
                    </div>
                </div>
            <?php elseif ($_SESSION['user_role'] === 'user'): ?>
                <!-- Comprador dropdown -->
                <div class="dropdown">
                    <button class="dropbtn"><i class="fa fa-user"></i> Mi Cuenta</button>
                    <div class="dropdown-content">
                        <a href="/proyecto-final/user/pedidos.php">Mis Pedidos</a>
                        <a href="/proyecto-final/Buscador/cart.php">Mi Carrito</a>
                        <a href="/proyecto-final/user/perfil.php">Perfil</a>
                        <a href="/proyecto-final/Login/logout.php">Cerrar Sesión</a>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <a href="/proyecto-final/Login/login.php">Iniciar Sesión</a>
        <?php endif; ?>
    </nav>

    <button class="menu-toggle" id="menu-toggle">
        <i class="fa fa-bars"></i>
    </button>
</header>

<!-- Mini Carrito -->
<div id="mini-cart" class="mini-cart">
    <div class="mini-cart-header">
        <strong>Tu Carrito</strong>
        <button id="close-mini-cart" class="close-btn">&times;</button>
    </div>
    <div id="mini-cart-content">
        <p>Tu carrito está vacío.</p>
    </div>
    <a href="/proyecto-final/Buscador/cart.php" class="btn-cart">Ver Carrito</a>
</div>

<!-- Estilos -->
<style>
    * {
        box-sizing: border-box;
    }

    .site-header {
        background: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        position: sticky;
        top: 0;
        z-index: 1000;
        font-family: 'Raleway', sans-serif;
    }

    .logo a {
        font-size: 1.2rem;
        font-weight: bold;
        color: #000;
        text-decoration: none;
    }

    .nav-links {
        display: flex;
        gap: 16px;
        align-items: center;
    }

    .nav-links a {
        text-decoration: none;
        color: #333;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .nav-links a:hover {
        color: #007bff;
    }

    .menu-toggle {
        display: none;
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #333;
        cursor: pointer;
    }

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropbtn {
        background: none;
        border: none;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        color: #333;
        padding: 6px 10px;
    }

    .dropbtn i {
        margin-right: 6px;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: #ffffff;
        min-width: 180px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        z-index: 1001;
        border-radius: 6px;
        overflow: hidden;
    }

    .dropdown-content a {
        color: #333;
        padding: 10px 16px;
        text-decoration: none;
        display: block;
        font-weight: 500;
    }

    .dropdown-content a:hover {
        background-color: #f0f0f0;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    /* Mini Cart */
    .mini-cart {
        position: fixed;
        top: 0;
        right: -350px;
        width: 300px;
        height: 100%;
        background: #fff;
        border-left: 1px solid #ddd;
        box-shadow: -4px 0 10px rgba(0, 0, 0, 0.1);
        transition: right 0.3s ease;
        z-index: 999;
        padding: 20px;
        overflow-y: auto;
    }

    .mini-cart.show {
        right: 0;
    }

    .mini-cart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .close-btn {
        background: transparent;
        border: none;
        font-size: 24px;
        cursor: pointer;
    }

    .btn-cart {
        display: block;
        background-color: #007bff;
        color: white;
        padding: 10px;
        border-radius: 6px;
        text-align: center;
        text-decoration: none;
        font-weight: bold;
        margin-top: 20px;
    }

    .btn-cart:hover {
        background-color: #0056b3;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .nav-links {
            position: absolute;
            top: 60px;
            right: 0;
            background-color: white;
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
            padding: 20px;
            display: none;
            border-top: 1px solid #eee;
        }

        .nav-links a,
        .dropdown {
            width: 100%;
        }

        .nav-links.active {
            display: flex;
        }

        .menu-toggle {
            display: block;
        }

        .dropdown-content {
            position: static;
            box-shadow: none;
        }

        .dropdown:hover .dropdown-content {
            display: none;
        }

        .dropdown.active .dropdown-content {
            display: block;
        }
    }
</style>

<!-- JS -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const toggleBtn = document.getElementById("menu-toggle");
        const navLinks = document.getElementById("nav");
        const closeBtn = document.getElementById("close-mini-cart");

        toggleBtn?.addEventListener("click", () => {
            navLinks.classList.toggle("active");
        });

        closeBtn?.addEventListener("click", () => {
            document.getElementById("mini-cart").classList.remove("show");
        });

        // Para activar dropdown en móvil (opcional si no se quiere hover en mobile)
        document.querySelectorAll('.dropdown .dropbtn').forEach(button => {
            button.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    e.preventDefault();
                    const parent = this.parentElement;
                    parent.classList.toggle('active');
                }
            });
        });
    });
</script>