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
$listarNoticias = "SELECT * FROM noticia";
// Ejecutar la consulta
$queryNoticias = mysqli_query($conexion, $listarNoticias);

// Declarar variables
$idNoticia = 0;
$imagenes = $error = "";

// Verificar que haga el metodo post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Revisar que los campos no estan vacios
    if (empty(trim($_POST["tituloNoticia"]))) {
        $error = "Debes seleccionar la noticia";
    } else {
        $idNoticia = trim($_POST["tituloNoticia"]);
    }
    
    // Si no hay errores
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
                    // Redireccionar la pagina principal
                   
                // Cerrar la conexion a la base de datos
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
    <title>Subir Imagenes - Municipalidad de Siguatepeque</title>
</head>
<body>
    <!-- Cabecera -->
    <div class="logo">
        <img src="../img/logo.png" alt="" srcset="">
    </div>
    <div class="escudo">
        <img src="../img/escudo.png" alt="" srcset="">
    </div>
    
   <div class="cabecera">
        <h1>Sistema de Registro de Noticias y Comunicados</h1>
   </div>
    <!-- Panel de acciones -->
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
                    <select name="tituloNoticia" id="" required>
                        <option value="" disabled selected>Selecciona la noticia</option>
                        <!-- Mostrar las categorias de noticia en la etiqueta SELECT -->
                        <?php while ($filas = mysqli_fetch_assoc($queryNoticias)):?>
                        <option value="<?php echo $filas["idNoticia"];?>"><?php echo $filas["tituloNoticia"];?></option>
                        <?php  endwhile;?>
                        <!-- Fin del ciclo while -->
                    </select>
                    

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