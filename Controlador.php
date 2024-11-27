<?php
/* require_once "modelo.php"
 */
require_once "vista.php";

class Controlador{
    public function __construct(){

    }

    public function inicia(){
        Vista::Inicio();
    }
}

$programa= new Controlador();
$programa->inicia();





?>