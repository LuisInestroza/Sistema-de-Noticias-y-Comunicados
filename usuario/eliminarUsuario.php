<?php
require_once "../config/db.php";

//Recibir el id del comunicado
if (isset($_GET["id"])) {
    $idUsuario = $_GET["id"];
    // Query
    $sql = "DELETE FROM usuario WHERE idUsuario = '$idUsuario'";
    // Ejecutar la consulta
    $resultado = mysqli_query($conexion, $sql);
    if ($resultado === true) {
        // Redireccionar
        header("Location: /usuario/listarUsuario.php?e=1");
    }
}
