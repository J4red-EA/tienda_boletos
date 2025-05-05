<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Boletos</title>
    <link rel="stylesheet" href="/tienda_boletos/assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="main-header">
        <div class="container">
            <h1 class="logo">🎬 Tienda de Boletos</h1>
            <nav class="nav">
                <ul>
                    <li><a href="/tienda_boletos/index.php">Inicio</a></li>
                    <li><a href="/tienda_boletos/quienes-somos.php">Quiénes Somos</a></li>
                    <li><a href="/tienda_boletos/catalogo.php">Catálogo</a></li>
                    <li><a href="/tienda_boletos/contacto.php">Contacto</a></li>

                    <?php if (isset($_SESSION['usuario'])): ?>
                        <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                            <li><a href="admin/productos.php">Administrador</a></li>
                        <?php else: ?>
                            <li><a href="/tienda_boletos/usuario/perfil.php">Mi Perfil</a></li>
                        <?php endif; ?>
                        <li><a href="/tienda_boletos/logout.php">Cerrar sesión</a></li>
                    <?php else: ?>
                        <li><a href="/tienda_boletos/registro.php">Registro</a></li>
                        <li><a href="/tienda_boletos/login.php">Iniciar sesión</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main>
