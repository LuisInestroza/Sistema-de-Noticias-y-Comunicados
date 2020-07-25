<?php
require_once "./config/db.php";

// Declarar variables
$idUsuario = $_SESSION["idUsuario"];
$sql ="SELECT * FROM comunicado WHERE usuario_idUsuario = '$idUsuario'";


?>

<div id="cuarto" class="single-tab" >
    <table class ="tables">
        <tr>
            <th>Codigo Comunicado</th>
            <th>Imagen</th>
            <th>Fecha de publicación</th>
            <th>Acciones</th>
        </tr>

        <?php  if ($resultado = mysqli_query($conexion, $sql)):?>
        <?php while ($filas = mysqli_fetch_assoc($resultado)): ?>
        <tr>
            <td><?php echo $filas["codigoComunicado"]; ?></td>
            <td><?php echo "<img src = 'data:image/;base64,".base64_encode($filas['imagen'])."' />";; ?></td>
            <td><?php echo $filas["fechaComunicado"]; ?></td>
            <td>
                <a href="/view/editarComunicado.php?id=<?php echo $filas["idComunicado"];?>"><i class="fas fa-edit"></i></a>
                <a href="/view/eliminarComunicado.php?id=<?php echo $filas["idComunicado"];?>"><i class="fas fa-trash"></i></a>
            </td>
        </tr>
        <?php endwhile; ?>
        <?php endif;  ?>
       
</table>
 
</div>