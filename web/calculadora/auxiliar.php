<?php

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

function calcular(&$op1,$op2,$op) 
{
    switch($op) {
        case '+':
        $op1 += $op2;
        break;

        case '-': 
        $op1 -= $op2;
        break;

        case '*': 
        $op1 *= $op2;
        break;

        case '/':
        $op1 /= $op2;
        break;
    }
}

function comprobarParametros($par, &$errores) 
{

    $res = $par;

    if (!empty($_GET)) {
        if (empty(array_diff_key($par,$_GET)) && 
            empty(array_diff_key($_GET,$par))) {
                $res = array_map('trim', $_GET);
            } else {
                $errores[] = 'Los parámetros recibidos no son los correctos.';
        }
    }
    return $res;
}

function comprobarValores($op1,$op2,$op,$ops,&$errores)
{
    if (!is_numeric($op1)) {
        $errores['op1'] = 'El primer operando no es un número';
    }
    if (!is_numeric($op2)) {
        $errores['op2'] = 'El segundo operando no es un número';
    }
    if (!in_array($op,$ops)) {
        $errores['op'] = 'La operación no es correcta';
    }
    if ($op == '/' && $op2 == 0) {
        $errores['op'] = 'Error: División por cero';
    }
    comprobarErrores($errores);
}

function comprobarErrores(&$errores)
{
    if (empty($_GET) || !empty($errores)) {
        throw new Exception();
    }
}

/**
 * Vuelca por la salida un mensaje de error 
 *
 * @param string $s
 * @return void
 */
function mensajeError($campo,$errores) 
{
    if(isset($errores[$campo])) {
        $mensaje = $errores[$campo];
        return <<<EOT
        <div class="invalid-feedback">
        {$errores[$campo]}
        </div>
        EOT;
    }else {
        return '';
    }
}

// function mostrarErrores($errores) 
// {
//     foreach ($errores as $error) {
//         mensajeError($error);
//     }
// }

function selected($op,$o)
{
    return $op == $o ? 'selected' : '';
}

function valido($campo,$errores)
{
    if (isset($errores[$campo])) {
        return 'is-invalid';
    }elseif (!empty($_GET)){
        return 'is-valid';
    }else {
        return '';
    }
}

function dibujarFormulario($op1,$op2,$op,$ops,$errores)
{ 
    ?>
    <form action="" method="get">
        <div class="form-group">
            <label for="op1">Primer operando: </label>
            <input type="text" name="op1" id="op1" 
            class="form-control <?= valido('op1',$errores) ?>
            " value="<?= $op1 ?>">
            <?= mensajeError('op1',$errores)?>
        </div>
    <div class="form-group">
        <label for="op2">Segundo operando:</label>
        <input type="text" name="op2" id="op2" class="form-control <?= valido('op2',$errores) ?>
        " value="<?= $op2 ?>">
        <?= mensajeError('op2',$errores)?>
    </div>
    <div class="form-group">
        <label for="op">Operación:</label>
        <select class="form-control <?= valido('op',$errores) ?>
        " name="op" id="op">
            <?php foreach($ops as $o): ?>
            <option value="<?= $o ?>" <?= selected($op,$o) ?> >
                <?= $o ?>
            </option>
            <?php endforeach ?>
        </select>
    </div>
    <button type="submit">Calcular</button>
</form><?php
}
