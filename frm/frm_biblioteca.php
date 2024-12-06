<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
    <link rel="stylesheet" href="/gamesRus/css/frm_biblioteca.css">
</head>

<body>

    <header>
        <div class="titulo">
            <h1>GamesRus</h1>
            <p>Bienvenido <?php echo $_SESSION['idUsuario'];  ?></p>
        </div>
        <!-- <nav>
            <ul>
                <li>Perfil</li>
                <li>Catálogo</li>
                <li>Biblioteca</li>
                <li>Carrito</li>
                <li>Buscador</li>
                <li>Salir</li>
            </ul>
        </nav> -->
        <nav>
            <form action="" method="post">
                <input type="text" class="buscardor" placeholder="Bucar...">
                <input type="submit" name="irAlPerfil" class="perfil" value="Perfil">
                <input type="submit" name="irAlCatalogo" class="catalogo" value="Catálogo">
                <input type="submit" name="irBiblioteca" class="biblioteca" value="Biblioteca">
                <input type="submit" name="irAlCarrito" class="carrito" value="Carrito">
                <input type="submit" name="cerrar_sesion" class="salir" value="Cerrar Sesión">
            </form>
        </nav>
    </header>

    <?php /* var_dump($data)  */ ?>
    <main class="contenido_principal">
        <h2>Tus Juegos</h2>
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
        <div class="boton_administrador" style="display: <?php if ($_SESSION['idUsuario'] != 4) {
                                                                echo 'none';
                                                            }  ?>;">
            <form action="" method="post">
                <input type="submit" name="administrar" value="Administrar">
            </form>
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