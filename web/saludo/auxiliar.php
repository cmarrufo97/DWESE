<?php

function dibujar_tabla($numero) {
    for ($i = 0; $i <= 10; $i++) :
        fila($numero, $i);
    endfor;
}

/**
 * Vuelca por la salida una fila de la tabla de multiplicar
 *
 * @param string|int $n
 * @param int $i
 * @return void
 */
function fila($n,int $i)
{
        $res = $n * $i;
        echo "$n x $i = $res"; ?>
        <br><?php
}

/**
 * Vuelca por la salida un mensaje de error 
 *
 * @param string $s
 * @return void
 */
function mensaje_error($s) 
{
    ?>
    <div class="error"><?= $s?></div><?php
}

/**
 * Devuelve el valor de un parámetro GET, o cadena vacía si no existe.
 *
 * @param string $p
 * @return string
 */
function param(string $p) : string 
{
    return (isset($_GET[$p])) ? trim($_GET[$p]) : '';
}
