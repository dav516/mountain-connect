<?php
session_start();
include("../../config/config.php");
include("../../includes/functions.php");
include("../../includes/header.php");

// Inicializamos variables
$errors = [];
$success = "";

// Cargar rutas guardadas en el archivo JSON
$rutas = cargarRutas();

// Procesamos el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $dificultad = $_POST["dificultad"];
    $distancia = trim($_POST["distancia"]);
    $desnivel = trim($_POST["desnivel"]);
    $duracion = trim($_POST["duracion"]);
    $provincia = $_POST["provincia"];
    $epocas = isset($_POST["epocas"]) ? $_POST["epocas"] : [];
    $descripcion = trim($_POST["descripcion"]);
    $nivel_tecnico = $_POST["nivel_tecnico"];
    $nivel_fisico = $_POST["nivel_fisico"];
    $fotos_subidas = [];

    // VALIDACIONES
    if (empty($nombre)) $errors[] = "El nombre de la ruta es obligatorio.";
    if (empty($dificultad)) $errors[] = "Selecciona una dificultad.";
    if (!is_numeric($distancia) || $distancia <= 0) $errors[] = "La distancia debe ser un número positivo.";
    if (empty($provincia)) $errors[] = "Selecciona una provincia.";

    // Validar y subir fotos
    if (!empty($_FILES["fotos"]["name"][0])) {
        $permitidos = ["image/jpeg", "image/png", "image/jpg"];
        foreach ($_FILES["fotos"]["tmp_name"] as $key => $tmp_name) {
            $tipo = $_FILES["fotos"]["type"][$key];
            $tamano = $_FILES["fotos"]["size"][$key];
            $nombre_archivo = basename($_FILES["fotos"]["name"][$key]);
            $ruta_destino = "../../uploads/photos/" . time() . "_" . $nombre_archivo;

            if (!in_array($tipo, $permitidos)) {
                $errors[] = "El archivo $nombre_archivo no es una imagen válida (jpg o png).";
            } elseif ($tamano > 2 * 1024 * 1024) {
                $errors[] = "El archivo $nombre_archivo supera el tamaño máximo (2MB).";
            } else {
                move_uploaded_file($tmp_name, $ruta_destino);
                $fotos_subidas[] = $ruta_destino;
            }
        }
    }

    // Si todo está bien, guardamos la ruta
    if (empty($errors)) {
        $nueva_ruta = [
            "nombre" => $nombre,
            "dificultad" => $dificultad,
            "distancia" => $distancia,
            "desnivel" => $desnivel,
            "duracion" => $duracion,
            "provincia" => $provincia,
            "epocas" => $epocas,
            "descripcion" => $descripcion,
            "nivel_tecnico" => $nivel_tecnico,
            "nivel_fisico" => $nivel_fisico,
            "fotos" => $fotos_subidas,
            "creador" => $_SESSION["usuario"]["username"] 
        ];

        // Añadimos la nueva ruta al listado y guardamos
        $rutas[] = $nueva_ruta;
        guardarRutas($rutas);

        $success = "✅ Ruta añadida correctamente.";
    }
}
?>

<main id="contenido-principal">
    <h2>Crear nueva ruta</h2>

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

    <form method="post" enctype="multipart/form-data" id="form-ruta">
        <label>Nombre de la ruta:</label><br>
        <input type="text" name="nombre"><br><br>

        <label>Dificultad:</label><br>
        <select name="dificultad">
            <option value="">-- Selecciona --</option>
            <option value="Fácil">Fácil</option>
            <option value="Moderada">Moderada</option>
            <option value="Difícil">Difícil</option>
            <option value="Muy difícil">Muy difícil</option>
        </select><br><br>

        <label>Distancia (km):</label><br>
        <input type="text" name="distancia"><br><br>

        <label>Desnivel positivo (m):</label><br>
        <input type="text" name="desnivel"><br><br>

        <label>Duración estimada (horas):</label><br>
        <input type="text" name="duracion"><br><br>

        <label>Provincia:</label><br>
        <select name="provincia">
            <option value="">-- Selecciona --</option>
            <option value="Madrid">Madrid</option>
            <option value="Barcelona">Barcelona</option>
            <option value="Valencia">Valencia</option>
            <option value="Granada">Granada</option>
        </select><br><br>

        <label>Época recomendada:</label><br>
        <input type="checkbox" name="epocas[]" value="primavera"> Primavera
        <input type="checkbox" name="epocas[]" value="verano"> Verano
        <input type="checkbox" name="epocas[]" value="otoño"> Otoño
        <input type="checkbox" name="epocas[]" value="invierno"> Invierno
        <br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion" rows="4" cols="50"></textarea><br><br>

        <label>Nivel técnico (1-5):</label>
        <input type="number" name="nivel_tecnico" min="1" max="5"><br><br>

        <label>Nivel físico (1-5):</label>
        <input type="number" name="nivel_fisico" min="1" max="5"><br><br>

        <label>Fotos (jpg, png, máx 2MB):</label><br>
        <input type="file" name="fotos[]" multiple><br><br>

        <input type="submit" value="Guardar ruta">
    </form>

    <p><a href="list.php">Ver listado de rutas</a></p>
</main>

<?php include("../../includes/footer.php"); ?>
