<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=ç, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Confirmar borrado</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <?php
    require __DIR__ . '/../comunes/auxiliar.php';
    require __DIR__ . '/auxiliar.php';


    $pdo = conectar();

    if (hayAvisos()) {
        alert();
    }

    if (isset($_GET) && !empty($_GET)) {
        if (isset($_GET['id'])) {
            $id = h(trim($_GET['id']));
            unset($_GET['id']);
        }
    }

    if (isset($_POST) && !empty($_POST)) {
        if (isset($_POST['confirmacion'])) {
            $confirmacion = h(trim($_POST['confirmacion']));

            if ($confirmacion === 'SI') {
                //realizar borrado.
                $sent = $pdo->prepare("DELETE FROM departamentos WHERE id = :id");
                $sent->execute([':id' => $id]);
                // borrarFila($pdo, 'departamentos', $id);
                
                if ($sent->rowCount() === 1) {
                    aviso('Departamento borrado correctamente');
                    header('Location: /departamentos/index.php');
                    return;
                } else {
                    aviso('El departamento tiene empleados', 'danger');
                    header('Location: /departamentos/index.php');
                    return;
                }
            } else {
                // no se realiza el borrado.
                aviso('Se cancelo el borrado.', 'danger');
                header('Location: /departamentos/index.php');
                return;
            }
        }
    }

    ?>
    <?= dibujarFormularioConfirmacion() ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>