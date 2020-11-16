<?php
session_start();
// Verifica rque isuario este logueado
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../login.php");
    exit;
}
require_once "../config/db.php";

// Declarar variables
$rolUser = $_SESSION["rol"];
$idUsuario = $_SESSION["idUsuario"];
$sql ="SELECT idUsuario, nombre, nombreUsuario, (b.rol) as rolUser, (c.nombreDepartamento) as departamento
        FROM usuario a INNER JOIN roles b on b.idRoles = a.roles_idRoles
        INNER join departamentousuario c on  c.idDepartamentoUsuario = a.departamentoUsuario_idDepartamentoUsuario";

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
    <link rel="stylesheet" href="/css/all.min.css">
    <title>Listar Usuarios - Municipalidad de Siguatepeque</title>
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
   

    <table class ="tables">
        <tr>
            <th>Nombre</th>
            <th>Nombre Usuario</th>
            <th>Departamento</th>
            <th>Rol de Usuario</th>
            <th>Acciones</th>
        </tr>


        <?php while ($filas = mysqli_fetch_assoc($resultado)): ?>
        <tr>
            <td><?php echo $filas["nombre"]; ?></td>
            <td><?php echo $filas["nombreUsuario"];?></td>
            <td><?php echo $filas["departamento"] ?></td>
            <td><?php echo $filas["rolUser"]; ?></td>
            <td class = "acciones">
                <a href="/usuario/editarUsuario.php?id=<?php echo $filas["idUsuario"];?>"><i class="fas fa-edit"></i></a>
                <a href="/usuario/eliminarUsuario.php?id=<?php echo $filas["idUsuario"];?>" class="btn-deleteUser"
                        id="btn-deleteUser"><i class="fas fa-trash"></i></a>
            </td>
        </tr>
        <?php endwhile; ?>
       
    </table>
    <?php if(isset($_GET['e'])):?>
        <div class="flash-data" id="flash-data" data-flashdata="<?= $_GET['e']; ?>"></div>
    <?php endif; ?>
 
</div>
    
</body>
<!-- SweatAlert -->
<script src="../js/jquery-3.5.1.min.js"></script>
<script src="../js/sweetalert2.all.min.js"></script>
<script src="../js/deleteUser.js"></script>
<script src="/js/all.min.js"></script>
<?php include("../include/sweetalert.php"); ?>
</html>
