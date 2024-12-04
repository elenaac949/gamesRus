<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'><!-- para usar los iconos de boicons -->
    <link rel="stylesheet" href="/gamesRus/css/frm_login.css">
</head>

<body>
    <div class="layout">
        <form action="#" method="post">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" name="usuario" id="usuario" placeholder="Introduce nick o correo" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="contrasenia" id="password" placeholder="Contraseña" required>
                <i class='bx bxs-lock-alt' ></i>
            </div>
            <div class="remember-forgot">
                <label>
                    <input type="checkbox"> Recuerdame
                </label>
                <a href="#">¿Olvidaste la contraseña?</a>
            </div>

            <input type="submit" value="Entrar" name="enviar" class="enviar">

            <div class="link-registro">
                <p>¿No tienes cuenta? <a href="#">Registrar</a> </p>
            </div>

        </form>

    </div>

</body>

</html>

<!-- de aqui hay que recoger el value del imput del usuario y en el cpnorolador validar
 si es el nick o el correo con una conexion a la base de datos
 
 Si es correcto nos devuelve al main con el header location 
 si no, dar error y renviar a la misma pagina con algo que te diga el error
 
 -->