<?php
// Iniciar sesion
session_start();
// Verifica rque isuario este logueado
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
    <link rel="icon" type="image/png" href="./logo.ico" />
    
    <title>Municipalidad - Siguatepeque 2020</title>
</head>
<body>
    <!-- Cabecera -->
    <div class="logo">
        <img src="./img/logo.png" alt="" srcset="">
    </div>
    <div class="escudo">
        <img src="./img/escudo.png" alt="" srcset="">
    </div>
    
   <div class="cabecera">
        <h1>Sistema de Registro de Noticias y Comunicados</h1>
   </div>

   <!-- Panel de acciones -->
   <div class="tabs">
       <div class="navegation">
            <div class="nav-index">
                <p>
                    Bienvenido(a), <br>
                    <p><?php echo $_SESSION['nombre']; ?></p>
                </p>
            </div>
            <div class="nav-index">
                <i class="fas fa-sign-out-alt"></i> 
                <a href="logout.php">Cerrar Sesion</a> 
            </div>
            
        
        </div>  
        
        <!-- Contenidos de form -->
        <div class="tabs-content" style="margin: 50px auto;">
            <!-- Crear Noticias -->
            <a href="/view/crearNoticia.php">
                <i class="fas fa-newspaper"></i> <br>
                Noticias
            </a>
            <!-- Listar Noticias -->
           <a href="/view/listarNoticia.php">
                <i class="fas fa-list-alt"></i> <br>
                Listar Noticias
            </a>
            <!-- Crear Comunicados -->
            <a href="/view/crearComunicado.php">
                <i class="fas fa-file-alt"></i> <br>
                Comunicados
            </a>
            <!-- Listar Comunicados -->
            <a href="/view/listarComunicados.php">
                <i class="fas fa-list-alt"></i> <br>
                Listar Comunicados
            </a>
           
        </div>
    </div>
</body>
<script src="./js/app.js"></script>
</html>