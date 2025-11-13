<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MountainConnect</title>
    <link rel="stylesheet" href="/mountain-connect/assets/css/style.css">
</head>
<body>
    <header id="main-header">
        <h1>🏔️ MountainConnect</h1>
        <nav>
            <a href="/mountain-connect/public/index.php">Inicio</a> |

            <?php if (isset($_SESSION["usuario"])): ?>
                <!-- Si el usuario está logueado -->
                <a href="/mountain-connect/public/profile.php">Perfil</a> |
                <a href="/mountain-connect/public/routes/create.php">Nueva ruta</a> |
                <a href="/mountain-connect/public/routes/list.php">Ver rutas</a> |
                <a href="/mountain-connect/public/logout.php">Cerrar sesión</a>
                <span id="nombre-header">👤 Hola, <?php echo htmlspecialchars($_SESSION["usuario"]["username"]); ?>!</span>
            <?php else: ?>
                <!-- Si NO está logueado -->
                <a href="/mountain-connect/public/register.php">Registrate</a> |
                <a href="/mountain-connect/public/login.php">Inicia Sesión</a> 
            <?php endif; ?>
        </nav>
    </header>
