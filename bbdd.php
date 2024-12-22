<?php
class Database
{
    private $conexion;

    // Constructor para inicializar la conexión
    public function __construct($dsn, $usuario, $password)
    {
        try {
            $this->conexion = new PDO($dsn, $usuario, $password, array(PDO::ATTR_PERSISTENT => true));
        } catch (PDOException $e) {
            echo "Error (" . $e->getCode() . ") al abrir la base de datos: " . $e->getMessage();
            exit;
        }
    }

    public function controlLogin($credencial)
    {
        try {
            $sql = "SELECT `idUsuario`,`nick`, `email`, `contrasenia` FROM `usuario` 
                    WHERE `nick` = :credencial OR `email` = :credencial";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':credencial', $credencial);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            return $usuario;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //Registrar usuario - Create
    public function registrarUsuario($nombre, $apellidos, $correo, $nick, $contrasenia, $tipoDeVia, $nombreDeVia, $numero, $numeroTelefono)
    {
        try {
            // Consulta SQL con etiquetas para consultas preparadas
            $sql = "INSERT INTO `usuario` 
                    (`nick`, `email`, `nombre`, `apellidos`, `contrasenia`, `TipoDeVia`, `NombreDeVia`, `Numero`, `NumeroTelefono`) 
                    VALUES 
                    (:nick, :correo, :nombre, :apellidos, :contrasenia, :tipoDeVia, :nombreDeVia, :numero, :numeroTelefono)";

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);

            // Asignar valores a las etiquetas
            $stmt->bindParam(':nick', $nick);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellidos', $apellidos);
            $stmt->bindParam(':contrasenia', $contrasenia);
            $stmt->bindParam(':tipoDeVia', $tipoDeVia);
            $stmt->bindParam(':nombreDeVia', $nombreDeVia);
            $stmt->bindParam(':numero', $numero, PDO::PARAM_INT);
            $stmt->bindParam(':numeroTelefono', $numeroTelefono);

            // Ejecutar la consulta
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //obtener los datos del usuario para autorellenar 
    public function obtenerDatosUsuario(){
        $userId=$_SESSION['idUsuario'];
        try {

            $sql="SELECT nick, email, nombre, apellidos,contrasenia, TipoDeVia, NombreDeVia, Numero, Numeros, NumeroTelefono, Otros FROM usuario WHERE idUsuario = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $userData;
        } catch (PDOException $e) {
            echo "Error en la conexión: " . $e->getMessage();
        }
    }

    //Update usuario

    public function actualizarUsuario($nombre, $apellidos, $correo, $nick, $contrasenia, $tipoDeVia, $nombreDeVia, $numeroVia, $numeros, $otros, $numeroTelefono){
        try {
            // Consulta SQL con etiquetas para consultas preparadas
            $sql = "UPDATE INTO `usuario` 
                    (`nick`, `email`, `nombre`, `apellidos`, `contrasenia`, `TipoDeVia`, `NombreDeVia`, `Numero`, `Numeros`,`Otros`, `NumeroTelefono`) 
                    VALUES 
                    (:nick, :correo, :nombre, :apellidos, :contrasenia, :tipoDeVia, :nombreDeVia, :numeroVia,:numeros, :otros, :numeroTelefono)";

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);

            // Asignar valores a las etiquetas
            $stmt->bindParam(':nick', $nick);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellidos', $apellidos);
            $stmt->bindParam(':contrasenia', $contrasenia);
            $stmt->bindParam(':tipoDeVia', $tipoDeVia);
            $stmt->bindParam(':nombreDeVia', $nombreDeVia);
            $stmt->bindParam(':numeroVia', $numeroVia, PDO::PARAM_INT);
            $stmt->bindParam(':numeros', $numeros);
            $stmt->bindParam(':otros', $otros);
            $stmt->bindParam(':numeroTelefono', $numeroTelefono);

            // Ejecutar la consulta
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //Delete usuario
    public function eliminarUsuario($nick)
    {
        try {
            $sql = "DELETE FROM `usuario` WHERE `nick` = :nick";
            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nick', $nick);

            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

    }

    // Añadir tarjeta
    // public function agnadirTarjeta($)
    //Función para mostrar los juegos comprados por un usuario en concreto  FALTA REGALADO Y PRESTADO
    public function mostrarBiblioteca($idUsuario)
    {
        try {
            $sql = "SELECT * FROM juego j INNER JOIN comprado c ON j.idJuego = c.idJuego WHERE c.idUsuario = :idUsuario;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();
            $biblioteca = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetchAll para obtener todas las filas
            return $biblioteca;
        } catch (\Throwable $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function verificarSiExisteUsuario($nick, $correo)
    {
        try {
            // Preparar la consulta
            $sql = "SELECT idUsuario FROM usuario WHERE `nick` = :nick OR `email` = :correo";
            $stmt = $this->conexion->prepare($sql);

            // Asociar parámetros con bindParam
            $stmt->bindParam(':nick', $nick, PDO::PARAM_STR);
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);

            // Ejecutar la consulta
            $stmt->execute();

            // Buscar el primer resultado
            $coincidencias = $stmt->fetch(PDO::FETCH_ASSOC);

            // Si hay coincidencias, devuelve false (usuario ya existe)
            return !$coincidencias;
        } catch (\Throwable $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Función que muestra todos los juegos
    public function mostrarJuegos()
    {
        try {
            // Establecer la consulta SQL
            $sql = "SELECT * FROM `juego`";

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);  // Asumiendo que $this->pdo es tu conexión PDO

            // Ejecutar la consulta
            $stmt->execute();

            // Obtener los resultados (como un array asociativo)
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Retornar los resultados
            return $resultados;
        } catch (Exception $e) {
            // Si hay un error, mostrar el mensaje
            echo "Error: " . $e->getMessage();
        }
    }


    //Agregar un juego nuevo
    public function agregarJuego($titulo, $desarrollador, $distribuidor, $anio, $ruta, $genero, $descripcion, $portada)
    {
        try {
            // Consulta SQL actualizada
            $sql = "INSERT INTO `juego` 
                (`titulo`, `desarrollador`, `distribuidor`, `anio`, `ruta`, `idGenero`, `descripcion`, `portada`) 
                VALUES 
                (:titulo, :desarrollador, :distribuidor, :anio, :ruta, :idGenero, :descripcion, :portada)";

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);

            // Asignar valores a las etiquetas
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':desarrollador', $desarrollador);
            $stmt->bindParam(':distribuidor', $distribuidor);
            $stmt->bindParam(':anio', $anio, PDO::PARAM_INT);
            $stmt->bindParam(':ruta', $ruta);
            $stmt->bindParam(':idGenero', $genero, PDO::PARAM_INT);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':portada', $portada);

            // Ejecutar la consulta
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    // Editar juego
    public function editarJuego($titulo, $desarrollador, $distribuidor, $anio, $ruta, $genero)
    {
        try {
            // Consulta SQL corregida
            $sql = "UPDATE INTO `juego` 
                    (`titulo`, `desarrollador`, `distribuidor`, `anio`, `ruta`, `idGenero`) 
                    VALUES 
                    (:titulo, :desarrollador, :distribuidor, :anio, :ruta, :idGenero)";

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);

            // Asignar valores a las etiquetas
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':desarrollador', $desarrollador);
            $stmt->bindParam(':distribuidor', $distribuidor);
            $stmt->bindParam(':anio', $anio, PDO::PARAM_INT);
            $stmt->bindParam(':ruta', $ruta);
            $stmt->bindParam(':idGenero', $genero, PDO::PARAM_INT);

            // Ejecutar la consulta
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    // Eliminar juego 
    public function eliminarJuego($idJuego)
    {
        try {
            $sql = "DELETE FROM `juego`WHERE `idJuego` = :idJuego )";
            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idJuego', $idJuego);

            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    public function accederGeneros()
    {
        try {
            // Establecer la consulta SQL
            $sql = "SELECT * FROM `genero`";

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);  // Asumiendo que $this->pdo es tu conexión PDO

            // Ejecutar la consulta
            $stmt->execute();

            // Obtener los resultados (como un array asociativo)
            $generos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Retornar los resultados
            return $generos;
        } catch (Exception $e) {
            // Si hay un error, mostrar el mensaje
            echo "Error: " . $e->getMessage();
        }
    }


    // Este metodo se ejecuta al finalizar la ejecución de la web,
    // Eliminamos la conexión para que no dé error de conexión si se ejecuta muchas veces rapido
    function __destruct()
    {
        $this->conexion = null;
    }
}

// Uso de la clase
include "./env/conf.env";

// Crear una instancia de la clase y mostrar los productos
$baseDatos = new Database($dsn, $usuario, $password);
// $baseDatos->mostrarProductos();
