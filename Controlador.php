<?php
/* require_once "modelo.php"
 */
require_once "vista.php";
require_once "bbdd.php";
include "./env/conf.env";



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
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $this->mostrarLogin();
        }else{
           Vista::MuestraLanding(); 
        }
        
    }


     function mostrarLogin(){
        
        Vista::MuestraLogin();
        if (isset($_POST['enviar'])) {
            
            
            
            
        }
    }
    public function verificarUsuario() {
        global $baseDatos;
        $usuario = trim($_POST['usuario']); // validamos el nombre de usuario, nick o contraseña
            $contrasenia = trim($_POST['contrasenia']); 
        //$contraseniaHasheada = password_hash($contrasenia, PASSWORD_DEFAULT);  //ESTA CONTRASEÑA NO SE HASHEA AGAIN
            //Para controlar que funciona
            echo $usuario . " " . $contrasenia; 
            if (($baseDatos->controlLogin($usuario)) == $contrasenia) {

            }
    }
    }


$programa = new Controlador();


$programa->Inicio();

if (isset($_POST['enviar'])) {
    $programa->verificarUsuario();
}
/* if(isset($_POST['entrar'])){
    $programa->inicia();
} *///no se como hacer que se deje de llamar a la pagina de landing
/* $programa->inicia();

$programa->registra(); */

// Si enviamos las credenciales de usuario y contraseña


//Si registramos usuario nuevo
/* if (isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $nick = $_POST['nick'];
    $contrasenia = $_POST['contrasenia'];
    $contrasenia2 = $_POST['contrasenia2'];
} */
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
