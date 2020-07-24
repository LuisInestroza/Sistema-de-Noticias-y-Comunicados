<?php
// Cerrar session
session_start();

$_SESSION = array();

// Destruir la session
session_destroy();

// Redireccionar
header("Location: login.php");
exit;
