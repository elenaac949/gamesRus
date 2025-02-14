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
    public function registrarUsuario($nombre, $apellidos, $correo, $nick, $contrasenia, $tipoDeVia, $nombreDeVia, $numero, $numeros, $otros, $numeroTelefono)
    {
        try {
            // Consulta SQL con etiquetas para consultas preparadas
            $sql = "INSERT INTO `usuario` 
                    (`nick`, `email`, `nombre`, `apellidos`, `contrasenia`, `tipoDeVia`, `nombreDeVia`, `numeroDeVia`,`numeros`,`otros`, `numeroTelefono`, `idRol` ) 
                    VALUES 
                    (:nick, :correo, :nombre, :apellidos, :contrasenia, :tipoDeVia, :nombreDeVia, :numero,:numeros,:otros, :numeroTelefono,1)";

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
            $stmt->bindParam(':numeros', $numeros);
            $stmt->bindParam(':otros', $otros);
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
    // Obtenemos todos los usuarios
    public function todosLosUsuarios()
    {
        try {
            $sql = "SELECT * FROM `usuario`";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $usuarios;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /* ----TARJETAS--- */

    // Añadir tarjeta
    public function anadirTarjeta($numeroTarjeta, $fechaCaducidad, $idUsuario)
    {
        try {
            // Consulta SQL con etiquetas para consultas preparadas
            $sql = "INSERT INTO `tarjeta` 
                (`numeroTarjeta`, `fechaCaducidad`, `idUsuario`) 
                VALUES 
                (:numeroTarjeta, :fechaCaducidad, :idUsuario)";

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);

            // Asignar valores a las etiquetas
            $stmt->bindParam(':numeroTarjeta', $numeroTarjeta);
            $stmt->bindParam(':fechaCaducidad', $fechaCaducidad);
            $stmt->bindParam(':idUsuario', $idUsuario);

            // Ejecutar la consulta
            $stmt->execute();
        } catch (Exception $e) {
            // Manejar errores
            echo "Error al añadir la tarjeta: " . $e->getMessage();
        }
    }

    //Editar tarjeta
    public function editarTarjeta($numero, $caducidad, $idUsuario)
    {
        try {
            // Consulta SQL con etiquetas para consultas preparadas
            $sql = "UPDATE `tarjeta` 
                SET `numeroTarjeta` = :numeroTarjeta, `fechaCaducidad` = :caducidad 
                WHERE `idUsuario` = :idUsuario";

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);

            $stmt->bindParam(':numeroTarjeta', $numero, PDO::PARAM_STR); // Aquí corregido
            $stmt->bindParam(':caducidad', $caducidad, PDO::PARAM_STR);
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);

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

    /* Obtener la tarjeta con la que se va a procesar el pago en base a su id POSIBLEMENTE SE PUEDA BORRAR*/
    public function obtenerTarjeta($idTarjeta)
    {
        try {
            $sql = "SELECT * FROM `tarjeta` WHERE `idTarjeta` = :idTarjeta";

            // Preparar la consulta SQL
            $stmt = $this->conexion->prepare($sql);

            // Vincular el parámetro :idUsuario con el valor proporcionado
            $stmt->bindParam(':idTarjeta', $idTarjeta, PDO::PARAM_INT);

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

    // Función para comprobar si la tarjeta existe
    /* public function tarjetaExiste($numeroTarjeta, $caducidad, $idUsuario)
    {
        // Comprobar si existe una tarjeta con el mismo número y CCV para el usuario actual
        $sql = "SELECT * FROM `tarjeta` WHERE `numeroTarjeta` = :numeroTarjeta AND `fechaCaducidad` = :caducidad AND `idUsuario` = :idUsuario";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':numeroTarjeta', $numeroTarjeta, PDO::PARAM_STR);
        $stmt->bindParam(':caducidad', $caducidad);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);

        $stmt->execute();
        // Si se encuentra alguna tarjeta, devolvemos true (existe)
        return $stmt->rowCount() > 0;
    } */

    public function tarjetaExiste($numeroTarjeta, $caducidad, $idUsuario)
    {
        try {
            // Comprobar si existe una tarjeta con el mismo número y fecha de caducidad para el usuario actual
            $sql = "SELECT 1 FROM `tarjeta` WHERE `numeroTarjeta` = :numeroTarjeta AND `fechaCaducidad` = :caducidad AND `idUsuario` = :idUsuario";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':numeroTarjeta', $numeroTarjeta, PDO::PARAM_STR);
            $stmt->bindParam(':caducidad', $caducidad, PDO::PARAM_STR);
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);

            $stmt->execute();

            // Si se encuentra alguna tarjeta, devolvemos true (existe)
            return $stmt->fetch() !== false;
        } catch (PDOException $e) {
            // Manejo de errores
            error_log("Error en tarjetaExiste: " . $e->getMessage());
            return false;
        }
    }


    /* ----JUEGOS--- */

    public function obtenerAnioJuego()
    {
        try {
            // Conectar a la base de datos (usando $this->conexion)
            $sql = "SELECT DISTINCT anio FROM `juego`";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            // Obtener los resultados
            $anios = $stmt->fetchAll(PDO::FETCH_COLUMN);

            return $anios;
        } catch (PDOException $e) {
            // Manejo de errores
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Obtener el último juego introducido en la BBDD
    public function obtenerUltimoJuego()
    {
        try {

            $sql = "SELECT titulo FROM juego ORDER BY idJuego DESC LIMIT 1;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return   $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //Función para obtener el id del juego por el título

    public function obtenerTituloJuego()
    {
        try {
            // Consulta SQL con etiquetas para consultas preparadas
            $sql = "SELECT titulo FROM juego";

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);

            // Ejecutar la consulta
            $stmt->execute();
            $titulos = $stmt->fetchAll(PDO::FETCH_COLUMN);
            return $titulos;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    // Añadir juego a la biblioteca del usuario - COMPRADO
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

    //Eliminar juego de la biblioteca de un usuario
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


    //misma funcion pero usando la tabla posee juego
    public function mostrarBiblioteca($idUsuario)
    {
        $comprado = $this->mostrarComprados($idUsuario);
        $prestado = $this->mostrarPrestados($idUsuario);
        $regalado = $this->mostrarRegalados($idUsuario);

        return array_merge($comprado, $prestado, $regalado);
    }

    // Juegos que YO he comprado
    public function mostrarComprados($idUsuario)
    {
        try {
            $sql = "SELECT j.idJuego,
            j.titulo, 
            j.desarrollador, 
            j.distribuidor, 
            j.anio, 
            j.ruta, 
            j.descripcion, 
            j.portada, 
            GROUP_CONCAT(DISTINCT g.genero SEPARATOR ', ') AS generos,
            GROUP_CONCAT(DISTINCT s.nombre SEPARATOR ', ') AS sistemas,
            true AS comprado
        FROM juego j
        INNER JOIN generoJuego gj ON gj.idJuego = j.idJuego
        INNER JOIN genero g ON gj.idGenero = g.idGenero
        INNER JOIN juegoSistema js ON js.idJuego = j.idJuego
        INNER JOIN sistema s ON s.idSistema = js.idSistema
        INNER JOIN comprado c ON j.idJuego = c.idJuego
                    WHERE c.idUsuario = :idUsuario
        GROUP BY j.idJuego, j.titulo, j.desarrollador, j.distribuidor, j.anio, 
                j.ruta, j.descripcion, j.portada, comprado;";


            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();
            $biblioteca = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetchAll para obtener todas las filas

            return $biblioteca;
        } catch (PDOException $e) {
            error_log("Error al obtener la biblioteca: " . $e->getMessage());
            return false;
        }
    }

    // Juegos que me han PRESTADO
    public function mostrarPrestados($idUsuario)
    {
        try {
            $sql = "SELECT j.idJuego,
                    j.titulo, 
                    j.desarrollador, 
                    j.distribuidor, 
                    j.anio, 
                    j.ruta, 
                    j.descripcion, 
                    j.portada, 
                    GROUP_CONCAT(DISTINCT g.genero SEPARATOR ', ') AS generos,
                    GROUP_CONCAT(DISTINCT s.nombre SEPARATOR ', ') AS sistemas,
                    true AS prestado
                    FROM juego j
                    INNER JOIN generoJuego gj ON gj.idJuego = j.idJuego
                    INNER JOIN genero g ON gj.idGenero = g.idGenero
                    INNER JOIN juegoSistema js ON js.idJuego = j.idJuego
                    INNER JOIN sistema s ON s.idSistema = js.idSistema
                    INNER JOIN prestado c ON j.idJuego = c.idJuego
                            WHERE c.idUsuarioRecibe = :idUsuario
                    GROUP BY j.idJuego, j.titulo, j.desarrollador, j.distribuidor, j.anio, 
                        j.ruta, j.descripcion, j.portada, prestado;";



            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();
            $biblioteca = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetchAll para obtener todas las filas

            return $biblioteca;
        } catch (PDOException $e) {
            error_log("Error al obtener la biblioteca: " . $e->getMessage());
            return false;
        }
    }

    //Juego que me han REGALADO

    public function mostrarRegalados($idUsuario)
    {
        try {
            $sql = "SELECT j.idJuego,
                    j.titulo, 
                    j.desarrollador, 
                    j.distribuidor, 
                    j.anio, 
                    j.ruta, 
                    j.descripcion, 
                    j.portada, 
                    GROUP_CONCAT(DISTINCT g.genero SEPARATOR ', ') AS generos,
                    GROUP_CONCAT(DISTINCT s.nombre SEPARATOR ', ') AS sistemas,
                    true AS regalado
                    FROM juego j
                    INNER JOIN generoJuego gj ON gj.idJuego = j.idJuego
                    INNER JOIN genero g ON gj.idGenero = g.idGenero
                    INNER JOIN juegoSistema js ON js.idJuego = j.idJuego
                    INNER JOIN sistema s ON s.idSistema = js.idSistema
                    INNER JOIN regalado c ON j.idJuego = c.idJuego
                            WHERE c.idUsuarioRecibe = :idUsuario
                    GROUP BY j.idJuego, j.titulo, j.desarrollador, j.distribuidor, j.anio, 
                        j.ruta, j.descripcion, j.portada, regalado;";



            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();
            $biblioteca = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetchAll para obtener todas las filas

            return $biblioteca;
        } catch (PDOException $e) {
            error_log("Error al obtener la biblioteca: " . $e->getMessage());
            return false;
        }
    }


    /* ------SERIALIZE DEL CARRITO------------ */

    public function obtenerJuegosDelCarrito($idCarrito)
    {
        $query = "SELECT j.idJuego, j.titulo, j.anio 
                  FROM carritoJuego cj
                  INNER JOIN juego j ON cj.idJuego = j.idJuego
                  WHERE cj.idCarrito = :idCarrito";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':idCarrito', $idCarrito, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verificarJuegoEnCarrito($idCarrito, $idJuego)
    {
        $query = "SELECT COUNT(*) FROM carritoJuego WHERE idCarrito = :idCarrito AND idJuego = :idJuego";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':idCarrito', $idCarrito, PDO::PARAM_INT);
        $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function agregarJuegoAlCarrito($idCarrito, $idJuego)
    {
        $query = "INSERT INTO carritoJuego (idCarrito, idJuego) VALUES (:idCarrito, :idJuego)";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':idCarrito', $idCarrito, PDO::PARAM_INT);
        $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function eliminarJuegoDelCarrito($idCarrito, $idJuego)
    {
        $query = "DELETE FROM carritoJuego WHERE idCarrito = :idCarrito AND idJuego = :idJuego";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':idCarrito', $idCarrito, PDO::PARAM_INT);
        $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function vaciarCarrito($idCarrito)
    {
        $query = "DELETE FROM carritoJuego WHERE idCarrito = :idCarrito";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':idCarrito', $idCarrito, PDO::PARAM_INT);
        return $stmt->execute();
    }
    function obtenerJuegoPorId($idJuego)
    {
        $sql = "SELECT idJuego, titulo, desarrollador, distribuidor, anio, ruta, descripcion, portada 
                FROM juego 
                WHERE idJuego = :idJuego";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    /* function verificarJuegoEnCarrito($idCarrito, $idJuego)
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
    } */

    /* MODIFY Carrito */
    /* function anadirJuegoAlCarrito($idCarrito, $idJuego)
    {
        try {
            // Añadir el juego al carrito
            $sql = "INSERT INTO carritojuego (idCarrito, idJuego) VALUES (:idCarrito, :idJuego)";
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
    } */



    /*     function obtenerJuegosDelCarrito($idCarrito)
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
            error_log("Error en la base de datos: " . $e->getMessage());
            return false;
        }
    } */

    /* Eliminar 1 juego del carrito */

    /* public function eliminarJuegoCarrito($idCarrito, $idJuego)
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
    } */

    public function eliminarTodosLosJuegosCarrito($idCarrito)
    {
        try {
            $sql = "DELETE FROM carritoJuego WHERE idCarrito = :idCarrito";
            $stmt = $this->conexion->prepare($sql);

            $stmt->bindParam(':idCarrito', $idCarrito, PDO::PARAM_INT);

            $stmt->execute();
        } catch (Exception $e) {
            // Si ocurre un error, lo registramos en el log
            error_log("Error en eliminarTodosLosJuegosCarrito: " . $e->getMessage());
            return false;
        }
    }



    /* Devuelve true/false dependiendo de si encuentra el juego en posesion de un usuario en concreto */
    public function esJuegoComprado($idUsuario, $idJuego)
    {
        try {
            $sql = "SELECT COUNT(*) as conteo FROM comprado WHERE idUsuario = :idUsuario AND idJuego = :idJuego";
            $stmt = $this->conexion->prepare($sql);

            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);

            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return ($result && $result['conteo'] > 0) ? true : false;
        } catch (Exception $e) {
            error_log("Error al comprobar si el juego ha sido comprado: " . $e->getMessage());
            return false;
        }
    }
    /* devuelve true/false dependiendo de si el ususario tinee el juego o no  */
    public function esJuegoRegalado($idUsuario, $idJuego)
    {
        try {
            // Consulta SQL para verificar si el usuario ha recibido el juego
            $sql = "SELECT COUNT(*) as conteo FROM regalado WHERE idUsuarioRecibe = :idUsuario AND idJuego = :idJuego";
            $stmt = $this->conexion->prepare($sql);

            // Vinculamos los parámetros
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);

            // Ejecutamos la consulta
            $stmt->execute();

            // Obtenemos el resultado
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Si el conteo es mayor que 0, significa que el juego ha sido regalado a este usuario
            return ($result && $result['conteo'] > 0) ? true : false;
        } catch (Exception $e) {
            // Capturamos cualquier excepción y la registramos en los logs de error
            error_log("Error al comprobar si el juego ha sido regalado: " . $e->getMessage());
            return false;
        }
    }


    public function comprarJuego($idUsuario, $idJuego)
    {
        try {
            // Consulta SQL para insertar la compra en la tabla
            $sql = "INSERT INTO comprado (idUsuario, idJuego, fechaCompra)
                    VALUES (:idUsuario, :idJuego, NOW())";
            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);

            // Vincular parámetros para evitar inyección SQL
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);

            // Ejecutar la consulta
            $stmt->execute();
            return "Compra realizada con éxito";
        } catch (Exception $e) {
            // Registrar el error en el log
            error_log("Error en comprarJuego: " . $e->getMessage());
            return false;
        }
    }


    public function agnadirJuegoAUsuario($idUsuario, $idJuego)
    {
        try {
            // Consulta SQL para insertar el juego en la tabla poseejuego
            $sql = "INSERT INTO poseejuego (idUsuario, idJuego)
                    VALUES (:idUsuario, :idJuego)"; // Cierre del paréntesis corregido

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);

            // Vincular parámetros para evitar inyección SQL
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);

            // Ejecutar la consulta
            $stmt->execute();

            // Retornar éxito
            return "Juego añadido a la biblioteca del usuario con éxito";
        } catch (Exception $e) {
            // Registrar el error en el log
            error_log("Error en añadir Juego comprado a Usuario: " . $e->getMessage());
            return false;
        }
    }


    // Función que muestra todos los juegos
    /*     public function mostrarJuegos()
    {
        try {
            // Establecer la consulta SQL
            $sql = "SELECT * FROM `juego`
                    INNER JOIN generoJuego gj on gj.idJuego = juego.idJuego
                    INNER JOIN genero g on gj.idGenero = g.idGenero";

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
    } */

    public function mostrarJuegos()
    {
        try {
            // Establecer la consulta SQL
            $sql = "SELECT j.idJuego,
                    j.titulo, 
                    j.desarrollador, 
                    j.distribuidor, 
                    j.anio, 
                    j.ruta, 
                    j.descripcion, 
                    j.portada, 
                    GROUP_CONCAT(DISTINCT g.genero SEPARATOR ', ') AS generos,
                    GROUP_CONCAT(DISTINCT s.nombre SEPARATOR ', ') AS sistemas
                FROM juego j
                INNER JOIN generoJuego gj ON gj.idJuego = j.idJuego
                INNER JOIN genero g ON gj.idGenero = g.idGenero
                INNER JOIN juegoSistema js ON js.idJuego = j.idJuego
                INNER JOIN sistema s ON s.idSistema = js.idSistema
                GROUP BY j.idJuego, j.titulo, j.desarrollador, j.distribuidor, j.anio, 
                        j.ruta, j.descripcion, j.portada;

                    ";

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
    // public function agregarJuego($titulo, $desarrollador, $distribuidor, $anio, $generos, $sistemas, $ruta, $descripcion, $portada)
    // {
    //     try {
    //         // Consulta SQL actualizada
    //         $sql = "INSERT INTO `juego` 
    //         (`titulo`, `desarrollador`, `distribuidor`, `anio`, `ruta`, `descripcion`, `portada`) 
    //         VALUES 
    //         (:titulo, :desarrollador, :distribuidor, :anio, :ruta, :descripcion, :portada)";

    //         // Preparar la consulta
    //         $stmt = $this->conexion->prepare($sql);

    //         // Asignar valores a las etiquetas
    //         $stmt->bindParam(':titulo', $titulo);
    //         $stmt->bindParam(':desarrollador', $desarrollador);
    //         $stmt->bindParam(':distribuidor', $distribuidor);
    //         $stmt->bindParam(':anio', $anio, PDO::PARAM_INT);
    //         $stmt->bindParam(':descripcion', $descripcion);
    //         $stmt->bindParam(':portada', $portada);
    //         $stmt->bindParam(':ruta', $ruta);
    //         // Ejecutar la consulta
    //         $stmt->execute();

    //         /* Antes de meter los generos y los sistemas comprobamos que existan */
    //         /* este array es de ids no de generos */
    //         if (is_array($generos) && !empty($generos)) {
    //             $this->anadirGeneroJuego($this->conexion->lastInsertId(), $generos);
    //         }
    //         if (is_array($sistemas) && !empty($sistemas)) {
    //             $this->anadirSistemaJuego($this->conexion->lastInsertId(), $sistemas);
    //         }

    //         /* faltarian los juegos relacionados */
    //     } catch (Exception $e) {
    //         echo "Error: " . $e->getMessage();
    //     }
    // }

    public function agregarJuego($titulo, $desarrollador, $anio, $generos, $sistemas, $ruta, $descripcion, $portada, $precio)
    {
        try {
            // Consulta SQL actualizada para incluir la columna `precio`
            $sql = "INSERT INTO `juego` 
                (`titulo`, `desarrollador`, `anio`, `ruta`, `descripcion`, `portada`, `precio`) 
                VALUES 
                (:titulo, :desarrollador, :anio, :ruta, :descripcion, :portada, :precio)";

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);

            // Asignar valores a las etiquetas
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':desarrollador', $desarrollador);
            $stmt->bindParam(':anio', $anio, PDO::PARAM_INT);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':portada', $portada);
            $stmt->bindParam(':ruta', $ruta);
            $stmt->bindParam(':precio', $precio, PDO::PARAM_STR);  // Precio como string para manejar decimales correctamente

            // Ejecutar la consulta
            echo "a";
            $stmt->execute();
            echo "b";

            // Obtener el último ID insertado
            $lastId = $this->conexion->lastInsertId();

            // Verificar y añadir géneros
            if (is_array($generos) && !empty($generos)) {
                $this->anadirGeneroJuego($lastId, $generos);
            }

            // Verificar y añadir sistemas
            if (is_array($sistemas) && !empty($sistemas)) {
                $this->anadirSistemaJuego($lastId, $sistemas);
            }

            /* Faltarían los juegos relacionados, si los hay */
        } catch (Exception $e) {
            echo "Error: Agregar juego - " . $e->getMessage();
        }
    }


    // Cargar juego desde un archivo externo JSON o XML
    public function cargarJuego($titulo, $desarrollador, $distribuidor, $anio, $ruta, $descripcion, $portada, $precio)
    {
        try {
            // Consulta SQL actualizada para incluir `precio`
            $sql = "INSERT INTO `juego` 
                (`titulo`, `desarrollador`, `distribuidor`, `anio`, `ruta`, `descripcion`, `portada`, `precio`) 
                VALUES 
                (:titulo, :desarrollador, :distribuidor, :anio, :ruta, :descripcion, :portada, :precio)";

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);

            // Asignar valores a las etiquetas
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':desarrollador', $desarrollador);
            $stmt->bindParam(':distribuidor', $distribuidor);
            $stmt->bindParam(':anio', $anio, PDO::PARAM_INT);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':portada', $portada);
            $stmt->bindParam(':ruta', $ruta);
            $stmt->bindParam(':precio', $precio, PDO::PARAM_STR);  // Precio como string para manejar decimales

            // Ejecutar la consulta
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    // Editar juego
    public function editarJuego($idJuego, $desarrollador, $distribuidor, $anio, $portada, $descripcion, $precio)
    {
        try {
            // Consulta SQL actualizada para incluir el precio
            $sql = "UPDATE `juego`
                SET 
                    `desarrollador` = :desarrollador,
                    `distribuidor` = :distribuidor,
                    `anio` = :anio,
                    `portada` = :portada,
                    `descripcion` = :descripcion,
                    `precio` = :precio                        
                WHERE `idJuego` = :idJuego";

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);

            // Asignar valores a las etiquetas
            $stmt->bindParam(':desarrollador', $desarrollador);
            $stmt->bindParam(':distribuidor', $distribuidor);
            $stmt->bindParam(':anio', $anio, PDO::PARAM_INT);
            $stmt->bindParam(':portada', $portada);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':precio', $precio, PDO::PARAM_STR);  // Precio como string para manejar decimales
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


    /* ----GENEROS--- */
    public function anadirGeneroJuego($idJuego, $arrayIdGeneros)
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
            echo "Error: Añadir género " . $e->getMessage();
        }
    }

    public function insertarGenero($genero)
    {
        try {
            $sql = "INSERT INTO `genero` (genero) VALUES (:genero)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':genero', $genero, PDO::PARAM_STR);
            $stmt->execute();

            // Devolvemos el idGenero del nuevo género insertado
            return $this->conexion->lastInsertId();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function insertarRelacionGeneroJuego($idJuego, $idGenero)
    {
        try {
            $sql = "INSERT INTO `generoJuego` (idJuego, idGenero) VALUES (:idJuego, :idGenero)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
            $stmt->bindParam(':idGenero', $idGenero, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    /* ----SISTEMAS--- */
    public function anadirSistemaJuego($idJuego, $arraySistemas)
    {
        try {
            // Consulta SQL actualizada para la tabla juego_sistema
            $sql = "INSERT INTO `juegoSistema` 
                (`idJuego`, `idSistema`) 
                VALUES 
                (:idJuego, :idSistema)";

            // Recorrer el array de sistemas
            foreach ($arraySistemas as $sistema) {
                // Preparar la consulta
                $stmt = $this->conexion->prepare($sql);

                // Asignar valores a las etiquetas
                $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
                $stmt->bindParam(':idSistema', $sistema, PDO::PARAM_INT);

                // Ejecutar la consulta
                $stmt->execute();
            }
        } catch (Exception $e) {
            echo "Error: Añadir Sistema" . $e->getMessage();
        }
    }

    //Función para mostrar los juegos comprados por un usuario en concreto  FALTA REG

    public function obtenerIdJuegoPorTitulo($titulo)
    {
        try {
            $sql = "SELECT idJuego FROM `juego` WHERE titulo = :titulo LIMIT 1";

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);

            // Asociar el parámetro :titulo
            $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);

            // Ejecutar la consulta
            $stmt->execute();

            // Si encontramos el juego, devolver el idJuego
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['idJuego'];  // Retorna el idJuego
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;  // Retornar null en caso de error
        }
    }

    /* Funcion para añadir los generos de cada juego */

    public function cargarGeneroJuego($idJuego, $arrayGeneros)
    {
        try {
            foreach ($arrayGeneros as $genero) {
                // Verificar si el género ya existe en la tabla genero
                $idGenero = $this->verificarGeneroExiste($genero);

                // Si el género no existe, insertarlo y obtener su idGenero
                if ($idGenero === null) {
                    $idGenero = $this->insertarGenero($genero);
                }

                // Relacionar el idJuego con el idGenero en la tabla generoJuego
                $this->insertarRelacionGeneroJuego($idJuego, $idGenero);
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Verificar si el género ya existe en la tabla genero
    public function verificarGeneroExiste($genero)
    {
        try {
            $sql = "SELECT idGenero FROM `genero` WHERE genero = :genero";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':genero', $genero, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['idGenero'];  // Retorna el idGenero si existe
            }
            return null;  // Retorna null si no existe
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

    // Acceder a Sistemas
    public function accederSistemas()
    {
        try {
            // Establecer la consulta SQL
            $sql = "SELECT * FROM `sistema`";

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);  // Asumiendo que $this->pdo es tu conexión PDO

            // Ejecutar la consulta
            $stmt->execute();

            // Obtener los resultados (como un array asociativo)
            $sistemas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Retornar los resultados
            return $sistemas;
        } catch (Exception $e) {
            // Si hay un error, mostrar el mensaje
            echo "Error: " . $e->getMessage();
        }
    }

    // PRESTAR
    // Función para prestar juego 
    //funcion para añadir el juego a la tabla posee del que recibe el juego prestado
    public function agnadirJuegoPrestado($idUsuarioRecibe, $idJuego)
    {
        try {
            // Preparar el SQL de inserción
            $sql = "INSERT INTO poseeJuego (idUsuario, idJuego) VALUES (:idUsuarioRecibe, :idJuego)";
            $stmt = $this->conexion->prepare($sql);

            // Asociar parámetros con bindParam
            $stmt->bindParam(':idUsuarioRecibe', $idUsuarioRecibe, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error al añadir juego prestado: " . $e->getMessage());
            return false; // Fallo
        }
    }

    //funcion para eliminar el juego de la tabla posee del usuario original
    public function eliminarJuegoPrestado($idUsuarioPresta, $idJuego)
    {
        try {
            // Preparar la consulta de eliminación
            $sql = "DELETE FROM poseeJuego WHERE idUsuario = :idUsuarioPresta AND idJuego = :idJuego";
            $stmt = $this->conexion->prepare($sql);

            // Asociar parámetros con bindParam
            $stmt->bindParam(':idUsuarioPresta', $idUsuarioPresta, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
            $stmt->execute();

            return true; // Éxito
        } catch (PDOException $e) {
            error_log("Error al eliminar juego prestado: " . $e->getMessage()); // Registrar el error en logs
            return false; // Fallo
        }
    }

    /* Funcion para actualizar los datos de las bibliotecas de los usuarios */
    public function actualizarJuegosPrestadosRegalados($idJuego, $idUsuarioDa, $idUsuarioRecibe)
    {
        try {
            // Consulta SQL para actualizar el juego de un usuario a otro
            $sql = "UPDATE comprado SET idUsuario = :idUsuarioRecibe 
                WHERE idJuego = :idJuego AND idUsuario = :idUsuarioDa";

            $stmt = $this->conexion->prepare($sql);

            // Vinculamos los parámetros con los valores correspondientes
            $stmt->bindParam(':idUsuarioDa', $idUsuarioDa, PDO::PARAM_INT);
            $stmt->bindParam(':idUsuarioRecibe', $idUsuarioRecibe, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);

            // Ejecutamos la consulta
            $stmt->execute();

            // Verificamos si se actualizó al menos una fila
            if ($stmt->rowCount() > 0) {
                return true;  // La actualización fue exitosa
            } else {
                return false; // No se encontró el juego o el usuario que da no lo tenía
            }
        } catch (PDOException $e) {
            // Si ocurre algún error, lo registramos en los logs
            error_log("Error al actualizar juego prestado/regalado: " . $e->getMessage());
            return false;  // Fallo al ejecutar la actualización
        }
    }


    public function agnadirPrestamos($idUsuarioPresta, $idUsuarioRecibe, $idJuego)
    {
        try {
            // Crear un objeto DateTime con la fecha actual
            $fechaInicio = new DateTime();

            // Clonar el objeto para fechaFin y añadir 30 días
            $fechaFin = clone $fechaInicio;
            //$fechaFin->modify('+30 days');
            $fechaFin->modify('+1 minute');

            // Formatear las fechas
            $fechaInicioFormateada = $fechaInicio->format('Y-m-d H:i:s');
            $fechaFinFormateada = $fechaFin->format('Y-m-d H:i:s');

            // Preparar el SQL de inserción
            $sql = "INSERT INTO `prestado` (`idUsuarioPresta`, `idUsuarioRecibe`, `idJuego`, `fechaInicio`, `fechaFin`) 
                     VALUES (:idUsuarioPresta, :idUsuarioRecibe, :idJuego, :fechaHoy, :fechaDevolver)";

            $stmt = $this->conexion->prepare($sql);

            // Asociar parámetros con bindParam
            $stmt->bindParam(':idUsuarioPresta', $idUsuarioPresta, PDO::PARAM_INT);
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



    public function obtenerPrestamosVencidos()
    {
        try {
            $sql = "SELECT * 
                FROM prestado 
                WHERE fechaFin <= NOW()";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Usamos FETCH_ASSOC para obtener los registros completos
        } catch (PDOException $e) {
            error_log("Error al obtener préstamos vencidos: " . $e->getMessage());
            return false;
        }
    }


    public function eliminarPrestamo($idPrestamo)
    {
        try {
            // Consulta de eliminación para un préstamo específico
            $sqlDelete = "DELETE FROM prestado WHERE idPrestamo = :idPrestamo";
            $stmtDelete = $this->conexion->prepare($sqlDelete);
            $stmtDelete->bindParam(':idPrestamo', $idPrestamo, PDO::PARAM_INT);
            $stmtDelete->execute();
            return true; // Éxito al eliminar el préstamo

        } catch (PDOException $e) {
            error_log("Error al eliminar préstamo (ID: $idPrestamo): " . $e->getMessage());
            return false; // Error al eliminar el préstamo
        }
    }




    // REGALAR
    // Función para regalar juego 
    public function agnadirRegalo($idUsuarioRegala, $idUsuarioRecibe, $idJuego)
    {
        try {
            $fechaRegalo = new DateTime();
            $fechaInicioFormateada = $fechaRegalo->format('Y-m-d H:i:s');

            // Preparar el SQL de inserción
            $sql = "INSERT INTO `regalado` (`idUsuarioRegala`, `idUsuarioRecibe`, `idJuego`, `fechaRegalo`) 
                     VALUES (:idUSuarioRegala, :idUsuarioRecibe, :idJuego, :fechaInicioFormateada)";

            $stmt = $this->conexion->prepare($sql);

            // Asociar parámetros con bindParam
            $stmt->bindParam(':idUSuarioRegala', $idUsuarioRegala, PDO::PARAM_INT);

            $stmt->bindParam(':idUsuarioRecibe', $idUsuarioRecibe, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
            $stmt->bindParam(':fechaInicioFormateada', $fechaInicioFormateada, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (\Throwable $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    /* Funcion para seleccionar los detalles de los juegos */

    /* CARGAR SISTEMAS DE LOS JUEGOS */

    public function cargarSistemasJuego($idJuego, $arraySistemas)
    {
        try {
            foreach ($arraySistemas as $sistema) {
                // Verificar si el sistema ya existe en la tabla juego_sistema
                $idSistema = $this->verificarSistemaExiste($sistema);

                if ($idSistema === null) {
                    $idSistema = $this->insertarSistema($sistema);
                }

                $this->insertarRelacionJuegoSistema($idJuego, $idSistema);
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function insertarSistema($nombreSistema)
    {
        try {
            $sql = "INSERT INTO `sistema` (nombre) VALUES (:nombreSistema)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombreSistema', $nombreSistema, PDO::PARAM_STR);
            $stmt->execute();

            // Devolvemos el idSistema del nuevo sistema insertado
            return $this->conexion->lastInsertId();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    // Función para verificar si el sistema ya está asociado al juego
    public function verificarSistemaExiste($nombreSistema)
    {
        try {
            $sql = "SELECT idSistema FROM `sistema` WHERE nombre = :nombreSistema";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombreSistema', $nombreSistema, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['idSistema'];  // Retorna el idSistema si existe
            }
            return null;  // Retorna null si no existe
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    // Función para insertar la relación entre idJuego y sistema en juegoSistema
    public function insertarRelacionJuegoSistema($idJuego, $sistema)
    {
        try {
            // Consulta para insertar la relación entre idJuego y sistema en juegoSistema
            $sql = "INSERT INTO `juegosistema` (idJuego, idsistema) VALUES (:idJuego, :idsistema)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
            $stmt->bindParam(':idsistema', $sistema, PDO::PARAM_INT);  // Cambiado a PARAM_INT
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }



    public function obtenerGenero($idJuego)
    {
        try {
            // Preparar el SQL de selección
            $sql = "SELECT g.genero
                    FROM generoJuego gj
                    INNER JOIN genero g ON gj.idGenero = g.idGenero
                    WHERE gj.idJuego = :idJuego;";

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
            $stmt->execute();

            // Obtener los datos
            $generos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $generos;
        } catch (\Throwable $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    // Función para obtener los sistemas de un juego
    public function obtenerDatosJuegoConGenero($idJuego)
    {
        try {
            // Consulta SQL
            $sql = "SELECT 
                    j.titulo, 
                    j.desarrollador, 
                    j.distribuidor, 
                    j.anio, 
                    j.ruta, 
                    j.descripcion, 
                    j.portada, 
                    GROUP_CONCAT(g.genero SEPARATOR ', ') AS generos
                FROM 
                    juego j
                INNER JOIN 
                    generoJuego gj ON j.idJuego = gj.idJuego
                INNER JOIN 
                    genero g ON gj.idGenero = g.idGenero
                WHERE 
                    j.idJuego = :idJuego
                GROUP BY 
                    j.idJuego;";

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);
            // Enlazar el parámetro
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
            // Ejecutar la consulta
            $stmt->execute();

            // Obtener los resultados
            $datosJuego = $stmt->fetch(PDO::FETCH_ASSOC); // fetch devuelve una única fila como array asociativo
            return $datosJuego;
        } catch (\Throwable $e) {
            // Capturar errores
            echo "Error: " . $e->getMessage();
            return false;
        }
    }



    /* FILTRAR JUEGOS DEL CATÁLOGO */

    public function filtrarJuegos($genero, $sistema, $fecha)
    {
        try {
            $sql = "SELECT DISTINCT j.* FROM juego j
                    INNER JOIN generoJuego gj ON gj.idJuego = j.idJuego
                    INNER JOIN genero g ON gj.idGenero = g.idGenero
                    INNER JOIN juegoSistema js ON js.idJuego = j.idJuego
                    INNER JOIN sistema s ON s.idSistema = js.idSistema
                    WHERE 1=1"; // 1=1 permite agregar condiciones dinámicas

            $params = [];

            if ($genero != "0") {
                $sql .= " AND g.idGenero = :genero";
                $params[':genero'] = $genero;
            }

            if ($sistema != "0") {
                $sql .= " AND s.idSistema = :sistema";
                $params[':sistema'] = $sistema;
            }

            if (!empty($fecha)) {
                $sql .= " AND j.anio = :fecha";
                $params[':fecha'] = $fecha;
            }

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
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
