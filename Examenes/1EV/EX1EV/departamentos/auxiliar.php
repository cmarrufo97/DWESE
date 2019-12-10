<?php

const PAR = [
    'num_dep' => [
        'def' => '',
        'tipo' => TIPO_ENTERO,
        'etiqueta' => 'Número',
    ],
    'dnombre' => [
        'def' => '',
        'tipo' => TIPO_CADENA,
        'etiqueta' => 'Nombre',
    ],
    'localidad' => [
        'def' => '',
        'tipo' => TIPO_CADENA,
        'etiqueta' => 'Localidad',
    ],
    // 'Num.Empleados' => [
    //     'def' => 0,
    //     'tipo' => TIPO_ENTERO,
    //     'etiqueta' => 'Num.Empleados',
    // ],
];

function comprobarValoresIndex($args, &$errores)
{
    if (!empty($errores)) {
        return;
    }

    extract($args);

    if (isset($args['num_dep']) && $num_dep !== '') {
        if (!ctype_digit($num_dep)) {
            $errores['num_dep'] = 'El número de departamento debe ser un número entero positivo.';
        } elseif (mb_strlen($num_dep) > 2) {
            $errores['num_dep'] = 'El número no puede tener más de dos dígitos.';
        }
    }

    if (isset($args['dnombre']) && $dnombre !== '') {
        if (mb_strlen($dnombre) > 255) {
            $errores['dnombre'] = 'El nombre del departamento no puede tener más de 255 caracteres.';
        }
    }

    if (isset($args['localidad']) && $localidad !== '') {
        if (mb_strlen($localidad) > 255) {
            $errores['localidad'] = 'La localidad no puede tener más de 255 caracteres.';
        }
    }
}

function comprobarValores(&$args, $id, $pdo, &$errores)
{
    if (!empty($errores) || empty($_POST)) {
        return;
    }

    extract($args);

    if (isset($args['num_dep'])) {
        if ($num_dep === '') {
            $errores['num_dep'] = 'El número de departamento es obligatorio.';
        } elseif (!ctype_digit($num_dep)) {
            $errores['num_dep'] = 'El número de departamento debe ser un número entero positivo.';
        } elseif (mb_strlen($num_dep) > 2) {
            $errores['num_dep'] = 'El número no puede tener más de dos dígitos.';
        } else {
            if ($id === null) {
                $sent = $pdo->prepare('SELECT COUNT(*)
                                         FROM departamentos
                                        WHERE num_dep = :num_dep');
                $sent->execute(['num_dep' => $num_dep]);
            } else {
                $sent = $pdo->prepare('SELECT COUNT(*)
                                         FROM departamentos
                                        WHERE num_dep = :num_dep
                                          AND id != :id');
                $sent->execute(['num_dep' => $num_dep, 'id' => $id]);
            }
            if ($sent->fetchColumn() > 0) {
                $errores['num_dep'] = 'Ese número de departamento ya existe.';
            }
        }
    }

    if (isset($args['dnombre'])) {
        if ($dnombre === '') {
            $errores['dnombre'] = 'El nombre del departamento es obligatorio.';
        } elseif (mb_strlen($dnombre) > 255) {
            $errores['dnombre'] = 'El nombre del departamento no puede tener más de 255 caracteres.';
        }
    }

    if (isset($args['localidad'])) {
        if ($localidad !== '') {
            if (mb_strlen($localidad) > 255) {
                $errores['localidad'] = 'La localidad no puede tener más de 255 caracteres.';
            }
        } else {
            $args['localidad'] = null;
        }
    }
}

function departamentoVacio($pdo, $id)
{
    $sent = $pdo->prepare('SELECT COUNT(*)
                             FROM empleados
                            WHERE departamento_id = :id');
    $sent->execute(['id' => $id]);
    return $sent->fetchColumn() === 0;
}

function dibujarFormularioConfirmacion()
{
    ?>
    <form method="POST">
        <div class="form-group">
            <label for="confirmacion">¿Está seguro de que quiere eliminar el departamento?</label>
            <select class="form-control" id="conrimacion" name="confirmacion">
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
        </div>
        <button type="submit" class="btn btn-danger">Borrar</button>
    </form>
<?php
}

function dibujarTablaDepartamentos($sent, $count, $par, $orden, $errores)
{
    $filtro = paramsFiltro();
    ?>
    <?php if ($count == 0): ?>
        <?php alert('No se ha encontrado ninguna fila que coincida.', 'danger') ?>        <div class="row mt-3">
    <?php elseif (isset($errores[0])): ?>
        <?php alert($errores[0], 'danger') ?>
    <?php else: ?>
        <div class="row mt-4">
            <div class="col-8 offset-2">
                <table class="table">
                    <thead>
                        <?php foreach ($par as $k => $v): ?>
                            <th scope="col">
                                <a href="<?= "?$filtro&orden=$k" ?>">
                                    <?= $par[$k]['etiqueta'] ?>
                                </a>
                                <?= ($k === $orden) ? '⬆' : '' ?>
                            </th>
                        <?php endforeach ?>
                        <th scope="col">Acciones</th>
                        <th scope="col">Num. Empleados</th>
                    </thead>
                    <tbody>
                        <?php foreach ($sent as $fila): ?>
                            <tr scope="row">
                                <?php foreach ($par as $k => $v): ?>
                                    <?php if (isset($par[$k]['relacion'])): ?>
                                        <?php $visualizar = $par[$k]['relacion']['visualizar'] ?>
                                        <td><?php 
                                            ?><a href="../departamentos/modificar.php?id=<?=$fila['id']?>"><?=$fila[$visualizar]?></a><?php
                                        ?></td>
                                    <?php else: ?>
                                        <td><?= h($fila[$k]) ?></td>
                                    <?php endif ?>
                                <?php endforeach ?>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="id" value="<?= $fila['id'] ?>">
                                        <?= token_csrf() ?>
                                        <!-- <button type="submit" class="btn btn-sm btn-danger">Borrar</button> -->
                                        <a href="borrar.php?id=<?=$fila['id']?>" class="btn btn-sm btn-danger" role="button">Borrar</a>
                                        <a href="modificar.php?id=<?= $fila['id'] ?>" class="btn btn-sm btn-info" role="button">
                                            Modificar
                                        </a>
                                    </form>
                                </td>
                                <td>

                                <?php
                                $pdo = conectar();
                                $s = $pdo->prepare("SELECT count(*) FROM  empleados WHERE departamento_id IN (SELECT id FROM departamentos WHERE id = :id)");
                                $s->execute([':id' => $fila['id']]);
                                $res = $s->fetchColumn();

                                ?><?=$res?><?php
                                ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif;
}
