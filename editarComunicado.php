<?php  
    include("./config/db.php");
    $con = conexion();
    

    //si existe "id" en la url
    if (isset($_GET['id'])) {
        $id = $_GET['id'];//le asigno una variable
        $query = "SELECT * FROM comunicado WHERE idcomunicado =".$id; //cadena de consulta para el elemento $id
        
        
        if ($resultado = mysqli_query($con, $query)) { //si obtengo resultados ejecutando la consulta anterior
        while ($comunicado = mysqli_fetch_assoc($resultado)) { //asigno ese resultado a un array asociativo $user
            $imagen = $comunicado['imagen'];
            $codigoComunicado = $comunicado['codigoComunicado'];
            $fecha = $comunicado['fechaComunicado'];
        }
        }

    }
    // if (($_POST['update']) == 1) { //si se ha presionado el boton "Actualizar
        if (isset($_FILES['imagen']['name']) &&($_FILES['imagen']['name']!="")) {
            //cadena con la orden de actualizacion a la tabla "users" con los valores de los inputs enviados por POST
            $type = $_FILES['imagen']['tmp_name'];
            $imagenChange = addslashes(file_get_contents($type));
         
           $query2 =  "UPDATE comunicado SET imagen = '".$imagenChange."', fechaComunicado = '".$_POST['fecha']."', codigoComunicado = '".$_POST['codigo']."' WHERE idcomunicado =".$_POST['id'];


     

            if (mysqli_query($con, $query2)) { //si la consulta se ejecuta con exito
                echo "La informacion se actualizo con exito"; //mensaje de exito
                header('Location: ../index.php'); //redireccion a index.php
            }else { //si ocurrio un error
                echo "Ocurrio un error al intentar actualizar"; //mensaje de error
            }
        }
    // }
?>

<!DOCTYPE html>
<html lang="es">
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

        
        <form action="" method="POST" enctype="multipart/form-data">
                <h2>Comunicados</h2>
                <div class="accion">
                    <label for="">Codigo Comunicado</label>
                    <input class="form-control" type="text" placeholder="Codigo" name="codigoComunicado" value="<?php echo $codigoComunicado ?>">
                </div>
                
                <div class="accion">
                    <label for="">Imagen</label>
                    <input class="form-control" type="file" name="imagen" id="" multiple="">
                    <?php echo "<img src = 'data:image/;base64,".base64_encode($imagen)."' />";; ?>
                </div>    
                <!-- botones de acualizar -->
                <input class="btn-actualizar" type="submit" name="actualizar"value="Actualizar">
                <input type="hidden" name="id" value="<?php echo $id;?>">
                <input type="hidden" name="update" value="1" >

            </form>
   
              

    
</body>
</html>