<?php
session_start();
include("../config/config.php");
include("../includes/functions.php");
include("../includes/header.php");
?>
<main id="contenido-principal">
    <h2>Bienvenido a <?php echo $project_name; ?></h2>

    <?php if (isset($_SESSION["usuario"])): ?>
        <p>Hola, <strong><?php echo htmlspecialchars($_SESSION["usuario"]["username"]); ?></strong> 👋</p>
        <p>Enhorabuena ahora puedes ver las <a href="/mountain-connect/public/routes/list.php">rutas</a> de los compañeros <br>También puedes <a href="/mountain-connect/public/routes/create.php">crear</a> las tuyas propias</p>
        <br>
        <p>Puedes ir a tu <a href="/mountain-connect/public/profile.php">perfil</a> o <a href="/mountain-connect/public/logout.php">cerrar sesión</a>.</p>
    <?php else: ?>
        <p>Bienvenido visitante 👋</p>
        <p>Si aún no tienes cuenta, <a href="/mountain-connect/public/register.php">regístrate aquí</a>.</p>
        <p>O si ya tienes cuenta, <a href="/mountain-connect/public/login.php">inicia sesión</a>.</p>
    <?php endif; ?>
</main>
<?php include("../includes/footer.php"); ?>
