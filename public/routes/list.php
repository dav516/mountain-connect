<?php
session_start();
include("../../config/config.php");
include("../../includes/header.php");
include("../../includes/functions.php");

$rutas = cargarRutas();
?>
<main id="contenido-principal">
<h2>Listado de rutas creadas</h2>

<?php if (empty($rutas)): ?>
    <p>No hay rutas creadas todavía.</p>
<?php else: ?>
    <?php foreach ($rutas as $ruta): ?>
        <div class="card-ruta">
            <h3><?php echo htmlspecialchars($ruta["nombre"]); ?></h3>
            <p><strong>Dificultad:</strong> <?php echo htmlspecialchars($ruta["dificultad"]); ?></p>
            <p><strong>Provincia:</strong> <?php echo htmlspecialchars($ruta["provincia"]); ?></p>
            <p><strong>Distancia:</strong> <?php echo htmlspecialchars($ruta["distancia"]); ?> km</p>
            <p><strong>Descripción:</strong> <?php echo htmlspecialchars($ruta["descripcion"]); ?></p>

            <?php if (!empty($ruta["fotos"])): ?>
                <div style="display:flex; gap:10px;">
                    <?php foreach ($ruta["fotos"] as $foto): ?>
                        <img src="<?php echo $foto; ?>" alt="Foto ruta" width="120">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <p><strong>Autor:</strong> <?php echo htmlspecialchars($ruta["creador"]); ?></p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<p><a href="/mountain-connect/public/routes/create.php">Añadir nueva ruta</a></p>
</main>
<?php
include("../../includes/footer.php");
?>
