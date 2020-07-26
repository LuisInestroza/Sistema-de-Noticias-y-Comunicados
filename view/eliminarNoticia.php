<?php
require_once "../config/db.php";

//Recibir el id del comunicado
if (isset($_GET["id"])) {
    $idNoticia = $_GET["id"];
    $sql = "DELETE FROM noticia WHERE idNoticia= '$idNoticia'";
    $resultado = mysqli_query($conexion, $sql);
    if ($resultado === true) {
        header("Location: /view/listarNoticia.php");
    }
}
