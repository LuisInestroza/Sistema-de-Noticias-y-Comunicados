<?php
    include("./config/db.php");
    $con = conexion();
    $mostrarNoticias = "SELECT * from categorianoticia";

    //si existe "id" en la url
    if (isset($_GET['id'])) {
        $id = $_GET['id'];//le asigno una variable
        $query = "SELECT * FROM noticia WHERE idnoticia =".$id; //cadena de consulta para el elemento $id
        if ($resultado = mysqli_query($con, $query)) { //si obtengo resultados ejecutando la consulta anterior
        while ($noticia = mysqli_fetch_assoc($resultado)) { //asigno ese resultado a un array asociativo $user
            $titulo = $noticia['tituloNoticia'];
            $descripcion = $noticia['descripcionNoticia'];
            $fecha = $noticia['fechaNoticia'];
            $categoriaNoticia = $noticia['categoriaNoticia_idcategoriaNoticia'];
            $imagen1 = $noticia['imagen'];
            $imagen2 = $noticia['imagen2'];
            $imagen3 = $noticia['imagen3'];
            $imagen4 = $noticia['imagen4'];
            $imagen5 = $noticia['imagen5'];
            $imagen6 = $noticia['imagen6'];
        }
        }
    }
    if (isset($_POST['update']) == 1) { //si se ha presionado el boton "Actualizar
        if (isset($_FILES['imagen']['name']) &&($_FILES['imagen']['name']!="")) {
            //cadena con la orden de actualizacion a la tabla "users" con los valores de los inputs enviados por POST
            $type = $_FILES['imagen']['tmp_name'];
            $imagenChange = addslashes(file_get_contents($type));
            $type2 = $_FILES['imagen2']['tmp_name'];
            $imagenChange2 = addslashes(file_get_contents($type2));
            $type3 = $_FILES['imagen3']['tmp_name'];
            $imagenChange3 = addslashes(file_get_contents($type3));
            $type4 = $_FILES['imagen4']['tmp_name'];
            $imagenChange4 = addslashes(file_get_contents($type4));
            $type5 = $_FILES['imagen5']['tmp_name'];
            $imagenChange5 = addslashes(file_get_contents($type5));
            $type6 = $_FILES['imagen6']['tmp_name'];
            $imagenChange6 = addslashes(file_get_contents($type6));


            $query2 = "UPDATE noticia SET tituloNoticia='".$_POST['titulo']."', descripcionNoticia='".$_POST['descripcion']."', fechaNoticia='".$_POST['fecha']."', categoriaNoticia_idcategoriaNoticia='".$_POST['categoriaNoticia']."', imagen='".$imagenChange."', imagen2='".$imagenChange2."', imagen3='".$imagenChange3."', imagen4='".$imagenChange4."', imagen5='".$imagenChange5."', imagen6='".$imagenChange6."' WHERE idnoticia=".$_POST['id'];
        
            if (mysqli_query($con, $query2)) { //si la consulta se ejecuta con exito
             echo "La informacion se actualizo con exito"; //mensaje de exito
            header('Location: ../'); //redireccion a index.php
            } else { //si ocurrio un error
            echo "Ocurrio un error al intentar actualizar"; //mensaje de error
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Editar Noticia</title>
 
</head>
<body>
    <div class="logo">
        <img src="../img/logo.png" alt="" srcset="">
    </div>
    <div class="escudo">
        <img src="../img/escudo.png" alt="" srcset="">
    </div>
   <div class="cabecera">
        <h1>Sistema de Registro de Noticias y Comunicados</h1>
   </div>   
   
   <!-- Formulario de editar alumno -->
   <form action="" method="post" enctype="multipart/form-data">
        <h2>Editar Noticia</h2>
        <div class="accion"> 
                    <label for="">Titulo</label>
                    <input type="text" placeholder="Escribe el titulo" name="titulo" value = "<?php echo $titulo?>">
                </div>
                <div class="accion">
                    <label for="">Descripcion: </label>
                    <textarea name="descripcion" type="text" placeholder="Escribe la descripción" value = ""><?php echo $descripcion?></textarea>
                </div>
                <div class="accion">
                    <label for="">Fecha:</label>
                    <input type="date" name="fecha" id="" value="<?php  echo $fecha?>">
                </div>
                <div class="accion">
                    <label for="">Imagenes</label>
                    <input type="file" name="imagen" id="" multiple="">
                    <?php echo "<img src = 'data:image/;base64,".base64_encode($imagen1)."' />";; ?>
                    <input type="file" name="imagen2" id="" multiple="">
                    <?php echo "<img src = 'data:image/;base64,".base64_encode($imagen2)."' />";; ?>
                    <input type="file" name="imagen3" id="" multiple="">
                    <?php echo "<img src = 'data:image/;base64,".base64_encode($imagen3)."' />";; ?>
                    <input type="file" name="imagen4" id="" multiple="">
                    <?php echo "<img src = 'data:image/;base64,".base64_encode($imagen4)."' />";; ?>
                    <input type="file" name="imagen5" id="" multiple="">
                    <?php echo "<img src = 'data:image/;base64,".base64_encode($imagen5)."' />";; ?>
                    <input type="file" name="imagen6" id="" multiple="">
                    <?php echo "<img src = 'data:image/;base64,".base64_encode($imagen6)."' />";; ?>
              
                </div>
                <div class="accion">
                
                    <label for="">Categoria de noticia:</label>

                    <select name="categoriaNoticia" id="">
                        <?php  if ($categoria = mysqli_query($con, $mostrarNoticias) or die("Error en la consulta")):?>
                            <?php while ($columna = mysqli_fetch_assoc($categoria)): ?>
                                <option name="" value=<?php echo $categoriaNoticia; ?> ><?php echo $columna['categoriaNoticia'] ?></option>
                            <?php endwhile; ?>
                        <?php  endif;  ?>
                    </select>
                </div>
    
        <!-- botones de acualizar -->
        <input class="btn-actualizar" type="submit" name="actualizar"value="Actualizar">
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <input type="hidden" name="update"value="1" >
    </form>
    
</body>
</html>