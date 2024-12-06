<?php
/* require_once "modelo.php"
 */
require_once "vista.php";
require_once "bbdd.php";
include "./env/conf.env";



class Controlador
{
    private $modelo;

    private $action;

    private $data;

    public function __construct()
    {
        // $this->modelo= new Modelo();
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['irInicioSesion'])) {
                $this->action = 'login';
            }
        } else {
            $this->action = 'landing';
        }
    }

    public function Inicio()
    {
        // var_dump($this->action);
        switch ($this->action) {
            case 'login':
                Vista::MuestraLogin($this->data);
                break;
            case 'registro':
                Vista::MuestraRegistro($this->data);
                break;
            case 'landing':
                Vista::MuestraLanding();
                break;
            case 'biblioteca':
                $this->datosBiblioteca();
                Vista::MuestraBiblioteca($this->data);
                break;
        }
    }


    //quiero gurdar la sesion en el ordenador del  usuario con cookies
    /* private function recordarUsuario()
    {
        if (isset($_POST['recordar_usuario'])) { //si hemos marcado la casilla de recordarme creamos la cookie
            setcookie('usuario', $_SESSION['idUsuario'], time() + (30 * 24 * 60 * 60), "/");
        } else {
            if (isset($_COOKIE['usuario'])) { //si no esta marcada se borra
                setcookie('usuario', '', time() - 3600, "/");
            }
        }
    } */

    public function irAlRegistro()
    {
        $this->action = 'registro';
    }

    
    private function datosBiblioteca()
    {
        global $baseDatos;
        $idUsuario = $_SESSION['idUsuario'];
        $this->data = $baseDatos->mostrarBiblioteca($idUsuario);
    }
    public function verificarUsuario()
    {
        global $baseDatos;
        $usuario = trim($_POST['usuario']); // validamos el nombre de usuario, nick o contraseña
        $contrasenia = trim($_POST['contrasenia']);
        $usuarioCorrecto = $baseDatos->controlLogin($usuario);
        if ($usuarioCorrecto) {
            // Verificar la contraseña
            if (password_verify($contrasenia, $usuarioCorrecto['contrasenia'])) {
                $_SESSION['idUsuario'] = $usuarioCorrecto['idUsuario'];
                $this->action = 'biblioteca';
                return;
            } else {
                $this->data = 'Contraseña incorrecta';
            }
        } else {
            $this->data = 'Usuario no existe';
        }
        $this->action = 'login';
        return;
    }
}


$programa = new Controlador();


if (isset($_POST['loginUsuario'])) {
    $programa->verificarUsuario();
} elseif (isset($_POST['registroUsuario'])) {
    $programa->irAlRegistro();
}

$programa->Inicio();


/* if(isset($_POST['entrar'])){
    $programa->inicia();
} *///no se como hacer que se deje de llamar a la pagina de landing
/* $programa->inicia();

$programa->registra(); */

// Si enviamos las credenciales de usuario y contraseña


//Si registramos usuario nuevo
/* if (isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $nick = $_POST['nick'];
    $contrasenia = $_POST['contrasenia'];
    $contrasenia2 = $_POST['contrasenia2'];
} */
    // Validar si las contraseñas coinciden
   /*  if ($contrasenia === $contrasenia2) {
        // Hashear la contraseña
        $hashedPassword = password_hash($contrasenia, PASSWORD_DEFAULT); */

        // Registrar al usuario
/*         $baseDatos->registrarUsuario($nombre, $apellidos, $correo, $nick, $hashedPassword);
    } else {
        echo 'Las contraseñas no coinciden.';
    }
} */
