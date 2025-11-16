<?php
include("../includes/auth_check.php");
include("../config/config.php");
include("../includes/functions.php");
include("../includes/header.php");

$usuario = $_SESSION["usuario"];
?>

<main id="contenido-principal">
    <?php
    $foto = $usuario["foto"] ?? "";
    $foto_perfil = !empty($foto) ? $foto : "/mountain-connect/assets/img/avatar.png";
    ?>
    <img src="<?= $foto_perfil ?>" id="foto-perfil">
    <h2>Perfil de <?php echo htmlspecialchars($usuario["username"]); ?></h2>
    <p>Bienvenido a tu perfil, <?php echo htmlspecialchars($usuario["username"]); ?> 👋</p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($usuario["email"]); ?></p>
    <br><br>
    <p><a href="edit_profile.php">Editar perfil</a></p>
    <p><a href="/mountain-connect/public/routes/my_routes.php">Ver mis actividades</a></p>
    <br>
    <p id="profile" class="profile-logout">
        <a href="/mountain-connect/public/logout.php">Cerrar sesión</a>
    </p>
</main>

<?php include("../includes/footer.php"); ?>

