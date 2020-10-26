<?php
session_start();
// Verifica rque isuario este logueado
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../login.php");
    exit;
}
require_once "../config/db.php";

// Declarar variables
$idUsuario = $_SESSION["idUsuario"];
$sql ="SELECT * FROM comunicado WHERE usuario_idUsuario = '$idUsuario'";

$resultado = mysqli_query($conexion, $sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../logo.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
    <title>Listar Comunicados - Municipalidad de Siguatepeque</title>
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
             <!-- <div class="nav">
                <p>
                    Bienvenido(a) <br>
                    <?php //echo $_SESSION['nombre'];?>
                </p>
            </div> -->
        </div>  
    </div>
   
    <div id="cuarto" class="single-tab" >
        <table class ="tables">
            <tr>
                <th>Codigo Comunicado</th>
                <th>Imagen</th>
                <th>Fecha de publicación</th>
                <th>Acciones</th>
            </tr>


            <?php while ($filas = mysqli_fetch_assoc($resultado)): ?>
            <tr>
                <td><?php echo $filas["codigoComunicado"]; ?></td>
                <td><?php echo "<img src = 'data:image/;base64,".base64_encode($filas['imagen'])."' />";; ?></td>
                <td><?php echo $filas["fechaComunicado"]; ?></td>
                <td class="acciones">
                    <a href="/view/editarComunicado.php?id=<?php echo $filas["idComunicado"];?>"><i class="fas fa-edit"></i></a>
                    <a href="/view/eliminarComunicado.php?id=<?php echo $filas["idComunicado"];?>" class="btn-deleteComunicado"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <?php endwhile; ?>
        
        </table>
        <!-- Mostar las alertas del SweetAlert -->
        
        <?php if(isset($_GET['e'])):?>
            <div class="flash-dataComunicado" id="flash-data" data-flashdatacomunicado ="<?= $_GET['e']; ?>"></div>
        <?php endif; ?>
    </div>
</body>
<script src="../js/jquery-3.5.1.min.js"></script>
<script src="../js/sweetalert2.all.min.js"></script>
<script src="../js/deleteComunicado.js"></script>
<?php include("../include/sweetalert.php"); ?>

</html>


