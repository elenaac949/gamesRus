<header>
        <div class="titulo">
            <h1>GamesRus</h1>
            <p>Bienvenido <?php echo $_SESSION['nickUsuario'];  ?></p>
        </div>
        <nav>
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
                    <form action="#" method="post">
                        <img src="/img/salir.png" alt="">
                        <input type="submit" name="verPerfil" class="verPerfil" value="Ver Perfil">
                        <form action="#" method="post">
                            <img src="/img/usuario.png" alt="" srcset="">
                            <input type="submit" name="cerrar_sesion" class="salir" value="Cerrar Sesión">
                        </form>
                    </form>
                </div>
            </div>
        </nav>
    </header>