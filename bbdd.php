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

    //Registro de usuario
    public function registrarUsuario($nombre, $apellidos, $correo, $nick, $contrasenia)
    {
        try {
            $sql = "INSERT INTO `usuario` (`nick`, `email`, `nombre`, `apellidos`, `contrasenia`) 
                    VALUES (:nick, :correo, :nombre, :apellidos, :contrasenia)"; //etiquetas para que luego se cambien son valores predeterminado consultas preparadas 
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                ':nick' => $nick,
                ':correo' => $correo,
                ':nombre' => $nombre,
                ':apellidos' => $apellidos,
                ':contrasenia' => $contrasenia,
            ]);
           
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    //Función para mostrar los juegos comprados por un usuario en concreto

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
            $sql = "SELECT idUsuario FROM usuario WHERE `nick` = :nick OR `email` = :correo";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                ':nick' => $nick,
                ':correo' => $correo                
            ]);
    
            // Busco el primer resultado
            $coincidencias = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Si no hay coincidencias, devuelvo true indicando que no existe el usuario
            if ($coincidencias) {
                return false; // Ya existe un usuario con el mismo correo o nick
            } else {
                return true;  // No existe usuario con ese correo o nick
            }
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
