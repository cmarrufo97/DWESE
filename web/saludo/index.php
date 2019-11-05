<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>El programa que multiplica</title>
    <style>
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php

    require __DIR__ . '/auxiliar.php';

    $numero = param('numero');
    ?>

    <form action="index.php" method="get">
        <label for="numero">Número:</label>
        <input type="text" name="numero" id="numero" value="<?= $numero ?>"><br>
        <button type="submit">Mostrar</button>
    </form>

    <?php
    if (isset($_GET['numero'])) {
        if ($numero != '') {
            if (ctype_digit(($numero))) {                         // sólo hay digitos
                if ($numero >= 0 && $numero <= 10) {              // está entre 0 y 10.
                    dibujar_tabla($numero);
                } else {
                    mensaje_error('Sólo se admiten números entre 0 y 10');
                }
            } else {
                mensaje_error('Sólo pueden haber dígitos');
            }
        }else {
            mensaje_error('El número es obligatorio');
        }
    }

    ?>
</body>

</html>
