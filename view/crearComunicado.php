<?php
// Incluir el script de la base de datos
require_once "./config/db.php";

// Declarar variables
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
                header("Location: index.php");
            } else {
                $Error ="error en la consulta";
            }
        }
    }
    mysqli_close($conexion);
}

?>
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