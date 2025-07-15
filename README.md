# E-Commerce PHP/MySQL

Este proyecto es un sistema de comercio electrónico básico desarrollado con PHP, MySQL, HTML, CSS y JavaScript. Está pensado como una plataforma funcional para la compra y gestión de productos en línea, con funciones tanto para el usuario como para el administrador.

## 🛠️ Tecnologías utilizadas

- PHP (lógica de backend)
- MySQL (base de datos)
- HTML/CSS (estructura y diseño)
- JavaScript (interactividad)
- Bootstrap (para estilos rápidos y responsivos)

## ⚙️ Funcionalidades

### 👤 Usuario
- Registro e inicio de sesión
- Visualización de productos
- Búsqueda de productos
- Agregar productos al carrito
- Eliminar productos del carrito
- Generar pedidos
- Visualizar historial de pedidos desde el dashboard

### 🛒 Carrito
- Vista previa de productos seleccionados
- Total dinámico
- Eliminación de ítems
- Botón para finalizar compra

### 📦 Administración
- Gestión básica de productos (desde base de datos)
- Seguimiento de pedidos (estados)
- Dashboard visual

## 📁 Estructura del proyecto
/E-Commerce-main <br>
│ <br> 
├──index.php # Página principal <br>
├──login.php # Inicio de sesión <br>
├──register.php # Registro de usuario <br>
├──productos.php # Catálogo de productos <br>
├──carrito.php # Carrito de compras <br>
├──checkout.php # Finalización de compra <br>
├──dashboard_user.php # Panel de usuario <br>
│ <br>
├──/admin # Panel de administrador (opcional) <br>
├──/css # Estilos <br>
├──/js # Scripts JS <br>
├──/uploads # Imágenes de productos <br>
├──/db # Conexión y estructura base de datos <br>
└──/includes # Archivos comunes como encabezados, sesiones, etc. <br>




## 🧪 Cómo ejecutar el proyecto localmente

1. Clona este repositorio o descomprime los archivos en tu servidor local (XAMPP, WAMP o similar).
2. Crea una base de datos en MySQL y ejecuta el script `db.sql` (si está incluido).
3. Configura el archivo de conexión en `/conexion.php` con tus credenciales de MySQL.
4. Abre tu navegador y accede a `http://localhost/PROYECTO-FINAL`.

## ✅ Pendientes / Mejoras futuras

- Autenticación con tokens
- Panel de administración completo
- Pasarela de pagos (PayPal, Stripe)
- Filtros avanzados por categoría, precio, etc.
- Protección CSRF y validaciones más robustas

## 📄 Licencia

Este proyecto es de uso educativo y puede ser adaptado libremente.
