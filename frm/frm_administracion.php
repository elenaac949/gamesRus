<?php
include __DIR__ . '/../common/controlSesion.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador</title>
    <link rel="stylesheet" href="/gamesRus/css/general.css">
    <link rel="stylesheet" href="/gamesRus/css/frm_administracion.css">
</head>

<body>
    <?php
    include './common/cabecera.php';
    ?>

    <main>
        <aside class="">
            <form action="" method="post" name="elegir_accion_administrador">

                <!-- Le estamos pasando el parametro administrar para que en controlador nos cargue esta vista  NO TIENE QUE VER CON EL submit DE ADMINISTRAR se llaman igual porque con ese valor vamos a hacer la misma función, es decir, mostrar la vista de administrador-->
                <input type="hidden" name="administrar">
                <div>

                    <input type="submit" name="mostrar_anadir_juego" value="Nuevo Juego">
                </div>
                <div>
                    <input type="submit" name="boton" value="Eliminar">
                </div>
                <div>
                    <input type="submit" name="mostrar_editar_juego" value="Editar">
                </div>
            </form>
        </aside>
        <section>

            <p class="errores"><?= $error ?></p>
            <!-- si damos al boton de añadir juego se muestra el formulario correspondiente-->
            <?php if (isset($_POST['mostrar_anadir_juego'])) : ?>

                <h2>Datos Juego Nuevo</h2>

                <form action="#" id="buscador_juego">
                    <span>Busca un juego:</span>
                    <input type="text" name="buscar_juego" id="buscar_juego">
                    <input type="submit" value="Buscar">
                    <details>
                        <summary>Total resultados: <span id="total-resultados"></span></summary>
                        <ul id="lista_juegos">
                            <!-- Aquí se mostrarán los juegos que coincidan con la búsqueda -->

                        </ul>

                    </details>
                    <hr>
                </form>
                <form action="#" method="post" name="formulario_anadir_juego">
                    <input type="text" name="titulo_juego" placeholder="Título" id="titulo_juego">
                    <select name="genero_juego" id="genero_juego">
                        <option value="">Selecciona un género</option>
                        <?php foreach ($data as $genero) : ?>
                            <option value="<?= $genero['idGenero']; ?>"><?= $genero['genero']; ?></option>
                        <?php endforeach ?>
                    </select>
                    <input type="text" name="desarrollador_juego" placeholder="Desarrollador" id="desarrollador_juego">
                    <input type="text" name="distribuidor_juego" placeholder="Distribuidor" id="distribuidor_juego">
                    <input type="date" name="anio_lanzamiento" placeholder="Año" id="anio_lanzamiento">
                    <!-- <input type="text" name="ruta_juego" placeholder="Ruta" id="ruta_juego"> -->
                    <textarea name="descripcion_juego" placeholder="Descripción" id="descripcion_juego"></textarea>
                    <input type="text" name="portada_juego" placeholder="Portada" id="portada_juego">
                    <input type="submit" name="anadir-juego" value="Añadir Juego">

                </form>
            <?php endif ?>

            <!-- ELIMINAR LOS JUEGOS -->
            <?php if (isset($_POST['mostrar_eliminar_juego'])) : ?>
                <h2>Eliminar Juego</h2>
                <form action="" method="post" name="formulario_eliminar_juego">
                    <select name="nombre_juego">
                        <option value="">Selecciona un titulo</option>
                        <?php foreach ($data as $titulo) : ?>
                            <option value="<?= $titulo['titulo']; ?>"><?= $titulo['titulo']; ?></option>
                        <?php endforeach ?>
                    </select>
                    <input type="submit" name="eliminar-juego" value="Eliminar juego">
                </form>
            <?php endif ?>

            <!-- Editar los juegos -->
            <?php if (isset($_POST['mostrar_editar_juego'])) : ?>
                <h2>Editar juego</h2>
                <form action="" method="post" name="formulario_editar_juego">
                    <select name="idJuego">
                        <option value="">Selecciona un titulo</option>
                        <?php foreach ($data as $titulo) : ?>
                            <option value="<?= $titulo['idJuego']; ?>"><?= $titulo['titulo']; ?></option>
                        <?php endforeach ?>
                    </select>
                    
                   

                    <input type="text" name="desarrollador_juego" placeholder="Desarrollador" value="">
                    <input type="text" name="distribuidor_juego" placeholder="Distribuidor">
                    <input type="date" name="anio_lanzamiento" placeholder="Año">
                    <input type="text" name="portada_juego" placeholder="Portada" id="portada_juego">
                    <textarea name="descripcion_juego" placeholder="Descripción"></textarea>
                    <input type="submit" name="editar-juego" value="Editar Juego">


                </form>
            <?php endif ?>
        </section>

    </main>


    <?php
    include './common/footer.php';
    ?>
    <script>
        // Llama al proxy local para hacer la petición a la API de MobyGames
        (async () => {
            const formBuscar = document.querySelector("#buscador_juego");
            formBuscar.addEventListener("submit", async (e) => {
                e.preventDefault();
                const url = new URL(window.location.href);
                const titulo = document.querySelector("#buscar_juego").value;
                const mobyGamesUrl = new URL("https://api.mobygames.com/v1/games");
                mobyGamesUrl.searchParams.append("api_key", "moby_Ivjf8fphPEz3gLn9DVIcRsvNYgE");
                mobyGamesUrl.searchParams.append("title", titulo);
                url.searchParams.append("mobyGames", mobyGamesUrl.toString());
                const response = await fetch(url, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                    },
                });

                const data = await response.json();
                console.log(data.games);
                document.querySelector("#total-resultados").innerHTML = data.games.length;
                data.games.forEach((juego) => {
                    const li = document.createElement("li");
                    li.textContent = juego.title;
                    li.addEventListener("click", () => {
                        document.querySelector("#titulo_juego").value = juego.title;
                        markSelectedOptions(juego.genres[0].genre_name);
                        // document.querySelector("#genero_juego").value = juego.genres[0].genre_name
                        // document.querySelector("#desarrollador_juego").value = juego.developers[0].name;
                        // document.querySelector("#distribuidor_juego").value = juego.publishers[0].name;
                        // document.querySelector("#anio_lanzamiento").value = juego.platforms[0].first_release_date;
                        // document.querySelector("#ruta_juego").value = juego.url;
                        document.querySelector("#descripcion_juego").value = removeHTMLTags(juego.description);
                        document.querySelector("#portada_juego").value = juego.sample_cover.image;
                    });
                    document.querySelector("#lista_juegos").appendChild(li);
                });
            });
        })();

        function removeHTMLTags(htmlString) {
            const tempDiv = document.createElement("div");
            tempDiv.innerHTML = htmlString; // Asigna el string HTML al div temporal
            return tempDiv.textContent || tempDiv.innerText || ""; // Retorna el texto limpio
        }

        function markSelectedOptions(selectedGenre) {
            const selectElement = document.getElementById("genero_juego"); // Obtener el elemento <select>
            const options = selectElement.options; // Obtener todas las opciones

            for (let i = 0; i < options.length; i++) {
                const option = options[i];
                // Si el valor o texto coincide, marcar como seleccionado
                option.selected = selectedGenre.includes(option.textContent) || selectedGenre.includes(option.value);
            }
        }
    </script>
</body>

</html>