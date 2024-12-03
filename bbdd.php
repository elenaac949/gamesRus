<?php
class Database
{
    private $conexion;

    // Constructor para inicializar la conexión
    public function __construct($dsn, $usuario, $password)
    {
        try {
            $this->conexion = new PDO($dsn, $usuario, $password);
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
            $sql = "SELECT `nick`, `email`, `contrasenia` FROM `usuario`;";
            $consulta = $this->conexion->query($sql);
            foreach ($consulta as $fila) {
                if ($fila['nick'] == $credencial || $fila['email'] == $credencial) {
                    echo 'usuario correcto';

                    if ($fila['contrasenia'] == $password) {
                        echo 'Contraseña correcta';
                    }
                } else {
                    echo 'error';
                }
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //Registro de usuario
    public function registrarUsuario($nombre, $apellidos, $correo, $nick, $contrasenia)
    {
        try {
            $sql = "INSERT INTO `usuario` (`nick`, `email`, `nombre`, `apellidos`, `contrasenia`) 
                    VALUES (:nick, :correo, :nombre, :apellidos, :contrasenia)";
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
