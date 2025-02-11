<?php

$uri = "http://localhost/gamesRus/servidorSOAP.php";



function esTarjetaValida($numeroTarjeta)
{
    // Elimina espacios o guiones del número
    $numeroTarjeta = preg_replace('/\D/', '', $numeroTarjeta);

    // Algoritmo de Luhn para validar el número de tarjeta
    $suma = 0;
    $alternar = false;
    for ($i = strlen($numeroTarjeta) - 1; $i >= 0; $i--) {
        $digito = (int) $numeroTarjeta[$i];
        if ($alternar) {
            $digito *= 2;
            if ($digito > 9) $digito -= 9;
        }
        $suma += $digito;
        $alternar = !$alternar;
    }

    if (($suma % 10) === 0) {
        return "válida";
    } else {
        "inválida";
    }
}

function esFechaCaducidadValida($dia, $mes, $anio)
{

    if ($anio < 100) {
        $anio += 2000; // Asumimos siglo actual
    }

    // Fecha actual
    $dia_actual = intval(date('d'));
    $mes_actual = intval(date('m'));
    $anio_actual = intval(date('Y'));

    // Validar que no esté vencida
    if ($anio > $anio_actual) {
        return true;
    } elseif ($anio === $anio_actual) {
        if ($mes > $mes_actual) {
            return true;
        } elseif ($mes === $mes_actual) {
            return $dia >= $dia_actual;
        }
    }

    return false;
}



try {
    $server = new SoapServer(null, array("uri" => $uri));
    $server->addFunction("esTarjetaValida");
    $server->handle();
} catch (SoapFault $e) {
    echo "Error del servidor SOAP: " . $e->getMessage();
}
