<?php
session_start();
// Verifica rque isuario este logueado
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../login.php");
    exit;
}
// Incluir el script de la coenexion a la base de datos
require_once "../config/db.php";
//Incluir el id del usuario loguedo
$idUsuario = $_SESSION["idUsuario"];
//Query para listar las categoria de noticias
$listarCategoriaComunicado = "SELECT * FROM categorianoticia";
// Ejecutar la consula
$categoriaNoticia = mysqli_query($conexion, $listarCategoriaComunicado);

//Funcionalidad  de crear la noticia
//Declarar variables
$tituloNoticia = $descripcionNoticia  = "";
$categoriasNoticia = 0;
$error = "";
// Verificar que se realice el metodo post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar que los campos no esten vacios
    if (empty(trim($_POST["tituloNoticia"]))) {
        $error = "Ingrese el titulo de la noticia";
    } else {
        $tituloNoticia = trim($_POST["tituloNoticia"]);
    }
    if (empty(trim($_POST["descripcionNoticia"]))) {
        $error = "Ingrese la descripcion de la noticia";
    } else {
        $descripcionNoticia = trim($_POST["descripcionNoticia"]);
    }
    if (empty(trim($_POST["categoriaNoticia"]))) {
        $error = "Ingrese la categoria de la noticia";
    } else {
        $categoriasNoticia = trim($_POST["categoriaNoticia"]);
    }

    // Si no hay errores
    if (empty($error)) {

        // Verificar que haya una imagen cargada
        $imagenCheck = getimagesize($_FILES['imagenNoticia']['tmp_name']);
        if (!$imagenCheck === false) {
            $imagen = $_FILES['imagenNoticia']['tmp_name'];
            $imagenSubir = addslashes(file_get_contents($imagen));
            $queryNoticia = "INSERT INTO `noticia`(`fechaNoticia`, `imagenNoticia`, `tituloNoticia`, `descripcionNoticia`, `categoriaNoticia_idcategoriaNoticia`, `usuario_idUsuario`)
                                 VALUES (CURDATE(),'$imagenSubir', '$tituloNoticia', '$descripcionNoticia', '".$_POST['categoriaNoticia']."', '$idUsuario')";
    
            $insertarNoticia = mysqli_query($conexion, $queryNoticia);
            if ($insertarNoticia === true) {
                session_start();
                $_SESSION['status'] = "Noticia Creada";
                $_SESSION['status_icon'] = "success";
                header("Location: /view/subirImagenesNoticia.php");
            } else {
                $error = "Noticia no registrada";
            }
        }
    }
    mysqli_close($conexion);
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
    <title>Crear Noticia - Municipalidad de Siguatepeque</title>
</head>
<body>
    <!-- Cabecera -->
    <!-- <div class="logo">
        <img src="../img/logo.png" alt="" srcset="">
    </div>
    <div class="escudo">
        <img src="../img/escudo.png" alt="" srcset="">
    </div>
    
   <div class="cabecera">
        <h1>Sistema de Registro de Noticias y Comunicados</h1>
   </div> -->
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
        <?php  echo "<p>$error</p>" ;?>
    </div>
    <div id="primero" class="single-tab" >
        <div class="center form-noticia" >
            <h2>Ingresar Noticia</h2>
            <form action="" method="post" class="accion" enctype="multipart/form-data">
                <div class="txt_field panel">
                    <input type="text" name="tituloNoticia" id="" required>  
                    <span></span>
                    <label for="">Titulo de Noticia</label>
                </div>
                
                <div class="txt_field panel">
                    <select name="categoriaNoticia" id="" required>
                        <option value="" disabled selected>Categoria de Noticia</option>
                        <!-- Mostrar las categorias de noticia en la etiqueta SELECT -->
                        <?php while ($filas = mysqli_fetch_assoc($categoriaNoticia)):?>
                        <option value="<?php echo $filas["idCategoriaNoticia"]; ?>"><?php echo $filas["categoriaNoticia"];?></option>
                        <?php  endwhile;?>
                        <!-- Fin del ciclo while -->
                    </select>
                </div>
                <div class="txt_field">
                    <input type="file" name="imagenNoticia" id="" required>  
                    
                    
                </div>
                <div class="txt_field panel">
                    <textarea name="descripcionNoticia" id="" cols="30" rows="10" required></textarea>
                    <span class="span-descripcion"></span>
                    <label for="">Descripción de Noticia</label>
                    
                </div>
                
                <input type="submit" value="Subir Noticia">
            </form>
        </div>
      
    </div>
    
</body>
</html>
<script src="../js/app.js"></script>