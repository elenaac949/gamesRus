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

    //Mostramos toda la tabla de usuarios
    public function mostrarProductos()
    {
        try {
            $sql = "SELECT * FROM USUARIO;";
            $consulta = $this->conexion->query($sql);

            if ($consulta === false) {
                throw new Exception("Error al ejecutar la consulta SQL.");
            }

            // Iterar y mostrar los resultados
            foreach ($consulta as $fila) {
                echo "idUsuario: " . $fila['idUsuario'] . '<br>';
                echo "Nick: " . $fila['nick'] . '<br>';
                echo "Email: " . $fila['email'] . '<br>';
                echo "Nombre: " . $fila['nombre'] . '<br>';
                echo "Apellidos: " . $fila['apellidos'] . '<br>';
                echo "Contraseña: " . $fila['contrasenia'] . '<br>';
                echo "----------------<br>";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function controlLogin($credencial, $password)
    {
        try {
            $sql = "SELECT `nick`, `email`, `contrasenia` FROM `usuario` 
                    WHERE `nick` = :credencial OR `email` = :credencial";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':credencial', $credencial);
            $stmt->execute();
    
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($usuario) {
                // Verificar la contraseña
                if (password_verify($usuario['contrasenia'],$password)) {
                    echo 'Usuario y contraseña correctos.';
                    return true; // Retornar un valor en lugar de seguir con echo
                } else {
                    echo 'Contraseña incorrecta.';
                    return false;
                }
            } else {
                echo 'Usuario no registrado.';
                return false;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
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
            echo "Usuario registrado correctamente.";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

   
}

// Uso de la clase
include "./env/conf.env";

// Crear una instancia de la clase y mostrar los productos
$baseDatos = new Database($dsn, $usuario, $password);
// $baseDatos->mostrarProductos();
