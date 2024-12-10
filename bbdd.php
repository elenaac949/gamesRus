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

    //Registrar usuario - Cambiado
    public function registrarUsuario($nombre, $apellidos, $correo, $nick, $contrasenia)
    {
        try {
            $sql = "INSERT INTO `usuario` (`nick`, `email`, `nombre`, `apellidos`, `contrasenia`) 
                    VALUES (:nick, :correo, :nombre, :apellidos, :contrasenia)"; //etiquetas para que luego se cambien son valores predeterminado consultas preparadas 
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nick', $nick);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellidos', $apellidos);
            $stmt->bindParam(':contrasenia', $contrasenia);
            $stmt->execute();            
           
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
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

    public function verificarSiExisteUsuario($nick, $correo) {
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
    
    


    // Este metodo se ejecuta al finalizar la ejecución de la web,
    // eliminamos la conexión para que no dé error de conexión si se ejecuta muchas veces rapido
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
