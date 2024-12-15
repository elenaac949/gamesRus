<?php
include __DIR__ . '/../controlSesion.php';
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

    <header>
        <div class="titulo">
            <h1>GamesRus</h1>
            <p>Bienvenido <?php echo $_SESSION['nickUsuario'];  ?></p>
        </div>
        <nav>
            <form action="" method="post">
                <input type="text" class="buscardor" placeholder="Buscar...">
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
            <div class="perfil-container">
                <form action="perfil" method="post" class="perfil-form">
                    <a href="#"><img src="./img/usuario.png" alt=""></a>
                    <input type="submit" name="irAlPerfil" class="perfil" value="Perfil">
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

    <?php /* var_dump($data)  */ ?>
    <main class="contenido_principal">
        <h2>Tus Juegos</h2>
        <div class="boton_administrador" style="display: <?php if ($_SESSION['idUsuario'] != 4) {
                                                                echo 'none';
                                                            }  ?>;">
            <form action="" method="post">
                <input type="submit" name="administrar" value="Administrar">
            </form>

        </div>
        <div class="vista_juegos">
            <?php foreach ($data as $juego): ?>
                <div class="juego">
                    <div class="imagen_juego">
                        <img src="https://placehold.co/200x100" alt="<?php echo $juego['titulo']; ?>">
                    </div>
                    <div class="nombre_juego">
                        <p><?php echo $juego['titulo']; ?></p>
                    </div>
                    <div class="botones_juego">
                        <form action="" method="post">
                            <input type="button" value="Detalles">
                            <input type="button" value="Jugar">
                            <input type="button" value="Prestar">
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


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