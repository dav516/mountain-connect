<?php
// ======================================================
// FUNCIONES AUXILIARES DEL PROYECTO MOUNTAINCONNECT
// ======================================================

// 1️⃣ Sanitizar texto
function limpiarEntrada($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// 2️⃣ Validar email
function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// 3️⃣ Generar nombre único para archivos subidos
function generarNombreArchivo($nombre_original) {
    $extension = pathinfo($nombre_original, PATHINFO_EXTENSION);
    $nombre_unico = uniqid("img_", true) . "." . strtolower($extension);
    return $nombre_unico;
}

// 4️⃣ Formatear fechas (opcional)
function formatearFecha($fecha) {
    return date("d/m/Y H:i", strtotime($fecha));
}

// 5️⃣ Convertir dificultad numérica en texto
function dificultadTexto($nivel) {
    $niveles = [
        1 => "Muy fácil",
        2 => "Fácil",
        3 => "Moderada",
        4 => "Difícil",
        5 => "Muy difícil"
    ];
    return $niveles[$nivel] ?? "Desconocido";
}

// 6️⃣ Verificar si hay sesión activa
function usuarioLogueado() {
    return isset($_SESSION["usuario"]);
}

// ============================================
// GUARDAR Y LEER RUTAS DESDE ARCHIVO JSON
// ============================================

function guardarRutas($rutas) {
    $ruta_archivo = __DIR__ . "/../data/rutas.json";
    file_put_contents($ruta_archivo, json_encode($rutas, JSON_PRETTY_PRINT));
}

function cargarRutas() {
    $ruta_archivo = __DIR__ . "/../data/rutas.json";
    if (file_exists($ruta_archivo)) {
        $contenido = file_get_contents($ruta_archivo);
        return json_decode($contenido, true) ?? [];
    }
    return [];
}

// =============================================
// FUNCIONES DE USUARIOS (REGISTRO / LOGIN)
// =============================================

function guardarUsuarios($usuarios) {
    $ruta_archivo = __DIR__ . "/../data/usuarios.json";
    file_put_contents($ruta_archivo, json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function cargarUsuarios() {
    $ruta_archivo = __DIR__ . "/../data/usuarios.json";
    if (file_exists($ruta_archivo)) {
        $contenido = file_get_contents($ruta_archivo);
        return json_decode($contenido, true) ?? [];
    }
    return [];
}

?>
