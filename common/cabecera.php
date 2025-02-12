<header>
    <div class="titulo">
        <h1>GamesRus</h1>
        <p>Bienvenido <?php echo $_SESSION['nickUsuario'];  ?></p>
    </div>
    <nav>
        <div id="notificacion"></div>
        <form action="" method="post">
            <input type="text" class="buscardor" placeholder="Buscar...">
        </form>
        <form action="" method="post">
            <img src="./img/catalogo.png" alt="" srcset="">
            <input type="submit" name="irAlCatalogo" class="catalogo" value="Catálogo">
        </form>
        <form action="" method="post">
            <img src="./img/biblioteca.png" alt="" srcset="">
            <input type="submit" name="irBiblioteca" class="biblioteca" value="Biblioteca">
        </form>
        <form action="" method="post">
            <img src="./img/carro-de-la-compra.png" alt="" srcset="">
            <input type="submit" name="irAlCarrito" class="carrito" value="Carrito">
        </form>
        <div class="perfil-container">
            <form action="perfil" method="post" class="perfil-form">
                <img src="./img/usuario.png" alt="">
                <input type="button" name="irAlPerfil" class="perfil" value="Perfil">
            </form>
            <div class="desplegable">
                <form action="" method="post">
                    <input type="submit" name="verPerfil" class="verPerfil" value="Ver Perfil">
                </form>

                <form action="" method="post" class="boton_administrador" style="display: <?php if ($_SESSION['idUsuario'] != 4) {
                                                                                                echo 'none';
                                                                                            }  ?>;">
                    <!--  -->
                    <input type="submit" name="administrar" value="Administrar">
                </form>


                <form action="" method="post">
                    <input type="submit" name="cerrar_sesion" class="salir" value="Cerrar Sesión">
                </form>
            </div>
        </div>
    </nav>
</header>

<script>
    (async () => {

        const url = new URL(window.location.href);
        url.searchParams.append('ultimojuegoananido', '1')
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Acción cuando el documento esté listo:

                const notificacion = document.getElementById('notificacion')
                notificacion.innerHTML = xhttp.responseText;
                setTimeout(() => {
                    notificacion.style.display = 'none';
                }, 5000);
            }
        };
        xhttp.open("GET", url, true);
        xhttp.send();

    })();
</script>