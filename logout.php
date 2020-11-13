<?php
// Cerrar session
session_start();

// Contener las sesiones en un array
$_SESSION = array();

// Destruir la session
session_destroy();

// Redireccionar
header("Location: login.php");
exit;
