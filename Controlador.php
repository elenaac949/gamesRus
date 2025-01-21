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
        session_start();
        /*         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['irInicioSesion'])) {
                Vista::MuestraLogin($this->data);
            }
        } else {
            Vista::MuestraLanding();exit;
        } */

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
            'btn_anadir_carrito' => 'anadirAlCarrito',
            'btn_eliminar_del_carrito' => 'quitarDelCarrito',
            'btn_pagar' => 'pagarCompra',
            'cerrar_sesion' => 'cerrarSesion',
            'prestar' => 'irAPrestar',
            'prestar-juego' => 'prestarJuego',
            'btn_confirmar_regalo' => 'regalarJuego',
            'mobyGames' => 'mobyGames',

        ];


        $this->procesarAcciones($_POST, $accionesPost);
    }



/*     private function procesarAcciones($datos, $acciones)
    {
        foreach ($acciones as $key => $metodo) {
            if (isset($datos[$key]) && method_exists($this, $metodo)) {
                $this->$metodo($datos[$key]);
                return; // Terminamos después de la acción.
            }
        }
    } */
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


    public function mobyGames($urlMobyGames)
    {
        echo file_get_contents($urlMobyGames);
        die();
    }


    public function handleGet()
    {
        $accionesGet = [
            'mobyGames' => 'mobyGames',
        ];
        $this->procesarAcciones($_GET, $accionesGet);
    }



    /*    private function procesarAcciones($datos, $acciones)
    {
        foreach ($acciones as $key => $metodo) {
            if (isset($datos[$key]) && method_exists($this, $metodo)) {
                if ($datos === $_GET) {
                    $this->$metodo($datos[$key]); // Pasamos el valor en caso de GET
                } else {
                    $this->$metodo();
                }
                break; 
            }
        }
    } */



    /*     public function Inicio()
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
                Vista::MuestraBiblioteca($this->data, $this->data1, $this->error);
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
        }
    } */


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
        // $this->action = 'registro';
        Vista::MuestraRegistro($this->data);
    }

    public function irABiblioteca()
    {
        if (isset($_POST['btn_mostrar_detalles'])) {
            $this->mostrarDetalles();
        } else {
            $this->error = "Mostrar biblioteca";
            $this->datosBiblioteca();
        }
        Vista::MuestraBiblioteca($this->data, $this->data1, $this->error);
        //$this->action = 'biblioteca';
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
        //$this->action = 'catalogo';
        Vista::MuestraCatalogo($this->data, $this->data1, $this->error);
    }

    public function irAlCarrito()
    {
        global $baseDatos;
        $idCarrito = $baseDatos->obtenerCarrito($_SESSION['idUsuario']);
        $this->data = $baseDatos->obtenerJuegosDelCarrito($idCarrito);
        Vista::MuestraCarrito($this->data, $this->error, $this->data1);
    }


    // Función que te lleva al panel de administración
    public function irAlAdministrador()
    {
        //$this->action = 'administracion';
        $this->mostrarFormulario();
        Vista::MuestraAdministración($this->data, $this->error);
    }

    public function irAlPerfil()
    {
        global $baseDatos;
        $this->data = $baseDatos->obtenerDatosUsuario();
        $this->data1 = $baseDatos->mostrarTarjetas($_SESSION['idUsuario']);

        Vista::MuestraPerfil($this->data, $this->data1, $this->error);
        //$this->action = 'perfil';
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
            $numeroTelefono = $_POST['telefono'];

            $patron = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
            //Hacer una consulta a la bbdd que verifiqeu si ese email o nick existen
            if ($baseDatos->existeUsuario($nick, $correo)) {
                $this->data = 'Correo o nick ya existentes';
                //$this->action = 'registro';
                Vista::MuestraRegistro($this->data);
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
                //$this->action = 'catalogo';
                Vista::MuestraCatalogo($this->data, $this->data1, $this->error);
            } else {
                $this->error = 'Error: El usuario ' . $nick . ' no existe';
                //$this->action = 'prestar';
                Vista::MuestraPrestar($this->data, $this->error);
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
                $this->data1 = 'Regalo para ' . $nick;
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
        //$this->action = 'landing';
        Vista::MuestraLanding();
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
        } else {
            $this->error = "Revisa la informacion";
        }
        $this->irAlPerfil();
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
            $anio += 2000; // Asumimos siglo actual
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

        $this->irAlPerfil();
    }



    /* JUEGOS */

    /* Funcion para gestionar la importacion de los jegos a partir de un fichero */

    public function importarJuegos() {}




    function importarJson()
    {
        // Verificar si el archivo existe
        $dirJson = ".\gamesRus\archivos\JSON\juegos.json";
        if (!file_exists($dirJson)) {
            echo "Error: El archivo JSON no existe en la ruta especificada.";
            return null;
        }

        // Intentar leer el contenido del archivo
        $contenidoJson = file_get_contents($dirJson);
        if ($contenidoJson === false) {
            echo "Error: No se pudo leer el archivo JSON.";
            return null;
        }

        // Eliminar espacios en blanco y saltos de línea al principio y al final
        $contenidoJson = trim($contenidoJson);

        // Verificar si el contenido parece ser JSON válido
        if (empty($contenidoJson) || $contenidoJson[0] != '{' || $contenidoJson[strlen($contenidoJson) - 1] != '}') {
            echo "Error: El archivo JSON tiene un formato inválido.";
            return null;
        }

        // Convertir el JSON en un arreglo asociativo manualmente
        // El contenido del archivo JSON está en formato texto, así que tenemos que hacerlo a mano
        $data = [];
        $contenidoJson = substr($contenidoJson, 1, strlen($contenidoJson) - 2); // Eliminar las llaves inicial y final


        $entradas = explode(',', $contenidoJson);


        foreach ($entradas as $entrada) {
            $entrada = trim($entrada);

            // Dividir la entrada por los dos puntos para separar la clave y el valor
            $keyValue = explode(':', $entrada, 2);
            if (count($keyValue) != 2) {
                continue; // Si no tiene el formato clave:valor, ignorar esta entrada
            }

            // Limpiar las claves y los valores
            $key = trim($keyValue[0], '"');
            $value = trim($keyValue[1]);

            // Si el valor es una cadena, eliminar las comillas
            if ($value[0] == '"' && $value[strlen($value) - 1] == '"') {
                $value = trim($value, '"');
            }

            // Agregar al arreglo de datos
            $data[$key] = $value;
        }

        return $data;
    }


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
                //$this->action = 'administracion';
            } else {
                $this->error = 'Datos incompletos.';
                //$this->action = 'administracion';
            }
            $this->mostrarFormulario();
            Vista::MuestraAdministración($this->data, $this->error);
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
                //$this->action = 'administracion';
            } else {
                $this->error = 'Datos incompletos.';
                //$this->action = 'administracion';
            }
            $this->mostrarFormulario();
            Vista::MuestraAdministración($this->data, $this->error);
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
            Vista::MuestraAdministración($this->data, $this->error);
        }
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
}
// El programa en sí comienza aquí
$programa = new Controlador();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $programa->handlePost();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $programa->handleGet();
}
 



// var_dump($_POST);
/* if (isset($_POST['loginUsuario'])) {
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
} elseif (isset($_POST['btn_confirmar_regalo'])) {
    $programa->regalarJuego();
} elseif (isset($_POST['btn_subir_archivo'])) {
    $programa->importarJuegos();
} */
// } elseif (isset($_POST['a'])) {
//     echo "hola";
// }


/* $programa->Inicio(); */
