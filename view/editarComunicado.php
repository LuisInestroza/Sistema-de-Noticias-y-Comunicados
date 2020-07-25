<?php
// Iniciar sesion
session_start();
// Verifica rque isuario este logueado
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../login.php");
    exit;
}

//Conectar el script de la base de datos
require_once "../config/db.php";
$error = "";
// Verificar que exista el id en la url
if (isset($_GET["id"])) {
    $idUrl = $_GET["id"];
    $sql = "SELECT * FROM comunicado WHERE idComunicado = '$idUrl'";

    // Verificar que el query se ejecute
    if ($listarComunicado = mysqli_query($conexion, $sql)) {
        while ($comunicado = mysqli_fetch_assoc($listarComunicado)) {
            $codigoComunicadoUpdate = $comunicado["codigoComunicado"];
            $imagenComunicadoUpdate = $comunicado["imagen"];
        }
    } else {
        $error = "Error en la consulta";
    }
}
// Verifica que se realize el metodo post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar que cada campo no este vacio
    if (empty(trim($_POST["codigoComunicado"]))) {
        $error = "No hay datos mostrados";
    } else {
        $codigoComunicadoUpdate = trim($_POST["codigoComunicado"]);
    }
    // Si no hay  errores
    if (empty($error)) {
        if (isset($_POST['update']) == 1) {
            if (isset($_FILES["imagen"]["name"])&&($_FILES["imagen"]["name"] != "")) {
                $typeImagen = $_FILES["imagen"]["tmp_name"];
                $imagenUpdate = addslashes(file_get_contents($typeImagen));
                $updateComunicado = "UPDATE comunicado 
                                        SET codigoComunicado = '$codigoComunicadoUpdate', imagen ='$imagenUpdate' 
                                    WHERE idComunicado = '$idUrl'";
                
                if (mysqli_query($conexion, $updateComunicado)) {
                    header("Location: ../index.php");
                } else {
                    $error = "Error en la consulta";
                }
            } else {
                $error = "No hay imagen almacenada";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="shortcut icon" href="/logo.ico" type="image/x-icon">
    <title>Editar Comunicado - Municipalidad de Siguatepeque</title>
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

   <!-- Alertas -->
   <div class="alertas">
        <?php  echo "<p>$error</p>" ;?> 
    </div>

    <div class="editarComunicado">
        <div class="center form-editarComunicado ">
            <h2>Editar Comunicado</h2>      
            <form action="" method="post" class="accion" enctype="multipart/form-data">
                <div class="txt_field">
                    <input 
                        type="text" 
                        name="codigoComunicado" 
                        id="" 
                        value ="<?php echo $codigoComunicadoUpdate; ?>"
                        required>  
                    <span></span>
                    <label for="">Codigo Comunicado</label>
                </div>
                <div class="txt_field">
                    <input 
                        type="file" 
                        name="imagen" 
                        id="">  
                    <span></span>
                </div>        
                <input type="hidden" name="update" id="id" value="<?php echo $idUrl; ?>">    
                <input type="submit" value="Editar Comunicado">
            </form>
        </div>     
        <div class="imagen">
            <?php echo "<img src = 'data:image/jpeg;base64,".base64_encode($imagenComunicadoUpdate)."' />";; ?>
        </div>
    </div>

   


    
</body>
<script src="../js/app.js"></script>
</html>