<?php
include("../../includes/auth_check.php");
include("../../config/config.php");
include("../../includes/functions.php");
include("../../includes/header.php");

$rutas = cargarRutas();
$usuario = $_SESSION["usuario"];
$mis_rutas = [];

foreach ($rutas as $r) {
    if ($r["creador"] === $usuario["username"]) {
        $mis_rutas[] = $r;
    }
}
?>
<main id="contenido-principal">
    <h2>Mis actividades creadas</h2>

    <?php if (empty($mis_rutas)): ?>
        <p>No has creado ninguna actividad todavía.</p>
    <?php else: ?>
        <?php foreach ($mis_rutas as $ruta): ?>
            <div class="card-ruta">
                <h3><?= htmlspecialchars($ruta["nombre"]) ?></h3>
                <p><strong>Dificultad:</strong> <?php echo htmlspecialchars($ruta["dificultad"]); ?></p>
                <p><strong>Provincia:</strong> <?php echo htmlspecialchars($ruta["provincia"]); ?></p>
                <p><strong>Distancia:</strong> <?php echo htmlspecialchars($ruta["distancia"]); ?> km</p>
                <p><strong>Descripción:</strong> <?php echo htmlspecialchars($ruta["descripcion"]); ?></p>
                <p><strong>Autor:</strong> <?php echo htmlspecialchars($ruta["creador"]); ?></p>
                
                <?php if (!empty($ruta["fotos"])): ?>
                    <div style="display:flex; gap:10px;">
                        <?php foreach ($ruta["fotos"] as $foto): ?>
                            <img src="<?php echo $foto; ?>" alt="Foto ruta" width="120">
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</main>

<?php include("../../includes/footer.php"); ?>
