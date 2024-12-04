<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="layout">
        <form action="#" method="post">
            <input type="text" name="usuario" id="usuario" placeholder="Introduce nick o correo">
            <input type="password" name="contrasenia" id="password" placeholder="Contraseña">
            <input type="submit" value="Entrar" name="enviar">
        </form>


    </div>

</body>

</html>

<!-- de aqui hay que recoger el value del imput del usuario y en el cpnorolador validar
 si es el nick o el correo con una conexion a la base de datos
 
 Si es correcto nos devuelve al main con el header location 
 si no, dar error y renviar a la misma pagina con algo que te diga el error
 
 -->