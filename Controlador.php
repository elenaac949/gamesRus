<?php
/* require_once "modelo.php"
 */
require_once "vista.php";
require_once "bbdd.php";
include "./env/conf.env";



class Controlador
{

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
            case 'administracion':
                $this->mostrarGeneros();
                Vista::MuestraAdministración($this->data);

                break;
        }
    }


    //Estamos trabajando en ello (No es requisito de Luis para esta entrega)
    //quiero gurdar la sesion en el ordenador del  usuario con cookies
    /*private function recordarUsuario()
    {
        if (isset($_POST['recordar_usuario'])) { //si hemos marcado la casilla de recordarme creamos la cookie
            setcookie('usuario', $_SESSION['idUsuario'], time() + (30 * 24 * 60 * 60), "/");
        } else {
            if (isset($_COOKIE['usuario'])) { //si no esta marcada se borra
                setcookie('usuario', '', time() - 3600, "/");
            }
        }
    }*/

    public function irAlRegistro()
    {
        $this->action = 'registro';
    }


    //Función que muestra la biblioteca - si eres admin muestra todo, si no muestra 
    private function datosBiblioteca()
    {
        global $baseDatos;
        if ($_SESSION['nickUsuario'] === 'admin') {
            $this->data = $baseDatos->mostrarJuegos();
        } else {
            $idUsuario = $_SESSION['idUsuario'];
            $this->data = $baseDatos->mostrarBiblioteca($idUsuario);
        }
    }




    public function verificarUsuario()
    {
        global $baseDatos;
        if ($_POST['usuario'] && $_POST['contrasenia'] != '') {

            $usuario = trim($_POST['usuario']); // validamos el nombre de usuario, nick o contraseña
            $contrasenia = trim($_POST['contrasenia']);
            $usuarioCorrecto = $baseDatos->controlLogin($usuario);
            if ($usuarioCorrecto) {
                // Verificar la contraseña
                if (password_verify($contrasenia, $usuarioCorrecto['contrasenia'])) {
                    $_SESSION['idUsuario'] = $usuarioCorrecto['idUsuario'];
                    $_SESSION['nickUsuario'] = $usuarioCorrecto['nick'];
                    $this->action = 'biblioteca';
                    return;
                } else {
                    $this->data = 'Contraseña incorrecta';
                }
            } else {
                $this->data = 'Usuario no existe';
            }
        }
        $this->action = 'login';
        return;
    }


    public function anadirUsuario()
    {
        global $baseDatos;

        if (!empty($_POST['nombre']) && !empty($_POST['apellidos']) && !empty($_POST['alias']) && !empty($_POST['correo']) && !empty($_POST['contrasenia1']) && !empty($_POST['contrasenia2']) && !empty($_POST['telefono'])) {
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $correo = $_POST['correo'];
            $nick = $_POST['alias'];
            $contrasenia1 = $_POST['contrasenia1'];
            $contrasenia2 = $_POST['contrasenia2'];
            $tipoDeVia = $_POST["tipo_via"];
            $nombreDeVia = $_POST['nombre_via'];
            $numero = $_POST['numero_via'];
            $numeroTelefono = $_POST['telefono'];

            $patron = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
            //Hacer una consulta a la bbdd que verifiqeu si ese email o nick existen
            if (!$baseDatos->verificarSiExisteUsuario($nick, $correo)) {
                $this->data = 'Correo o nick ya existentes';
                $this->action = 'registro';
            } else {
                if (preg_match($patron, $correo)) {
                    // Validar si las contraseñas coinciden
                    if ($contrasenia1 === $contrasenia2) {
                        // Hashear la contraseña
                        $hashedPassword = password_hash($contrasenia1, PASSWORD_DEFAULT);

                        // Registrar al usuario
                        $baseDatos->registrarUsuario($nombre, $apellidos, $correo, $nick, $hashedPassword, $tipoDeVia, $nombreDeVia, $numero, $numeroTelefono);
                        //Guardamos en cookie el nombre nick para pasarlo a l login (contraseña no por seguridad) - la cookie dura 5 mins
                        // setcookie('nick', $_POST['nick'], time() + (5 * 60), "/");
                        $this->data = 'Usuario registrado correctamente.';
                        $this->action = 'login';
                    } else {
                        $this->data = 'Las contraseñas no coinciden.';
                        $this->action = 'registro';
                    }
                } else {
                    $this->data = 'El correo electónico no es válido.';
                    $this->action = 'registro';
                }
            }
        } else {
            $this->data = 'Datos incompletos.';
            $this->action = 'registro';
        }
    }



    public function cerrarSesion()
    {
        session_destroy();
        $this->action = 'login';
        $this->data = 'Sesión cerrada';
    }



    public function irAlAdministrador(){
        $this->action='administracion';

    }

    public function mostrarGeneros(){
        global $baseDatos;
        $this->data=$baseDatos->accederGeneros();
    }
}


$programa = new Controlador();


if (isset($_POST['loginUsuario'])) {
    $programa->verificarUsuario();
} elseif (isset($_POST['irRegistro'])) {
    $programa->irAlRegistro();
} else if (isset($_POST['registroUsuario'])) {
    $programa->anadirUsuario();
}else if(isset($_POST['administrar'])){
    $programa->irAlAdministrador();
}

if (isset($_POST['cerrar_sesion'])) {
    $programa->cerrarSesion();
}

$programa->Inicio();
