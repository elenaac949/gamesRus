<?php
header("Access-Control-Allow-Origin: *"); // Permitir cualquier origen, permite utilizar CORS
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
    private $data1;
    private $error;

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
                $this->mostrarFormulario();
                Vista::MuestraAdministración($this->data, $this->error);
                break;
            case 'perfil':
                Vista::MuestraPerfil($this->data, $this->data1, $this->error);
                break;
            case 'catalogo':
                Vista::MuestraCatalogo($this->data, $this->data1, $this->error);
                break;
            case 'carrito':

                Vista::MuestraCarrito($this->data, $this->error, $this->data1);
                break;
            case 'prestar':
                Vista::MuestraPrestar($this->data, $this->error);
                break;
            case 'regalar':
                Vista::MuestraRegalar($this->data, $this->error);
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

    public function irABiblioteca()
    {
        $this->action = 'biblioteca';
    }

    public function irAlCatalogo()
    {
        global $baseDatos;
        $this->data = $baseDatos->mostrarJuegos();
        $this->action = 'catalogo';
    }

    public function irAlCarrito()
    {
        global $baseDatos;

        $idCarrito = $baseDatos->obtenerCarrito($_SESSION['idUsuario']);

        $this->data = $baseDatos->obtenerJuegosDelCarrito($idCarrito);
        $this->action = 'carrito';
    }

    // Función que te lleva al panel de administración
    public function irAlAdministrador()
    {
        $this->action = 'administracion';
    }

    public function irAlPerfil()
    {
        global $baseDatos;
        $this->data = $baseDatos->obtenerDatosUsuario();
        $this->data1 = $baseDatos->mostrarTarjetas($_SESSION['idUsuario']);
        $this->action = 'perfil';
    }

    // Funciones para manejar el préstamos de juegos
    public function irAPrestar()
    {
        $this->data = $_POST['idJuegoCatalogo'];
        $this->action = 'prestar';
    }

    // Función para regalar juegos
    public function irARegalar()
    {
        $this->data = $_POST['idJuegoCatalogo'];
        $this->action = 'regalar';
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
            if ($baseDatos->existeUsuario($nick, $correo)) {
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
                        $usuario = $baseDatos->controlLogin($correo);
                        //Creamos el carrito del usuario
                        //$baseDatos->crearCarrito($usuario['idUsuario']);

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


    // Función para mostrar Formularios de añadir, eliminar y editar
    public function mostrarFormulario()
    {
        if (isset($_POST['mostrar_anadir_juego'])) {
            $this->mostrarGeneros();
        } elseif (isset($_POST['mostrar_editar_juego'])) {
            $this->mostrarLosJuegos();
        } elseif (isset($_POST['mostrar_eliminar_juego'])) {
            $this->mostrarLosJuegos();
        }
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

    // Función para prestar juego a otro usuario
    public function prestarJuego()
    {

        if (!empty($_POST['idJuego']) && !empty($_POST['nombre-usuario'])) {
            global $baseDatos;
            $nick = $_POST['nombre-usuario'];
            $idJuego = $_POST['idJuego'];
            $idUsuarioPresta = $_SESSION['idUsuario'];
            $idUsuarioRecibe = $baseDatos->obtenerIdUsuario($nick);


            // var_dump($baseDatos->existeUsuario($nick, ''));
            if ($baseDatos->existeUsuario($nick, '')) {
                $baseDatos->agnadirPrestamos($idUsuarioPresta, $idUsuarioRecibe, $idJuego);
                $this->data = $baseDatos->mostrarJuegos();
                $this->data1 = 'Juego prestado correctamente';
                $this->action = 'catalogo';
            } else {
                $this->error = 'Error: El usuario ' . $nick . ' no existe';
                $this->action = 'prestar';
            }
        }
    }

    public function regalarJuego()
    {
        if (!empty($_POST['idJuego']) && !empty($_POST['nombre-usuario'])) {
            global $baseDatos;
            $nick = $_POST['nombre-usuario'];
            $idJuego = $_POST['idJuego'];
            $idUsuarioRegala = $_SESSION['idUsuario'];
            $idUsuarioRecibe = $baseDatos->obtenerIdUsuario($nick);

            





            var_dump($baseDatos->existeUsuario($nick, ''));
            if ($baseDatos->existeUsuario($nick, '')) {
                $baseDatos->agnadirRegalo($idUsuarioRegala, $idUsuarioRecibe, $idJuego);
                // $this->data = $baseDatos->mostrarJuegos();
                $this->data1 = 'Juego regalado correctamente';

               
            } else {
                $this->error = 'Error: El usuario ' . $nick . ' no existe';
            }
        } else {

            $this->error = 'No entra en el if';
        }
        $this->irAlCarrito();
    }



    public function actualizarDatosUsuario()
    {
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $correo = $_POST['correo'];
        $nick = $_POST['alias'];
        $tipoDeVia = $_POST["tipo_via"];
        $nombreDeVia = $_POST['nombre_via'];
        $numero = $_POST['numero_via'];
        $numeros = $_POST['numeros'];
        $otros = $_POST['otros'];
        $numeroTelefono = $_POST['telefono'];


        /* valdria comparar los datos introducidos con los dde la bbdd y si han cambiado cambiarlos */
        /* añadir un ifelse de exito */
        global $baseDatos;
        $this->data = $baseDatos->actualizarUsuario($nombre, $apellidos, $correo, $nick, $tipoDeVia, $nombreDeVia, $numero, $numeros, $otros, $numeroTelefono);
        $this->irAlPerfil();
    }

    public function eliminarCuentaUsuario()
    {
        global $baseDatos;
        if ($_SESSION['nickUsuario'] == "admin" || $_SESSION['nickUsuario'] == "usuario") {
            $this->error = "No puedes eliminar esta cuenta";
            $this->irAlPerfil();
            return;
        }
        $baseDatos->eliminarUsuario($_SESSION['nickUsuario']);
        $this->action = 'landing';
    }



    /* Tarjetas de usuario */


    public function anadirNuevaTarjeta()
    {
        if (!empty($_POST['numero_tarjeta']) && !empty($_POST['ccv_tarjeta']) && !empty($_POST['mes_cad_tarjeta']) && !empty($_POST['anio_cad_tarjeta'])) {
            $numeroTarjeta = $_POST['numero_tarjeta'];
            $ccv = $_POST['ccv_tarjeta'];

            $diaCad = 01; //para poder guardarlo en la base de datos
            $mesCad = intval($_POST['mes_cad_tarjeta']);
            $anioCad = intval($_POST['anio_cad_tarjeta']);

            $caducidad = $anioCad . "-" . $mesCad . "-" . $diaCad;
            global $baseDatos;

            // Validar el número de tarjeta con el algoritmo de Luhn
            if (!$this->esTarjetaValida($numeroTarjeta)) {
                $this->error = "El número de tarjeta es inválido.";
                $this->irAlPerfil();
                return;
            }

            // Validar CCV (debe ser un número de 3 o 4 dígitos)
            if (!preg_match('/^\d{3,4}$/', $ccv)) {
                $this->error = "El CCV debe contener 3 o 4 dígitos.";
                $this->irAlPerfil();
                return;
            }


            // Comprobar si ya existe una tarjeta con el mismo número y el mismo CCV para este usuario
            if ($baseDatos->tarjetaExiste($numeroTarjeta, $ccv, $_SESSION['idUsuario'])) {
                $this->error = "Ya tienes una tarjeta registrada con ese número y CCV.";
                $this->irAlPerfil();
                return;
            }

            // Validar que la tarjeta no esté vencida
            if (!$this->esFechaCaducidadValida($diaCad, $mesCad, $anioCad)) {
                $this->error = "La tarjeta está vencida.";
                $this->irAlPerfil();
                return;
            }


            $baseDatos->anadirTarjeta($numeroTarjeta, $ccv, $caducidad, $_SESSION['idUsuario']);
            $this->irAlPerfil();
        } else {
            $this->error = "Revisa la informacion";
        }

        $this->action = 'perfil';
    }

    private function esTarjetaValida($numero_tarjeta)
    {
        $numero_tarjeta = str_replace(' ', '', $numero_tarjeta); // Eliminar espacios
        if (!preg_match('/^\d{13,19}$/', $numero_tarjeta)) {
            return false; // La tarjeta debe contener entre 13 y 19 dígitos
        }

        $suma = 0;
        $alternar = false;
        for ($i = strlen($numero_tarjeta) - 1; $i >= 0; $i--) {
            $digito = intval($numero_tarjeta[$i]);
            if ($alternar) {
                $digito *= 2;
                if ($digito > 9) {
                    $digito -= 9;
                }
            }
            $suma += $digito;
            $alternar = !$alternar;
        }
        return ($suma % 10 === 0);
    }

    private function esFechaCaducidadValida($dia, $mes, $anio)
    {

        if ($anio < 100) {
            $anio += 2000; // Asumir siglo actual
        }

        // Fecha actual
        $dia_actual = intval(date('d'));
        $mes_actual = intval(date('m'));
        $anio_actual = intval(date('Y'));

        // Validar que no esté vencida
        if ($anio > $anio_actual) {
            return true;
        } elseif ($anio === $anio_actual) {
            if ($mes > $mes_actual) {
                return true;
            } elseif ($mes === $mes_actual) {
                return $dia >= $dia_actual;
            }
        }

        return false;
    }




    public function eliminarTarjeta()
    {
        if (isset($_POST['idTarjeta'])) {
            $idTarjeta = $_POST['idTarjeta'];

            global $baseDatos;
            $baseDatos->eliminarTarjeta($idTarjeta);

            $this->irAlPerfil();
        }
    }

    public function editarTarjeta()
    {
        if (!empty($_POST['ccv_tarjeta']) && !empty($_POST['mes_cad_tarjeta']) && !empty($_POST['anio_cad_tarjeta'])) {

            $ccv = $_POST['ccv_tarjeta'];

            $diaCad = 01; //para poder guardarlo en la base de datos
            $mesCad = intval($_POST['mes_cad_tarjeta']);
            $anioCad = intval($_POST['anio_cad_tarjeta']);

            $caducidad = $anioCad . "-" . $mesCad . "-" . $diaCad;
            global $baseDatos;



            // Validar CCV (debe ser un número de 3 o 4 dígitos)
            if (!preg_match('/^\d{3,4}$/', $ccv)) {
                $this->error = "El CCV debe contener 3 o 4 dígitos.";
                $this->irAlPerfil();
                return;
            }


            // Validar que la tarjeta no esté vencida
            if (!$this->esFechaCaducidadValida($diaCad, $mesCad, $anioCad)) {
                $this->error = "La tarjeta está vencida.";
                $this->irAlPerfil();
                return;
            }


            $baseDatos->editarTarjeta($ccv, $caducidad, $_SESSION['idUsuario']);
            $this->irAlPerfil();
        } else {
            $this->error = "Revisa la informacion";
        }

        $this->action = 'perfil';
    }



    /* JUEGOS */
    public function anadirNuevoJuego()
    {
        global $baseDatos;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validar campos obligatorios
            if (
                !empty($_POST['titulo_juego']) && !empty($_POST['genero_juego']) &&
                !empty($_POST['desarrollador_juego']) && !empty($_POST['distribuidor_juego']) &&
                !empty($_POST['anio_lanzamiento']) &&
                !empty($_POST['descripcion_juego'] && !empty($_POST['portada_juego']))
            ) {
                $titulo = $_POST['titulo_juego'];
                $generos = $_POST['genero_juego'];
                $desarrollador = $_POST['desarrollador_juego'];
                $distribuidor = $_POST['distribuidor_juego'];
                $lanzamiento = $_POST['anio_lanzamiento'];

                $descripcion = $_POST['descripcion_juego'];
                $portada = $_POST['portada_juego'];
                //falta una funcion para verificar si el juego existe ya
                //falta que se añada la descripcion y la portada
                $baseDatos->agregarJuego($titulo, $desarrollador, $distribuidor, $lanzamiento, $generos, $descripcion, $portada);
                $this->error = 'Juego añadido correctamente';
                $this->action = 'administracion';
            } else {
                $this->error = 'Datos incompletos.';
                $this->action = 'administracion';
            }
        }
    }
    //otra funcion para mostar titulos a eliminar y otra para modificar que se parezca a la decrear

    public function editarJuego()
    {
        global $baseDatos;
        if ($_SERVER["REQUEST_METHOD"]  == "POST") {
            // Validar campos obligatorios
            if (

                !empty($_POST['desarrollador_juego']) && !empty($_POST['distribuidor_juego']) &&
                !empty($_POST['anio_lanzamiento']) &&
                !empty($_POST['descripcion_juego'] && !empty($_POST['portada_juego'])) && !empty($_POST['idJuego'])
            ) {

                $desarrollador = $_POST['desarrollador_juego'];
                $distribuidor = $_POST['distribuidor_juego'];
                $lanzamiento = $_POST['anio_lanzamiento'];
                $descripcion = $_POST['descripcion_juego'];
                $portada = $_POST['portada_juego'];
                $idJuego = $_POST['idJuego'];
                //falta una funcion para verificar si el juego existe ya
                //falta que se añada la descripcion y la portada
                $baseDatos->editarJuego($idJuego, $desarrollador, $distribuidor, $lanzamiento, $portada, $descripcion);

                $this->error = 'Juego añadido correctamente';
                $this->action = 'administracion';
            } else {
                $this->error = 'Datos incompletos.';
                $this->action = 'administracion';
            }
        }
    }

    //Función eliminar juego
    public function eliminarJuego()
    {
        global $baseDatos;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validar campos obligatorios
            if (!empty($_POST['idJuego'])) {
                $idJuego = $_POST['idJuego'];
                $baseDatos->eliminarJuego($idJuego);
                $this->error = 'Juego eliminado correctamente';
                $this->action = 'administracion';
            } else {
                $this->error = 'Datos incompletos.';
                $this->action = 'administracion';
            }
        }
    }

    public function mobyGames($urlMobyGames)
    {
        echo file_get_contents($urlMobyGames);
        die();
    }





    /* Funciones para gestionar el carrito */
    public function anadirAlCarrito()
    {
        global $baseDatos;
        if (isset($_POST['idJuegoCatalogo'])) {
            $idJuego = $_POST['idJuegoCatalogo'];

            $idCarrito = $baseDatos->obtenerCarrito($_SESSION['idUsuario']);
            $existeJuego = $baseDatos->verificarJuegoEnCarrito($idCarrito, $idJuego);
            if ($existeJuego != true) {
                $this->error = $baseDatos->anadirJuegoAlCarrito($idCarrito, $idJuego);
            } else {
                $this->error = "El juego ya está en el carrito";
            }
            $this->irAlCatalogo();
        }
    }


    public function quitarDelCarrito()
    {
        global $baseDatos;

        if (isset($_POST['idJuegoCatalogo'])) {
            $idJuego = $_POST['idJuegoCatalogo'];
            $idCarrito = $baseDatos->obtenerCarrito($_SESSION['idUsuario']);

            // Verifica si obtenemos el carrito correctamente
            if ($idCarrito) {
                $this->error = $baseDatos->eliminarJuegoCarrito($idCarrito, $idJuego);
            } else {
                // Si no se encuentra el carrito
                $this->error = "Carrito no encontrado para el usuario.";
            }
        } else {
            $this->error = "ID del juego no recibido.";
        }

        // Redirige al carrito pero no redirige AAAAAAAAAAAAAAA
        $this->irAlCarrito();
    }

    /* Esta funcion está a medias todavia */
    public function pagarCompra()
    {
        global $baseDatos;
        $idCarrito = $baseDatos->obtenerCarrito($_SESSION['idUsuario']);
        $juegos = $baseDatos->obtenerJuegosDelCarrito($idCarrito);

        if (!empty($juegos)) {
            $this->error = $baseDatos->eliminarTodosLosJuegosCarrito($idCarrito);
        } else {
            $this->error = "No hay nada que pagar";
        }

        $this->irAlCarrito();
    }


    public function mostrarDetalles() {}
}
// El programa en sí comienza aquí
$programa = new Controlador();

// var_dump($_POST);
if (isset($_POST['loginUsuario'])) {
    $programa->verificarUsuario();
} elseif (isset($_POST['irRegistro'])) {
    $programa->irAlRegistro();
} elseif (isset($_POST['irAlCatalogo'])) {
    $programa->irAlCatalogo();
} elseif (isset($_POST['irAlCarrito'])) {
    $programa->irAlCarrito();
} elseif (isset($_POST['irBiblioteca'])) {
    $programa->irABiblioteca();
} else if (isset($_POST['registroUsuario'])) {
    $programa->anadirUsuario();
} else if (isset($_POST['administrar'])) {
    //Gracias al parametro administrar (pasado por submit desde biblioteca o por hidden en el mismo panel del administrador) nos muestra la vista de Administrador
    $programa->irAlAdministrador();
} else if (isset($_POST['anadir-juego'])) {
    $programa->anadirNuevoJuego();
} elseif (isset($_POST['editar-juego'])) {
    // var_dump('hola');
    $programa->editarJuego();
} elseif (isset($_POST['eliminar-juego'])) {
    $programa->eliminarJuego();
} elseif (isset($_POST['verPerfil'])) {
    $programa->irAlPerfil();
} elseif (isset($_POST['btn_actualizar_datos'])) {
    $programa->actualizarDatosUsuario();
} elseif (isset($_POST['btn_eliminar_cuenta'])) {
    $programa->eliminarCuentaUsuario();
} elseif (isset($_POST['btn_anadir_tarjeta'])) {
    $programa->anadirNuevaTarjeta();
} elseif (isset($_POST['btn_eliminar_tarjeta'])) {
    $programa->eliminarTarjeta();
} elseif (isset($_POST['btn_editar_tarjeta'])) {
    $programa->editarTarjeta();
} elseif (isset($_POST['btn_anadir_carrito'])) {
    $programa->anadirAlCarrito();
} elseif (isset($_POST['btn_eliminar_del_carrito'])) {
    $programa->quitarDelCarrito();
} elseif (isset($_POST['btn_pagar'])) {
    $programa->pagarCompra();
} elseif (isset($_POST['cerrar_sesion'])) {
    $programa->cerrarSesion();
} elseif (isset($_GET['mobyGames'])) {
    $programa->mobyGames($_GET['mobyGames']);
} elseif (isset($_POST['prestar'])) {
    $programa->irAPrestar();
} elseif (isset($_POST['prestar-juego'])) {
    $programa->prestarJuego();
    // } elseif (isset($_POST['btn_regalar_juego'])) {
    //     $programa->irARegalar();
} elseif (isset($_POST['btn_confirmar_regalo'])) {
    $programa->regalarJuego();
}

if (isset($_POST['btn_mostrar_detalles'])) {
    $programa->mostrarDetalles();
}

$programa->Inicio();
