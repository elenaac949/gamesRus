<?php
/* require_once "modelo.php"
 */
require_once "vista.php";
require_once "bbdd.php";

class Controlador
{
    private $modelo;
    public function __construct()
    {
        // $this->modelo= new Modelo();
        session_start();
    }

    public function Inicio()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //aqui se procesa pasar al login
            $this->entrarLogin();
        } else {
            //Llamamos a la clase vista y usamos el metodo entrar -> nos muestra el landing
            Vista::MuestraLanding();
        }
    }


    function entrarLogin()
    {
        Vista::MuestraLogin();
    }

}

$programa=new Controlador();
$programa->Inicio();













//Mostramos el landing
/* if (!isset($_POST['entrar'])) {
    //$programa->entrar();
} */


//si existe la variable entrar nos muestra el formulario de login
if (isset($_POST['entrar'])) {
    //$programa->inicia();
} //no se como hacer que se deje de llamar a la pagina de landing
/* $programa->inicia();*/

// $programa->registra();

//si existe la variable enviar nos muestra el formulario de login

if (isset($_POST['enviar'])) {
    // Si enviamos las credenciales de usuario y contraseña
    /* $usuario = $_POST['usuario']; // validamos el nombre de usuario, nick o contraseña
    $contrasenia = $_POST['contrasenia'];
    $contraseniaHasheada = password_hash($contrasenia, PASSWORD_DEFAULT); */
    //Para controlar que funciona
    // echo $usuario . " " . $contrasenia; 
   /*  $baseDatos->controlLogin($usuario, $contraseniaHasheada); */
}


//si existe la variable registrar nos muestra el formulario de login
/* if (isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $nick = $_POST['nick'];
    $contrasenia = $_POST['contrasenia'];
    $contrasenia2 = $_POST['contrasenia2'];
 */
    // Validar si las contraseñas coinciden
   /*  if ($contrasenia === $contrasenia2) {
        // Hashear la contraseña
        $hashedPassword = password_hash($contrasenia, PASSWORD_DEFAULT); */

        // Registrar al usuario
/*         $baseDatos->registrarUsuario($nombre, $apellidos, $correo, $nick, $hashedPassword);
    } else {
        echo 'Las contraseñas no coinciden.';
    }
} */
