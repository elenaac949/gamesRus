<h2>Datos Juego Nuevo</h2>
<form action="" method="post" name="formulario_anadir_juego">
    <input type="text" name="titulo_juego" placeholder="Título">

    <select name="genero_juego">
        <option value="">Selecciona un género</option>
        <?php
        // Mostramos los géneros disponibles, usando $data
        foreach ($data as $genero) {
            echo "<option value=\"{$genero['idGenero']}\">{$genero['genero']}</option>";
        }
        ?>
    </select>
    <input type="text" name="portada_juego" placeholder="Portada">
    <input type="text" name="desarrollador_juego" placeholder="Desarrollador">
    <input type="text" name="distribuidor_juego" placeholder="Distribuidor">
    <input type="date" name="anio_lanzamiento" placeholder="Año">
    <input type="text" name="ruta_juego" placeholder="Ruta">
    <textarea name="descripcion_juego" placeholder="Descripción"></textarea>
    <input type="submit" name="btn_anadir_juego" value="Añadir Juego">
</form>