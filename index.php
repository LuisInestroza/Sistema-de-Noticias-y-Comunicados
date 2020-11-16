<?php
// Iniciar sesion
session_start();
// Verifica rque isuario este logueado
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}

$rolUser = $_SESSION["rol"];
// Verifivar el tipo de rol del usuario

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/all.min.css">
    <link rel="icon" type="image/png" href="./logo.ico" />
    
    <title>Municipalidad - Siguatepeque 2020</title>
</head>
<body>
    
   <!-- Panel de acciones -->
   <div class="tabs">
       <div class="tabs-nav" style="padding-bottom: 41px;">
            <div class="nav" style="position: absolute; right:0;">
                <a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i> 
                    Cerrar Sesion
                </a> 
            </div>
        </div>  
        <div class="init">   
            <h3>Bienvenido(a),</h3>
            <h2><?php echo $_SESSION["nombre"]; ?></h2>
        </div>
        <!-- Contenidos de form -->
        <div class="tabs-content" style="margin: 50px auto; margin-top: 0px;">
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

            <!-- Verificar mostrar el contenido los botone de usuario mediante el user -->
            <?php if($rolUser === "Admin"){ ?>
            <a href="#" class="user" id="user">
                <i class="fas fa-user"></i><br>
                Usuarios
            </a>
            <a href="/usuario/listarUsuario.php" class="list-user">
                <i class="fas fa-list-alt"></i><br>
                Listar Usuarios
            </a>
            <?php } ?>
           
        </div>
    </div>
</body>
<script src="./js/app.js"></script>
<script src="/js/all.min.js"></script>

</html>
