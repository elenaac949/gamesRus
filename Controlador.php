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
    private $data2;
    private $data3;
    private $data4;
    private $error;

    public function __construct()
    {
        session_start();

        // Redirección inicial según el estado de sesión o parámetros iniciales
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['irInicioSesion'])) {
            Vista::MuestraLogin($this->data);
            exit; // Detenemos la ejecución tras redirigir.
        }

        // Mostrar la landing solo si no es una solicitud específica (ni POST ni GET)
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && empty($_GET)) {
            Vista::MuestraLanding();
            exit; // Detenemos la ejecución tras mostrar la página inicial.
        }
    }

    public function handlePost()
    {
        $accionesPost = [
            'loginUsuario' => 'verificarUsuario',
            'irRegistro' => 'irAlRegistro',
            'irAlCatalogo' => 'irAlCatalogo',
            'irAlCarrito' => 'irAlCarrito',
            'irBiblioteca' => 'irABiblioteca',
            'registroUsuario' => 'anadirUsuario',
            'administrar' => 'irAlAdministrador',
            'anadir-juego' => 'anadirNuevoJuego',
            'editar-juego' => 'editarJuego',
            'eliminar-juego' => 'eliminarJuego',
            'verPerfil' => 'irAlPerfil',
            'btn_actualizar_datos' => 'actualizarDatosUsuario',
            'btn_eliminar_cuenta' => 'eliminarCuentaUsuario',
            'btn_anadir_tarjeta' => 'anadirNuevaTarjeta',
            'btn_eliminar_tarjeta' => 'eliminarTarjeta',
            'btn_editar_tarjeta' => 'editarTarjeta',
            'btn_anadir_carrito' => 'agregarJuegoAlCarrito',
            'btn_eliminar_del_carrito' => 'eliminarJuegoDelCarrito',
            'btn_pagar' => 'irAlPago',
            'btn_confirmar_pago' => 'tramitarCompra',
            'cerrar_sesion' => 'cerrarSesion',
            'prestar' => 'irAPrestar',
            'prestar-juego' => 'prestarJuego',
            'regalar' => 'irARegalar',
            'btn_confirmar_regalo' => 'regalarJuegoBiblioteca',
            'mobyGames' => 'mobyGames',
            'btn_subir_archivo' => 'subirArchivos',
            'btn_filtrar_juegos' => 'filtrar',
            'btn_volver'=>'irABiblioteca'
        ];

        $this->procesarAcciones($_POST, $accionesPost);
    }

    private function procesarAcciones($datos, $acciones)
    {
        foreach ($acciones as $key => $metodo) {
            if (isset($datos[$key]) && method_exists($this, $metodo)) {
                // Ejecutamos la acción correspondiente
                if ($key === 'mobyGames') {
                    $this->$metodo($datos[$key]); // Pasar el parámetro para mobyGames
                } else {
                    $this->$metodo();
                }
                return; 
            }
        }

        $this->error="Se ha producido un error.";
        Vista::MuestraPaginaError($this->data, $this->error);
    }


    public function mostrarError()
    {
        Vista::MuestraPaginaError($this->data, $this->error);
    }



    public function mobyGames($urlMobyGames)
    {
        echo file_get_contents($urlMobyGames);
        die();
    }


    public function handleGet()
    {
        $accionesGet = [
            'mobyGames' => 'mobyGames',
            'ultimojuegoananido' => 'obtenerUltimoJuego'
        ];
        $this->procesarAcciones($_GET, $accionesGet);
    }

   

    public function irAlRegistro()
    {
        // $this->action = 'registro';
        Vista::MuestraRegistro($this->data);
    }

    public function irABiblioteca()
    {
        if (isset($_POST['btn_mostrar_detalles'])) {
            $this->mostrarDetalles();
        } else {
            $this->finalizarPrestamo();
            $this->datosBiblioteca();
        }

        Vista::MuestraBiblioteca($this->data, $this->data1, $this->error);
        //$this->action = 'biblioteca';
    }

    //Función que muestra la biblioteca - si eres admin muestra todo, si no muestra los juegos del usuario
    private function datosBiblioteca()
    {
        global $baseDatos;
        // if ($_SESSION['nickUsuario'] === 'admin') {
        //     $this->data = $baseDatos->mostrarJuegos();
        // } else {
        $idUsuario = $_SESSION['idUsuario'];
        $this->data = $baseDatos->mostrarBiblioteca($idUsuario);
        // }
    }


    public function mostrarDetalles()
    {

        global $baseDatos;
        if (isset($_POST['idJuegoCatalogo'])) {
            $idJuego = intval($_POST['idJuegoCatalogo']);
            $this->data1 = $baseDatos->obtenerDatosJuegoConGenero($idJuego);

            if (!$this->data1) {
                $this->data1 = "No se encontraron detalles para el ID proporcionado.";
            }
            exit;
        } else {
            $this->data1 = "ID del juego no proporcionado.";
        }
    }


    public function irAlCatalogo()
    {
        global $baseDatos;
        $this->data = $baseDatos->mostrarJuegos();
        $this->data2 = $baseDatos->accederGeneros();
        $this->data3 = $baseDatos->accederSistemas();
        $this->data4 = $baseDatos->obtenerAnioJuego();
        /* var_dump($this->data4); */
        /* var_dump($_SESSION); */
        //$this->action = 'catalogo';
        Vista::MuestraCatalogo($this->data, $this->data1, $this->data2, $this->data3, $this->data4, $this->error);
    }

    public function irAlCarrito()
    {
        global $baseDatos;
        $this->sincronizarCarrito();
        $idCarrito = $baseDatos->obtenerCarrito($_SESSION['idUsuario']);
        $this->data = $baseDatos->obtenerJuegosDelCarrito($idCarrito);

        Vista::MuestraCarrito($this->data, $this->error, $this->data1);
    }


    // Función que te lleva al panel de administración
    public function irAlAdministrador()
    {
        $this->mostrarFormulario();
        Vista::MuestraAdministración($this->data, $this->data1, $this->error);
    }

    public function irAlPerfil()
    {
        global $baseDatos;
        $this->data = $baseDatos->obtenerDatosUsuario();
        $this->data1 = $baseDatos->mostrarTarjetas($_SESSION['idUsuario']);

        Vista::MuestraPerfil($this->data, $this->data1, $this->error);
    }

    // Funciones para manejar el préstamos de juegos
    public function irAPrestar()
    {
        if (isset($_POST['idJuegoCatalogo'])) {
            $idJuego =  intval($_POST['idJuegoCatalogo']);
            global $baseDatos;
            $this->data = $baseDatos->obtenerDatosJuegoConGenero($idJuego);
        }
        //$this->action = 'prestar';
        Vista::MuestraPrestar($this->data, $this->error);
    }

    public function irARegalar()
    {
        if (isset($_POST['idJuegoCatalogo'])) {
            $idJuego =  intval($_POST['idJuegoCatalogo']);
            global $baseDatos;
            $this->data = $baseDatos->obtenerDatosJuegoConGenero($idJuego);
        }
        //$this->action = 'prestar';
        Vista::MuestraRegalar($this->data, $this->error);
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
                    $this->irABiblioteca();/* cambio */
                    return;
                } else {
                    $this->data = 'Contraseña incorrecta';
                }
            } else {
                $this->data = 'Usuario no existe';
            }
        }
        //$this->action = 'login';
        /*  $this->sincronizarCarrito(); */
        Vista::MuestraLogin($this->data);
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
            $numeros = $_POST['numeros'];
            $otros = $_POST['otros'];
            $numeroTelefono = $_POST['telefono'];

            $patron = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
            //Hacer una consulta a la bbdd que verifiqeu si ese email o nick existen
            if ($baseDatos->existeUsuario($nick, $correo)) {
                $this->data = 'Correo o nick ya existentes';
                Vista::MuestraRegistro($this->data);
            } else {
                if (preg_match($patron, $correo)) {
                    // Validar si las contraseñas coinciden
                    if ($contrasenia1 === $contrasenia2) {
                        // Hashear la contraseña
                        $hashedPassword = password_hash($contrasenia1, PASSWORD_DEFAULT);

                        // Registrar al usuario
                        $baseDatos->registrarUsuario($nombre, $apellidos, $correo, $nick, $hashedPassword, $tipoDeVia, $nombreDeVia, $numero, $numeros, $otros, $numeroTelefono);
                        //Guardamos en cookie el nombre nick para pasarlo a l login (contraseña no por seguridad) - la cookie dura 5 mins
                        // setcookie('nick', $_POST['nick'], time() + (5 * 60), "/");
                        $usuario = $baseDatos->controlLogin($correo);
                        //Creamos el carrito del usuario
                        //$baseDatos->crearCarrito($usuario['idUsuario']);

                        $this->data = 'Usuario registrado correctamente.';
                        //$this->action = 'login';
                        Vista::MuestraLogin($this->data);
                    } else {
                        $this->data = 'Las contraseñas no coinciden.';
                        //$this->action = 'registro';
                        Vista::MuestraRegistro($this->data);
                    }
                } else {
                    $this->data = 'El correo electónico no es válido.';
                    // $this->action = 'registro';
                    Vista::MuestraRegistro($this->data);
                }
            }
        } else {
            $this->data = 'Datos incompletos.';
            Vista::MuestraRegistro($this->data);
            //$this->action = 'registro';
        }
    }

    // Función que cierra la sesión y redirge al login
    public function cerrarSesion()
    {
        session_destroy();
        //$this->action = 'login';
        $this->data = 'Sesión cerrada';
        Vista::MuestraLogin($this->data);
    }


    // Función para mostrar Formularios de añadir, eliminar y editar
    public function mostrarFormulario()
    {
        if (isset($_POST['mostrar_anadir_juego'])) {
            $this->mostrarGeneros();
            $this->mostrarSistemas();
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

    // Función que muestra los sistemas de los juegos

    public function mostrarSistemas()
    {
        global $baseDatos;
        $this->data1 = $baseDatos->accederSistemas();
    }

    public function mostrarFechas()
    {
        global $baseDatos;
        $this->data4 = $baseDatos->obtenerAnioJuego();
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
                if ($idUsuarioPresta != $idUsuarioRecibe) {
                    /* Aqui hay que añadir el juego a la biblioteca del usuario 2 y quitarla de la biblioteca del 1 */
                    $prestado = $baseDatos->agnadirJuegoPrestado($idUsuarioRecibe, $idJuego); //esta funcion devuelve true si se añade correctamente el juego al usuario que lo recibe
                    $eliminado = $baseDatos->eliminarJuegoPrestado($idUsuarioPresta, $idJuego);
                    if ($prestado && $eliminado) {
                        $baseDatos->agnadirPrestamos($idUsuarioPresta, $idUsuarioRecibe, $idJuego);/* tabla prestado */
                        $baseDatos->actualizarJuegosPrestadosRegalados($idJuego, $idUsuarioPresta, $idUsuarioRecibe); /* tabla comprado */
                    }
                    //$this->data = $baseDatos->mostrarJuegos();
                    $this->error = 'Juego prestado correctamente';
                    //$this->action = 'catalogo';
                    //Vista::MuestraCatalogo($this->data, $this->data1, $this->data2, $this->data3, $this->error);
                } else {
                    $this->error = "No te ppuedes prestar a ti mismo subnormal";
                }
                $this->irABiblioteca();
            } else {
                $this->error = 'Error: El usuario ' . $nick . ' no existe';
                Vista::MuestraPrestar($this->data, $this->error);
            }
        }
    }

    public function finalizarPrestamo()
    {
        global $baseDatos;
        // Obtener los préstamos vencidos con todos sus detalles
        $prestamosVencidos = $baseDatos->obtenerPrestamosVencidos();
        //var_dump($prestamosVencidos);

        if (!empty($prestamosVencidos)) {
            foreach ($prestamosVencidos as $prestamo) {
                $idPrestamo = $prestamo['idPrestamo'];
                $idUsuarioPresta = $prestamo['idUsuarioPresta'];
                $idUsuarioRecibe = $prestamo['idUsuarioRecibe'];
                $idJuego = $prestamo['idJuego'];
                /* elimianr el juego rpestado de poseejuego */
                $baseDatos->agnadirJuegoPrestado($idUsuarioRecibe, $idJuego);
                $baseDatos->eliminarJuegoPrestado($idUsuarioRecibe, $idJuego);

                /* eliminar el prestamo en la tabla prestamos */
                $baseDatos->eliminarPrestamo($idPrestamo);
                /* misma funcion que antes pero al reves, ya que el que recibe devuelve el juego */
                $baseDatos->actualizarJuegosPrestadosRegalados($idJuego, $idUsuarioRecibe, $idUsuarioPresta);
            }
            $this->error = "Préstamos finalizados.";
        }
    }

    public function regalarJuegoBiblioteca()
    {
        global $baseDatos;
        if (!empty($_POST['idJuego']) && !empty($_POST['nombre-usuario'])) {

            $nick = $_POST['nombre-usuario'];
            $idJuego = $_POST['idJuego'];
            $idUsuarioRegala = $_SESSION['idUsuario'];
            $idUsuarioRecibe = $baseDatos->obtenerIdUsuario($nick);


            if ($baseDatos->existeUsuario($nick, '')) {
                if ($idUsuarioRegala != $idUsuarioRecibe) {
                    $baseDatos->agnadirRegalo($idUsuarioRegala, $idUsuarioRecibe, $idJuego);
                    $baseDatos->actualizarJuegosPrestadosRegalados($idJuego, $idUsuarioRegala, $idUsuarioRecibe);
                    $this->data1 = 'Regalo para ' . $nick;
                } else {
                    $this->error = "Prueba otra vez";
                }
            } else {
                $this->error = 'Error: El usuario ' . $nick . ' no existe';
            }
        }
        $this->irABiblioteca();
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
        //$this->action = 'landing';
        Vista::MuestraLanding();
    }

    /* Tarjetas de usuario */

    public function comprobarDireccion()
    {
        if (isset($_POST['perfil'])) {
            $this->irAlPerfil();
        } elseif (isset($_POST['pago'])) {
            $this->irAlPago();
        }
    }

    /* Tarjetas */

    public function anadirNuevaTarjeta()
    {
        if (!empty($_POST['numero_tarjeta']) && !empty($_POST['mes_cad_tarjeta']) && !empty($_POST['anio_cad_tarjeta'])) {

            $numeroTarjeta = $_POST['numero_tarjeta'];
            $ccv = $_POST['ccv_tarjeta'];
            $diaCad = 01; //para poder guardarlo en la base de datos
            $mesCad = intval($_POST['mes_cad_tarjeta']);
            $anioCad = intval($_POST['anio_cad_tarjeta']);
            $caducidad = $anioCad . "-" . $mesCad . "-" . $diaCad;

            global $baseDatos;

            $url = 'http://localhost/gamesRus/servidorSOAP.php';
            $uri = 'http://localhost/gamesRus/';

            try {
                $cliente = new SoapClient(null, array(
                    'location' => $url,
                    'uri'      => $uri
                ));

                // Validación del número de tarjeta
                $numeroValido = $cliente->esTarjetaValida($numeroTarjeta);
                if (!$numeroValido) {
                    $this->error = "El número de tarjeta es inválido.";
                    $this->comprobarDireccion();
                    return;
                }

                // Validación de la fecha de caducidad
                $fechaValida = $cliente->esFechaCaducidadValida($diaCad, $mesCad, $anioCad);
                if (!$fechaValida) {
                    $this->error = "La fecha de caducidad es inválida.";
                    $this->comprobarDireccion();
                    return;
                }

                // Validación del CCV
                $ccvValido = $cliente->validarCcv($ccv);
                if (!$ccvValido) {
                    $this->error = "El CCV es inválido. Debe contener 3 o 4 dígitos.";
                    $this->comprobarDireccion();
                    return;
                }

                // Comprobar si ya existe una tarjeta con el mismo número y el mismo CCV para este usuario
                if ($baseDatos->tarjetaExiste($numeroTarjeta, $caducidad, $_SESSION['idUsuario'])) {
                    $this->error = "Ya tienes esta tarjeta registrada.";
                    $this->comprobarDireccion();
                    return;
                }
                // Si todo es válido
                $baseDatos->anadirTarjeta($numeroTarjeta, $caducidad, $_SESSION['idUsuario']);
                $this->error = "Tarjeta añadida correctamente.";
            } catch (SoapFault $e) {
                $this->error = "<p>Error en la validación de la tarjeta: " . $e->getMessage() . "</p>";
            }
        } else {
            $this->error = "Todos los campos son obligatorios.";
        }
        $this->comprobarDireccion();
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
        if (!empty($_POST['numeroTarjeta']) && !empty($_POST['mes_cad_tarjeta']) && !empty($_POST['anio_cad_tarjeta'])) {
            $numeroTarjeta = $_POST['numeroTarjeta'];

            $diaCad = 01; //para poder guardarlo en la base de datos
            $mesCad = intval($_POST['mes_cad_tarjeta']);
            $anioCad = intval($_POST['anio_cad_tarjeta']);
            $caducidad = implode("-", [$anioCad, $mesCad, $diaCad]);
            global $baseDatos;

            $url = 'http://localhost/gamesRus/servidorSOAP.php';
            $uri = 'http://localhost/gamesRus/';

            try {
                $cliente = new SoapClient(null, array(
                    'location' => $url,
                    'uri'      => $uri
                ));

                // Validación del número de tarjeta
                $numeroValido = $cliente->esTarjetaValida($numeroTarjeta);
                if (!$numeroValido) {
                    $this->error = "El número de tarjeta es inválido.";
                    return;
                }

                // Validación de la fecha de caducidad
                $fechaValida = $cliente->esFechaCaducidadValida($diaCad, $mesCad, $anioCad);
                if (!$fechaValida) {
                    $this->error = "La fecha de caducidad es inválida.";
                    return;
                }

                // Comprobar si ya existe una tarjeta con el mismo número y el mismo CCV para este usuario
                if ($baseDatos->tarjetaExiste($numeroTarjeta, $caducidad, $_SESSION['idUsuario'])) {
                    $this->error = "Ya tienes una tarjeta registrada con ese número.";
                    return;
                }

                // Si todo es válido
                $baseDatos->editarTarjeta($numeroTarjeta, $caducidad, $_SESSION['idUsuario']);
                $this->error = "Tarjeta editada correctamente.";
            } catch (SoapFault $e) {
                $this->error = "<p>Error en la validación de la tarjeta: " . $e->getMessage() . "</p>";
            }
        } else {
            $this->error = "Revisa la informacion";
        }
        $this->irAlPerfil();
    }

    /* JUEGOS */

    public function anadirNuevoJuego()
    {

        var_dump($_POST);
        global $baseDatos;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validar campos obligatorios
            if (
                !empty($_POST['titulo_juego']) && !empty($_POST['genero_juego']) &&
                !empty($_POST['sistema_juego'])  && !empty($_POST['portada_juego'])
            ) {
                $titulo = $_POST['titulo_juego'];
                $generos = $_POST['genero_juego'];
                $desarrollador = $_POST['desarrollador_juego'] ?? "Sin desarrollador";
                $lanzamiento = $_POST['anio_lanzamiento'] ?? "2024";
                $descripcion = $_POST['descripcion_juego'] ?? "Sin descripción";
                $portada = $_POST['portada_juego'];
                $ruta = $_POST['ruta_juego'] ?? "Sin ruta";
                $sistemas = $_POST['sistema_juego'];
                $precio = !empty($_POST['precio_juego']) ? floatval($_POST['precio_juego']) : 15.99; //si no se añade un precio se pone el de ejemplo

                //falta una funcion para verificar si el juego existe ya
                //falta que se añada la descripcion y la portada
                $baseDatos->agregarJuego($titulo, $desarrollador, $lanzamiento, $generos, $sistemas, $ruta, $descripcion, $portada, $precio);
                $this->error = 'Juego añadido correctamente';
            } else {
                $this->error = 'Datos incompletos.';
            }
            $this->mostrarFormulario();
            Vista::MuestraAdministración($this->data, $this->data1, $this->error);
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
                $precio = !empty($_POST['precio_juego']) ? floatval($_POST['precio_juego']) : 15.99; //si no se añade un precio se pone el de ejemplo

                //falta una funcion para verificar si el juego existe ya
                //falta que se añada la descripcion y la portada
                $baseDatos->editarJuego($idJuego, $desarrollador, $distribuidor, $lanzamiento, $portada, $descripcion, $precio);

                $this->error = 'Juego añadido correctamente';
                //$this->action = 'administracion';
            } else {
                $this->error = 'Datos incompletos.';
                //$this->action = 'administracion';
            }
            $this->mostrarFormulario();
            Vista::MuestraAdministración($this->data, $this->data1, $this->error);
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
                //$this->action = 'administracion';
            } else {
                $this->error = 'Datos incompletos.';
                //$this->action = 'administracion';
            }
            $this->mostrarFormulario();
            Vista::MuestraAdministración($this->data, $this->data1, $this->error);
        }
    }

    /* Funciones para gestionar el carrito */

    public function sincronizarCarrito()
    {
        if (!isset($_SESSION['idUsuario'])) {
            return;
        }

        global $baseDatos;
        $idCarrito = $baseDatos->obtenerCarrito($_SESSION['idUsuario']);

        // Obtener los juegos del carrito en la base de datos
        $juegosDB = $baseDatos->obtenerJuegosDelCarrito($idCarrito);

        // Inicializar la estructura de carrito si no existe
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // Agregar los juegos de la base de datos al carrito en sesión si no están ya agregados
        foreach ($juegosDB as $juego) {
            $_SESSION['carrito'][$juego['idJuego']] = $_SESSION['carrito'][$juego['idJuego']] ?? [
                'titulo' => $juego['titulo'],
                'desarrollador' => $juego['desarrollador'],
                'distribuidor' => $juego['distribuidor'],
                'anio' => $juego['anio'],
                'ruta' => $juego['ruta'],
                'descripcion' => $juego['descripcion'],
                'portada' => $juego['portada'],
                'precio' => $juego['precio']
            ];
        }
    }


    public function agregarJuegoAlCarrito()
    {
        global $baseDatos;
        // Verificar si el juego ya está en el carrito de la sesión
        if (isset($_POST['idJuegoCatalogo'])) {
            $idJuego = $_POST['idJuegoCatalogo'];
            $idCarrito = $baseDatos->obtenerCarrito($_SESSION['idUsuario']);

            $existeJuego = $baseDatos->verificarJuegoEnCarrito($idCarrito, $idJuego);
            if (!$existeJuego) {
                // Obtener los datos del juego desde la base de datos para agregarlo a la sesión
                $juego = $baseDatos->obtenerJuegoPorId($idJuego);  // Método que debes añadir al modelo

                // Agregar el juego a la sesión
                $_SESSION['carrito'][$idJuego] = [
                    'titulo' => $juego['titulo'],
                    'desarrollador' => $juego['desarrollador'],
                    'distribuidor' => $juego['distribuidor'],
                    'anio' => $juego['anio'],
                    'ruta' => $juego['ruta'],
                    'descripcion' => $juego['descripcion'],
                    'portada' => $juego['portada'],
                    'precio' => $juego['precio']
                ];

                // También lo agregamos a la base de datos
                $baseDatos->agregarJuegoAlCarrito($idCarrito, $idJuego);
                $this->error = "Juego agregado al carrito.";
            } else {
                $this->error = "El juego ya está en el carrito.";
            }
            /* var_dump($_SESSION); */
            $this->irAlCatalogo();
        }
    }


    public function eliminarJuegoDelCarrito()
    {

        global $baseDatos;

        if (isset($_POST['idJuegoCatalogo'])) {
            $idJuego = $_POST['idJuegoCatalogo'];
            $idCarrito = $baseDatos->obtenerCarrito($_SESSION['idUsuario']);

            if (isset($_SESSION['carrito'][$idJuego])) {
                // Eliminar el juego de la sesión
                unset($_SESSION['carrito'][$idJuego]);

                //Eliminamos el juego de la bbdd
                $baseDatos->eliminarJuegoDelCarrito($idCarrito, $idJuego);

                $this->error = "Juego eliminado del carrito.";
            } else {
                $this->error = "El juego no está en el carrito.";
            }
            $this->irAlCatalogo();
        }
    }

    /* public function anadirAlCarrito()
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
    } */


    /* public function quitarDelCarrito()
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
        $this->irAlCarrito();
    } */



    public function reegalarJuegoBiblioteca()
    {
        global $baseDatos;
        if (!empty($_POST['idJuego']) && !empty($_POST['nombre-usuario'])) {

            $nick = $_POST['nombre-usuario'];
            $idJuego = $_POST['idJuego'];
            $idUsuarioRegala = $_SESSION['idUsuario'];
            $idUsuarioRecibe = $baseDatos->obtenerIdUsuario($nick);


            if ($baseDatos->existeUsuario($nick, '')) {
                if ($idUsuarioRegala != $idUsuarioRecibe) {
                    $baseDatos->agnadirRegalo($idUsuarioRegala, $idUsuarioRecibe, $idJuego);
                    $baseDatos->actualizarJuegosPrestadosRegalados($idJuego, $idUsuarioRegala, $idUsuarioRecibe);
                    $this->data1 = 'Regalo para ' . $nick;
                } else {
                    $this->error = "Prueba otra vez";
                }
            } else {
                $this->error = 'Error: El usuario ' . $nick . ' no existe';
            }
        }
        $this->irABiblioteca();
    }


    /* Esta funcion está a medias todavia */

    public function tramitarCompra()
    {
        global $baseDatos;
        if (isset($_POST['btn_confirmar_pago']) && $_POST['tarjeta'] !== "0") {
            //tengo que recoger los datos de la tarjeta
            $idTarjeta = $_POST['tarjeta'];
            $tarjetas = $baseDatos->obtenerTarjeta($idTarjeta);
            $fechaCaducidad = $tarjetas[0]['fechaCaducidad'];
            list($anioCad, $mesCad, $diaCad) = explode('-', $fechaCaducidad);

            $url = 'http://localhost/gamesRus/servidorSOAP.php';
            $uri = 'http://localhost/gamesRus/';

            try {
                $cliente = new SoapClient(null, array(
                    'location' => $url,
                    'uri'      => $uri
                ));

                $fechaValida = $cliente->esFechaCaducidadValida($diaCad, $mesCad, $anioCad);
                if (!$fechaValida) {
                    $this->error = "La fecha de caducidad es inválida.";
                    $this->irAlPago();
                    return;
                }
            } catch (SoapFault $e) {
                $this->error = "<p>Error en la validación de la tarjeta: " . $e->getMessage() . "</p>";
            }
            //comprobar si esta caducada solo


            //guardar los datos pertineentes en sesion--> nos ahorramos el paso si los guardo en sesion direcramene
            if (isset($_POST['juegosRegalados']) && is_array($_POST['juegosRegalados'])) {
                $juegosRegalados = $_POST['juegosRegalados'];
                //var_dump($juegosRegalados);
            } else {
                $juegosRegalados = []; // Si no hay juegos regalados, inicializamos el array vacío
            }

            // Recoger los usuarios a los que se regaló los juegos (array de nombres)
            if (isset($_POST['usuariosRegalados']) && is_array($_POST['usuariosRegalados'])) {
                $usuariosRegalados = $_POST['usuariosRegalados'];
                //var_dump($usuariosRegalados);
            } else {
                $usuariosRegalados = []; // Si no hay usuarios, inicializamos el array vacío
            }

            $_SESSION['juegosRegalados'] = $juegosRegalados;
            $_SESSION['usuariosRegalados'] = $usuariosRegalados;

            $this->pagarCompra();
        } else {
            $this->error = "No has seleccionado una tarjeta.";
            $this->irAlPago();
        }
    }

    public function irAlPago()
    {
        $idUsuario = $_SESSION['idUsuario'];
        if (isset($_SESSION['carrito'])) {
            global $baseDatos;
            $this->data = $baseDatos->mostrarTarjetas($idUsuario);
            Vista::MuestraPago($this->data, $this->error);
        } else {
            $this->error = "No tienes nada en el carrito.";
            $this->irAlCarrito();
        }
    }


    public function pagarCompra()
    {

        $juegosRegalados = $_SESSION['juegosRegalados'];
        $usuariosRegalados = $_SESSION['usuariosRegalados'];

        global $baseDatos;
        $idCarrito = $baseDatos->obtenerCarrito($_SESSION['idUsuario']);
        $juegos = $baseDatos->obtenerJuegosDelCarrito($idCarrito);

        //echo $idCarrito . "<br>";
        //var_dump($juegos);

        if (!empty($juegos)) {
            foreach ($juegos as $juego) {
                if (isset($juego['idJuego'])) {
                    $idJuego = $juego['idJuego'];
                    $titulo = $juego['titulo'];
                    /* comprobar que juegos van a regalarse comparandolos con el array de juegos*/
                    if (in_array($idJuego, $juegosRegalados)) {
                        // Si el juego está en la lista de juegos regalados, obtenemos el índice y el usuario
                        $posicion = array_search($idJuego, $juegosRegalados);  // Encuentra el índice del juego en el array
                        // Obtenemos el nombre del usuario destinatario usando el mismo índice
                        $nombreUsuarioRegalado = isset($usuariosRegalados[$posicion]) ? $usuariosRegalados[$posicion] : 'Desconocido';
                        $idUsuarioRegala = $_SESSION['idUsuario'];

                        $idUsuarioRecibe = $baseDatos->obtenerIdUsuario($nombreUsuarioRegalado);
                        if ($idUsuarioRecibe == null) {
                            $this->error = "Ese usuario no existe.";
                        } else {
                            if ($baseDatos->existeUsuario($nombreUsuarioRegalado, '')) {
                                if ($idUsuarioRegala != $idUsuarioRecibe) {
                                    /* comprobar que el usuario que recibe no tenga ese juego ya */
                                    if (!$baseDatos->esJuegoComprado($idUsuarioRecibe, $idJuego)) { //comprobar que el usuario que recibe el juego lo tiene en la biblioteca
                                        //si no lo tiene se lo podemos regalar
                                        //$baseDatos->comprarJuego($idUsuarioRecibe, $idJuego);
                                        $baseDatos->agnadirRegalo($idUsuarioRegala, $idUsuarioRecibe, $idJuego);
                                        $baseDatos->eliminarTodosLosJuegosCarrito($idCarrito);
                                    } else {
                                        $this->error .= "<br>$titulo ya ha existe en la biblioteca del usuario.<br>";
                                    }
                                } else {
                                    $this->error = "No te puedes regalar a ti mismo";
                                }
                            }
                        }
                    } else {
                        if (!$baseDatos->esJuegoComprado($_SESSION['idUsuario'], $idJuego) && !$baseDatos->esJuegoRegalado($_SESSION['idUsuario'], $idJuego)) {
                            $baseDatos->comprarJuego($_SESSION['idUsuario'], $idJuego);
                            $baseDatos->agnadirJuegoAUsuario($_SESSION['idUsuario'], $idJuego);
                            $baseDatos->eliminarTodosLosJuegosCarrito($idCarrito);
                            // Limpiar el carrito de la sesión
                            unset($_SESSION['carrito']);
                            $this->error = "Pago realizado con éxito";
                        } else {
                            $this->error .= "<br>$titulo ya ha los tienes. Eliminalo del carrito o tramitalo como regalo.<br>";
                        }
                    }
                }
            }
        } else {
            $this->error = "No hay nada que pagar";
        }

        // Redirigir o mostrar el carrito
        $this->irAlCarrito();
    }


    public function subirArchivos()
    {
        $this->subirArchivosJSON();
        $this->subirArchivosXML();
    }


    public function subirArchivosXML()
    {
        global $baseDatos;
        // Ruta al archivo XML
        $xmlFile = '.\archivos\XML\juegos.xml';
        $rutaRelativa = '.\archivos\XML';
        // Verificar si el archivo XML existe
        if (file_exists($xmlFile)) {
            // Cargar el archivo XML
            $xml = simplexml_load_file($xmlFile);

            // Verificar si se ha cargado correctamente
            if ($xml === false) {
                $this->error = "No existen datos en el archivo";
            } else {

                // Mostrar el contenido del XML 
                //var_dump($xml);

                foreach ($xml->juego as $juego) {
                    $titulo = $juego->titulo;
                    $desarrollador =  $juego->desarrollador;
                    $distribuidor = $juego->distribuidor;
                    $anio = (int) $juego->año;
                    $portada = $rutaRelativa . DIRECTORY_SEPARATOR . $juego->portada;
                    $ruta = $rutaRelativa . DIRECTORY_SEPARATOR . $juego->ruta;
                    $descripcion = !empty($juego->descripcion) ? $juego->descripcion : " ";
                    $precio = !empty($juego->precio) ? $juego->precio : 15.99;

                    $sistemas = [];
                    foreach ($juego->sistemas->sistema as $sistema) {
                        $sistemas[] = (string) $sistema;
                    }

                    $generos = [];
                    foreach ($juego->generos->genero as $genero) {
                        $generos[] = (string) $genero;
                    }


                    $titulosBase = $baseDatos->obtenerTituloJuego();
                    $existe = $this->compararTitulos($titulosBase, $titulo);

                    if ($existe == true) {
                        $detalles[] = "El juego '$titulo' ya existe.";
                    } else {
                        $baseDatos->cargarJuego($titulo, $desarrollador, $distribuidor, $anio, $ruta, $descripcion, $portada, $precio);
                        $idJuego = $baseDatos->obtenerIdJuegoPorTitulo($titulo);
                        $baseDatos->cargarGeneroJuego($idJuego, $generos);
                        $baseDatos->cargarSistemasJuego($idJuego, $sistemas);
                        $detalles[] = "El juego '$titulo' ha sido añadido.";
                    }
                }
                $_SESSION['detalles1'] = $detalles;
            }
        } else {
            exit('No se pudo abrir el archivo XML.');
        }
        $this->irAlAdministrador();
    }

    public function subirArchivosJSON()
    {
        global $baseDatos;
        // Ruta al archivo JSON
        $archivoJSON = '.\archivos\JSON\juegos.json';

        $rutaRelativa = '.\archivos\JSON';
        // Leer el contenido del archivo JSON
        $datos = file_get_contents($archivoJSON);

        if (!$datos) {
            $this->error = "No existen datos en el archivo";
        } else {
            $datosDecode = json_decode($datos, true); //Usar true devuelve los datos como array

            /* En detalles guardamos la informacion sobre los juegos, los que se han añadido y los que no porque ya estan */
            $detalles = [];
            foreach ($datosDecode as $juego) {
                $titulo = $juego['titulo'];
                $desarrollador = $juego['desarrollador'];
                $distribuidor = $juego['distribuidor'];
                $anio = $juego['año'];
                $portada = $rutaRelativa . DIRECTORY_SEPARATOR . $juego['portada'];
                $ruta = $rutaRelativa . DIRECTORY_SEPARATOR . $juego['ruta'];
                $descripcion = !empty($juego['descripcion']) ? $juego['descripcion'] : " ";
                $precio = !empty($juego->precio) ? $juego->precio : 15.99;

                $relacionados = [];
                foreach ($juego['relacionados'] as $relacionado) {
                    $relacionados[] = $relacionado;
                }
                $sistemas = [];
                foreach ($juego['sistemas'] as $sistema) {
                    $sistemas[] = $sistema;
                }
                $generos = [];
                foreach ($juego['generos'] as $genero) {
                    $generos[] = $genero;
                }

                $titulosBase = $baseDatos->obtenerTituloJuego();
                $existe = $this->compararTitulos($titulosBase, $titulo);

                if ($existe == true) {
                    $detalles[] = "El juego '$titulo' ya existe.";
                } else {
                    $baseDatos->cargarJuego($titulo, $desarrollador, $distribuidor, $anio, $ruta, $descripcion, $portada, $precio);
                    $idJuego = $baseDatos->obtenerIdJuegoPorTitulo($titulo);
                    $baseDatos->cargarGeneroJuego($idJuego, $generos);
                    $baseDatos->cargarSistemasJuego($idJuego, $sistemas);
                    $detalles[] = "El juego '$titulo' ha sido añadido.";
                }
            }
            $_SESSION['detalles'] = $detalles;
        }
    }

    public function compararTitulos($arrayTitulos, $titulo)
    {
        foreach ($arrayTitulos as $t1) {
            if (strcmp($t1, $titulo) === 0) {
                return true;
            }
        }
    }


    /* FILTRAR JUEGOS DEL CATÁLOGO */
    public function filtrar()
    {
        global $baseDatos;

        $this->data2 = $baseDatos->accederGeneros();
        $this->data3 = $baseDatos->accederSistemas();
        $this->data4 = $baseDatos->obtenerAnioJuego();
        // var_dump($this->data4 );

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $genero = $_POST['genero'] ?? "0"; // Si no existe, usar "0"
            $sistema = $_POST['sistema'] ?? "0";
            $fecha = $_POST['fecha'] ?? "0";

            $this->data = $baseDatos->filtrarJuegos($genero, $sistema, $fecha);
        } else {
            $this->data = []; // Evita errores si la vista espera este array
            $this->error = "No se ha podido filtrar";
        }

        Vista::MuestraCatalogo($this->data, $this->data1, $this->data2, $this->data3, $this->data4, $this->error);
    }

    function obtenerUltimoJuego()
    {
        global $baseDatos;
        $juego = $baseDatos->obtenerUltimoJuego();
        $texto = 'Último juego añadido: ' . $juego[0];
        $MAX_LENGTH = 45;
        if (strlen($texto) > $MAX_LENGTH) {
            $texto = substr($texto, 0, $MAX_LENGTH) . '…';
        }
        echo $texto;
    }
}






// El programa en sí comienza aquí
$programa = new Controlador();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $programa->handlePost();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $programa->handleGet();
}
