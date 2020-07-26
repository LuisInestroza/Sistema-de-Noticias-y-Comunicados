<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../logo.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
    <title>Listar Noticia - Municipalidad de Siguatepeque</title>
</head>
<body>
    <!-- Cabecera -->
    <div class="logo">
        <img src="../img/logo.png" alt="" srcset="">
    </div>
    <div class="escudo">
        <img src="../img/escudo.png" alt="" srcset="">
    </div>
    
   <div class="cabecera">
        <h1>Sistema de Registro de Noticias y Comunicados</h1>
   </div>
    <!-- Panel de acciones -->
   <div class="tabs">
       <div class="tabs-navegation">
           <div class="nav">
               <a href="../index.php">
                   <i class="fas fa-home"></i>
                   Home
                </a>
           </div>
           <div class="nav">
               <a href="/view/crearNoticia.php">
                    <i class="fas fa-newspaper"></i>
                    Noticias
                </a>
           </div>
           <div class="nav">
               <a href="/view/listarNoticia.php">
                    <i class="fas fa-list-alt"></i>
                    Listar Noticias
                </a>
           </div>
           <div class="nav">  
               <a href="/view/crearComunicado.php">
                    <i class="fas fa-file-alt"></i> 
                    Comunicados
                </a>
           </div>
           <div class="nav">
                <a href="/view/listarComunicados.php">
                    <i class="fas fa-list-alt"></i>
                    Listar Comunicados
                </a>
           </div>
           
            <div class="nav">
                <a href="../logout.php">
                    <i class="fas fa-sign-out-alt"></i> 
                    Cerrar Sesion
                </a> 
            </div>
             <!-- <div class="nav">
                <p>
                    Bienvenido(a) <br>
                    <?php //echo $_SESSION['nombre'];?>
                </p>
            </div> -->
            

           
        </div>  
    </div>
    <div id="segundo" class="single-tab" >
            
    </div>
  

    
</body>
</html>
