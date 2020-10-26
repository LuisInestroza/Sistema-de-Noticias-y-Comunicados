<?php
require_once "../config/db.php";

//Recibir el id del comunicado
if (isset($_GET["id"])) {
    $idNoticia = $_GET["id"];
    $sql2 = "DELETE FROM detallenoticia WHERE noticia_idNoticia = '$idNoticia'";
    $resultado2 = mysqli_query($conexion, $sql2);
    $sql = "DELETE FROM noticia WHERE idNoticia= '$idNoticia'";
    $resultado = mysqli_query($conexion, $sql);
    
    if ($resultado === true) {
        header("Location: /view/listarNoticia.php?e=1");
    }
}
