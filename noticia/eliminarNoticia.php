<?php
require_once "../config/db.php";

//Recibir el id del comunicado
if (isset($_GET["id"])) {
    $idNoticia = $_GET["id"];
    // Eliminar las imagenes de la noticia 
    $sqlDetalleNoticia = "DELETE FROM detallenoticia WHERE noticia_idNoticia = '$idNoticia'";
    // Ejecutar la consulta
    $resultadoDetalleNoticia = mysqli_query($conexion, $sqlDetalleNoticia);
    // Eliminar la noticia
    $sql = "DELETE FROM noticia WHERE idNoticia= '$idNoticia'";
    // Ejecutar la consulta
    $resultado = mysqli_query($conexion, $sql);
    
    if ($resultado === true) {
        // Redireccionar
        header("Location: /noticia/listarNoticia.php?e=1");
    }
}
