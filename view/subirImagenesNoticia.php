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
$listarNoticiaReciente = "SELECT idNoticia, tituloNoticia FROM noticia  
                            WHERE idNoticia = (SELECT MAX(idNoticia) FROM noticia);";

// Ejecutar la consulta
$queryNoticia = mysqli_query($conexion, $listarNoticiaReciente);
while ($fila = mysqli_fetch_assoc($queryNoticia)) {
    $idNoticia = $fila["idNoticia"];
    $tituloNoticia = $fila["tituloNoticia"];
}

// Declarar variables
$imagenes = $error = "";

// Verificar que haga el metodo post
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($error)) {
        if (isset($_FILES['imagen'])) {
            $cantidad = count($_FILES["imagen"]["tmp_name"]);
            for ($i=0; $i < $cantidad; $i++) {
                if ($_FILES['imagen']['type'][$i]=='image/png' || $_FILES['imagen']['type'][$i]=='image/jpeg') {
            
                    //Subimos el fichero al servidor
                    $imagen = addslashes(file_get_contents($_FILES["imagen"]["tmp_name"][$i], $_FILES["imagen"]["name"][$i]));

                    $query = "INSERT INTO `detallenoticia`(`imagen`, `noticia_idNoticia`) 
                                                    VALUES ('$imagen', '$idNoticia')";
                    // Realizar la consulta a la base de datos
                    $resultado = mysqli_query($conexion, $query);
                    if ($resultado === true) {
                        header("Location: /view/listarNoticia.php");
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
    <title>Subir Imagenes - Municipalidad de Siguatepeque</title>
</head>
<body>
   <div class="tabs">
       <div class="tabs-navegation">
           <div class="nav">
               <a href="../index.php">
                   <i class="fas fa-home"></i>
                   Home
                </a>
           </div>
           <div class="nav">
               <a href="/view/crearNoticia.php">
                    <i class="fas fa-newspaper"></i>
                    Noticias
                </a>
           </div>
           <div class="nav">
               <a href="/view/listarNoticia.php">
                    <i class="fas fa-list-alt"></i>
                    Listar Noticias
                </a>
           </div>
           <div class="nav">  
               <a href="/view/crearComunicado.php">
                    <i class="fas fa-file-alt"></i> 
                    Comunicados
                </a>
           </div>
           <div class="nav">
                <a href="/view/listarComunicados.php">
                    <i class="fas fa-list-alt"></i>
                    Listar Comunicados
                </a>
           </div>
           
            <div class="nav user">
                <i class="fas fa-user"></i>
                <?php echo $_SESSION["nombre"]; ?>
            </div>
             <div class="nav">
                <a href="../logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    Cerrar Sesion
                </a>
            </div>
          
        </div>  
    </div>
    <div class="alertas">
        <?php  //echo "<p>$error</p>" ;?>
    </div>
    <div id="primero" class="single-tab" >
        <div class="center form-imagen">
            <h2>Subir Imagenes</h2>
            <form action="" method="post" class="accion" enctype="multipart/form-data"> 
                <div class="txt_field">
                    <p class="noticia-text">Noticia:</p>
                    <p class="titulo-noticia-reciente"><?php echo $tituloNoticia; ?></p>

                </div> 
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