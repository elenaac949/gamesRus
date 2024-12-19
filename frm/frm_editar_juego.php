
<h2>Editar juego</h2>
<form action="" method="post" name="formulario_editar_juego">
    <select name="nombre_juego">
        <option value="">Selecciona un titulo</option>
        <?php foreach ($data as $titulo) : ?>
            <option value="<?= $titulo['titulo']; ?>"><?= $titulo['titulo']; ?></option>
        <?php endforeach ?>
    </select>

    <input type="text" name="desarrollador_juego" placeholder="Desarrollador" value="">
    <input type="text" name="distribuidor_juego" placeholder="Distribuidor">
    <input type="date" name="anio_lanzamiento" placeholder="Año">
    <input type="text" name="ruta_juego" placeholder="Ruta">
    <textarea name="descripcion_juego" placeholder="Descripción"></textarea>

</form>