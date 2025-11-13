<?php
include("../includes/auth_check.php");
include("../config/config.php");
include("../includes/functions.php");
include("../includes/header.php");

$usuario = $_SESSION["usuario"];
?>

<main id="contenido-principal">
    <h2>Perfil de <?php echo htmlspecialchars($usuario["username"]); ?></h2>
    <p>Bienvenido a tu perfil, <?php echo htmlspecialchars($usuario["username"]); ?> 👋</p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($usuario["email"]); ?></p>
    <br><br><br>

    <p id="profile" class="profile-logout">
        <a href="/mountain-connect/public/logout.php">Cerrar sesión</a>
    </p>
</main>

<?php include("../includes/footer.php"); ?>

