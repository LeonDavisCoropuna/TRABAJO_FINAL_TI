
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
    
        <table class="tabla">
            <thead class="header">
                <tr>
                    <th >N</th>
                    <th >Cursos</th>
                    <th colspan ="2">Modulos</th>
                    
                </tr>
                
            </thead>
            <tbody>
                <?php
                    $i=1;
                    foreach($this->datos as $row){
                        $curso = new Curso();
                        $curso = $row;
                        $url_aux = constant('URL');
                        $aux_curso = $curso->nameCurso;
                        $aux_curso = strtr($aux_curso," " , "-");
                        echo "<tr>";
                        echo "<td>".$i."</td>";
                        echo "<td>".$curso->nameCurso."</td>";
                        echo "<td><fieldset>
                                <form action='".$url_aux."modulos/Asistencia/".$aux_curso."' method='post'>
                                    <select name='asistencia' id='asistencia'>
                                        <option value='registro'> Registro  </option>
                                        <option value='estadistica'> Estadisticas </option>
                                    </select>
                                    <input type='submit' value=' Asistencia' >
                                </form>
                            </fieldset>

                        </td>";
                        echo "<td><fieldset>
                                <form action='".$url_aux."modulos/Notas/".$aux_curso."' method='post'>
                                    <select name='parciales' id='parciales'>
                                        <option value='1'> 1° Parcial </option>
                                        <option value='2'> 2° Parcial </option>
                                        <option value='3'> 3° Parcial </option>
                                    </select>
                                    <input type='submit' value=' Notas' id='registro_notas'>
                                </form>
                            </fieldset>

                        </td>";
                        echo "</tr>";
                        $i++;
                    }
                ?>
            </tbody>
            
        </table>
    <?php require_once 'vista/footer.php'; ?>
</body>
</html>