<header>
    <div class="titulo">
        <h1>GamesRus</h1>
        <p>Bienvenido <?php echo $_SESSION['nickUsuario']; ?></p>
    </div>
    <nav>
        <div id="notificacion"></div>
        
        <!-- Formulario de búsqueda -->
        <form action="" method="post">
            <input type="text" class="buscardor" placeholder="Buscar...">
        </form>
        
        <!-- Navegación a diferentes secciones -->
        <form action="" method="post">
            <img src="./img/catalogo.png" alt="Catálogo">
            <input type="submit" name="irAlCatalogo" class="catalogo" value="Catálogo">
        </form>
        <form action="" method="post">
            <img src="./img/biblioteca.png" alt="Biblioteca">
            <input type="submit" name="irBiblioteca" class="biblioteca" value="Biblioteca">
        </form>
        <form action="" method="post">
            <img src="./img/carro-de-la-compra.png" alt="Carrito">
            <input type="submit" name="irAlCarrito" class="carrito" value="Carrito">
        </form>
        
        <!-- Perfil de usuario -->
        <div class="perfil-container">
            <form action="perfil" method="post" class="perfil-form">
                <img src="./img/usuario.png" alt="Perfil">
                <input type="button" name="irAlPerfil" class="perfil" value="Perfil">
            </form>
            
            <!-- Menú desplegable de perfil -->
            <div class="desplegable">
                <form action="" method="post">
                    <input type="submit" name="verPerfil" class="verPerfil" value="Ver Perfil">
                </form>

                <!-- Botón de administración visible solo para administradores -->
                <form action="" method="post" class="boton_administrador" 
                    style="display: <?php if ($_SESSION['idUsuario'] != 4) { echo 'none'; } ?>;">
                    <input type="submit" name="administrar" value="Administrar">
                </form>
                
                <!-- Cerrar sesión -->
                <form action="" method="post">
                    <input type="submit" name="cerrar_sesion" class="salir" value="Cerrar Sesión">
                </form>
            </div>
        </div>
    </nav>
</header>

<script>
    /**
     * Script para mostrar una notificación temporal sobre el último juego añadido.
     * La notificación se oculta automáticamente después de 5 segundos.
     */
    (async () => {
        const url = new URL(window.location.href);
        url.searchParams.append('ultimojuegoananido', '1');
        
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const notificacion = document.getElementById('notificacion');
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
