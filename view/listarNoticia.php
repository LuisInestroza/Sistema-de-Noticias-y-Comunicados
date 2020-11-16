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
$rolUser = $_SESSION["rol"];


// Query
$sql ="SELECT *,date_format(fechaNoticia, '%d %M, %Y') as fechaNoticia FROM noticia 
        WHERE usuario_idUsuario = '$idUsuario'";

// Ejecutar Consulta
$resultado = mysqli_query($conexion, $sql);


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../logo.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/css/all.min.css">
    <title>Listar Noticia - Municipalidad de Siguatepeque</title>
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
            <?php if($rolUser === "Admin"){ ?>
            <div class="nav">
                <a href="">
                    <i class="fas fa-user"></i>
                    Usuarios
                </a>
            </div>
            
            <div class="nav">
                <a href="">
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
    <div class="lista-noticias">
        <div class="noticias">
            <?php while ($filas = mysqli_fetch_assoc($resultado)): ?>
            <div class="contenedor">
                <?php echo "<img src = 'data:image/;base64,".base64_encode($filas['imagenNoticia'])."' />";;?></td>
                <p class="titulo-noticia"><?php echo $filas["tituloNoticia"]; ?></p>
                <p class="fecha-noticia"><?php echo $filas["fechaNoticia"]; ?></p>
                <td class="acciones">
                    <a href="/view/editarNoticia.php?id=<?php echo $filas["idNoticia"];?>"><i
                            class="fas fa-edit"></i></a>
                    <a href="/view/eliminarNoticia.php?id=<?php echo $filas["idNoticia"];?>" class="btn-deleteNoticia"
                        id="btn-deleteNoticia"><i class="fas fa-trash"></i></a>
                </td>
            </div>
            <?php endwhile; ?>

        </div>

       
    </div>
    <?php if(isset($_GET['e'])):?>
        <div class="flash-data" id="flash-data" data-flashdata="<?= $_GET['e']; ?>"></div>
    <?php endif; ?>
</body>
<!-- SweatAlert -->
<script src="../js/jquery-3.5.1.min.js"></script>
<script src="../js/sweetalert2.all.min.js"></script>
<script src="../js/deleteNoticia.js"></script>
<script src="/js/all.min.js"></script>
<?php include("../include/sweetalert.php"); ?>

</html>