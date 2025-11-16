<?php
include("../includes/auth_check.php");
include("../config/config.php");
include("../includes/functions.php");
include("../includes/header.php");

$usuarios = cargarUsuarios();
$usuario = $_SESSION["usuario"];
$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevo_username = trim($_POST["username"]);
    $nuevo_email = trim($_POST["email"]);
    $password_actual = $_POST["password_actual"];
    $password_nueva = $_POST["password_nueva"];

    // Validaciones básicas
    if (empty($nuevo_username)) $errors[] = "El nombre de usuario no puede estar vacío.";
    if (!filter_var($nuevo_email, FILTER_VALIDATE_EMAIL)) $errors[] = "El email no es válido.";

    // Contraseña actual obligatoria para editar
    if (!password_verify($password_actual, $usuario["password"])) {
        $errors[] = "La contraseña actual es incorrecta.";
    }

    // --- PROCESAR FOTO DE PERFIL ---
    $nueva_foto = $usuario["foto"] ?? ""; // por defecto mantiene la foto anterior

    if (isset($_FILES["foto"]) && !empty($_FILES["foto"]["name"])) {

        $permitidos = ["image/jpeg", "image/png", "image/jpg", "image/webp"];
        $tipo = $_FILES["foto"]["type"];
        $tamano = $_FILES["foto"]["size"];
        $nombre_archivo = basename($_FILES["foto"]["name"]);

        if (!in_array($tipo, $permitidos)) {
            $errors[] = "La foto debe ser JPG o PNG.";
        } elseif ($tamano > 3 * 1024 * 1024) {
            $errors[] = "La foto excede los 3MB.";
        } else {

            $nombre_unico = time() . "_" . $nombre_archivo;
            $ruta_destino = "../uploads/profile/" . $nombre_unico;

            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $ruta_destino)) {
                $nueva_foto = $ruta_destino;
            } else {
                $errors[] = "No se pudo subir la nueva foto de perfil.";
            }
        }
    }

    // --- SI NO HAY ERRORES, ACTUALIZAR ---
    if (empty($errors)) {
        foreach ($usuarios as &$u) {
            if ($u["username"] === $usuario["username"]) {
                $u["username"] = $nuevo_username;
                $u["email"] = $nuevo_email;
                $u["foto"] = $nueva_foto;

                if (!empty($password_nueva)) {
                    $u["password"] = password_hash($password_nueva, PASSWORD_DEFAULT);
                }

                // Actualizar sesión
                $_SESSION["usuario"] = $u;
            }
        }

        guardarUsuarios($usuarios);
        $success = "Perfil actualizado correctamente ✔️";
    }
}
?>
<main id="contenido-principal">
    <h2>Editar perfil</h2>

    <?php if (!empty($errors)): ?>
        <div style="color:red;">
            <ul>
                <?php foreach ($errors as $e): ?><li><?= $e ?></li><?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div style="color:green;"><?= $success ?></div>
    <?php endif; ?>

     <!-- Mostrar foto actual -->
    <?php 
        $foto = $usuario["foto"] ?? "";
        $foto_mostrar = !empty($foto) ? $foto : "/mountain-connect/assets/img/avatar.png";
    ?>
    <img src="<?= $foto_mostrar ?>" id="foto-perfil">

    <form method="post" enctype="multipart/form-data">
        <label>Cambiar foto de perfil:</label><br>
        <input type="file" name="foto"><br><br>

        <label>Nuevo nombre de usuario:</label><br>
        <input type="text" name="username" value="<?= $usuario['username'] ?>"><br><br>

        <label>Nuevo email:</label><br>
        <input type="email" name="email" value="<?= $usuario['email'] ?>"><br><br>

        <label>Contraseña actual (obligatoria):</label><br>
        <input type="password" name="password_actual"><br><br>

        <label>Nueva contraseña (opcional):</label><br>
        <input type="password" name="password_nueva"><br><br>

        <input type="submit" value="Guardar cambios">
    </form>
</main>
