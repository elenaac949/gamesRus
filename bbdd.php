<?php
class Database
{
    /**
     * @var PDO $conexion Objeto de conexión a la base de datos
     */
    private $conexion;

    /**
     * Constructor para inicializar la conexión a la base de datos
     *
     * @param string $dsn       Data Source Name que define la conexión a la base de datos
     * @param string $usuario   Nombre de usuario para la conexión
     * @param string $password  Contraseña para la conexión
     *
     * @throws PDOException En caso de error en la conexión, se captura y muestra el mensaje
     */
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

    /**
     * Verifica si un usuario existe en la base de datos por su nick o correo electrónico
     *
     * @param string $nick   Nombre de usuario a verificar
     * @param string $correo Correo electrónico a verificar
     * @return bool          Devuelve true si el usuario existe, false en caso contrario
     */
    public function existeUsuario($nick, $correo)
    {
        try {
            $sql = "SELECT idUsuario FROM usuario WHERE `nick` = :nick OR `email` = :correo";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nick', $nick, PDO::PARAM_STR);
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmt->execute();
            $coincidencias = $stmt->fetch(PDO::FETCH_ASSOC);
            return $coincidencias !== false;
        } catch (\Throwable $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Obtiene el ID de un usuario por su nombre de usuario (nick)
     *
     * @param string $nick Nombre de usuario
     * @return int|null    Devuelve el ID del usuario o null si no se encuentra
     */
    public function obtenerIdUsuario($nick)
    {
        try {
            $sql = "SELECT idUsuario FROM usuario WHERE `nick` = :nick";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nick', $nick, PDO::PARAM_STR);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado ? (int) $resultado['idUsuario'] : null;
        } catch (\Throwable $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    /**
     * Verifica las credenciales de un usuario para el inicio de sesión
     *
     * @param string $credencial Nombre de usuario o correo electrónico
     * @return array|false       Devuelve un array con los datos del usuario si existe, false en caso contrario
     */
    public function controlLogin($credencial)
    {
        try {
            $sql = "SELECT `idUsuario`, `nick`, `email`, `contrasenia` FROM `usuario` 
                    WHERE `nick` = :credencial OR `email` = :credencial";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':credencial', $credencial);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Registra un nuevo usuario en la base de datos
     *
     * @param string $nombre
     * @param string $apellidos
     * @param string $correo
     * @param string $nick
     * @param string $contrasenia
     * @param string $tipoDeVia
     * @param string $nombreDeVia
     * @param int $numero
     * @param string $numeros
     * @param string $otros
     * @param string $numeroTelefono
     * @return void
     */
    public function registrarUsuario($nombre, $apellidos, $correo, $nick, $contrasenia, $tipoDeVia, $nombreDeVia, $numero, $numeros, $otros, $numeroTelefono)
    {
        try {
            $sql = "INSERT INTO `usuario` 
                    (`nick`, `email`, `nombre`, `apellidos`, `contrasenia`, `tipoDeVia`, `nombreDeVia`, `numeroDeVia`, `numeros`, `otros`, `numeroTelefono`, `idRol`) 
                    VALUES 
                    (:nick, :correo, :nombre, :apellidos, :contrasenia, :tipoDeVia, :nombreDeVia, :numero, :numeros, :otros, :numeroTelefono, 1)";
            $stmt = $this->conexion->prepare($sql);
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
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Obtiene los datos de un usuario logueado desde la sesión
     *
     * @return array|false Devuelve un array con los datos del usuario o false en caso de error
     */
    public function obtenerDatosUsuario()
    {
        $userId = $_SESSION['idUsuario'];
        try {
            $sql = "SELECT * FROM usuario WHERE idUsuario = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error en la conexión: " . $e->getMessage();
        }
    }

    /**
     * Actualiza los datos de un usuario en la base de datos
     *
     * @param string $nombre
     * @param string $apellidos
     * @param string $correo
     * @param string $nick
     * @param string $tipoDeVia
     * @param string $nombreDeVia
     * @param int $numeroVia
     * @param string $numeros
     * @param string $otros
     * @param string $numeroTelefono
     * @return void
     */
    public function actualizarUsuario($nombre, $apellidos, $correo, $nick, $tipoDeVia, $nombreDeVia, $numeroVia, $numeros, $otros, $numeroTelefono)
    {
        try {
            $idUsuario = $_SESSION['idUsuario'];
            $sql = "UPDATE `usuario`
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
            $stmt = $this->conexion->prepare($sql);
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
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Elimina un usuario de la base de datos por su nick
     *
     * @param string $nick Nombre de usuario
     * @return void
     */
    public function eliminarUsuario($nick)
    {
        try {
            $sql = "DELETE FROM `usuario` WHERE `nick` = :nick";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nick', $nick);
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Obtiene todos los usuarios de la base de datos
     *
     * @return array|false Lista de usuarios o false en caso de error
     */
    public function todosLosUsuarios()
    {
        try {
            $sql = "SELECT * FROM `usuario`";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /* ----TARJETAS--- */

    /**
     * Añadir una nueva tarjeta a la base de datos.
     *
     * @param string $numeroTarjeta Número de la tarjeta.
     * @param string $ccv Código de seguridad de la tarjeta.
     * @param string $fechaCaducidad Fecha de caducidad de la tarjeta (YYYY-MM-DD).
     * @param int $idUsuario ID del usuario al que pertenece la tarjeta.
     */
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

    /**
     * Editar los datos de una tarjeta existente.
     *
     * @param string $ccv Nuevo código de seguridad de la tarjeta.
     * @param string $caducidad Nueva fecha de caducidad (YYYY-MM-DD).
     * @param int $idUsuario ID del usuario dueño de la tarjeta.
     */
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

    /**
     * Eliminar una tarjeta de la base de datos.
     *
     * @param int $idTarjeta ID de la tarjeta a eliminar.
     */
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

    /**
     * Obtener todas las tarjetas de un usuario específico.
     *
     * @param int $idUsuario ID del usuario propietario de las tarjetas.
     * @return array|null Lista de tarjetas asociadas al usuario o null en caso de error.
     */
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
            return null;
        }
    }

    /**
     * Verificar si una tarjeta ya existe en la base de datos.
     *
     * @param string $numeroTarjeta Número de la tarjeta a verificar.
     * @param string $ccv Código de seguridad de la tarjeta.
     * @param int $idUsuario ID del usuario dueño de la tarjeta.
     * @return bool True si la tarjeta existe, false en caso contrario.
     */
    public function tarjetaExiste($numeroTarjeta, $ccv, $idUsuario)
    {
        // Comprobar si existe una tarjeta con el mismo número y CCV para el usuario actual
        $sql = "SELECT * FROM `tarjeta` WHERE `numeroTarjeta` = :numeroTarjeta AND `ccv` = :ccv AND `idUsuario` = :idUsuario";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':numeroTarjeta', $numeroTarjeta, PDO::PARAM_STR);
        $stmt->bindParam(':ccv', $ccv, PDO::PARAM_STR);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);

        $stmt->execute();

        // Si se encuentra alguna tarjeta, devolvemos true (existe)
        return $stmt->rowCount() > 0;
    }



    /* ----JUEGOS--- */
    /**
     * Obtener los años en los que se han publicado juegos.
     *
     * @return array|false Lista de años distintos o false en caso de error.
     */

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

    /**
     * Obtener el último juego introducido en la base de datos.
     *
     * @return array|false Título del último juego o false en caso de error.
     */

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

    /**
     * Obtener los títulos de todos los juegos registrados.
     *
     * @return array|false Lista de títulos de juegos o false en caso de error.
     */

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


    /**
     * Agregar un juego a la biblioteca de un usuario como comprado.
     *
     * @param int $idUsuario ID del usuario.
     * @param int $idJuego ID del juego.
     * @return void
     */
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

    /**
     * Eliminar un juego de la biblioteca de un usuario.
     *
     * @param int $idUsuario ID del usuario.
     * @param int $idJuego ID del juego a eliminar.
     * @return void
     */
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


    /**
     * Mostrar la biblioteca de un usuario combinando juegos comprados, prestados y regalados.
     *
     * @param int $idUsuario ID del usuario.
     * @return array Biblioteca de juegos del usuario.
     */
    public function mostrarBiblioteca($idUsuario)
    {
        $comprado = $this->mostrarComprados($idUsuario);
        $prestado = $this->mostrarPrestados($idUsuario);
        $regalado = $this->mostrarRegalados($idUsuario);

        return array_merge($comprado, $prestado, $regalado);
    }

    /**
     * Obtener los juegos que un usuario ha comprado.
     *
     * @param int $idUsuario ID del usuario.
     * @return array|false Lista de juegos comprados o false en caso de error.
     */
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

    /**
     * Obtener los juegos que han sido prestados a un usuario.
     *
     * @param int $idUsuario ID del usuario.
     * @return array|false Lista de juegos prestados o false en caso de error.
     */
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


    /**
     * Obtener los juegos que han sido regalados a un usuario.
     *
     * @param int $idUsuario ID del usuario.
     * @return array|false Lista de juegos regalados o false en caso de error.
     */
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


    /* ----CARRITO---- */

    /**
     * Obtener el carrito de un usuario o crearlo si no existe.
     *
     * @param int $idUsuario ID del usuario.
     * @return int|false ID del carrito o false en caso de error.
     */
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


    /**
     * Verifica si un juego ya está en el carrito del usuario.
     * No se permite repetir el mismo juego en el carrito debido a la estructura de la base de datos.
     *
     * @param int $idCarrito ID del carrito del usuario.
     * @param int $idJuego ID del juego a verificar.
     * @return bool Devuelve true si el juego ya está en el carrito, false en caso contrario.
     */
    function verificarJuegoEnCarrito($idCarrito, $idJuego)
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM carritoJuego WHERE idCarrito = :idCarrito AND idJuego = :idJuego";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idCarrito', $idCarrito, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
            $stmt->execute();
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            return $fila['total'] > 0;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    /**
     * Agrega un juego al carrito del usuario.
     *
     * @param int $idCarrito ID del carrito del usuario.
     * @param int $idJuego ID del juego a agregar.
     * @return string Mensaje de éxito o error.
     */
    function anadirJuegoAlCarrito($idCarrito, $idJuego)
    {
        try {
            $sql = "INSERT INTO carritojuego (idCarrito, idJuego) VALUES (:idCarrito, :idJuego)";
            $stmt = $this->conexion->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta.");
            }
            $stmt->bindParam(':idCarrito', $idCarrito, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
            $stmt->execute();
            return "Juego añadido al carrito correctamente.";
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    /**
     * Obtiene los juegos dentro de un carrito específico.
     *
     * @param int $idCarrito ID del carrito del usuario.
     * @return array|false Devuelve un array con los juegos del carrito o false en caso de error.
     */
    function obtenerJuegosDelCarrito($idCarrito)
    {
        try {
            $sql = "SELECT j.idJuego, j.titulo, j.desarrollador, j.distribuidor, j.anio, j.ruta, j.descripcion, j.portada
                FROM juego j
                JOIN carritoJuego cj ON j.idJuego = cj.idJuego
                WHERE cj.idCarrito = :idCarrito";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idCarrito', $idCarrito, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error en la base de datos: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina un juego específico del carrito del usuario.
     *
     * @param int $idCarrito ID del carrito del usuario.
     * @param int $idJuego ID del juego a eliminar.
     * @return string Mensaje de éxito o error.
     */
    public function eliminarJuegoCarrito($idCarrito, $idJuego)
    {
        try {
            $sql = "DELETE FROM carritoJuego WHERE idCarrito = :idCarrito AND idJuego = :idJuego";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idCarrito', $idCarrito, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
            $stmt->execute();
            return "Eliminado con éxito";
        } catch (Exception $e) {
            return "Error en la base de datos: " . $e->getMessage();
        }
    }

    /**
     * Elimina todos los juegos dentro de un carrito específico.
     *
     * @param int $idCarrito ID del carrito del usuario.
     * @return bool Devuelve true si la operación fue exitosa, false en caso de error.
     */
    public function eliminarTodosLosJuegosCarrito($idCarrito)
    {
        try {
            $sql = "DELETE FROM carritoJuego WHERE idCarrito = :idCarrito";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idCarrito', $idCarrito, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            error_log("Error en eliminarTodosLosJuegosCarrito: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verifica si un usuario ha comprado un juego en particular.
     *
     * @param int $idUsuario ID del usuario.
     * @param int $idJuego ID del juego.
     * @return bool Devuelve true si el usuario ha comprado el juego, false en caso contrario.
     */
    public function esJuegoComprado($idUsuario, $idJuego)
    {
        try {
            $sql = "SELECT COUNT(*) as conteo FROM comprado WHERE idUsuario = :idUsuario AND idJuego = :idJuego";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return ($result && $result['conteo'] > 0);
        } catch (Exception $e) {
            error_log("Error al comprobar si el juego ha sido comprado: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verifica si un usuario ha recibido un juego como regalo.
     *
     * @param int $idUsuario ID del usuario.
     * @param int $idJuego ID del juego.
     * @return bool Devuelve true si el usuario ha recibido el juego como regalo, false en caso contrario.
     */
    public function esJuegoRegalado($idUsuario, $idJuego)
    {
        try {
            $sql = "SELECT COUNT(*) as conteo FROM regalado WHERE idUsuarioRecibe = :idUsuario AND idJuego = :idJuego";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return ($result && $result['conteo'] > 0);
        } catch (Exception $e) {
            error_log("Error al comprobar si el juego ha sido regalado: " . $e->getMessage());
            return false;
        }
    }


    /**
     * Registra la compra de un juego por parte de un usuario.
     *
     * @param int $idUsuario ID del usuario que realiza la compra.
     * @param int $idJuego ID del juego a comprar.
     * @return string|bool Mensaje de éxito o false en caso de error.
     */
    public function comprarJuego($idUsuario, $idJuego)
    {
        try {
            $sql = "INSERT INTO comprado (idUsuario, idJuego, fechaCompra)
                VALUES (:idUsuario, :idJuego, NOW())";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
            $stmt->execute();
            return "Compra realizada con éxito";
        } catch (Exception $e) {
            error_log("Error en comprarJuego: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Añade un juego a la biblioteca de un usuario después de la compra.
     *
     * @param int $idUsuario ID del usuario.
     * @param int $idJuego ID del juego a añadir.
     * @return string|bool Mensaje de éxito o false en caso de error.
     */
    public function agnadirJuegoAUsuario($idUsuario, $idJuego)
    {
        try {
            $sql = "INSERT INTO poseejuego (idUsuario, idJuego) VALUES (:idUsuario, :idJuego)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
            $stmt->execute();
            return "Juego añadido a la biblioteca del usuario con éxito";
        } catch (Exception $e) {
            error_log("Error en añadir juego comprado a usuario: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene la lista de todos los juegos junto con sus géneros y sistemas disponibles.
     *
     * @return array|false Devuelve un array con los juegos o false en caso de error.
     */
    public function mostrarJuegos()
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
                    GROUP_CONCAT(DISTINCT s.nombre SEPARATOR ', ') AS sistemas
                FROM juego j
                INNER JOIN generoJuego gj ON gj.idJuego = j.idJuego
                INNER JOIN genero g ON gj.idGenero = g.idGenero
                INNER JOIN juegoSistema js ON js.idJuego = j.idJuego
                INNER JOIN sistema s ON s.idSistema = js.idSistema
                GROUP BY j.idJuego, j.titulo, j.desarrollador, j.distribuidor, j.anio, 
                        j.ruta, j.descripcion, j.portada";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error en mostrarJuegos: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Agrega un nuevo juego a la base de datos.
     *
     * @param string $titulo El título del juego.
     * @param string $desarrollador El nombre del desarrollador del juego.
     * @param int $anio El año de lanzamiento del juego.
     * @param array $generos Un array de IDs de géneros asociados al juego.
     * @param array $sistemas Un array de IDs de sistemas donde se puede jugar el juego.
     * @param string $ruta La ruta del archivo relacionado con el juego.
     * @param string $descripcion Una descripción del juego.
     * @param string $portada La imagen de portada del juego.
     * @return void
     */
    public function agregarJuego($titulo, $desarrollador, $anio, $generos, $sistemas, $ruta, $descripcion, $portada)
    {
        try {
            // Consulta SQL actualizada
            $sql = "INSERT INTO `juego` 
        (`titulo`, `desarrollador`, `anio`, `ruta`, `descripcion`, `portada`) 
        VALUES 
        (:titulo, :desarrollador, :anio, :ruta, :descripcion, :portada)";

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);

            // Asignar valores a las etiquetas
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':desarrollador', $desarrollador);
            $stmt->bindParam(':anio', $anio, PDO::PARAM_INT);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':portada', $portada);
            $stmt->bindParam(':ruta', $ruta);

            // Ejecutar la consulta
            $stmt->execute();

            // Obtén el último ID insertado
            $lastId = $this->conexion->lastInsertId();

            // Añadir géneros asociados al juego
            if (is_array($generos) && !empty($generos)) {
                $this->anadirGeneroJuego($lastId, $generos);
            }

            // Añadir sistemas asociados al juego
            if (is_array($sistemas) && !empty($sistemas)) {
                $this->anadirSistemaJuego($lastId, $sistemas);
            }
        } catch (Exception $e) {
            echo "Error: Agregar juego" . $e->getMessage();
        }
    }

    /**
     * Carga un juego desde un archivo JSON o XML y lo agrega a la base de datos.
     *
     * @param string $titulo El título del juego.
     * @param string $desarrollador El nombre del desarrollador del juego.
     * @param string $distribuidor El nombre del distribuidor del juego.
     * @param int $anio El año de lanzamiento del juego.
     * @param string $ruta La ruta del archivo relacionado con el juego.
     * @param string $descripcion Una descripción del juego.
     * @param string $portada La imagen de portada del juego.
     * @return void
     */
    public function cargarJuego($titulo, $desarrollador, $distribuidor, $anio, $ruta, $descripcion, $portada)
    {
        try {
            // Consulta SQL para insertar el juego
            $sql = "INSERT INTO `juego` 
        (`titulo`, `desarrollador`, `distribuidor`, `anio`, `ruta`, `descripcion`, `portada`) 
        VALUES 
        (:titulo, :desarrollador, :distribuidor, :anio, :ruta, :descripcion, :portada)";

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

            // Ejecutar la consulta
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Edita un juego en la base de datos.
     *
     * @param int $idJuego El ID del juego a editar.
     * @param string $desarrollador El nombre del desarrollador del juego.
     * @param string $distribuidor El nombre del distribuidor del juego.
     * @param int $anio El año de lanzamiento del juego.
     * @param string $portada La nueva portada del juego.
     * @param string $descripcion Una nueva descripción del juego.
     * @return void
     */
    public function editarJuego($idJuego, $desarrollador, $distribuidor, $anio, $portada, $descripcion)
    {
        try {
            // Consulta SQL para actualizar el juego
            $sql = "UPDATE `juego`
            SET 
                `desarrollador` = :desarrollador,
                `distribuidor` = :distribuidor,
                `anio` = :anio,
                `portada` = :portada,
                `descripcion` = :descripcion
            WHERE `idJuego` = :idJuego"; // Se utiliza el idJuego como clave primaria.

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

    /**
     * Elimina un juego de la base de datos.
     *
     * @param int $idJuego El ID del juego a eliminar.
     * @return void
     */
    public function eliminarJuego($idJuego)
    {
        try {
            // Consulta SQL para eliminar el juego
            $sql = "DELETE FROM `juego` WHERE `idJuego` = :idJuego";

            // Preparar la consulta
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idJuego', $idJuego);

            // Ejecutar la consulta
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Añade géneros al juego en la tabla `generoJuego`.
     *
     * @param int $idJuego El ID del juego.
     * @param array $arrayIdGeneros Un array de IDs de géneros.
     * @return void
     */
    public function anadirGeneroJuego($idJuego, $arrayIdGeneros)
    {
        try {
            // Consulta SQL para insertar géneros asociados al juego
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

    /**
     * Inserta un nuevo género en la base de datos.
     *
     * @param string $genero El nombre del género a insertar.
     * @return int El ID del género insertado.
     */
    public function insertarGenero($genero)
    {
        try {
            // Consulta SQL para insertar un nuevo género
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

    /**
     * Inserta una relación entre un juego y un género en la base de datos.
     *
     * @param int $idJuego El ID del juego.
     * @param int $idGenero El ID del género.
     * @return void
     */
    public function insertarRelacionGeneroJuego($idJuego, $idGenero)
    {
        try {
            // Consulta SQL para insertar la relación entre juego y género
            $sql = "INSERT INTO `generoJuego` (idJuego, idGenero) VALUES (:idJuego, :idGenero)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
            $stmt->bindParam(':idGenero', $idGenero, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Añade sistemas asociados a un juego en la base de datos.
     *
     * @param int $idJuego El ID del juego.
     * @param array $arraySistemas Un array de IDs de sistemas.
     * @return void
     */
    public function anadirSistemaJuego($idJuego, $arraySistemas)
    {
        try {
            // Consulta SQL para insertar sistemas asociados al juego
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

    /**
     * Obtiene el ID de un juego por su título.
     *
     * @param string $titulo El título del juego.
     * @return int|null El ID del juego o null si no se encuentra.
     */
    public function obtenerIdJuegoPorTitulo($titulo)
    {
        try {
            // Consulta SQL para obtener el ID de un juego por su título
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


    /**
     * Función para añadir los géneros de un juego en la base de datos.
     *
     * Esta función verifica si los géneros proporcionados existen en la tabla `genero`. 
     * Si no existen, los inserta. Luego, crea la relación entre el juego y sus géneros 
     * en la tabla `generoJuego`.
     *
     * @param int   $idJuego     El ID del juego al que se le van a añadir los géneros.
     * @param array $arrayGeneros Un array de géneros que se añadirán al juego.
     * 
     * @return void
     */
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

    /**
     * Verificar si un género ya existe en la base de datos.
     *
     * Esta función consulta la tabla `genero` para comprobar si un género específico 
     * ya está registrado. Si es así, devuelve su ID, en caso contrario, retorna `null`.
     *
     * @param string $genero El nombre del género a verificar.
     *
     * @return int|null El ID del género si existe, de lo contrario, `null`.
     */
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

    /**
     * Obtener todos los géneros disponibles en la base de datos.
     *
     * Esta función obtiene todos los registros de géneros de la tabla `genero`.
     *
     * @return array|false Un array asociativo con todos los géneros si la consulta es exitosa,
     *                     de lo contrario, devuelve `false` en caso de error.
     */
    public function accederGeneros()
    {
        try {
            $sql = "SELECT * FROM `genero`";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            $generos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $generos;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Obtener todos los sistemas disponibles en la base de datos.
     *
     * Esta función obtiene todos los registros de sistemas de la tabla `sistema`.
     *
     * @return array|false Un array asociativo con todos los sistemas si la consulta es exitosa,
     *                     de lo contrario, devuelve `false` en caso de error.
     */
    public function accederSistemas()
    {
        try {
            $sql = "SELECT * FROM `sistema`";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            $sistemas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $sistemas;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Añadir un juego a la tabla `poseeJuego` para indicar que un usuario ha recibido el juego prestado.
     *
     * Esta función inserta un registro en la tabla `poseeJuego`, indicando que un usuario 
     * ha recibido un juego en préstamo.
     *
     * @param int $idUsuarioRecibe El ID del usuario que recibe el juego.
     * @param int $idJuego         El ID del juego que se va a prestar.
     *
     * @return bool `true` si la operación es exitosa, `false` si falla.
     */
    public function agnadirJuegoPrestado($idUsuarioRecibe, $idJuego)
    {
        try {
            $sql = "INSERT INTO poseeJuego (idUsuario, idJuego) VALUES (:idUsuarioRecibe, :idJuego)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idUsuarioRecibe', $idUsuarioRecibe, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error al añadir juego prestado: " . $e->getMessage());
            return false; // Fallo
        }
    }

    /**
     * Eliminar un juego de la tabla `poseeJuego` para indicar que un usuario ha devuelto el juego prestado.
     *
     * Esta función elimina un registro de la tabla `poseeJuego`, indicando que un usuario ha devuelto 
     * el juego que había recibido en préstamo.
     *
     * @param int $idUsuarioPresta El ID del usuario que prestó el juego.
     * @param int $idJuego         El ID del juego que fue devuelto.
     *
     * @return bool `true` si la operación es exitosa, `false` si falla.
     */
    public function eliminarJuegoPrestado($idUsuarioPresta, $idJuego)
    {
        try {
            $sql = "DELETE FROM poseeJuego WHERE idUsuario = :idUsuarioPresta AND idJuego = :idJuego";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idUsuarioPresta', $idUsuarioPresta, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
            $stmt->execute();
            return true; // Éxito
        } catch (PDOException $e) {
            error_log("Error al eliminar juego prestado: " . $e->getMessage());
            return false; // Fallo
        }
    }

    /**
     * Actualizar los registros de los juegos prestados o regalados de un usuario a otro.
     *
     * Esta función actualiza los registros en la tabla `comprado` cuando un usuario transfiere un juego 
     * a otro (ya sea en préstamo o regalado).
     *
     * @param int $idJuego         El ID del juego a transferir.
     * @param int $idUsuarioDa     El ID del usuario que da el juego.
     * @param int $idUsuarioRecibe El ID del usuario que recibe el juego.
     *
     * @return bool `true` si la operación es exitosa, `false` si falla.
     */
    public function actualizarJuegosPrestadosRegalados($idJuego, $idUsuarioDa, $idUsuarioRecibe)
    {
        try {
            $sql = "UPDATE comprado SET idUsuario = :idUsuarioRecibe 
                WHERE idJuego = :idJuego AND idUsuario = :idUsuarioDa";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idUsuarioDa', $idUsuarioDa, PDO::PARAM_INT);
            $stmt->bindParam(':idUsuarioRecibe', $idUsuarioRecibe, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;  // Retorna `true` si la actualización fue exitosa
        } catch (PDOException $e) {
            error_log("Error al actualizar juego prestado/regalado: " . $e->getMessage());
            return false;  // Fallo al ejecutar la actualización
        }
    }

    /**
     * Registrar un préstamo de un juego entre dos usuarios.
     *
     * Esta función inserta un registro en la tabla `prestado` para registrar un préstamo 
     * de un juego entre dos usuarios con fechas de inicio y fin.
     *
     * @param int    $idUsuarioPresta  El ID del usuario que presta el juego.
     * @param int    $idUsuarioRecibe  El ID del usuario que recibe el juego.
     * @param int    $idJuego          El ID del juego que se presta.
     *
     * @return bool `true` si la operación es exitosa, `false` si falla.
     */
    public function agnadirPrestamos($idUsuarioPresta, $idUsuarioRecibe, $idJuego)
    {
        try {
            $fechaInicio = new DateTime();
            $fechaFin = clone $fechaInicio;
            $fechaFin->modify('+1 minute');  // La fecha de fin es un minuto después

            $fechaInicioFormateada = $fechaInicio->format('Y-m-d H:i:s');
            $fechaFinFormateada = $fechaFin->format('Y-m-d H:i:s');

            $sql = "INSERT INTO `prestado` (`idUsuarioPresta`, `idUsuarioRecibe`, `idJuego`, `fechaInicio`, `fechaFin`) 
                 VALUES (:idUsuarioPresta, :idUsuarioRecibe, :idJuego, :fechaHoy, :fechaDevolver)";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idUsuarioPresta', $idUsuarioPresta, PDO::PARAM_INT);
            $stmt->bindParam(':idUsuarioRecibe', $idUsuarioRecibe, PDO::PARAM_INT);
            $stmt->bindParam(':idJuego', $idJuego, PDO::PARAM_INT);
            $stmt->bindParam(':fechaHoy', $fechaInicioFormateada, PDO::PARAM_STR);
            $stmt->bindParam(':fechaDevolver', $fechaFinFormateada, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (\Throwable $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Obtener todos los préstamos vencidos (que ya pasaron su fecha de devolución).
     *
     * Esta función consulta la tabla `prestado` para obtener todos los préstamos cuyo 
     * campo `fechaFin` ya haya pasado.
     *
     * @return array|false Un array asociativo con los préstamos vencidos si la consulta es exitosa,
     *                     de lo contrario, devuelve `false` en caso de error.
     */
    public function obtenerPrestamosVencidos()
    {
        try {
            $sql = "SELECT * 
                FROM prestado 
                WHERE fechaFin <= NOW()";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener préstamos vencidos: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Eliminar un préstamo específico de la tabla `prestado`.
     *
     * Esta función elimina un registro de la tabla `prestado` utilizando el ID de préstamo.
     *
     * @param int $idPrestamo El ID del préstamo a eliminar.
     *
     * @return bool `true` si la operación es exitosa, `false` si falla.
     */
    public function eliminarPrestamo($idPrestamo)
    {
        try {
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




    /**
     * Función para regalar un juego a un usuario.
     *
     * Esta función inserta un nuevo registro en la tabla `regalado` asociando un juego a un usuario receptor 
     * y un usuario que regala el juego. También se graba la fecha en que se realiza el regalo.
     *
     * @param int $idUsuarioRegala ID del usuario que regala el juego.
     * @param int $idUsuarioRecibe ID del usuario que recibe el juego.
     * @param int $idJuego ID del juego que se regala.
     * 
     * @return bool Retorna `true` si la inserción fue exitosa, `false` en caso de error.
     */
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

    /**
     * Función para cargar los sistemas asociados a un juego.
     *
     * Esta función recorre un array de sistemas y los asocia a un juego dado. Si el sistema no existe en la base de datos, 
     * lo inserta y luego lo relaciona con el juego en la tabla `juego_sistema`.
     *
     * @param int $idJuego ID del juego al que se asociarán los sistemas.
     * @param array $arraySistemas Array de nombres de sistemas a asociar al juego.
     * 
     * @return void
     */
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

    /**
     * Función para insertar un sistema en la base de datos.
     *
     * Inserta un nuevo sistema en la tabla `sistema` y retorna su ID.
     *
     * @param string $nombreSistema Nombre del sistema a insertar.
     * 
     * @return int El ID del sistema recién insertado.
     */
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

    /**
     * Función para verificar si un sistema existe en la base de datos.
     *
     * Verifica si un sistema ya está registrado en la tabla `sistema`.
     *
     * @param string $nombreSistema Nombre del sistema a verificar.
     * 
     * @return int|null Retorna el ID del sistema si existe, o `null` si no existe.
     */
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

    /**
     * Función para insertar la relación entre un juego y un sistema en la base de datos.
     *
     * Inserta un registro en la tabla `juegosistema` para asociar un juego con un sistema.
     *
     * @param int $idJuego ID del juego a asociar.
     * @param int $sistema ID del sistema a asociar.
     * 
     * @return void
     */
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

    /**
     * Función para obtener los géneros de un juego.
     *
     * Esta función retorna todos los géneros asociados a un juego específico.
     *
     * @param int $idJuego ID del juego para obtener sus géneros.
     * 
     * @return array Retorna un array con los géneros asociados al juego.
     */
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



    /**
     * Función para filtrar juegos en el catálogo según género, sistema y fecha.
     *
     * Esta función construye una consulta SQL dinámica para filtrar los juegos según los parámetros proporcionados.
     * Permite filtrar por género, sistema y año de lanzamiento.
     *
     * @param string $genero ID del género para filtrar los juegos. Si es "0", no se aplica filtro por género.
     * @param string $sistema ID del sistema para filtrar los juegos. Si es "0", no se aplica filtro por sistema.
     * @param string $fecha Año de lanzamiento de los juegos para filtrar. Si está vacío, no se aplica filtro por fecha.
     * 
     * @return array|false Retorna un array con los juegos que cumplen con los filtros aplicados, 
     * o `false` en caso de error.
     */
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

    /**
     * Destructor de la clase.
     *
     * Este método se ejecuta al finalizar la ejecución de la web. Su función es cerrar la conexión 
     * a la base de datos para evitar errores de conexión cuando la conexión se realiza muchas veces rápidamente.
     *
     * @return void
     */
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
