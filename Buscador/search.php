<?php
session_start();
include '../conexion.php';
include __DIR__ . '/../user/header.php';

// Obtener categorías
$cat_result = $conn->query("SELECT id, name FROM categories");

// Obtener filtros
$search     = $_GET["q"] ?? "";
$category   = $_GET["category"] ?? "";
$min_price  = $_GET["min_price"] ?? "";
$max_price  = $_GET["max_price"] ?? "";
$page       = max(1, (int)($_GET['page'] ?? 1));
$limit      = 12;
$offset     = ($page - 1) * $limit;

// Construir la consulta SQL con filtros dinámicos
$base_query = "FROM products p 
LEFT JOIN product_category pc ON p.id = pc.product_id 
WHERE 1";

$params = [];
$types = "";

if (!empty($search)) {
    $base_query .= " AND p.name LIKE ?";
    $params[] = "%$search%";
    $types .= "s";
}

if (!empty($category)) {
    $base_query .= " AND pc.category_id = ?";
    $params[] = $category;
    $types .= "i";
}

if ($min_price !== "") {
    $base_query .= " AND p.price >= ?";
    $params[] = $min_price;
    $types .= "d";
}

if ($max_price !== "") {
    $base_query .= " AND p.price <= ?";
    $params[] = $max_price;
    $types .= "d";
}

// Obtener total de productos
$count_stmt = $conn->prepare("SELECT COUNT(DISTINCT p.id) $base_query");
if ($params) {
    $count_stmt->bind_param($types, ...$params);
}
$count_stmt->execute();
$count_stmt->bind_result($total_rows);
$count_stmt->fetch();
$count_stmt->close();
$total_pages = ceil($total_rows / $limit);

// Obtener resultados paginados
$query = "SELECT DISTINCT p.* $base_query ORDER BY p.name ASC LIMIT $limit OFFSET $offset";
$stmt = $conn->prepare($query);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Productos</title>
    <link rel="stylesheet" href="styles.css" />
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

    <div class="container">
        <div class="sidebar">
            <h3>Filtrar búsqueda</h3>
            <form method="GET" id="filterForm">
                <input type="text" name="q" placeholder="Buscar producto..." value="<?= htmlspecialchars($search) ?>">

                <select name="category">
                    <option value="">Todas las categorías</option>
                    <?php $cat_result->data_seek(0);
                    while ($cat = $cat_result->fetch_assoc()): ?>
                        <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $category ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <input type="number" step="0.01" name="min_price" placeholder="Precio mínimo" value="<?= htmlspecialchars($min_price) ?>">
                <input type="number" step="0.01" name="max_price" placeholder="Precio máximo" value="<?= htmlspecialchars($max_price) ?>">
            </form>
        </div>

        <div class="main-content">
            <h2 style="margin-bottom: 20px;">Resultados de búsqueda</h2>
            <div class="product-grid">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="card">
                            <img src="/PROYECTO-FINAL/<?= htmlspecialchars($row["image"]) ?>" alt="<?= htmlspecialchars($row["name"]) ?>">
                            <h3><?= htmlspecialchars($row["name"]) ?></h3>
                            <p>$<?= number_format($row["price"], 2) ?></p>
                            <a href="product_detail.php?id=<?= $row["id"] ?>">Ver detalles</a>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No se encontraron productos.</p>
                <?php endif; ?>
            </div>

            <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" class="<?= $i == $page ? 'active' : '' ?>"> <?= $i ?> </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        const filterForm = document.getElementById('filterForm');
        filterForm.querySelectorAll('input, select').forEach(element => {
            element.addEventListener('change', () => {
                filterForm.submit();
            });
        });
    </script>

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