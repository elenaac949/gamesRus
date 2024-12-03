<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <label for="nombre">Nombre: 
           <input type="text" name="nombre" id="nombre" placeholder="Nombre"> 
        </label>
        <label for="apellidos" >Apellidos: 
            <input type="text" name="apellidos" id="apellidos" placeholder="Apellidos">
        </label>
        <label for="correo">Correo electrónico: 
            <input type="email" name="correo" id="correo" placeholder="Correo electrónico">
        </label>
        <label for="nick">Nick: 
            <input type="text" name="nick" id="nick" placeholder="Nombre de usuario">
        </label>
        <label for="contrasenia"> Contraseña:
            <input type="password" name="contrasenia" id="contrasenia" placeholder="Contraseña">
        </label>
        <label for="contrasenia2"> Confirma la contraseña:
            <input type="password" name="contrasenia2" id="contrasenia2" placeholder="Contraseña">
        </label>

        <input type="submit" name="registrar" value="Enviar">

    </form>
</body>
</html>