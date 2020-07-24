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
       <div class="tabs-navegation">
           <div class="nav">
               <!-- <i class="fas fa-newspaper"></i> -->
               <button  onclick="changeTab('primero')">Noticias</button>
           </div>
           <div class="nav">
               <!-- <i class="fas fa-list-alt"></i> -->
               <button  onclick="changeTab('segundo')">Listar Noticias</button>
           </div>
           <div class="nav">  
               <!-- <i class="fas fa-file-alt"></i>   -->
               <button  onclick="changeTab('tercero')">Comunicados</button>
           </div>
           <div class="nav">
                <!-- <i class="fas fa-list-alt"></i> -->
                <button  onclick="changeTab('cuarto')">Listar Comunicados</button>
           </div>
            <div class="nav">
                <a href="logout.php">Cerrar Sesion</a> 
            </div>
        
        </div>  
        
        <!-- Contenidos de form -->
        <div class="tabs-content">
            <!-- Crear Noticias -->
            <?php  include "view/crearNoticia.php"; ?>
            <!-- Listar Noticias -->
            <?php  include "view/listarNoticia.php"; ?>
            <!-- Crear Comunicados -->
            <?php  include "view/crearComunicado.php"; ?>
            <!-- Listar Comunicados -->
           <?php  include "view/listarComunicados.php"; ?>
        </div>
    </div>
</body>
<script src="./js/app.js"></script>
</html>