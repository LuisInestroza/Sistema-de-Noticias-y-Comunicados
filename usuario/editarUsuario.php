<?php

session_start();
// Verifica rque isuario este logueado
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../login.php");
    exit;
}
// Incluir el script de la base de datos
require_once "../config/db.php";
// Verificar que exista el id en la url
if (isset($_GET["id"])) {
    $idUrl = $_GET["id"];
    $sql = "SELECT nombre, nombreUsuario, password, roles_idRoles, (b.rol) as rolUser, (c.nombreDepartamento) as departamento, departamentoUsuario_idDepartamentoUsuario
                FROM usuario a 
                    INNER JOIN roles b on b.idRoles = a.roles_idRoles
                    INNER join departamentousuario c on  c.idDepartamentoUsuario = a.departamentoUsuario_idDepartamentoUsuario 
            WHERE idUsuario = '$idUrl'";

    // Verificar que el query se ejecute
    if ($listarUsuario = mysqli_query($conexion, $sql)) {
        // Listar los datos
        while ($usuario = mysqli_fetch_assoc($listarUsuario)) {
            $nombreUpdate = $usuario["nombre"];
            $nombreUsuarioUpdate = $usuario["nombreUsuario"];
            $passwordUpdate = $usuario["password"];
            $rolUpdate = $usuario["roles_idRoles"];
            $rolName = $usuario["rolUser"];
            $departamentoUpdate = $usuario["departamentoUsuario_idDepartamentoUsuario"];
            $deptoName = $usuario["departamento"];
        }
    } else {
        $error = "Error en la consulta";
    }
}

// Declarar variables
$rolUser = $_SESSION["rol"];

//Query para listar los deparatementos
$listarDepartamento = "SELECT * FROM departamentousuario";
$departamento = mysqli_query($conexion, $listarDepartamento);

// listar los roles de usuario
$listarRoles = "SELECT * FROM roles";
$roles = mysqli_query($conexion, $listarRoles);


// Declarar variables
$error = "";
$nuevaPassword = "";
// Verificar que se realice el metodo post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar que los campos no esten vacios
    if (empty(trim($_POST["nombre"]))) {
        $error = "Ingrese el nombre";
    } else {
        $nombreUpdate = trim($_POST["nombre"]);
    }
    if (empty(trim($_POST["nombreUsuario"]))) {
        $error = "Ingrese el nombre de usuario";
    } else {
        $nombreUsuarioUpdate = trim($_POST["nombreUsuario"]);
    }
    if (empty(trim($_POST["departamento"]))) {
        $error = "Ingrese la seleccione el departamento";
    } else {
        $departamentoUpdate = trim($_POST["departamento"]);
    }
    if (empty(trim($_POST["rolUser"]))) {
        $error = "Ingrese el rol de usuario";
    } else {
       $rolUpdate = trim($_POST["rolUser"]);
    }
    

    // Si no hay errores
    if (empty($error)) {
    
        // Si no se escribe una nueva contraseña
        if(empty(trim($_POST["password"]))){

            $updateUsuario = "UPDATE `usuario` 
                            SET `nombre`='$nombreUpdate',`nombreUsuario`='$nombreUsuarioUpdate',`password`='$passwordUpdate',`departamentoUsuario_idDepartamentoUsuario`='$departamentoUpdate',`roles_idRoles`='$rolUpdate' 
                        WHERE `idUsuario`= '$idUrl'";

            $resultado = mysqli_query($conexion, $updateUsuario);
            if ($resultado === true) {
                session_start();
                $_SESSION['status'] = "El usuario ha sido actualizado";
                $_SESSION['status_icon'] = "success";
                header("Location: /usuario/listarUsuario.php");
            } else {
                $error = "Datos no actualizados";
            }
        }else{
            // Si hay una nueva contraseña
            $nuevaPassword = $_POST["password"];
            $updateUsuario = "UPDATE `usuario` 
                            SET `nombre`='$nombreUpdate',`nombreUsuario`='$nombreUsuarioUpdate',`password`='$nuevaPassword',`departamentoUsuario_idDepartamentoUsuario`='$departamentoUpdate',`roles_idRoles`='$rolUpdate' 
                        WHERE `idUsuario`= '$idUrl'";

            $resultado = mysqli_query($conexion, $updateUsuario);
            if ($resultado === true) {
                session_start();
                $_SESSION['status'] = "El usuario ha sido actualizado";
                $_SESSION['status_icon'] = "success";
                header("Location: /usuario/listarUsuario.php");
            } else {
                $error = "Datos no actualizados";
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
    <link rel="stylesheet" href="/css/all.min.css">
    <title>Editar Usuario - Municipalidad de Siguatepeque</title>
</head>
<body>
    
    <div class="alertas">
        <?php  echo "<p>$error</p>" ;?>
    </div>
    <div id="tercero" class="single-tab" >
        <div class="center form-comunicado">
            <h2>Editar Usuario</h2>      

            <form action="" method="post" class="accion">
                <div class="txt_field">
                    <input 
                        type="text" 
                        name="nombre" 
                        id="" 
                        value = "<?php echo $nombreUpdate; ?>"
                        required>  
                    <span></span>
                    <label for="">Nombre</label>
                </div>
                <div class="txt_field">
                    <input 
                        type="text" 
                        name="nombreUsuario" 
                        id="" 
                        value = "<?php echo $nombreUsuarioUpdate; ?>"
                        required>  
                    <span></span>
                    <label for="">Nombre de Usuario</label>
                </div>
                <div class="txt_field">
                    <input type="password" name="password" id="">
                    <span></span>
                    <label for="">Contraseña</label>
                </div>
                 <div class="txt_field panel">
                    <select name="departamento" id="" required>
                        <option value="<?php echo $departamentoUpdate; ?>"><?php echo $deptoName;?></option>
                        <?php while ($filas = mysqli_fetch_assoc($departamento)):?>
                        <option value="<?php echo $filas["idDepartamentoUsuario"]; ?>"><?php echo $filas["nombreDepartamento"];?></option>
                        <?php  endwhile;?>
                    </select>
                </div>
                 <div class="txt_field panel">
                    <select name="rolUser" id="" required>
                        <option value="<?php echo $rolUpdate; ?>"><?php echo $rolName;?></option>
                        <?php while ($filas = mysqli_fetch_assoc($roles)):?>
                        <option value="<?php echo $filas["idRoles"]; ?>"><?php echo $filas["rol"];?></option>
                        <?php  endwhile;?>
                    </select>
                </div>
                

                <input type="submit" value="Editar Usuario">
                
            </form>
        </div>     
    
    </div>
    
    
</body>
<script src="/js/all.min.js"></script>
<script src="/js/app.js"></script>


</html>

