<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php   require 'vista/header.php';
            require_once 'modelo/clasecurso.php';

    ?>
        <div id="main">
            <h1 class="center">Bienvenido al main</h1>

            <img src="<?php echo constant('URL')?>public/imagenes/unsa.jpg" width="80%" style="text-align: center;">
            <table>
                <tr>
                    <td>MODELO</td>
                </tr>
                <tr>
                    <td>VISTA</td>
                </tr>
                <tr>
                    <td>CONTROLADOR</td>
                </tr>
            </table>
        </div>
    <?php require 'vista/footer.php'?>

</body>
</html>