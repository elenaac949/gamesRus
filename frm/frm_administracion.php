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
    <header>
        <div class="titulo">
            <h1>GamesRus</h1>
            <p>Bienvenido <?php echo $_SESSION['nickUsuario'];  ?></p>
        </div>
        <nav>
            <form action="" method="post">
                <input type="text" class="buscardor" placeholder="Buscar...">
            </form>
            <form action="perfil" method="post">
                <a href="#"><img src="./img/usuario.png" alt="" srcset=""></a>
                <input type="submit" name="irAlPerfil" class="perfil" value="Perfil">
            </form>
            <form action="catalogo" method="post">
                <a href="#"><img src="./img/catalogo.png" alt="" srcset=""></a>
                <input type="submit" name="irAlCatalogo" class="catalogo" value="Catálogo">
            </form>
            <form action="biblioteca" method="post">
                <a href="#"><img src="./img/biblioteca.png" alt="" srcset=""></a>
                <input type="submit" name="irBiblioteca" class="biblioteca" value="Biblioteca">
            </form>
            <form action="carrito" method="post">
                <a href="#"><img src="./img/carro-de-la-compra.png" alt="" srcset=""></a>
                <input type="submit" name="irAlCarrito" class="carrito" value="Carrito">
            </form>
            <form action="#" method="post">
                <a href="#"><img src="./img/salir.png" alt="" srcset=""></a>
                <input type="submit" name="cerrar_sesion" class="salir" value="Cerrar Sesión">

            </form>
        </nav>
    </header>

    <main>
        <aside class="">
            <form action="" method="post" name="elegir_accion_administrador">
                <div>
                    <input type="submit" name="mostrar_anadir_juego" value="Nuevo Juego">
                </div>
                <div>
                    <input type="submit" name="mostrar_eliminar_juego" value="Eliminar Juego">
                </div>
                <div>
                    <input type="submit" name="mostrar_modificar_juego" value="Editar Juego">
                </div>
            </form>
        </aside>
        <section>
            <!-- aqui va el contenido -->
             <h2>Datos Juego Nuevo</h2>
             <form action="" method="post" name="formulario_anadir_juego">
                <input type="text" name="titulo_juego" placeholder="Título">
                <input type="text" name="desarrollador_juego" placeholder="Desarrollador">
                <input type="text" name="distribuidor_juego" placeholder="Distribuidor">
                <input type="date" name="anio_lanzamiento" placeholder="Año">
                <input type="text" name="ruta_juego" placeholder="Ruta">
                <textarea name="descripcion_juego" placeholder="Descripción"></textarea>
                <input type="submit" name="anadir-juego" value="Añadir Juego">
             </form>
        </section>

    </main>


    <footer>
        <div class="logo">
            <h3>GamesRus</h3>
        </div>
        <div class="redes_sociales">

        </div>
        <div class="mas_informacion">
            <a href="">Sobre Nosotras</a>
            <a href="">Autoras</a>
            <a href="">Terminos y Condiciones</a>
            <a href="">Política de Cookies</a>
        </div>
    </footer>
</body>

</html>