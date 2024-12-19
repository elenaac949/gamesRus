<h2>Eliminar Juego</h2>
<form action="" method="post" name="formulario_eliminar_juego">
    <select name="nombre_juego">
        <option value="">Selecciona un titulo</option>
        <?php foreach ($data as $titulo) : ?>
            <option value="<?= $titulo['titulo']; ?>"><?= $titulo['titulo']; ?></option>
        <?php endforeach ?>
    </select>
    <input type="submit" name="btn_eliminar_juego" value="Eliminar juego">
</form>
