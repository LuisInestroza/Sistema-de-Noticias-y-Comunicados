<div id="primero" class="single-tab" >
    <div class="center form-noticia">
        <h2>Ingresar Noticia</h2>
        <form action="" method="post" class="accion">
            <div class="txt_field panel">
                <input type="text" name="" id="" required>  
                <span></span>
                <label for="">Titulo de Noticia</label>
            </div>
            
            <div class="txt_field panel">
                <select name="" id="" required>
                    <option value="" disabled selected>Selecciona la categoria</option>
                    <option value="">Infraestructura</option>
                    <option value="">Sociales</option>
                    <option value="">Eventos</option>
                    <option value="">Economía</option>
                </select>
                

            </div>
            <div class="txt_field panel">
                <textarea name="" id="" cols="30" rows="10" required></textarea>
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