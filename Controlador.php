<?php
require_once "vista.php";
// El modelo es bbdd
require_once "bbdd.php";
include "./env/conf.env";

class Controlador
{
    // Con action controlamos la navegación de páginas
    private $action;
    // Con data controlamos los mensajes y errores (Crear una para errores?)
    private $data;
    private $error;

    public function __construct()
    {
        // $this->modelo= new Modelo();
        session_start();
        $this->resolverAccion();
    }


    private function resolverAccion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['irInicioSesion'])){
                $this->action='login';
            }elseif (isset($_POST['loginUsuario'])) {
                $this->verificarUsuario();
            } elseif (isset($_POST['irRegistro'])) {
                $this->irAlRegistro();
            } elseif (isset($_POST['registroUsuario'])) {
                $this->anadirUsuario();
            } elseif (isset($_POST['cerrar_sesion'])) {
                $this->cerrarSesion();
            } elseif(isset($_POST['administrar'])){
                $this->action='administracion';
            }elseif (isset($_POST['mostrar_anadir_juego'])) {
                $this->action = 'administrar_nuevo_juego';
            } elseif (isset($_POST['mostrar_eliminar_juego'])) {
                $this->action = 'administrar_eliminar_juego';
            } elseif (isset($_POST['mostrar_editar_juego'])) {
                $this->action = 'administrar_editar_juego';
            }
        } else {
            $this->action = 'landing'; // Acción predeterminada en solicitudes GET
        }
    }

    public function Inicio()
    {
        // var_dump($this->action); // Para depuración si es necesario
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
                Vista::MuestraAdministración($this->data);
                break;
            case 'administrar_nuevo_juego':
                $this->mostrarGeneros();  // Llamar al método para obtener los géneros
                Vista::MuestraAdministración($this->data);
                break;
            case 'administrar_eliminar_juego':
                // Acción para mostrar el formulario de eliminar juego
                $this->mostrarLosJuegos();  // Cargar los juegos disponibles para eliminar
                Vista::MuestraAdministración($this->data);
                break;
            case 'administrar_editar_juego':
                // Acción para mostrar el formulario de editar juego
                $this->mostrarLosJuegos();  // Cargar los juegos disponibles para editar
                Vista::MuestraAdministración($this->data);
                break;
            default:
                Vista::MuestraLanding();  // Acción por defecto si no hay coincidencia
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


    //Función que muestra la biblioteca - si eres admin muestra todo, si no muestra los juegos del usuario
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



    // Función que verifica si el usuario se ha logeado bien
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


    // Función que registra a un usuario en el sistema (bbddd)
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

    // Función que cierra la sesión y redirge al login
    public function cerrarSesion()
    {
        session_destroy();
        $this->action = 'login';
        $this->data = 'Sesión cerrada';
    }

    // Función que te lleva al panel de administración
    public function irAlAdministrador()
    {
        $this->action = 'administracion';
    }

    // Función que muestra los géneros de los juegos
    public function mostrarGeneros()
    {
        global $baseDatos;
        $this->data = $baseDatos->accederGeneros();
    }

    public function mostrarLosJuegos()
    {
        global $baseDatos;
        $this->data = $baseDatos->mostrarJuegos();
    }

    //otra funcion para mostar titulos a eliminar y otra para modificar que se parezca a la decrear

    public function mostrarFormulario()
    {
        if (isset($_POST['mostrar_anadir_juego'])) {
            $this->mostrarGeneros();
        } else if (isset($_POST['mostrar_eliminar_juego'])) {
            $this->mostrarLosJuegos();
        } else if (isset($_POST['mostrar_editar_juego'])) {
            $this->mostrarLosJuegos();
        }
    }
}


// El programa en sí comienza aquí
$programa = new Controlador();
$programa->Inicio();
