<?php

// Incluir el script de la coenexion a la base de datos
require_once "./config/db.php";
//Incluir el id del usuario loguedo
$idUsuario = $_SESSION["idUsuario"];
//Query para listar las categoria de noticias
$listarCategoriaComunicado = "SELECT * FROM categorianoticia";
// Ejecutar la consula
$categoriaNoticia = mysqli_query($conexion, $listarCategoriaComunicado);


//Funcionalidad  de crear la noticia
//Declarar variables
$tituloNoticia = $descripcionNoticia = $categoriasNoticia = "";
$error = "";
// Verificar que se realice el metodo post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar que los campos no esten vacios
    if (empty(trim($_POST["tituloNoticia"]))) {
        $error = "Ingrese el titulo de la noticia";
    } else {
        $tituloNoticia = trim($_POST["tituloNoticia"]);
    }
    if (empty(trim($_POST["descripcionNoticia"]))) {
        $error = "Ingrese la descripcion de la noticia";
    } else {
        $descripcionNoticia = trim($_POST["descripcionNoticia"]);
    }
    if (empty(trim($_POST["categoriaNoticia"]))) {
        $error = "Ingrese la categoria de la noticia";
    } else {
        $categoriasNoticia = trim($_POST["categoriaNoticia"]);
    }

    // Si no hay errores
    if (empty($error)) {
        $queryNoticia = "INSERT INTO `noticia`(`fechaNoticia`, `tituloNoticia`, `descripcionNoticia`, `categoriaNoticia_idcategoriaNoticia`, `usuario_idUsuario`)
                                 VALUES (CURDATE(), '$tituloNoticia', '$descripcionNoticia', '$categoriasNoticia', '$idUsuario')";
    
        $insertarNoticia = mysqli_query($conexion, $queryNoticia);
        if ($insertarNoticia === true) {
            header("Location: index.php");
        } else {
            $error = "Noticia no registrada";
        }
    }
    mysqli_close($conexion);
}
?>
<div class="alertas">
    <?php  echo "<p>$error</p>" ;?>
</div>
<div id="primero" class="single-tab" >
    <div class="center form-noticia">
        <h2>Ingresar Noticia</h2>
        <form action="" method="post" class="accion">
            <div class="txt_field panel">
                <input type="text" name="tituloNoticia" id="" required>  
                <span></span>
                <label for="">Titulo de Noticia</label>
            </div>
            
            <div class="txt_field panel">
                <select name="categoriaNoticia" id="" required>
                    <option value="" disabled selected>Selecciona una opción</option>
                    <!-- Mostrar las categorias de noticia en la etiqueta SELECT -->
                    <?php while ($filas = mysqli_fetch_assoc($categoriaNoticia)):?>
                    <option value="<?php echo $filas["idCategoriaNoticia"]; ?>"><?php echo $filas["categoriaNoticia"];?></option>
                    <?php  endwhile;?>
                    <!-- Fin del ciclo while -->
                </select>
                

            </div>
            <div class="txt_field panel">
                <textarea name="descripcionNoticia" id="" cols="30" rows="10" required></textarea>
                <span class="span-descripcion"></span>
                <label for="">Descripción de Noticia</label>
                
            </div>
            
            <input type="submit" value="Subir Noticia">
        </form>
    </div>
    <div class="center form-imagen">
        <h2>Subir Imagenes</h2>
        <form action="" method="post" class="accion" enctype="multipart/form-data"> 
            <div class="txt_field panel">
                <input type="file" name="" id="" required multiple>  
                <span></span>
            </div>
            <input type="submit" value="Subir Imagenes">
        </form>
    </div>         
</div>