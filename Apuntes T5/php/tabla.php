<?php

/**
 * @author Christian Marrufo <christian.marrufo@iesdonana.org>
 * @copyright 2019 Christian Marrufo
 * @license https://www.gnu.org/licenses/gpl.txt
 */

// APUNTES TEMA 5

require __DIR__ . '/auxiliar.php';

// VALIDACIONES DE ENTRADA
if ($argc < 2) {
    echo "Sintaxis: {$argc[0]} <número>\n";        // {$argc[0]} -> Nombre del fichero.
    exit(1);
}

$n = $argv[1];

function prueba()
{
    global $n;      // para referirnos a una variable fuera de la funcion.
    echo $n;
}

if (!ctype_digit($n)) {                              // ctype_digit() -> evalua que sean numeros enteros y positivos. quita signos etc.
    echo "Error: El <número> debe ser un número entero y positivo.\n";
    exit(2);
}

if ($n < 0 || $n > 10) {
    echo "Error: El <número> debe estar comprendido entre 0 y 10.\n";
    exit(3);
}

dibujar_tabla($n);


// FUNCIONES

// function suma($x, $y)
// {
//     // return $x + $y;
// }

// var_dump(suma(4,3));
// die();          // Finalizar programa
