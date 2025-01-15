<?php
include __DIR__ . '/../common/controlSesion.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
    <link rel="stylesheet" href="/gamesRus/css/general.css">
    <link rel="stylesheet" href="/gamesRus/css/frm_biblioteca.css">
</head>

<body>

    <?php
    include './common/cabecera.php';
    ?>

    <?php /* var_dump($data) */  ?>
    <main class="contenido_principal">
        <h2>Tus Juegos</h2>
        <div class="boton_administrador" style="display: <?php if ($_SESSION['idUsuario'] != 4) {
                                                                echo 'none';
                                                            }  ?>;">
            <form action="" method="post">
                <!--  -->
                <input type="submit" name="administrar" value="Administrar">
            </form>

        </div>
        <div class="vista_juegos">
            <?php foreach ($data as $juego): ?>
                <div class="juego">
                    <div class="imagen_juego">
                        <img src="<?php echo $juego['portada'] ?? 'https://placehold.co/200x100' ?>" alt="<?php echo $juego['titulo']; ?>">
                    </div>
                    <div class="nombre_juego">
                        <p><?php echo $juego['titulo']; ?></p>

                    </div>
                    <div class="botones_juego">
                        <form action="" method="post">
                            <input type="hidden" value="<?php echo $juego['idJuego']; ?>" name="idJuegoCatalogo">
                            <input type="submit" value="Detalles" id="btn_mostrar_detalles" name="btn_mostrar_detalles">
                            <input type="button" value="Jugar">
                            <input type="submit" value="Prestar"
                                name="prestar">
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


    </main>

    <dialog name="detalles_juego" id="detalles_juego">
        <?php if (is_array($data1) && !empty($data1)): ?>
            <img src="<?php echo $data1[0]['portada'] ?? 'https://placehold.co/600x400'; ?>" alt="Imagen Portada Juego">
            <p>Título: <?php echo $data1[0]['titulo']; ?></p>
            <p>Desarrollador: <?php echo $data1[0]['desarrollador']; ?></p>
            <p>Distribuidor: <?php echo $data1[0]['distribuidor']; ?></p>
            <p>Año de Lanzamiento: <?php echo $data1[0]['anio']; ?></p>
            <p>Género(s): <?php echo $data1[0]['genero']; ?></p>
            <p>Descripción: <?php echo $data1[0]['descripcion']; ?></p>
        <?php else: ?>
            <p>No se encontraron detalles del juego.</p>
        <?php endif; ?>
        <button id="cerrar_detalles">Salir</button>
    </dialog>


    <?php
    include './common/footer.php';
    ?>

    <script>
        // botón para mostrar detalles
        let btn_detalles = document.querySelectorAll("#btn_mostrar_detalles");

        btn_detalles.forEach((btn) => {
            btn.addEventListener("click", (e) => {
                e.preventDefault();
                let dialogo = document.querySelector("#detalles_juego");
                dialogo.show();
            });
        });


        //botón para cerrar el diálogo
        let cerrar = document.querySelector("#cerrar_detalles");
        cerrar.addEventListener("click", (e) => {
            e.preventDefault();
            let dialogo = document.querySelector("#detalles_juego");
            dialogo.close(); // Cierra el diálogo
        });
    </script>

</body>

</html>