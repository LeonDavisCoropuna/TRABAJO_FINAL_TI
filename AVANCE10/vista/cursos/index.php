<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo constant('URL') ?>public/estilos/asistencia.css">

</head>
<body>
    <?php   require_once 'vista/header.php'; 
    ?>

    <div>
        <h1>CURSOS DISPONIBLES</h1>
        <form action="<?php echo constant('URL');?>cursos/registrarCurso" method="post">
            <?php 
                echo $this->all_cursos;
            
            ?>
            <!--
            <input type="text" name="curso" id="" placeholder="Curso">
            <input type="text" name="creditos" id="" placeholder="# de creditos">
            <input type="text" name="next" id="" placeholder="Siguiente">
                -->
            <input type="submit" value="Ingresar">
        </form>
    </div>
    <div>
        <table>
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Creditos</th>
                    <th>Next Curso</th>
                    <th>Eliminar</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include_once 'modelo/clasecurso.php';
                    foreach($this->datos as $row){
                        $curso = new Curso();
                        $curso = $row; 
                        $aux_curso = $curso->nameCurso;
                        $aux_curso = strtr($aux_curso," " , "_");
                        $url_aux = constant('URL');

                        echo "<tr>";
                        echo "<td>".$curso->nameCurso."</td>";
                        echo "<td>".$curso->creditos."</td>";
                        echo "<td>".$curso->nextCurso."</td>";
                        echo "<td><a href ='".$url_aux."cursos/eliminarCurso/".$aux_curso."'>Eliminar</a> </td>";

                        echo "<td><a href ='".$url_aux."cursos/editarCurso/".$aux_curso."'>Editar</a> </td>";
                        echo "</tr>";    
                    }
                ?>
            </tbody>
                
        </table>
        <?php 

        ?>

    </div>

    <?php require_once 'vista/footer.php'; ?>
</body>
</html>