<?php
require_once "../config/db.php";

//Recibir el id del comunicado
if (isset($_GET["id"])) {
    $idComunicado = $_GET["id"];
    $sql = "DELETE FROM comunicado WHERE idComunicado = '$idComunicado'";
    $resultado = mysqli_query($conexion, $sql);
    if ($resultado === true) {
        header("Location: /view/listarComunicados.php?e=1");
    }
}
