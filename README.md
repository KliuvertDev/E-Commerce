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
/PROYECTO-FINAL
│
├── index.php # Página principal
├── login.php # Inicio de sesión
├── register.php # Registro de usuario
├── productos.php # Catálogo de productos
├── carrito.php # Carrito de compras
├── checkout.php # Finalización de compra
├── dashboard_user.php # Panel de usuario
│
├── /admin # Panel de administrador (opcional)
├── /css # Estilos
├── /js # Scripts JS
├── /uploads # Imágenes de productos
├── /db # Conexión y estructura base de datos
└── /includes # Archivos comunes como encabezados, sesiones, etc.




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
