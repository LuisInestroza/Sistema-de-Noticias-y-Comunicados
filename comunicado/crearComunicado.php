<?php

session_start();
// Verifica rque isuario este logueado
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../login.php");
    exit;
}
// Incluir el script de la base de datos
require_once "../config/db.php";

// Declarar variables
$rolUser = $_SESSION["rol"];
$codigoComunicado = "";
$Error = "";
$idUsuario = $_SESSION["idUsuario"];
// Verificar el metodo post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar que los campos no esten vacios
    if (empty(trim($_POST["codigoComunicado"]))) {
        $Error = "Ingrese el codigo del comunicado";
    } else {
        $codigoComunicado = trim($_POST["codigoComunicado"]);
    }
    // Si no hay errores
    if (empty($Error)) {

        // Verificar que haya una imagen cargada
        $imagenCheck = getimagesize($_FILES['imagenComunicado']['tmp_name']);
        if (!$imagenCheck === false) {
            $imagen = $_FILES['imagenComunicado']['tmp_name'];
            $imagenSubir = addslashes(file_get_contents($imagen));

            $query = "INSERT INTO `comunicado`(`imagen`, `fechaComunicado`, `codigoComunicado`, `usuario_idUsuario`) 
                                       VALUES ('$imagenSubir', CURDATE(), '$codigoComunicado', '$idUsuario')";

            $resultadoQuery = mysqli_query($conexion, $query);
            if ($resultadoQuery === true) {
                session_start();
                $_SESSION['status'] = "Comunicado Creado";
                $_SESSION['status_icon'] = "success";
                header("Location: /view/listarComunicados.php");
            } else {
                $Error ="error en la consulta";
            }
        }
    }
    mysqli_close($conexion);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../logo.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/all.min.css">
    <title>Crear Comunicado - Municipalidad de Siguatepeque</title>
</head>
<body>
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
               <a href="/noticia/crearNoticia.php">
                    <i class="fas fa-newspaper"></i>
                    Noticias
                </a>
           </div>
           <div class="nav">
               <a href="/noticia/listarNoticia.php">
                    <i class="fas fa-list-alt"></i>
                    Listar Noticias
                </a>
           </div>
           <div class="nav">  
               <a href="/comunicado/crearComunicado.php">
                    <i class="fas fa-file-alt"></i> 
                    Comunicados
                </a>
           </div>
           <div class="nav">
                <a href="/comunicado/listarComunicados.php">
                    <i class="fas fa-list-alt"></i>
                    Listar Comunicados
                </a>
           </div>
           <?php if($rolUser === "Admin"){ ?>
            <div class="nav">
                <a href="/usuario/crearUsuario.php">
                    <i class="fas fa-user"></i>
                    Usuarios
                </a>
            </div>
            
            <div class="nav">
                <a href="/usuario/listarUsuario.php">
                    <i class="fas fa-list-alt"></i>
                    Listar Usuarios
                </a>
            </div>
            <?php } ?>
           
            <div class="nav" style="color: #ffffff; font-size: 14px; font-weight: bolder; right: 190px; position: absolute;">
                <i class="fas fa-user"></i>
                <?php echo $_SESSION["nombre"]; ?>
            </div>
             <div class="nav">
                <a href="../logout.php" style="color: #ffffff; font-weight: bolder; right: 0; position: absolute; top:0px;">
                    <i class="fas fa-sign-out-alt"></i>
                    Cerrar Sesion
                </a>
            </div>
    
        </div>  
    </div>
    <div class="alertas">
        <?php  echo "<p>$Error</p>" ;?>
    </div>
    <div id="tercero" class="single-tab" >
        <div class="center form-comunicado">
            <h2>Ingresar Comunicado</h2>      

            <form action="" method="post" class="accion" enctype="multipart/form-data">
                <div class="txt_field">
                    <input type="text" name="codigoComunicado" id="" required>  
                    <span></span>
                    <label for="">Codigo Comunicado</label>
                </div>
                <div class="txt_field">
                    <input type="file" name="imagenComunicado" id="" required>  
                    <span></span>
                </div>
                
                <input type="submit" value="Subir Comunicado">
                
            </form>
        </div>     
    
    </div>
    
    
</body>
<script src="/js/all.min.js"></script>


</html>

