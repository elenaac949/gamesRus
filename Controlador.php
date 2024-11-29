<?php
/* require_once "modelo.php"
 */
require_once "vista.php";
require_once "bbdd.php";

class Controlador{
    public function __construct(){

    }

    public function inicia(){
        Vista::Inicio();
    }

    public function registra(){
        Vista::registro();
    }

    
}

$programa= new Controlador();

$programa->inicia();
$programa->registra();


 if (isset($_POST['enviar'])){
    $usuario = $_POST['usuario'];
    $contrasenia = $_POST['password'];
    echo $usuario . " " . $contrasenia;
    $baseDatos->controlLogin($usuario,$contrasenia);
 }




?>