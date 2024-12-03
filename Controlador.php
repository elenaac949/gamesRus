<?php
/* require_once "modelo.php"
 */
require_once "vista.php";
require_once "bbdd.php";

class Controlador
{
    public function __construct() {}

    public function inicia()
    {
        Vista::Inicio();
    }

    public function registra()
    {
        Vista::registro();
    }
}

$programa = new Controlador();

$programa->inicia();

$programa->registra();


if (isset($_POST['enviar'])) {
    $usuario = $_POST['usuario']; // validamos el nombre de usuario, nick o contraseña
    $contrasenia = $_POST['contrasenia'];
    echo $usuario . " " . $contrasenia;
    $baseDatos->controlLogin($usuario, $contrasenia);
}

if (isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $nick = $_POST['nick'];
    $contrasenia = $_POST['contrasenia'];
    $contrasenia2 = $_POST['contrasenia2'];

    // Validar si las contraseñas coinciden
    if ($contrasenia === $contrasenia2) {
        // Hashear la contraseña
        $hashedPassword = password_hash($contrasenia, PASSWORD_DEFAULT);

        // Registrar al usuario
        $baseDatos->registrarUsuario($nombre, $apellidos, $correo, $nick, $hashedPassword);
        echo 'Usuario registrado correctamente.';
    } else {
        echo 'Las contraseñas no coinciden.';
    }
}

