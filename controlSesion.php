<?php
// Obtener el referer
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

// Comprobar si termina en "Controlador.php"
if (!str_ends_with($referer, 'Controlador.php')) {
    header("Location: ../Controlador.php");
}
