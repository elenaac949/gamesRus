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


    /* ----USUARIOS--- */

    public function existeUsuario($nick, $correo)
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
            // Devolver true si se encontró una coincidencia, false en caso contrario
            return $coincidencias !== false;
        } catch (\Throwable $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function obtenerIdUsuario($nick)
    {
        try {
            $sql = "SELECT idUsuario FROM usuario WHERE `nick` = :nick";
            $stmt = $this->conexion->prepare($sql);

            // Asociar parámetros con bindParam
            $stmt->bindParam(':nick', $nick, PDO::PARAM_STR);

            // Ejecutar la consulta
            $stmt->execute();

            // Obtener el resultado
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            // Si se encontró un resultado, devolver el id como entero, de lo contrario devolver null
            return $resultado ? (int) $resultado['idUsuario'] : null;
        } catch (\Throwable $e) {
            echo "Error: " . $e->getMessage();
            return null;
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
                    (`nick`, `email`, `nombre`, `apellidos`, `contrasenia`, `tipoDeVia`, `nombreDeVia`, `numeroDeVia`, `numeroTelefono`, `idRol` ) 
                    VALUES 
                    (:nick, :correo, :nombre, :apellidos, :contrasenia, :tipoDeVia, :nombreDeVia, :numero, :numeroTelefono,1)";

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
    public function obtenerDatosUsuario()
    {
        $userId = $_SESSION['idUsuario'];
        try {

            $sql = "SELECT * FROM usuario WHERE idUsuario = :id";
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

    public function actualizarUsuario($nombre, $apellidos, $correo, $nick, $tipoDeVia, $nombreDeVia, $numeroVia, $numeros, $otros, $numeroTelefono)
    {
        try {
            // Consulta SQL con etiquetas para consultas preparadas
            $idUsuario = $_SESSION['idUsuario'];
            $sql =  "UPDATE `usuario`
                     SET `nick` = :nick, 
                        `email` = :correo, 
                        `nombre` = :nombre, 
                        `apellidos` = :apellidos, 
                        
                        `tipoDeVia` = :tipoDeVia, 
                        `nombreDeVia` = :nombreDeVia, 
                        `numeroDeVia` = :numeroVia, 
                        `numeros` = :numeros, 
                        `otros` = :otros, 
                        `numeroTelefono` = :numeroTelefono
                    WHERE `idUsuario` = :id";

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);

            // Asignar valores a las etiquetas
            $stmt->bindParam(':nick', $nick);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellidos', $apellidos);
            $stmt->bindParam(':tipoDeVia', $tipoDeVia);
            $stmt->bindParam(':nombreDeVia', $nombreDeVia);
            $stmt->bindParam(':numeroVia', $numeroVia, PDO::PARAM_INT);
            $stmt->bindParam(':numeros', $numeros);
            $stmt->bindParam(':otros', $otros);
            $stmt->bindParam(':numeroTelefono', $numeroTelefono);
            $stmt->bindParam(':id', $idUsuario);
            var_dump($stmt->queryString);

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
    public function anadirTarjeta($numeroTarjeta, $ccv, $fechaCaducidad, $idUsuario)
    {
        try {
            // Consulta SQL con etiquetas para consultas preparadas
            $sql = "INSERT INTO `tarjeta` 
                (`numeroTarjeta`, `ccv`, `fechaCaducidad`, `idUsuario`) 
                VALUES 
                (:numeroTarjeta, :ccv, :fechaCaducidad, :idUsuario)";

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);

            // Asignar valores a las etiquetas
            $stmt->bindParam(':numeroTarjeta', $numeroTarjeta);
            $stmt->bindParam(':ccv', $ccv);
            $stmt->bindParam(':fechaCaducidad', $fechaCaducidad);
            $stmt->bindParam(':idUsuario', $idUsuario);

            // Ejecutar la consulta
            $stmt->execute();
            echo "Tarjeta añadida correctamente.";
        } catch (Exception $e) {
            // Manejar errores
            echo "Error al añadir la tarjeta: " . $e->getMessage();
        }
    }


    public function editarTarjeta($ccv, $caducidad, $idUsuario)
    {
        try {
            // Consulta SQL con etiquetas para consultas preparadas
            $sql = "UPDATE `tarjeta` 
                    SET `ccv` = :ccv, `fechaCaducidad` = :caducidad 
                    WHERE `idUsuario` = :idUsuario";

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);

            $stmt->bindParam(':ccv', $ccv);
            $stmt->bindParam(':caducidad', $caducidad);
            $stmt->bindParam(':idUsuario', $idUsuario);

            // Ejecutar la consulta
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    //Eliminar tarjeta
    function eliminarTarjeta($idTarjeta)
    {
        try {
            $sql = "DELETE FROM `tarjeta` WHERE `idTarjeta` = :idTarjeta";
            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idTarjeta', $idTarjeta);

            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    //Función para mostrar las tarjetas 
    public function mostrarTarjetas($idUsuario)
    {
        try {
            $sql = "SELECT * FROM `tarjeta` WHERE `idUsuario` = :idUsuario";

            // Preparar la consulta SQL
            $stmt = $this->conexion->prepare($sql);

            // Vincular el parámetro :idUsuario con el valor proporcionado
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);

            // Ejecutar la consulta
            $stmt->execute();

            // Obtener todas las filas de resultados
            $tarjeta = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $tarjeta;
        } catch (Exception $e) {
            // Capturar y mostrar el error si ocurre
            echo "Error: " . $e->getMessage();
        }
    }


    public function tarjetaExiste($numeroTarjeta, $ccv, $idUsuario)
    {
        global $baseDatos;

        // Comprobar si existe una tarjeta con el mismo número y CCV para el usuario actual
        $sql = "SELECT * FROM `tarjeta` WHERE `numeroTarjeta` = :numeroTarjeta AND `ccv` = :ccv AND `idUsuario` = :idUsuario";
        $stmt = $baseDatos->conexion->prepare($sql);
        $stmt->bindParam(':numeroTarjeta', $numeroTarjeta, PDO::PARAM_STR);
        $stmt->bindParam(':ccv', $ccv, PDO::PARAM_STR);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);

        $stmt->execute();

        // Si se encuentra alguna tarjeta, devolvemos true (existe)
        return $stmt->rowCount() > 0;
    }


    // Añadir juego a la biblioteca
    public function agregarJuegoBiblioteca($idUsuario, $idJuego)
    {
        try {
            // Consulta SQL con etiquetas para consultas preparadas
            $sql = "INSERT INTO `comprado` 
                    (`idUsuario`, `idJuego`) 
                    VALUES 
                    (:idUsuario, :idJuego)";

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);

            // Asignar valores a las etiquetas
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);

            // Ejecutar la consulta
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //Eliminar juego de la biblioteca
    public function eliminarJuegoBiblioteca($idUsuario, $idJuego)
    {
        try {
            $sql = "DELETE FROM `comprado` WHERE `idUsuario` = :idUsuario AND `idJuego` = :idJuego";
            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);

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

    /* ----CARRITO---- */

    /* Obtenemos el carrito o lo creamos si no existe--CREATE y READ */

    function obtenerCarrito($idUsuario)
    {
        try {
            // SQL para obtener el carrito del usuario
            $sql = "SELECT idCarrito FROM carrito WHERE idUsuario = :idUsuario";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();
            $carrito = $stmt->fetch(PDO::FETCH_ASSOC);

            // Creamos el carrito si no existe
            if (!$carrito) {
                // Insertar el nuevo carrito
                $sqlInsert = "INSERT INTO carrito (idUsuario) VALUES (:idUsuario)";
                $stmt = $this->conexion->prepare($sqlInsert);
                $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
                $stmt->execute();

                // Obtenemos el id del carrito insertado 
                $sqlSelect = "SELECT idCarrito FROM carrito WHERE idUsuario = :idUsuario ORDER BY idCarrito DESC LIMIT 1";
                $stmt = $this->conexion->prepare($sqlSelect);
                $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
                $stmt->execute();
                $carrito = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            // Devolver el ID del carrito
            return $carrito['idCarrito'];
        } catch (PDOException $e) {
            // Manejar errores de la base de datos
            throw new Exception("Error al obtener el carrito: " . $e->getMessage());
        }
    }



    /* Funcion para verificar si el juego ya esta en el carrito.
    No podemos repetir el mismo juego en el carrito debido a la estructura de la BBDD */
    function verificarJuegoEnCarrito($idCarrito, $idJuego)
    {
        try {
            // Consulta SQL para verificar si el juego ya está en el carrito
            $sql = "SELECT COUNT(*) AS total FROM carritoJuego WHERE idCarrito = :idCarrito AND idJuego = :idJuego";
            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);

            // Vincular los parámetros
            $stmt->bindParam(':idCarrito', $idCarrito, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);

            // Ejecutar la consulta
            $stmt->execute();
            // Obtener el resultado
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);

            return $fila['total'] > 0; // Devuelve true si el juego ya está en el carrito
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    /* MODIFY Carrito */
    function anadirJuegoAlCarrito($idCarrito, $idJuego)
    {

        $idUsuario = $_SESSION['idUsuario'];

        try {
            // Añadir el juego al carrito
            $sql = "INSERT INTO carritoJuego (idCarrito, idJuego) VALUES (:idCarrito, :idJuego)";
            $stmt = $this->conexion->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta.");
            }

            // Vincular los parámetros
            $stmt->bindParam(':idCarrito', $idCarrito, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
            // Ejecutar la consulta
            $stmt->execute();

            return "Juego añadido al carrito correctamente.";
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }



    function obtenerJuegosDelCarrito($idCarrito)
    {
        try {
            // Asegúrate de incluir idUsuario en la consulta si es necesario
            $sql = "SELECT j.idJuego, j.titulo, j.desarrollador, j.distribuidor, j.anio, j.ruta, j.descripcion, j.portada
                    FROM juego j
                    JOIN carritoJuego cj ON j.idJuego = cj.idJuego
                    WHERE cj.idCarrito = :idCarrito";

            $stmt = $this->conexion->prepare($sql);

            // Vincula los parámetros correctamente
            $stmt->bindParam(':idCarrito', $idCarrito, PDO::PARAM_INT);

            $stmt->execute();

            // Devuelve los juegos en un array asociativo
            $juegos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $juegos;
        } catch (Exception $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            return [];
        }
    }

    /* Eliminar 1 juego del carrito */

    public function eliminarJuegoCarrito($idCarrito, $idJuego)
    {
        try {
            // Preparamos la consulta para eliminar el juego del carrito
            $sql = "DELETE FROM carritoJuego WHERE idCarrito = :idCarrito AND idJuego = :idJuego";
            $stmt = $this->conexion->prepare($sql);

            // Vinculamos los parámetros 
            $stmt->bindParam(':idCarrito', $idCarrito, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);

            // Ejecutamos la consulta
            $stmt->execute();



            return "Eliminado con exito";
        } catch (Exception $e) {
            return  "Error en la base de datos: " . $e->getMessage();
        }
    }

    public function eliminarTodosLosJuegosCarrito($idCarrito)
    {
        try {

            $sql = "DELETE FROM carritoJuego WHERE idCarrito = :idCarrito";
            $stmt = $this->conexion->prepare($sql);

            $stmt->bindParam(':idCarrito', $idCarrito, PDO::PARAM_INT);

            $stmt->execute();
            return "Pago realizado con éxito";
        } catch (Exception $e) {
            // Si ocurre un error, lo registramos en el log
            error_log("Error en eliminarTodosLosJuegosCarrito: " . $e->getMessage());
            return false;
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


    //Agregar un juego nuevo - HEMOS QUITADO LA RUTA PARA QUE FUNCIONE 
    public function agregarJuego($titulo, $desarrollador, $distribuidor, $anio,  $generos, $descripcion, $portada)
    {
        try {
            // Consulta SQL actualizada
            $sql = "INSERT INTO `juego` 
                (`titulo`, `desarrollador`, `distribuidor`, `anio`,`descripcion`, `portada`) 
                VALUES 
                (:titulo, :desarrollador, :distribuidor, :anio, :descripcion, :portada)";

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);

            // Asignar valores a las etiquetas
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':desarrollador', $desarrollador);
            $stmt->bindParam(':distribuidor', $distribuidor);
            $stmt->bindParam(':anio', $anio, PDO::PARAM_INT);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':portada', $portada);

            // Ejecutar la consulta
            $stmt->execute();
            // Llamamos a la función que añade los géneros al juego después de insertarlo
            $this->agnadirGeneroJuego($this->conexion->lastInsertId(), $generos);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function agnadirGeneroJuego($idJuego, $arrayIdGeneros)
    {
        try {
            // Consulta SQL actualizada
            $sql = "INSERT INTO `generoJuego` 
                (`idJuego`, `idGenero`) 
                VALUES 
                (:idJuego, :idGenero)";

            foreach ($arrayIdGeneros as $genero) {
                // Preparar la consulta
                $stmt = $this->conexion->prepare($sql);

                // Asignar valores a las etiquetas
                $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
                $stmt->bindParam(':idGenero', $genero, PDO::PARAM_INT);

                // Ejecutar la consulta
                $stmt->execute();
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    // Editar juego
    public function editarJuego($idJuego, $desarrollador, $distribuidor, $anio, $portada, $descripcion)
    {
        try {

            // Consulta SQL corregida
            $sql = "UPDATE `juego`
                    SET 
                        `desarrollador` = :desarrollador,
                        `distribuidor` = :distribuidor,
                        `anio` = :anio,
                        `portada` = :portada,
                        `descripcion` = :descripcion                        
                    WHERE `idJuego` = :idJuego"; // Reemplaza `id` con la clave primaria de la tabla.


            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);

            // Asignar valores a las etiquetas

            $stmt->bindParam(':desarrollador', $desarrollador);
            $stmt->bindParam(':distribuidor', $distribuidor);
            $stmt->bindParam(':anio', $anio, PDO::PARAM_INT);
            $stmt->bindParam(':portada', $portada);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);

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
            $sql = "DELETE FROM `juego`WHERE `idJuego` = :idJuego ";
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

    // Función para prestar juego (faltan los parámetros de fecha estoy pensando)
    public function agnadirPrestamos($idUsuarioPresta, $idUsuarioRecibe, $idJuego)
    {
        try {
            // Crear un objeto DateTime con la fecha actual
            $fechaInicio = new DateTime();

            // Clonar el objeto para fechaFin y añadir 30 días
            $fechaFin = clone $fechaInicio;
            $fechaFin->modify('+30 days');

            // Formatear las fechas
            $fechaInicioFormateada = $fechaInicio->format('Y-m-d H:i:s');
            $fechaFinFormateada = $fechaFin->format('Y-m-d H:i:s');

            // Preparar el SQL de inserción
            $sql = "INSERT INTO `prestado` (`idUsuarioPresta`, `idUsuarioRecibe`, `idJuego`, `fechaInicio`, `fechaFin`) 
                    VALUES (:idUsuarioPresta, :idUsuarioRecibe, :idJuego, :fechaHoy, :fechaDevolver)";

            $stmt = $this->conexion->prepare($sql);

            // Asociar parámetros con bindParam
            $stmt->bindParam(':idUsuarioPresta', $idUsuarioPresta, PDO::PARAM_INT);
            var_dump($idJuego);
            $stmt->bindParam(':idUsuarioRecibe', $idUsuarioRecibe, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
            $stmt->bindParam(':fechaHoy', $fechaInicioFormateada, PDO::PARAM_STR);
            $stmt->bindParam(':fechaDevolver', $fechaFinFormateada, PDO::PARAM_STR);


            // Ejecutar el INSERT
            return $stmt->execute();
        } catch (\Throwable $e) {
            echo "Error: " . $e->getMessage();
            return false;
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
