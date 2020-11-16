<?php
session_start();
// Verifica rque isuario este logueado
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../login.php");
    exit;
}
// Incorporar la base de datos
require_once "../config/db.php";
// Listar las noticias


// Virificar que el id en la Url
if (isset($_GET["id"])) {
    $idUrl = $_GET["id"];
    
}
// Declarar variables
$error = "";

// Verificar que haga el metodo post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($error)) {
        $sql = "DELETE FROM detallenoticia WHERE noticia_idNoticia = '$idUrl'";
        mysqli_query($conexion, $sql);
        if (isset($_FILES['imagen'])) {
            $cantidad = count($_FILES["imagen"]["tmp_name"]);
            for ($i=0; $i < $cantidad; $i++) {
                if ($_FILES['imagen']['type'][$i]=='image/png' || $_FILES['imagen']['type'][$i]=='image/jpeg') {
            
                    //Subimos el fichero al servidor
                    $imagen = addslashes(file_get_contents($_FILES["imagen"]["tmp_name"][$i], $_FILES["imagen"]["name"][$i]));

                    $query = "INSERT INTO `detallenoticia`(`imagen`, `noticia_idNoticia`) 
                                                    VALUES ('$imagen', '$idUrl')";
                    // Realizar la consulta a la base de datos
                    $resultado = mysqli_query($conexion, $query);
                    if ($resultado === true) {
                        $_SESSION['status'] = "Las imagenes han sido actualizadas";
                        $_SESSION['status_icon'] = "success";
                        header("Location: /noticia/listarNoticia.php");
                    } else {
                        $error = "Imagenes no almacenadas";
                    }

                } else {
                    $error =  "Solo formato png y jpeg";
                }
            }
        } else {
            $error ="No hay imagen ingresada";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../logo.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/all.min.css">
    <title>Editar Imagenes - Municipalidad de Siguatepeque</title>
</head>
<body>

    <div class="alertas">
        <?php  //echo "<p>$error</p>" ;?>
    </div>
    <div id="primero" class="single-tab" >
        <div class="center form-imagen">
            <h2>Editar Imagenes</h2>
            <form action="" method="post" class="accion" enctype="multipart/form-data"> 
                <div class="txt_field">
                    <input type="file" name="imagen[]" id="" required multiple>  
                    <span></span>
                </div>
                <input type="submit" value="Subir Imagenes">
            </form>
        </div>    

            
          
     
    </div>
    
</body>
</html>
<script src="../js/app.js"></script>
<script src="/js/all.min.js"></script>