<?php

/**
 * Imprime por la salida la tabla de multiplicar del número
 * que se pasa como parámetro
 *
 * @param int $m
 * @return void
 */
function dibujar_tabla($m = 5)          // $m = 5 -> Argumento por defecto. Si hay mas de argumento y queremos poner por defecto, tienen que ser los ultimos.
{
    for ($i = 0; $i <= 10; $i++) {
        echo "$m x $i = " . $m * $i . "\n";
    }
}

/**
 * Undocumented function
 *
 * @param integer|null $x
 * @param float $y
 * @return float
 */
function suma(int $x, int $y): int 
{
    return $x + $y;
}
