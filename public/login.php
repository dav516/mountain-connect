<?php
session_start();
include("../config/config.php");
include("../includes/functions.php");
include("../includes/header.php");

$usuarios = cargarUsuarios(); // ← ahora cargamos desde el JSON
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = limpiarEntrada($_POST["login"]);
    $password = $_POST["password"];

    $usuario_encontrado = null;
    foreach ($usuarios as $u) {
    // Comprobar usuario o email
    if ($u["username"] === $login || $u["email"] === $login) {
        
        // Comprobar contraseña cifrada
        if (password_verify($password, $u["password"])) {
            $usuario_encontrado = $u;
            break;
        }
    }
}

    if ($usuario_encontrado) {
        $_SESSION["usuario"] = $usuario_encontrado;
        header("Location: /mountain-connect/public/profile.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<main id="contenido-principal">
<h2>Iniciar sesión</h2>

<?php if ($error): ?><div style="color:red;"><?php echo $error; ?></div><?php endif; ?>

<form method="post" action="" id="form-login">
    <label>Usuario o Email:</label><br>
    <input type="text" name="login" value="<?php echo $_POST['login'] ?? ''; ?>"><br><br>

    <label>Contraseña:</label><br>
    <input type="password" name="password"><br><br>

    <input type="submit" value="Entrar">
</form>

<p><a href="register.php">¿No tienes cuenta? Regístrate aquí</a></p>
</main>

<?php include("../includes/footer.php"); ?>
