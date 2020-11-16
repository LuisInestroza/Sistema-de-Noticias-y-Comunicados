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
$idUsuario = $_SESSION["idUsuario"];
//Query para listar los deparatementos
$listarDepartamento = "SELECT * FROM departamentousuario";
$departamento = mysqli_query($conexion, $listarDepartamento);

// listar los roles de usuario
$listarRoles = "SELECT * FROM roles";
$roles = mysqli_query($conexion, $listarRoles);

//Declarar variables
$nombre = $nombreUsuario = $password = "";
$deptoUser = 0;
$rolUsuario = 0;

$error = "";
// Verificar que se realice el metodo post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar que los campos no esten vacios
    if (empty(trim($_POST["nombre"]))) {
        $error = "Ingrese el nombre";
    } else {
        $nombre = trim($_POST["nombre"]);
    }
    if (empty(trim($_POST["nombreUsuario"]))) {
        $error = "Ingrese el nombre de usuario";
    } else {
        $nombreUsuario = trim($_POST["nombreUsuario"]);
    }
    if (empty(trim($_POST["password"]))) {
        $error = "Ingrese la contraseña";
    } else {
        $password = trim($_POST["password"]);
    }
    if (empty(trim($_POST["departamento"]))) {
        $error = "Ingrese la seleccione el departamento";
    } else {
        $deptoUser = trim($_POST["departamento"]);
    }
    if (empty(trim($_POST["rolUser"]))) {
        $error = "Ingrese el rol de usuario";
    } else {
       $rolUsuario = trim($_POST["rolUser"]);
    }
    

    // Si no hay errores
    if (empty($error)) {

        $queryUsuario = "INSERT INTO `usuario`(`nombre`, `nombreUsuario`, `password`, `departamentoUsuario_idDepartamentoUsuario`, `roles_idRoles`) 
                                        VALUES ('$nombre','$nombreUsuario','$password', '$deptoUser','$rolUsuario')";
    
            $insertarUsuario = mysqli_query($conexion, $queryUsuario);
            if ($insertarUsuario === true) {
                session_start();
                $_SESSION['status'] = "Usuario Creado";
                $_SESSION['status_icon'] = "success";
                header("Location: /usuario/listarUsuario.php");
            } else {
                $error = "Usuario No Registrado";
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
    <link rel="stylesheet" href="/css/all.min.css">
    <title>Crear Usuario - Municipalidad de Siguatepeque</title>
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
        <?php  echo "<p>$error</p>" ;?>
    </div>
    <div id="tercero" class="single-tab" >
        <div class="center form-comunicado">
            <h2>Crear Usuario</h2>      

            <form action="" method="post" class="accion">
                <div class="txt_field">
                    <input type="text" name="nombre" id="" required>  
                    <span></span>
                    <label for="">Nombre</label>
                </div>
                <div class="txt_field">
                    <input type="text" name="nombreUsuario" id="" required>  
                    <span></span>
                    <label for="">Nombre de Usuario</label>
                </div>
                <div class="txt_field">
                    <input type="password" name="password" id="" required>  
                    <span></span>
                    <label for="">Contraseña</label>
                </div>
                 <div class="txt_field panel">
                    <select name="departamento" id="" required>
                        <option value="" disabled selected>Departamento</option>
                        <?php while ($filas = mysqli_fetch_assoc($departamento)):?>
                        <option value="<?php echo $filas["idDepartamentoUsuario"]; ?>"><?php echo $filas["nombreDepartamento"];?></option>
                        <?php  endwhile;?>
                    </select>
                </div>
                 <div class="txt_field panel">
                    <select name="rolUser" id="" required>
                        <option value="" disabled selected>Rol de Usuario</option>
                        <?php while ($filas = mysqli_fetch_assoc($roles)):?>
                        <option value="<?php echo $filas["idRoles"]; ?>"><?php echo $filas["rol"];?></option>
                        <?php  endwhile;?>
                    </select>
                </div>
                
                <input type="submit" value="Crear Usuario">
                
            </form>
        </div>     
    
    </div>
    
    
</body>
<script src="/js/all.min.js"></script>
<script src="/js/app.js"></script>


</html>

