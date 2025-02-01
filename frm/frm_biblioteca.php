<?php
include __DIR__ . '/../common/controlSesion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // var_dump($data);
    //exit; // Detener la ejecución temporalmente para revisar los datos

    // var_dump($_POST);
}
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

    <h2>Tus Juegos</h2>
    <main class="contenido_principal">
    <p class="errores"><?= $error ?></p>
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
                        <form method="post">
                            <input type="hidden" value="<?php echo $juego['idJuego']; ?>" name="idJuegoCatalogo">
                            <input type="button" data-id="<?php echo $juego['idJuego']; ?>" value="Detalles" id="btn_mostrar_detalles" name="btn_mostrar_detalles">
                            <input type="button" value="Jugar">
                            <input type="submit" value="Prestar" name="prestar">
                        </form>
                        <form method="post">
                        <input type="hidden" value="<?php echo $juego['idJuego']; ?>" name="idJuegoCatalogo">
                            <input type="submit" value="Regalar" name="regalar">
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


    </main>

    <dialog name="detalles_juego" id="detalles_juego">

        <div id="contenido_detalles"></div>
        <?php
        // var_dump($_POST);
        //var_dump($data);
        // var_dump($error);
        //var_dump($data[0]);
        // echo "<br>";
        ?>
        <!-- <p>AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA</p> -->


        <button id="cerrar_detalles">Salir</button>
    </dialog>


    <?php
    include './common/footer.php';
    ?>

    <script>
        // Seleccionamos todos los botones
        let botones = document.querySelectorAll("#btn_mostrar_detalles");
        let dialogo = document.querySelector("#detalles_juego");
        let contenidoDetalles = document.querySelector("#contenido_detalles"); // Contenedor dinámico
        let cerrar = document.querySelector("#cerrar_detalles");

        // Añadimos el evento a cada botón
        botones.forEach(boton => {
            boton.addEventListener("click", (e) => {
                e.preventDefault();
                let idJuego = boton.getAttribute("data-id");

                // Accedemos a los datos del juego
                let juegos = <?php echo json_encode($data); ?>;
                console.log(juegos);
                let juegoSeleccionado = juegos.find(juego => juego.idJuego == idJuego);
                console.log(juegoSeleccionado); // el juego selecionado los detalles



                // Verificamos si el juego fue encontrado
                if (juegoSeleccionado) {
                    // Mostramos los datos del juego en el contenedor dinámico
                    contenidoDetalles.innerHTML = `
                    <h3>${juegoSeleccionado.titulo}</h3>
                    <img src="${juegoSeleccionado.portada}" alt="${juegoSeleccionado.titulo}">
                    <p>Descripción: ${juegoSeleccionado.descripcion}</p>                    
                    <p>Fecha de Lanzamiento: ${juegoSeleccionado.anio}</p>
                    <p>Género: ${juegoSeleccionado.generos}</p>
                    <p>Desarrollador: ${juegoSeleccionado.desarrollador}</p>
                    
                    <p>Sistemas: ${juegoSeleccionado.sistemas}</p>
                    
                `;
                } else {
                    contenidoDetalles.innerHTML = "<p>Juego no encontrado.</p>";
                }

                // Mostramos el diálogo
                dialogo.showModal();
            });
        });

        // Evento para cerrar el diálogo
        cerrar.addEventListener("click", () => {
            dialogo.close();
        });
    </script>

</body>

</html>