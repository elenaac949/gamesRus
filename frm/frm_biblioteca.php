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

    <?php /* var_dump($data)  */ ?>
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
                            <input type="submit" value="Detalles" id="btn_mostrar_detalles" name="btn_mostrar_detalles">
                            <input type="button" value="Jugar">
                            <input type="button" value="Prestar">
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


    </main>

    <dialog name="detalles_juego" id="detalles_juego">
        <?php
        include './frm/frm_detalles.php';
        ?>
    </dialog>

    <?php
    include './common/footer.php';
    ?>

    <script>
        let btn_detalles = document.querySelector("#btn_mostrar_detalles");
        btn_detalles.addEventListener("click", (e) => {
            e.preventDefault();
            let dialogo = document.querySelector("#detalles_juego");
            dialogo.show(); //muestra el dialogo
        });
//no funciona el salir
        let cerrar = document.querySelector("#cerrar_detalles");
        cerrar.addEventListener("click", (e) => {
            e.preventDefault();
            cerrar.close();
        });
    </script>
</body>

</html>