<?php
require_once "../config/db.php";

//Recibir el id del comunicado
if (isset($_GET["id"])) {
    $idComunicado = $_GET["id"];
    // Query
    $sql = "DELETE FROM comunicado WHERE idComunicado = '$idComunicado'";
    // Ejecutar la consulta
    $resultado = mysqli_query($conexion, $sql);
    if ($resultado === true) {
        // Redireccionar
        header("Location: /comunicado/listarComunicados.php?e=1");
    }
}
