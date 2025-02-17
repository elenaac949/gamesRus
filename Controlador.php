<?php
header("Access-Control-Allow-Origin: *"); // Permitir cualquier origen, permite utilizar CORS
require_once "vista.php";
// El modelo es bbdd
require_once "bbdd.php";
include "./env/conf.env";

/**
 * Controlador
 */
class Controlador
{

    /**
     * Controlamos la navegación de páginas 
     * 
     * action
     *
     * @var mixed
     */
    private $action;

    /**
     *  Controlamos los mensajes con las variables data
     * 
     * data
     *
     * @var mixed
     */
    private $data;
    /**
     * data1
     *
     * @var mixed
     */
    private $data1;
    /**
     * data2
     *
     * @var mixed
     */
    private $data2;
    /**
     * data3
     *
     * @var mixed
     */
    private $data3;
    /**
     * data4
     *
     * @var mixed
     */
    private $data4;
    /**
     * Controlamos los errores
     * 
     * error
     *
     * @var mixed
     */
    private $error;



    /**
     * Constructor de la clase.
     * 
     * - Inicia la sesión del usuario.
     * - Redirige a la página de inicio de sesión si se envía el formulario correspondiente.
     * - Muestra la página de inicio (landing) si no hay parámetros en la solicitud GET.
     * 
     * @return void
     */
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

    /**
     * Manejador de todas las solicitudes POST de la aplicación.
     * 
     * Este método se encarga de procesar las acciones enviadas por el usuario a través de POST
     * y redirigirlas al método correspondiente.
     *
     * @return void
     */
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
        ];


        $this->procesarAcciones($_POST, $accionesPost);
    }

    /**
     * Procesa las acciones enviadas a través de POST o GET.
     * 
     * Recorre la lista de acciones y, si encuentra una coincidencia con los datos recibidos, 
     * ejecuta el método correspondiente de la clase.
     *
     * @param array $datos Datos recibidos a través de POST o GET.
     * @param array $acciones Lista de acciones disponibles y sus métodos asociados.
     * @return void
     */
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
                return; // Terminamos después de la acción.
            }
        }

        // Si no se encuentra ninguna acción válida
        echo "Acción no encontrada.";
    }


    /**
     * Obtiene el contenido de una URL de MobyGames.
     * 
     * Este método recupera y muestra el contenido de la URL proporcionada, generalmente 
     * utilizada para obtener información sobre un videojuego desde la API de MobyGames.
     *
     * @param string $urlMobyGames URL de MobyGames a consultar.
     * @return void
     */
    public function mobyGames($urlMobyGames)
    {
        echo file_get_contents($urlMobyGames);
        die();
    }


    /**
     * Maneja las acciones GET de la aplicación.
     * 
     * Este método procesa las solicitudes GET y ejecuta la acción correspondiente 
     * según los parámetros recibidos.
     *
     * @return void
     */
    public function handleGet()
    {
        $accionesGet = [
            'mobyGames' => 'mobyGames',
            'ultimojuegoananido' => 'obtenerUltimoJuego'
        ];
        $this->procesarAcciones($_GET, $accionesGet);
    }



    /**
     * Redirige a la página de registro.
     * 
     * Este método muestra la vista de registro para que el usuario pueda crear una nueva cuenta.
     *
     * @return void
     */
    public function irAlRegistro()
    {
        // $this->action = 'registro';
        Vista::MuestraRegistro($this->data);
    }

    /**
     * Redirige a la biblioteca del usuario.
     * 
     * Este método gestiona la visualización de la biblioteca del usuario. Si se ha 
     * presionado el botón para mostrar detalles, llama al método correspondiente; 
     * de lo contrario, finaliza préstamos y obtiene los datos de la biblioteca.
     *
     * @return void
     */
    public function irABiblioteca()
    {
        if (isset($_POST['btn_mostrar_detalles'])) {
            $this->mostrarDetalles();
        } else {
            $this->finalizarPrestamo();
            $this->datosBiblioteca();
        }

        Vista::MuestraBiblioteca($this->data, $this->data1, $this->error);
    }

    /**
     * Obtiene los datos de la biblioteca del usuario.
     * 
     * Este método recupera los juegos de la biblioteca del usuario desde la base de datos 
     * y los almacena en `$this->data`. 
     *
     * @return void
     */
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


    /**
     * Obtiene y muestra los detalles de un juego específico.
     * 
     * Este método recupera los detalles de un juego seleccionado desde la base de datos, 
     * incluyendo su información y género. Si no se encuentra el juego o no se proporciona un ID, 
     * se asigna un mensaje de error a `$this->data1`.
     *
     * @return void
     */
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


    /**
     * Redirige a la página del catálogo de juegos.
     * 
     * Este método recupera la lista de juegos, géneros, sistemas y años de lanzamiento desde 
     * la base de datos, y luego pasa esos datos a la vista para mostrar el catálogo al usuario.
     *
     * @return void
     */
    public function irAlCatalogo()
    {
        global $baseDatos;

        // Obtiene la lista de juegos desde la base de datos.
        $this->data = $baseDatos->mostrarJuegos();

        // Obtiene los géneros disponibles para los juegos.
        $this->data2 = $baseDatos->accederGeneros();

        // Obtiene los sistemas disponibles para los juegos.
        $this->data3 = $baseDatos->accederSistemas();

        // Obtiene los años de lanzamiento de los juegos.
        $this->data4 = $baseDatos->obtenerAnioJuego();

        // Redirige a la vista del catálogo con los datos obtenidos.
        Vista::MuestraCatalogo($this->data, $this->data1, $this->data2, $this->data3, $this->data4, $this->error);
    }


    /**
     * Redirige a la página del carrito de compras del usuario.
     * 
     * Este método sincroniza el carrito de compras del usuario, obtiene los juegos 
     * almacenados en el carrito desde la base de datos y los pasa a la vista para su visualización.
     *
     * @return void
     */
    public function irAlCarrito()
    {
        global $baseDatos;

        // Sincroniza el carrito de compras (posiblemente actualiza o verifica el estado del carrito).
        $this->sincronizarCarrito();

        // Obtiene el ID del carrito del usuario desde la base de datos.
        $idCarrito = $baseDatos->obtenerCarrito($_SESSION['idUsuario']);

        // Obtiene los juegos que están en el carrito del usuario.
        $this->data = $baseDatos->obtenerJuegosDelCarrito($idCarrito);

        // Redirige a la vista del carrito con los datos obtenidos.
        Vista::MuestraCarrito($this->data, $this->error, $this->data1);
    }


    /**
     * Redirige al panel de administración.
     * 
     * Este método muestra un formulario necesario y luego carga la vista de administración,
     * pasando los datos y errores correspondientes para su visualización.
     *
     * @return void
     */
    public function irAlAdministrador()
    {
        // Llama al método para mostrar el formulario
        $this->mostrarFormulario();

        // Muestra la vista de administración utilizando la clase Vista
        // Se pasan los datos ($this->data, $this->data1) y un posible error ($this->error)
        Vista::MuestraAdministración($this->data, $this->data1, $this->error);
    }

    /**
     * Redirige a la página del perfil del usuario.
     * 
     * Este método obtiene los datos del usuario y sus tarjetas almacenadas desde la base de datos,
     * y luego los pasa a la vista para su visualización.
     *
     * @return void
     */
    public function irAlPerfil()
    {
        global $baseDatos;
        // Obtiene los datos del usuario desde la base de datos
        $this->data = $baseDatos->obtenerDatosUsuario();
        // Obtiene las tarjetas asociadas al usuario desde la base de datos
        $this->data1 = $baseDatos->mostrarTarjetas($_SESSION['idUsuario']);

        // Muestra la vista del perfil con los datos obtenidos y posibles errores
        Vista::MuestraPerfil($this->data, $this->data1, $this->error);
    }

    /**
     * Redirige a la página para prestar un juego.
     * 
     * Este método obtiene los datos de un juego específico, incluyendo su género, desde la base de datos,
     * y luego los pasa a la vista para su visualización.
     *
     * @return void
     */
    public function irAPrestar()
    {
        // Verifica si se ha enviado el ID del juego a través del formulario
        if (isset($_POST['idJuegoCatalogo'])) {
            $idJuego = intval($_POST['idJuegoCatalogo']);
            global $baseDatos;
            // Obtiene los datos del juego con su género desde la base de datos
            $this->data = $baseDatos->obtenerDatosJuegoConGenero($idJuego);
        }
        // Muestra la vista para prestar el juego con los datos obtenidos y posibles errores
        Vista::MuestraPrestar($this->data, $this->error);
    }

    /**
     * Redirige a la página para regalar un juego.
     * 
     * Este método obtiene los datos de un juego específico, incluyendo su género, desde la base de datos,
     * y luego los pasa a la vista para su visualización.
     *
     * @return void
     */
    public function irARegalar()
    {
        // Verifica si se ha enviado el ID del juego a través del formulario
        if (isset($_POST['idJuegoCatalogo'])) {
            $idJuego = intval($_POST['idJuegoCatalogo']);
            global $baseDatos;
            // Obtiene los datos del juego con su género desde la base de datos
            $this->data = $baseDatos->obtenerDatosJuegoConGenero($idJuego);
        }
        // Muestra la vista para regalar el juego con los datos obtenidos y posibles errores
        Vista::MuestraRegalar($this->data, $this->error);
    }

    /**
     * Verifica si el usuario ha iniciado sesión correctamente.
     * 
     * Este método valida las credenciales del usuario (nombre de usuario y contraseña) 
     * contra la base de datos. Si las credenciales son correctas, redirige al usuario 
     * a su biblioteca. Si no, muestra un mensaje de error en la vista de login.
     *
     * @return void
     */
    public function verificarUsuario()
    {
        global $baseDatos;
        // Verifica si se han enviado los campos de usuario y contraseña
        if ($_POST['usuario'] && $_POST['contrasenia'] != '') {
            // Limpia y valida los datos de entrada
            $usuario = trim($_POST['usuario']);
            $contrasenia = trim($_POST['contrasenia']);

            // Verifica si el usuario existe en la base de datos
            $usuarioCorrecto = $baseDatos->controlLogin($usuario);
            if ($usuarioCorrecto) {
                // Verifica si la contraseña coincide con el hash almacenado
                if (password_verify($contrasenia, $usuarioCorrecto['contrasenia'])) {
                    // Almacena los datos del usuario en la sesión
                    $_SESSION['idUsuario'] = $usuarioCorrecto['idUsuario'];
                    $_SESSION['nickUsuario'] = $usuarioCorrecto['nick'];

                    // Redirige al usuario a su biblioteca
                    $this->irABiblioteca();
                    return;
                } else {
                    // Mensaje de error si la contraseña es incorrecta
                    $this->data = 'Contraseña incorrecta';
                }
            } else {
                // Mensaje de error si el usuario no existe
                $this->data = 'Usuario no existe';
            }
        }
        // Muestra la vista de login con el mensaje de error correspondiente
        Vista::MuestraLogin($this->data);
        return;
    }

    /**
     * Registra a un nuevo usuario en el sistema.
     * 
     * Este método valida los datos de registro del usuario (nombre, apellidos, alias, correo, contraseña, etc.)
     * y los almacena en la base de datos. Si los datos son válidos y no existen conflictos (como un correo o alias ya registrado),
     * el usuario es registrado y se redirige a la vista de login. Si no, se muestran mensajes de error en la vista de registro.
     *
     * @return void
     */
    public function anadirUsuario()
    {
        global $baseDatos;

        // Verifica que todos los campos obligatorios estén completos
        if (!empty($_POST['nombre']) && !empty($_POST['apellidos']) && !empty($_POST['alias']) && !empty($_POST['correo']) && !empty($_POST['contrasenia1']) && !empty($_POST['contrasenia2']) && !empty($_POST['telefono'])) {
            // Obtiene y limpia los datos del formulario
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

            // Patrón para validar el formato del correo electrónico
            $patron = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

            // Verifica si el correo o el alias ya están registrados en la base de datos
            if ($baseDatos->existeUsuario($nick, $correo)) {
                $this->data = 'Correo o nick ya existentes';
                Vista::MuestraRegistro($this->data);
            } else {
                // Valida el formato del correo electrónico
                if (preg_match($patron, $correo)) {
                    // Verifica que las contraseñas coincidan
                    if ($contrasenia1 === $contrasenia2) {
                        // Hashea la contraseña antes de almacenarla
                        $hashedPassword = password_hash($contrasenia1, PASSWORD_DEFAULT);

                        // Registra al usuario en la base de datos
                        $baseDatos->registrarUsuario($nombre, $apellidos, $correo, $nick, $hashedPassword, $tipoDeVia, $nombreDeVia, $numero, $numeros, $otros, $numeroTelefono);

                        // Muestra un mensaje de éxito y redirige a la vista de login
                        $this->data = 'Usuario registrado correctamente.';
                        Vista::MuestraLogin($this->data);
                    } else {
                        // Mensaje de error si las contraseñas no coinciden
                        $this->data = 'Las contraseñas no coinciden.';
                        Vista::MuestraRegistro($this->data);
                    }
                } else {
                    // Mensaje de error si el correo no es válido
                    $this->data = 'El correo electónico no es válido.';
                    Vista::MuestraRegistro($this->data);
                }
            }
        } else {
            // Mensaje de error si faltan datos obligatorios
            $this->data = 'Datos incompletos.';
            Vista::MuestraRegistro($this->data);
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


    /**
     * Muestra formularios para añadir, editar o eliminar juegos.
     * 
     * Este método verifica qué acción se ha solicitado (añadir, editar o eliminar un juego)
     * y llama a los métodos correspondientes para mostrar los datos necesarios en los formularios.
     *
     * @return void
     */
    public function mostrarFormulario()
    {
        if (isset($_POST['mostrar_anadir_juego'])) {
            // Muestra los géneros y sistemas disponibles para añadir un juego
            $this->mostrarGeneros();
            $this->mostrarSistemas();
        } elseif (isset($_POST['mostrar_editar_juego'])) {
            // Muestra la lista de juegos para editar
            $this->mostrarLosJuegos();
        } elseif (isset($_POST['mostrar_eliminar_juego'])) {
            // Muestra la lista de juegos para eliminar
            $this->mostrarLosJuegos();
        }
    }

    /**
     * Muestra los géneros de los juegos disponibles.
     * 
     * Este método obtiene los géneros de los juegos desde la base de datos
     * y los almacena en la propiedad $this->data para su uso en la vista.
     *
     * @return void
     */
    public function mostrarGeneros()
    {
        global $baseDatos;
        $this->data = $baseDatos->accederGeneros();
    }

    /**
     * Muestra los sistemas de los juegos disponibles.
     * 
     * Este método obtiene los sistemas de los juegos desde la base de datos
     * y los almacena en la propiedad $this->data1 para su uso en la vista.
     *
     * @return void
     */
    public function mostrarSistemas()
    {
        global $baseDatos;
        $this->data1 = $baseDatos->accederSistemas();
    }

    /**
     * Muestra las fechas de lanzamiento de los juegos.
     * 
     * Este método obtiene los años de lanzamiento de los juegos desde la base de datos
     * y los almacena en la propiedad $this->data4 para su uso en la vista.
     *
     * @return void
     */
    public function mostrarFechas()
    {
        global $baseDatos;
        $this->data4 = $baseDatos->obtenerAnioJuego();
    }

    /**
     * Muestra la lista de juegos disponibles.
     * 
     * Este método obtiene la lista de juegos desde la base de datos
     * y los almacena en la propiedad $this->data para su uso en la vista.
     *
     * @return void
     */
    public function mostrarLosJuegos()
    {
        global $baseDatos;
        $this->data = $baseDatos->mostrarJuegos();
    }

    /**
     * Presta un juego a otro usuario.
     * 
     * Este método gestiona el préstamo de un juego de un usuario a otro.
     * Verifica que el usuario receptor exista y que no sea el mismo que el prestador.
     * Si todo es correcto, añade el juego a la biblioteca del receptor y lo elimina de la del prestador.
     *
     * @return void
     */
    public function prestarJuego()
    {
        if (!empty($_POST['idJuego']) && !empty($_POST['nombre-usuario'])) {
            global $baseDatos;
            $nick = $_POST['nombre-usuario'];
            $idJuego = $_POST['idJuego'];
            $idUsuarioPresta = $_SESSION['idUsuario'];
            $idUsuarioRecibe = $baseDatos->obtenerIdUsuario($nick);

            // Verifica si el usuario receptor existe
            if ($baseDatos->existeUsuario($nick, '')) {
                // Verifica que el usuario receptor no sea el mismo que el prestador
                if ($idUsuarioPresta != $idUsuarioRecibe) {
                    // Añade el juego a la biblioteca del receptor y lo elimina de la del prestador
                    $prestado = $baseDatos->agnadirJuegoPrestado($idUsuarioRecibe, $idJuego);
                    $eliminado = $baseDatos->eliminarJuegoPrestado($idUsuarioPresta, $idJuego);

                    if ($prestado && $eliminado) {
                        // Registra el préstamo en la base de datos
                        $baseDatos->agnadirPrestamos($idUsuarioPresta, $idUsuarioRecibe, $idJuego);
                        $baseDatos->actualizarJuegosPrestadosRegalados($idJuego, $idUsuarioPresta, $idUsuarioRecibe);
                    }

                    $this->error = 'Juego prestado correctamente';
                } else {
                    $this->error = "No te puedes prestar a ti mismo";
                }
                // Redirige a la biblioteca del usuario
                $this->irABiblioteca();
            } else {
                // Mensaje de error si el usuario receptor no existe
                $this->error = 'Error: El usuario ' . $nick . ' no existe';
                Vista::MuestraPrestar($this->data, $this->error);
            }
        }
    }


    /**
     * Finaliza los préstamos vencidos y actualiza el estado de los juegos prestados.
     * 
     * Este método obtiene los préstamos vencidos, elimina los juegos prestados de los usuarios 
     * y actualiza la base de datos para reflejar el retorno de los juegos, eliminando los registros 
     * de los préstamos correspondientes.
     *
     * @return void
     */
    public function finalizarPrestamo()
    {
        global $baseDatos;

        // Obtener los préstamos vencidos con todos sus detalles.
        $prestamosVencidos = $baseDatos->obtenerPrestamosVencidos();

        if (!empty($prestamosVencidos)) {
            foreach ($prestamosVencidos as $prestamo) {
                $idPrestamo = $prestamo['idPrestamo'];
                $idUsuarioPresta = $prestamo['idUsuarioPresta'];
                $idUsuarioRecibe = $prestamo['idUsuarioRecibe'];
                $idJuego = $prestamo['idJuego'];

                // Eliminar el juego prestado y agregarlo a la biblioteca del receptor.
                $baseDatos->agnadirJuegoPrestado($idUsuarioRecibe, $idJuego);
                $baseDatos->eliminarJuegoPrestado($idUsuarioRecibe, $idJuego);

                // Eliminar el préstamo en la tabla de préstamos.
                $baseDatos->eliminarPrestamo($idPrestamo);

                // Actualizar los juegos prestados/regalados.
                $baseDatos->actualizarJuegosPrestadosRegalados($idJuego, $idUsuarioRecibe, $idUsuarioPresta);
            }
            $this->error = "Préstamos finalizados.";
        }
    }


    /**
     * Regala un juego de la biblioteca de un usuario a otro usuario.
     * 
     * Este método permite a un usuario regalar un juego a otro usuario, actualizando 
     * las tablas correspondientes en la base de datos. Si el usuario de destino no 
     * existe o si el usuario intenta regalar un juego a sí mismo, se muestra un error.
     *
     * @return void
     */
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
                    // Regalar el juego y actualizar la base de datos.
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

    /**
     * Actualiza los datos del usuario en la base de datos.
     * 
     * Este método permite al usuario actualizar su perfil, incluyendo información personal, 
     * dirección y número de teléfono. Los nuevos datos se almacenan en la base de datos.
     *
     * @return void
     */
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

        global $baseDatos;

        // Actualiza los datos del usuario en la base de datos.
        $this->data = $baseDatos->actualizarUsuario($nombre, $apellidos, $correo, $nick, $tipoDeVia, $nombreDeVia, $numero, $numeros, $otros, $numeroTelefono);

        // Redirige al perfil del usuario después de la actualización.
        $this->irAlPerfil();
    }


    /**
     * Elimina la cuenta de un usuario.
     * 
     * Este método permite eliminar una cuenta de usuario, siempre y cuando no sea un usuario 
     * con privilegios especiales (como el admin). Después de eliminar la cuenta, se redirige 
     * a la página de inicio.
     *
     * @return void
     */
    public function eliminarCuentaUsuario()
    {
        global $baseDatos;

        // Verifica si el usuario no es admin ni usuario.
        if ($_SESSION['nickUsuario'] == "admin" || $_SESSION['nickUsuario'] == "usuario") {
            $this->error = "No puedes eliminar esta cuenta";
            $this->irAlPerfil();
            return;
        }

        // Elimina al usuario de la base de datos.
        $baseDatos->eliminarUsuario($_SESSION['nickUsuario']);

        // Redirige a la página de inicio después de eliminar la cuenta.
        Vista::MuestraLanding();
    }


    /**
     * Comprobar la dirección de la solicitud y redirigir al perfil o al pago.
     * 
     * Este método comprueba si se ha enviado un formulario desde el perfil del usuario 
     * o desde el pago, y redirige a la acción correspondiente.
     *
     * @return void
     */
    public function comprobarDireccion()
    {
        if (isset($_POST['perfil'])) {
            $this->irAlPerfil();
        } elseif (isset($_POST['pago'])) {
            $this->irAlPago();
        }
    }


    /**
     * Añadir una nueva tarjeta de crédito para el usuario.
     * 
     * Este método valida los datos de la tarjeta (número, fecha de caducidad y CCV) mediante 
     * un servicio SOAP externo, y si la tarjeta es válida, la guarda en la base de datos. 
     * También verifica que la tarjeta no esté ya registrada para el usuario.
     *
     * @return void
     */
    public function anadirNuevaTarjeta()
    {
        if (!empty($_POST['numero_tarjeta']) && !empty($_POST['mes_cad_tarjeta']) && !empty($_POST['anio_cad_tarjeta'])) {

            // Recuperar los datos de la tarjeta desde el formulario
            $numeroTarjeta = $_POST['numero_tarjeta'];
            $ccv = $_POST['ccv_tarjeta'];
            $diaCad = 01; // Para poder guardarlo en la base de datos
            $mesCad = intval($_POST['mes_cad_tarjeta']);
            $anioCad = intval($_POST['anio_cad_tarjeta']);
            $caducidad = $anioCad . "-" . $mesCad . "-" . $diaCad;

            global $baseDatos;

            // Configuración del cliente SOAP
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

                // Si todo es válido, se añade la tarjeta
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

    /**
     * Elimina una tarjeta registrada del perfil del usuario.
     * 
     * Este método elimina una tarjeta asociada al usuario en la base de datos usando 
     * el ID de la tarjeta proporcionado en el formulario.
     *
     * @return void
     */
    public function eliminarTarjeta()
    {
        if (isset($_POST['idTarjeta'])) {
            $idTarjeta = $_POST['idTarjeta'];
            global $baseDatos;

            // Eliminar la tarjeta de la base de datos
            $baseDatos->eliminarTarjeta($idTarjeta);

            // Redirigir al perfil después de la eliminación
            $this->irAlPerfil();
        }
    }


    /**
     * Edita la información de una tarjeta de crédito ya registrada.
     * 
     * Este método permite modificar la tarjeta del usuario, validando los nuevos datos 
     * de la tarjeta (número, fecha de caducidad) antes de actualizar la base de datos.
     *
     * @return void
     */
    public function editarTarjeta()
    {
        if (!empty($_POST['numeroTarjeta']) && !empty($_POST['mes_cad_tarjeta']) && !empty($_POST['anio_cad_tarjeta'])) {
            $numeroTarjeta = $_POST['numeroTarjeta'];

            $diaCad = 01; // Para poder guardarlo en la base de datos
            $mesCad = intval($_POST['mes_cad_tarjeta']);
            $anioCad = intval($_POST['anio_cad_tarjeta']);
            $caducidad = implode("-", [$anioCad, $mesCad, $diaCad]);

            global $baseDatos;

            // Configuración del cliente SOAP
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

                // Comprobar si ya existe una tarjeta con el mismo número y la misma fecha de caducidad para el usuario
                if ($baseDatos->tarjetaExiste($numeroTarjeta, $caducidad, $_SESSION['idUsuario'])) {
                    $this->error = "Ya tienes una tarjeta registrada con ese número.";
                    return;
                }

                // Actualizar los datos de la tarjeta
                $baseDatos->editarTarjeta($numeroTarjeta, $caducidad, $_SESSION['idUsuario']);
                $this->error = "Tarjeta editada correctamente.";
            } catch (SoapFault $e) {
                $this->error = "<p>Error en la validación de la tarjeta: " . $e->getMessage() . "</p>";
            }
        } else {
            $this->error = "Revisa la información";
        }
        $this->irAlPerfil();
    }


    /**
     * Añadir un nuevo juego a la base de datos.
     * 
     * Este método permite añadir un juego nuevo a la base de datos, verificando que 
     * se hayan completado todos los campos obligatorios. Si el juego se añade correctamente, 
     * se muestra un mensaje de éxito. Si los datos están incompletos, se muestra un error.
     *
     * @return void
     */
    public function anadirNuevoJuego()
    {
        var_dump($_POST);
        global $baseDatos;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validar campos obligatorios
            if (!empty($_POST['titulo_juego']) && !empty($_POST['genero_juego']) && !empty($_POST['sistema_juego'])  && !empty($_POST['portada_juego'])) {
                $titulo = $_POST['titulo_juego'];
                $generos = $_POST['genero_juego'];
                $desarrollador = $_POST['desarrollador_juego'] ?? "Sin desarrollador";
                $lanzamiento = $_POST['anio_lanzamiento'] ?? "2024";
                $descripcion = $_POST['descripcion_juego'] ?? "Sin descripción";
                $portada = $_POST['portada_juego'];
                $ruta = $_POST['ruta_juego'] ?? "Sin ruta";
                $sistemas = $_POST['sistema_juego'];
                $precio = !empty($_POST['precio_juego']) ? floatval($_POST['precio_juego']) : 15.99; // Si no se añade un precio, se pone el de ejemplo

                // Añadir juego a la base de datos
                $baseDatos->agregarJuego($titulo, $desarrollador, $lanzamiento, $generos, $sistemas, $ruta, $descripcion, $portada, $precio);
                $this->error = 'Juego añadido correctamente';
            } else {
                $this->error = 'Datos incompletos.';
            }
            $this->mostrarFormulario();
            Vista::MuestraAdministración($this->data, $this->data1, $this->error);
        }
    }


    /**
     * Edita los detalles de un juego existente en la base de datos.
     * 
     * Este método permite editar los detalles de un juego, como el desarrollador, distribuidor, 
     * fecha de lanzamiento, descripción, portada y precio. Si los campos obligatorios están completos, 
     * se actualiza la base de datos con la nueva información.
     *
     * @return void
     */
    public function editarJuego()
    {
        global $baseDatos;

        if ($_SERVER["REQUEST_METHOD"]  == "POST") {
            // Validar campos obligatorios
            if (
                !empty($_POST['desarrollador_juego']) && !empty($_POST['distribuidor_juego']) &&
                !empty($_POST['anio_lanzamiento']) && !empty($_POST['descripcion_juego']) &&
                !empty($_POST['portada_juego']) && !empty($_POST['idJuego'])
            ) {

                $desarrollador = $_POST['desarrollador_juego'];
                $distribuidor = $_POST['distribuidor_juego'];
                $lanzamiento = $_POST['anio_lanzamiento'];
                $descripcion = $_POST['descripcion_juego'];
                $portada = $_POST['portada_juego'];
                $idJuego = $_POST['idJuego'];
                $precio = !empty($_POST['precio_juego']) ? floatval($_POST['precio_juego']) : 15.99; // Si no se añade un precio, se pone el de ejemplo

                // Editar juego en la base de datos
                $baseDatos->editarJuego($idJuego, $desarrollador, $distribuidor, $lanzamiento, $portada, $descripcion, $precio);
                $this->error = 'Juego editado correctamente';
            } else {
                $this->error = 'Datos incompletos.';
            }
            $this->mostrarFormulario();
            Vista::MuestraAdministración($this->data, $this->data1, $this->error);
        }
    }

    /**
     * Elimina un juego de la base de datos.
     * 
     * Este método permite eliminar un juego de la base de datos usando su ID, proporcionado
     * a través de un formulario. Si el juego es eliminado correctamente, se muestra un mensaje
     * de éxito. Si los datos están incompletos, se muestra un mensaje de error.
     *
     * @return void
     */
    public function eliminarJuego()
    {
        global $baseDatos;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validar campos obligatorios
            if (!empty($_POST['idJuego'])) {
                $idJuego = $_POST['idJuego'];
                $baseDatos->eliminarJuego($idJuego);
                $this->error = 'Juego eliminado correctamente';
            } else {
                $this->error = 'Datos incompletos.';
            }
            $this->mostrarFormulario();
            Vista::MuestraAdministración($this->data, $this->data1, $this->error);
        }
    }


    /**
     * Sincroniza el carrito del usuario con la base de datos.
     * 
     * Este método obtiene el carrito de un usuario desde la base de datos y lo sincroniza
     * con el carrito que se encuentra almacenado en la sesión. Si no existe un carrito en 
     * la sesión, se crea uno nuevo. Los juegos del carrito se añaden a la sesión si no 
     * están ya presentes.
     *
     * @return void
     */
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


    /**
     * Agrega un juego al carrito del usuario.
     * 
     * Este método permite agregar un juego al carrito del usuario. Primero verifica si el 
     * juego ya está en el carrito de la sesión. Si no lo está, se agrega tanto a la sesión 
     * como a la base de datos. Si el juego ya está en el carrito, se muestra un mensaje de error.
     *
     * @return void
     */
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


    /**
     * Elimina un juego del carrito del usuario.
     * 
     * Este método elimina un juego del carrito del usuario tanto en la sesión como en la base 
     * de datos. Si el juego no está en el carrito, se muestra un mensaje de error.
     *
     * @return void
     */
    public function eliminarJuegoDelCarrito()
    {
        global $baseDatos;

        if (isset($_POST['idJuegoCatalogo'])) {
            $idJuego = $_POST['idJuegoCatalogo'];
            $idCarrito = $baseDatos->obtenerCarrito($_SESSION['idUsuario']);

            if (isset($_SESSION['carrito'][$idJuego])) {
                // Eliminar el juego de la sesión
                unset($_SESSION['carrito'][$idJuego]);

                // Eliminar el juego de la base de datos
                $baseDatos->eliminarJuegoDelCarrito($idCarrito, $idJuego);

                $this->error = "Juego eliminado del carrito.";
            } else {
                $this->error = "El juego no está en el carrito.";
            }
            $this->irAlCatalogo();
        }
    }

    /**
     * Tramita la compra de juegos.
     * 
     * Este método procesa la compra de juegos en el sistema. Verifica que se haya seleccionado
     * una tarjeta válida y que la fecha de caducidad de la tarjeta sea válida, utilizando un
     * servicio SOAP externo para la validación. Luego, guarda los juegos regalados y los usuarios
     * destinatarios en la sesión antes de proceder con el pago. Si no se selecciona una tarjeta,
     * se muestra un mensaje de error.
     *
     * @return void
     */
    public function tramitarCompra()
    {
        global $baseDatos;
        if (isset($_POST['btn_confirmar_pago']) && $_POST['tarjeta'] !== "0") {
            // Recoger los datos de la tarjeta
            $idTarjeta = $_POST['tarjeta'];
            $tarjetas = $baseDatos->obtenerTarjeta($idTarjeta);
            $fechaCaducidad = $tarjetas[0]['fechaCaducidad'];
            /* list($anioCad, $mesCad, $diaCad) = explode('-', $fechaCaducidad); */
            list($anioCad, $mesCad, $diaCad) = array_map('intval', explode('-', $fechaCaducidad));


            $url = 'http://localhost/gamesRus/servidorSOAP.php';
            $uri = 'http://localhost/gamesRus/';

            try {
                $cliente = new SoapClient(null, array(
                    'location' => $url,
                    'uri'      => $uri
                ));

                $fechaValida = $cliente->esFechaCaducidadValida($diaCad, $mesCad, $anioCad);
                if (!$fechaValida) {
                    /* $this->error = "La fecha de caducidad es inválida."; */
                    $this->error = var_dump($diaCad,$mesCad,$anioCad);

                    $this->irAlPago();
                    return;
                }
            } catch (SoapFault $e) {
                $this->error = "<p>Error en la validación de la tarjeta: " . $e->getMessage() . "</p>";
            }

            // Recoger los juegos regalados (si existen) y los usuarios destinatarios
            if (isset($_POST['juegosRegalados']) && is_array($_POST['juegosRegalados'])) {
                $juegosRegalados = $_POST['juegosRegalados'];
            } else {
                $juegosRegalados = []; // Inicializar array vacío si no hay juegos regalados
            }

            if (isset($_POST['usuariosRegalados']) && is_array($_POST['usuariosRegalados'])) {
                $usuariosRegalados = $_POST['usuariosRegalados'];
            } else {
                $usuariosRegalados = []; // Inicializar array vacío si no hay usuarios destinatarios
            }

            // Guardar la información en la sesión
            $_SESSION['juegosRegalados'] = $juegosRegalados;
            $_SESSION['usuariosRegalados'] = $usuariosRegalados;

            // Proceder con el pago
            $this->pagarCompra();
        } else {
            $this->error = "No has seleccionado una tarjeta.";
            $this->irAlPago();
        }
    }


    /**
     * Redirige al usuario a la página de pago si tiene juegos en el carrito.
     * 
     * Este método verifica si el usuario tiene juegos en su carrito. Si es así, muestra
     * las tarjetas de pago disponibles utilizando la función `mostrarTarjetas`. Si el carrito
     * está vacío, muestra un mensaje de error indicando que el carrito está vacío y redirige
     * al usuario a su carrito.
     *
     * @return void
     */
    public function irAlPago()
    {
        $idUsuario = $_SESSION['idUsuario'];
        if (isset($_SESSION['carrito']) && sizeof($_SESSION['carrito'])!=0) {
            global $baseDatos;
            $this->data = $baseDatos->mostrarTarjetas($idUsuario);
            var_dump($_SESSION);
            Vista::MuestraPago($this->data, $this->error);
        } else {
            $this->error = "No tienes nada en el carrito.";
            $this->irAlCarrito();
        }
    }


    /**
     * Procesa el pago de la compra de juegos y gestiona los juegos regalados.
     * 
     * Este método verifica si el usuario tiene juegos en su carrito de compra. Luego,
     * gestiona la compra de juegos, realizando los siguientes pasos:
     * - Si un juego está marcado como regalo para otro usuario, se verifica si el destinatario
     *   no tiene el juego y se le regala.
     * - Si el juego no es un regalo, se compra para el usuario.
     * Después de procesar la compra, los juegos se eliminan del carrito de compras y la sesión
     * se actualiza.
     *
     * @return void
     */
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


    /**
     * Subir archivos de diferentes formatos.
     * 
     * Este método gestiona la subida de archivos. Llama a los métodos específicos
     * `subirArchivosJSON` y `subirArchivosXML` para subir archivos en formato JSON y XML,
     * respectivamente.
     *
     * @return void
     */
    public function subirArchivos()
    {
        $this->subirArchivosJSON();
        $this->subirArchivosXML();
    }


    /**
     * Subir y procesar archivos XML para cargar juegos en la base de datos.
     * 
     * Este método lee un archivo XML que contiene información sobre juegos y los carga en la
     * base de datos. Para cada juego, el método verifica si ya existe en la base de datos
     * antes de agregarlo. Si el juego ya existe, se agrega un mensaje indicando que ya está
     * presente; de lo contrario, se agrega el juego y sus detalles como género y sistemas.
     *
     * @return void
     */
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


    /**
     * Subir y procesar archivos JSON para cargar juegos en la base de datos.
     * 
     * Este método lee un archivo JSON que contiene información sobre juegos y los carga en la
     * base de datos. Al igual que en el caso del XML, se verifica si el juego ya existe en la base
     * de datos antes de agregarlo. Si el juego ya está presente, se agrega un mensaje indicando
     * que ya existe, de lo contrario, el juego se agrega junto con sus detalles de género y sistemas.
     *
     * @return void
     */
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

    /**
     * Compara un título con una lista de títulos existentes.
     * 
     * Este método recibe un array de títulos y un título específico para comparar. Si el título
     * dado ya existe en el array, el método devuelve `true`, de lo contrario, devuelve `false`.
     *
     * @param array $arrayTitulos Un array con los títulos de juegos existentes en la base de datos.
     * @param string $titulo El título del juego que se quiere verificar si ya existe.
     *
     * @return bool `true` si el título existe en el array, `false` si no.
     */
    public function compararTitulos($arrayTitulos, $titulo)
    {
        foreach ($arrayTitulos as $t1) {
            if (strcmp($t1, $titulo) === 0) {
                return true;
            }
        }
    }


    /**
     * Filtrar juegos según género, sistema y año.
     * 
     * Este método filtra los juegos en función de los parámetros proporcionados a través de un
     * formulario. Si se recibe una solicitud POST con los filtros seleccionados, el método
     * recupera los juegos correspondientes desde la base de datos. Además, carga la información
     * sobre los géneros, sistemas y años disponibles para el filtrado. Si no se recibe una solicitud
     * POST, se muestra un mensaje de error.
     *
     * @return void
     */
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

    /**
     * Obtener el último juego añadido y mostrarlo con un límite de caracteres.
     * 
     * Este método recupera el último juego añadido desde la base de datos y genera un mensaje con su
     * nombre. Si el nombre del juego excede una longitud máxima definida, el mensaje será truncado
     * y se añadirá un "..." al final. El texto resultante se muestra en pantalla.
     *
     * @return void
     */
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

    // REVISAR ESTE ENGENDRO
    /*public function reegalarJuegoBiblioteca()
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
    }*/
}






// El programa en sí comienza aquí
$programa = new Controlador();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $programa->handlePost();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $programa->handleGet();
}
