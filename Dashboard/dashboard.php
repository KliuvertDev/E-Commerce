<?php
session_start();
include '../conexion.php';
include __DIR__ . '/../user/header.php';

$productos = $conn->query("SELECT * FROM products");
$usuarios = $conn->query("SELECT * FROM users");
$pedidos = $conn->query("SELECT o.id, u.name AS username, o.total, o.status, o.created_at 
                         FROM orders o 
                         LEFT JOIN users u ON o.user_id = u.id 
                         ORDER BY o.created_at DESC");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Raleway', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            display: flex;
        }

        .sidebar {
            width: 240px;
            background-color: #1e1e2f;
            color: #fff;
            height: 100vh;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
        }

        .sidebar h2 {
            font-size: 1.4em;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: #bbb;
            padding: 10px;
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 8px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #3a3a56;
            color: #fff;
        }

        .main {
            margin-left: 260px;
            padding: 40px;
            width: 100%;
        }

        .section-title {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        th,
        td {
            padding: 14px 18px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f1f1f1;
            font-weight: 600;
        }

        tr:hover {
            background-color: #f9fbff;
        }

        .actions a {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 14px;
            text-decoration: none;
            margin-right: 8px;
        }

        .Button-edit {
            background-color: #51b1ff;
            color: white;
        }

        .Button-edit:hover {
            background-color: #399bea;
        }

        .Button-delete {
            background-color: #ff6b6b;
            color: white;
        }

        .Button-delete:hover {
            background-color: #e74c3c;
        }

        .section-icon {
            margin-right: 8px;
            color: #555;
        }
    </style>
</head>

<body>

    <div class="dashboard-container">
        <div class="sidebar">
            <h2><i class="fas fa-chart-line"></i> Admin</h2>
            <a href="#" class="active" data-section="productos"><i class="fas fa-box"></i> Productos</a>
            <a href="#" data-section="usuarios"><i class="fas fa-users"></i> Usuarios</a>
            <a href="#" data-section="pedidos"><i class="fas fa-receipt"></i> Pedidos</a>
            <a href="../index.php"><i class="fas fa-home"></i> Inicio</a>

        </div>

        <div class="main">
            <div id="productos">
                <h2 class="section-title"><i class="fas fa-box section-icon"></i>Productos</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($p = $productos->fetch_assoc()): ?>
                            <tr>
                                <td><?= $p['id'] ?></td>
                                <td><?= htmlspecialchars($p['name']) ?></td>
                                <td>$<?= $p['price'] ?></td>
                                <td><?= $p['stock'] ?></td>
                                <td class="actions">
                                    <a class="Button-edit" href="javascript:void(0);" onclick="openEditModal(<?= $p['id'] ?>)">Editar</a>
                                    <a class="Button-delete" href="delete_product.php?id=<?= $p['id'] ?>" onclick="return confirm('¿Eliminar producto?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div id="usuarios" style="display: none;">
                <h2 class="section-title"><i class="fas fa-users section-icon"></i>Usuarios</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($u = $usuarios->fetch_assoc()): ?>
                            <tr>
                                <td><?= $u['id'] ?></td>
                                <td><?= htmlspecialchars($u['name']) ?></td>
                                <td><?= htmlspecialchars($u['email']) ?></td>
                                <td><?= htmlspecialchars($u['role']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div id="pedidos" style="display: none;">
                <h2 class="section-title"><i class="fas fa-receipt section-icon"></i>Pedidos</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($o = $pedidos->fetch_assoc()): ?>
                            <tr>
                                <td><?= $o['id'] ?></td>
                                <td><?= htmlspecialchars($o['username']) ?></td>
                                <td>$<?= $o['total'] ?></td>
                                <td><?= htmlspecialchars($o['status']) ?></td>
                                <td><?= $o['created_at'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <script>
            const sidebarLinks = document.querySelectorAll('.sidebar a[data-section]');
            const sections = document.querySelectorAll('.main > div');

            sidebarLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remueve clase 'active' de todos los botones
                    sidebarLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');

                    // Oculta todas las secciones
                    sections.forEach(section => section.style.display = 'none');

                    // Muestra la sección correspondiente
                    const target = document.getElementById(this.dataset.section);
                    if (target) target.style.display = 'block';
                });
            });

            // Muestra la sección Productos por defecto
            document.querySelector('#productos').style.display = 'block';
        </script>

        <iframe id="editModalFrame" style="display:none; position:fixed; top:0; left:0; width:100%; height:100vh; border:none; z-index:9999; background: rgba(0, 0, 0, 0.6);"></iframe>
        <script>
            function openEditModal(productId) {
                const modal = document.getElementById('editModalFrame');
                modal.src = `edit_product.php?id=${productId}`;
                modal.style.display = 'block';
            }

            window.addEventListener('message', (e) => {
                if (e.data === 'closeEditModal') {
                    document.getElementById('editModalFrame').style.display = 'none';
                    window.location.reload(); // Opcional: recarga dashboard al cerrar
                }
            });
        </script>
    </div>
</body>

</html>