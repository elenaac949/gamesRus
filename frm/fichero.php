<?php
// promocion.php
header('Content-Type: application/json');

// Simulamos la información de una promoción
$promociones = [
    'Descuento del 20% en todos los productos',
    'Envío gratis en compras mayores a $50',
    'Compra 1, llévate 2 en productos seleccionados'
];

// Seleccionamos una promoción aleatoria
$promocion = $promociones[array_rand($promociones)];

// Devolvemos el mensaje en formato JSON
echo json_encode(['mensaje' => $promocion]);

