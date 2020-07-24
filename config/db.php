<?php
 
// Definir variables para la conexion a la base de datos
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'muni2020');

// Conexion
$conexion = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Virificar que se haga la conexion
if($conexion === false){
    die("ERROR: no hay conexión". mysqli_connect_error());
}
?>
   




   
