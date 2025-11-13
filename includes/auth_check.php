<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: /mountain-connect/public/login.php");
    exit();
}
?>
