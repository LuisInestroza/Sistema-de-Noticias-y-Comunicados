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
$nombre = $nombreUsuario = $password = "";
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
        $sql = "SELECT `idUsuario`,`nombre`, `nombreUsuario`, `password` FROM `usuario` WHERE `nombreUsuario` = ?";

        if ($stmt = mysqli_prepare($conexion, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $paramNombreUsuario);
            // Enviar parametro
            $paramNombreUsuario = $nombreUsuario;

            // Ejecutar el query
            if (mysqli_stmt_execute($stmt)) {
                // Resultado
                mysqli_stmt_store_result($stmt);

                // Verifica que exista un usuario en la base de datos
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Enlazar los valores
                    mysqli_stmt_bind_result($stmt, $id, $nombre, $nombreUsuario, $password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if ($_POST['password'] === $password) {
                            // Si la contraseña es correcta iniciar sesion
                            session_start();
                            // Store de variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["idUsuario"] = $id;
                            $_SESSION["nombre"] = $nombre;
                            $_SESSION["nombreUsuario"] = $nombreUsuario;

                            // Redireccionar a la pagina
                            header("Location: index.php");
                        } else {
                            $_SESSION['status'] = "La contraseña no es correcta";
                            $_SESSION['status_icon'] = "error";
                           
                            
                        }
                    }
                } else {
                    $_SESSION['status'] = "El usuario no existe";
                    $_SESSION['status_icon'] = "error";
              
                }
            } else {
                echo "Algo salio mal";
            }
        }
        // Cerrar el statement
        mysqli_stmt_close($stmt);
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
   <div class="center">  
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