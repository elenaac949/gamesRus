<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            /* c2a5df */
            background-color: #010002;
            background-image:
                repeating-linear-gradient(to right, transparent 0 100px,
                    #ffffff 100px 102px),
                repeating-linear-gradient(to bottom, transparent 0 100px,
                    #ffffff 100px 101px);
        }

        body::before {
            position: absolute;
            width: min(1400px, 90vw);
            top: 10%;
            left: 50%;
            height: 90%;
            transform: translateX(-50%);
            content: '';
            /* background-image: url(images/fondo.jpg); */
            background-size: 100%;
            background-repeat: no-repeat;
            background-position: top center;
            pointer-events: none;
        }
    </style>
    <link rel="stylesheet" href="/gamesRus/css/frm_landing.css">
</head>

<body>

    <div class="banner">
        <div class="slider" style="--quantity: 10">
            <div class="item" style="--position: 1"><img src="/gamesRus/img/juego1.jpg" alt=""></div>
            <div class="item" style="--position: 2"><img src="/gamesRus/img/juego2.jpg" alt=""></div>
            <div class="item" style="--position: 3"><img src="/gamesRus/img/juego3.jpg" alt=""></div>
            <div class="item" style="--position: 4"><img src="/gamesRus/img/juego4.jpg" alt=""></div>
            <div class="item" style="--position: 5"><img src="/gamesRus/img/juego5.jpg" alt=""></div>
            <div class="item" style="--position: 6"><img src="/gamesRus/img/juego6.jpg" alt=""></div>
            <div class="item" style="--position: 7"><img src="/gamesRus/img/juego7.jpg" alt=""></div>
            <div class="item" style="--position: 8"><img src="/gamesRus/img/juego8.jpg" alt=""></div>
            <div class="item" style="--position: 9"><img src="/gamesRus/img/juego9.jpg" alt=""></div>
            <div class="item" style="--position: 10"><img src="/gamesRus/img/juego10.jpg" alt=""></div>

        </div>
        <div class="content">
            <h1 data-content="GamesR`us">
                GamesR`us
            </h1>
            <div class="author">
                <form action="" method="post" class="styled-form">
                    <input type="submit" name="irInicioSesion" value="Entrar">
                </form>
                <!-- <h2>LUN DEV</h2>
                <p><b>Web Design</b></p>
                <p>
                    Subscribe to the channel to watch many interesting videos
                </p> -->
            </div>
            <!-- <div class="model"></div> -->
        </div>
    </div>

</body>

</html>