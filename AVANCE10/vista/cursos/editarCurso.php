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
    <?php   require_once 'vista/header.php'; ?>

    <h1>EDITAR <?php echo $this->tableName; ?></h1>
    <form action="<?php echo constant('URL');?>cursos/editarCurso/<?php echo $this->tableName;?>/guardarPesos" method="post">
        <table> 
            <thead>
                <tr> 
                    <th colspan="5">Pesos Notas <?php echo $this->tableName; ?></th>    
                </tr>
                <tr>                
                    <th>#</th>
                    <th>Parcial 1</th>
                    <th>Parcial 2</th>
                    <th>Parcial 3</th>
                </tr>
                
            </thead>
            <tbody>
                <?php

                echo "<tr>";
                
                    echo "<td>CONTINUA</td>";
                    echo "<td><input type='number' name='continua1' value='".$this->pesosCurso[0]->continua1."' require></td>";
                    echo "<td><input type='number' name='continua2' value='".$this->pesosCurso[0]->continua2."' require></td>";
                    echo "<td><input type='number' name='continua3' value='".$this->pesosCurso[0]->continua3."' require></td>";
                echo "</tr>";
                
                echo "<tr>";
                    echo "<td>EXAMEN</td>";
                    echo "<td><input type='number' name='examen1' value='".$this->pesosCurso[1]->examen1."' require></td>";
                    echo "<td><input type='number' name='examen2' value='".$this->pesosCurso[1]->examen2."' require></td>";
                    echo "<td><input type='number' name='examen3' value='".$this->pesosCurso[1]->examen3."' require></td>";
                echo "</tr>";
                
                ?>
                

            </tbody>
        </table>
        <input type="submit" value="GUARDAR CAMBIOS">
    </form>
    <form action="<?php echo constant('URL');?>cursos/editarCurso/<?php echo $this->tableName;?>/insertAlumno" method="post" enctype="multipart/form-data">
        <div>
            <input type="file" name="archivoExel" id="file_input" require>
            <label for="file_input"></label>
            <span>Elegir archivo exel</span>
            <br>
            <input type="submit" value="INSERTAR ALUMNOS">
        </div>

    </form>        
    
    <table>
        <thead>
            <tr>
                <th>N</th>
                <th>Apellidos y Nombres</th>
                <th>Button</th>
            </tr>

        </thead>
        <tbody>
            <?php
                $i=1;
                foreach($this->alumnos as $row){
                    echo "<tr>";
                    echo "<td>".$i."</td>";
                    echo "<td>".$row."</td>";
                    echo "<td><input type='submit' value='Eliminar'></td>";
                    echo "</tr>";
                    $i++;
                }
            ?>
        </tbody>
    </table>
    
    <?php require_once 'vista/footer.php'; ?>

</body>
</html>