<?php
session_start();
include("../config/config.php");
include("../includes/functions.php");
include("../includes/header.php");

$errors = [];
$success = "";

// Cargar usuarios existentes
$usuarios = cargarUsuarios();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // VALIDACIONES
    if (empty($username)) $errors[] = "El nombre de usuario es obligatorio.";
    if (empty($email)) $errors[] = "El email es obligatorio.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "El email no es válido.";
    if (empty($password)) $errors[] = "La contraseña es obligatoria.";
    if ($password !== $confirm_password) $errors[] = "Las contraseñas no coinciden.";

    // Comprobar si el usuario o email ya existen
    foreach ($usuarios as $u) {
        if ($u["username"] === $username) $errors[] = "El nombre de usuario ya está en uso.";
        if ($u["email"] === $email) $errors[] = "El email ya está registrado.";
    }

    // --- SUBIR FOTO DE PERFIL (opcional) ---
    $foto_perfil = "";

    if (!empty($_FILES["foto"]["name"])) {

        $permitidos = ["image/jpeg", "image/png", "image/jpg"];
        $tipo = $_FILES["foto"]["type"];
        $tamano = $_FILES["foto"]["size"];
        $nombre_archivo = basename($_FILES["foto"]["name"]);

        if (!in_array($tipo, $permitidos)) {
            $errors[] = "La foto debe ser JPG o PNG.";
        } elseif ($tamano > 3 * 1024 * 1024) {
            $errors[] = "La foto no puede superar los 3MB.";
        } else {
            $nombre_unico = time() . "_" . $nombre_archivo;
            $ruta_destino = "../uploads/profile/" . $nombre_unico;

            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $ruta_destino)) {
                $foto_perfil = $ruta_destino;
            } else {
                $errors[] = "Error al subir la foto de perfil.";
            }
        }
    }

    // Si todo está correcto, guardamos
    if (empty($errors)) {
        $nuevo_usuario = [
            "username" => $username,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_DEFAULT),
            "foto" => $foto_perfil
        ];

        $usuarios[] = $nuevo_usuario;
        guardarUsuarios($usuarios);

        $success = "✅ Usuario registrado correctamente. Ahora puedes iniciar sesión.";
    }
}
?>
<main id="contenido-principal">
<h2>Registro de usuario</h2>

<?php if (!empty($errors)): ?>
    <div style="color:red;">
        <ul>
            <?php foreach ($errors as $e): ?>
                <li><?php echo $e; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div style="color:green;"><?php echo $success; ?></div>
<?php endif; ?>

<form method="post" id="form-registro">
    <label>Foto de perfil (opcional):</label><br>
    <input type="file" name="foto"><br><br>

    <label>Nombre de usuario:</label><br>
    <input type="text" name="username" value="<?php echo $_POST['username'] ?? ''; ?>"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo $_POST['email'] ?? ''; ?>"><br><br>

    <label>Contraseña:</label><br>
    <input type="password" name="password"><br><br>

    <label>Confirmar contraseña:</label><br>
    <input type="password" name="confirm_password"><br><br>

    <input type="submit" value="Registrar usuario">
</form>

<p><a href="login.php">Ya tienes cuenta? Inicia sesión aquí</a></p>
</main>

<?php include("../includes/footer.php"); ?>
