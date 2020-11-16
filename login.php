<?php
// Metodo de iniciar sesion
session_start();
// Verificar que el usuario este logueado
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("Location: index.php");
    exit;
}
// incluir la carpteta de la base de datos
require_once("./config/db.php");
// Definir variables
$nombre = $nombreUsuario = $password = $rolUser= "";
$Error= "";

// Verificar el procesamiento post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar que los campos no esten vacios
    if (empty(trim($_POST["nombreUsuario"]))) {
        $Error = "Ingrese su nombre de usuario";
    } else {
        $nombreUsuario = trim($_POST["nombreUsuario"]);
    }
    if (empty(trim($_POST["password"]))) {
        $Error = "Ingrese su contraseña";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validar las credenciales
    if (empty($Error)) {
        // Query
        $sql = "SELECT idUsuario, nombre, nombreUsuario, password, (b.rol) as rol  
                    FROM usuario a INNER JOIN roles b on b.idRoles = a.roles_idRoles 
                 WHERE `nombreUsuario` = '$nombreUsuario'";

        if ($resultadoQuery = mysqli_query($conexion, $sql)) {
           
            // Verifica que exista un usuario en la base de datos
            if (mysqli_num_rows($resultadoQuery) == 1) {
                // Enlazar los valore
                while($filas = mysqli_fetch_array($resultadoQuery)){
                   $id = $filas["idUsuario"];
                   $nombre = $filas["nombre"];
                   $nombreUsuario = $filas["nombreUsuario"];
                   $password = $filas["password"];
                   $rolUser = $filas["rol"];
                }
                if ($_POST['password'] === $password) {
                    // Si la contraseña es correcta iniciar sesion
                    session_start();
                    // Store de variables
                    $_SESSION["loggedin"] = true;
                    $_SESSION["idUsuario"] = $id;
                    $_SESSION["nombre"] = $nombre;
                    $_SESSION["nombreUsuario"] = $nombreUsuario;
                    $_SESSION["rol"] = $rolUser;

                    // Redireccionar a la pagina
                    header("Location: index.php");
                } else {
                    $_SESSION['status'] = "La contraseña no es correcta";
                    $_SESSION['status_icon'] = "error";         
                }
                
            } else {
                $_SESSION['status'] = "El usuario no existe";
                $_SESSION['status_icon'] = "error";
            }
        }else{
            $Error = "Error en la consulta";
        }
    }
    // Cerrar la conexion
    mysqli_close($conexion);
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Municipalidad de Siguatepeque</title>
    <link rel="shortcut icon" href="./logo.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="logo">
        <img src="./img/logo.png" alt="" srcset="">
    </div>
    <div class="escudo">
        <img src="./img/escudo.png" alt="" srcset="">
    </div>
    
   <div class="cabecera">
        <h1>Sistema de Registro de Noticias y Comunicados</h1>
   </div>

    <div class="alertas">
        <?php  echo "<p>$Error</p>" ;?>
    </div>

   
   <!-- Formulario Login -->
   <div class="center" style="top:90px">  
        <h2>Iniciar Sesión</h2>
        <form action="" method="post">
            <div class="txt_field">
                <input type="text" name="nombreUsuario" id="" required>
                
                <label for="">Nombre Usuario</label>
                
            </div>
            <div class="txt_field">
                <input type="password" name="password" id="" required>
                <label for="">Contraseña</label>
           
            </div>
            <input type="submit" value="Ingresar">
        </form>
   </div>
</body>
<script src="./js/app.js"></script>
<script src="./js/sweetalert2.all.min.js"></script>
<?php include("./include/sweetalert.php"); ?>
</html>