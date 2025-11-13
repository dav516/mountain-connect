<?php
session_start();
session_unset();
session_destroy();
header("Location: /mountain-connect/public/login.php");
exit();
