<?php
// Iniciar sesion
session_start();
// Verifica rque isuario este logueado
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../login.php");
    exit;
}
// Incorporar la base de datos
require_once "../config/db.php";
$error = "";
// Query para listar la noticia
$sqlCategoria = "SELECT * FROM categorianoticia";
// Ejecutar el script
$listarCategoria = mysqli_query($conexion, $sqlCategoria);

// Verificar que exista el id en la url
if (isset($_GET["id"])) {
    $idUrl = $_GET["id"];
    $sql = "SELECT * from noticia a 
                INNER JOIN categorianoticia b 
                    ON a.categoriaNoticia_idcategoriaNoticia = b.idCategoriaNoticia 
                WHERE a.idNoticia = '$idUrl'";

    // Verificar que el query se ejecute
    if ($listarNoticia = mysqli_query($conexion, $sql)) {
        while ($noticia = mysqli_fetch_assoc($listarNoticia)) {
            $tituloNoticiaUpdate = $noticia["tituloNoticia"];
            $descripcionNoticiaUpdate = $noticia["descripcionNoticia"];
            $categoriaNoticiaUpdate = $noticia["categoriaNoticia_idcategoriaNoticia"];
            $nombreCategoria = $noticia["categoriaNoticia"];
            $imagenNoticiaUpdate = $noticia["imagenNoticia"];
        }
    } else {
        $error = "Error en la consulta";
    }
}
// Verifica que se realize el metodo post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar que cada campo no este vacio
    if (empty(trim($_POST["tituloNoticia"]))) {
        $error = "No hay datos mostrados";
    } else {
        $tituloNoticiaUpdate = trim($_POST["tituloNoticia"]);
    }
    if (empty(trim($_POST["descripcionNoticia"]))) {
        $error = "No hay datos mostrados";
    } else {
        $descripcionNoticiaUpdate= trim($_POST["descripcionNoticia"]);
    }
    if (empty(trim($_POST["categoriaNoticia"]))) {
        $error = "No hay datos mostrados";
    } else {
        $categoriaNoticiaUpdate= trim($_POST["categoriaNoticia"]);
    }
    // Si no hay  errores
    if (empty($error)) {
        if (isset($_POST['update']) == 1) {
            if (isset($_FILES["imagenNoticia"]["name"])&&($_FILES["imagenNoticia"]["name"] != "")) {
                $typeImagen = $_FILES["imagenNoticia"]["tmp_name"];
                $imagenUpdate = addslashes(file_get_contents($typeImagen));
                $updateNoticia = "UPDATE noticia
                                    SET tituloNoticia = '$tituloNoticiaUpdate', imagenNoticia = '$imagenUpdate', descripcionNoticia ='$descripcionNoticiaUpdate', categoriaNoticia_idcategoriaNoticia = '$categoriaNoticiaUpdate'
                              WHERE idNoticia = '$idUrl'";
                if (mysqli_query($conexion, $updateNoticia)) {
                    session_start();
                    $_SESSION['status'] = "La noticia ha sido actualizada";
                    $_SESSION['status_icon'] = "success";
                    header("Location: /noticia/listarNoticia.php");
                } else {
                    $error = "Error en la consulta";
                }
            } else {
                $updateNoticia = "UPDATE noticia
                                    SET tituloNoticia = '$tituloNoticiaUpdate', descripcionNoticia ='$descripcionNoticiaUpdate', categoriaNoticia_idcategoriaNoticia = '$categoriaNoticiaUpdate'
                              WHERE idNoticia = '$idUrl'";
                if (mysqli_query($conexion, $updateNoticia)) {
                    session_start();
                    $_SESSION['status'] = "La noticia ha sido actualizada";
                    $_SESSION['status_icon'] = "success";
                    header("Location: /noticia/listarNoticia.php");
                } else {
                    $error = "Error en la consulta";
                }
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
    <link rel="stylesheet" href="/css/sample.css">
    <title>Editar Noticia - Municipalidad de Siguatepeque</title>
</head>
<body>
   <!-- Alertas -->
   <div class="alertas">
        <?php  echo "<p>$error</p>" ;?> 
    </div>
    <div id="primero" class="single-tab" >
        <div class="center" style="width: 50%">
            <h2>Editar Noticia</h2>
            <form action="" method="post" class="accion" enctype="multipart/form-data">
                <div class="txt_field panel">
                    <input 
                        type="text" 
                        name="tituloNoticia" 
                        id="" 
                        value = "<?php echo $tituloNoticiaUpdate;?>"required>  
                    <span></span>
                    <label for="">Titulo de Noticia</label>
                </div>
                
                <div class="txt_field panel">
                    <select name="categoriaNoticia" id="" required>
                        <!-- <option value="" disabled selected></option> -->
                        <option value="<?php echo $categoriaNoticiaUpdate?>"><?php echo $nombreCategoria;?></option>
                        <!-- Mostrar las categorias de noticia en la etiqueta SELECT -->
                        <?php while ($filas = mysqli_fetch_assoc($listarCategoria)):?>
                        <option value=<?php echo $filas["idCategoriaNoticia"]; ?>><?php echo $filas["categoriaNoticia"];?></option>
                        <?php  endwhile;?>
                        <!-- Fin del ciclo while -->
                    </select>
                </div>
                <div class="txt_field">
                    <input type="file" name="imagenNoticia" id="">  
                    <span></span>
                </div>
                <div class="imagen">
                     <?php echo "<img src = 'data:image/;base64,".base64_encode($imagenNoticiaUpdate)."' />";;?>
                </div> 
                <div class="txt_field panel">
                    <textarea name="descripcionNoticia" id="editor" cols="30" rows="10" required><?php echo $descripcionNoticiaUpdate; ?></textarea>
                    <!-- <span class="span-descripcion"></span>
                    <label for="">Descripción de Noticia</label> -->
                </div>
                <div class="editar-imagenes">
                    <a href="/noticia/editarImagenesNoticia.php?id=<?php echo $idUrl;?>">Editar Imagenes</a>
                </div>
                <input type="hidden" name="update" id="id" value="<?php echo $idUrl; ?>">    
                <input type="submit" value="Editar Noticia">
                
                
                
            </form>
        </div>
            
    </div>


   


    
</body>
<script src="../js/app.js"></script>
<script src="../js/ckeditor.js"></script>
<script>
		ClassicEditor
			.create(document.querySelector('#editor'), {
				// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
			})
			.then(editor => {
				window.editor = editor;
			})
			.catch(err => {
				console.error(err.stack);
			});
</script>
</html>