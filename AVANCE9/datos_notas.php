<!DOCTYPE html>
<?php
    include("base_datos.php");
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="datos_notas.css">
</head>
<body>
    <div class="Contenedor1">
        <select name="parciales" id="paraciales">
            <option value="1">Parcial 1</option>
            <option value="2">Parcial 2</option>
            <option value="3">Parcial 3</option>
        </select>
        
        <div class="tablasNotas">
            <table class="NotasContinuas">
                <thead>
                    <tr>
                        <th></th>
                        <th >Apellidos y Nombres</th>
                        <th>Notas</th>
                    </tr>
                </thead>
                <tbody class="cuerpoTabla">
                    <?php
                        
                        $Base_Datos = new base_datos("localhost","root","","asistencia","registro_notas");
                        $Base_Datos->conectar();

                        $parcial ="1";
                        $tabla = $Base_Datos->Obtener_tablaEtapas($parcial);
                        $RegistroNotas = $Base_Datos->getNotas();
                        while ($fila = $tabla->fetch_array()){
                            
                            while($row=$RegistroNotas->fetch_array()){
                                if($fila['MayorContinua']==$row['N']){
                                    echo "<tr>";
                                        echo "<td>Mayor Continua</td>";
                                        echo "<td>".$row['NOMBRE']."</td>";
                                        echo "<td>".$row['CONTINUA1']."</td>";
                                    echo "</tr>";
                                }
                                if($fila['MenorContinua']==$row['N']){
                                    echo "<tr>";
                                        echo "<td>Menor Continua</td>";
                                        echo "<td>".$row['NOMBRE']."</td>";
                                        echo "<td>".$row['CONTINUA1']."</td>";
                                    echo "</tr>";
                                }

                            }
                        }

                    ?>
                </tbody>
                
            </table>
        
            <table class="NotasExamen">
                <thead>
                    <tr>
                        <th></th>
                        <th >Apellidos y Nombres</th>
                        <th>Notas</th>
                    </tr>
                </thead>
                <tbody class="cuerpoTabla">
                    <?php
                        
                        $Base_Datos = new base_datos("localhost","root","","asistencia","registro_notas");
                        $Base_Datos->conectar();

                        $parcial ="1";
                        $tabla = $Base_Datos->Obtener_tablaEtapas($parcial);
                        $RegistroNotas = $Base_Datos->getNotas();
                        while ($fila = $tabla->fetch_array()){
                            
                            while($row=$RegistroNotas->fetch_array()){
                                if($fila['MayorExamen']==$row['N']){
                                    echo "<tr>";
                                        echo "<td>Mayor Examen</td>";
                                        echo "<td>".$row['NOMBRE']."</td>";
                                        echo "<td>".$row['EXAMEN1']."</td>";
                                    echo "</tr>";
                                }
                                if($fila['MenorExamen']==$row['N']){
                                    echo "<tr>";
                                        echo "<td>Menor Examen</td>";
                                        echo "<td>".$row['NOMBRE']."</td>";
                                        echo "<td>".$row['EXAMEN1']."</td>";
                                    echo "</tr>";
                                }

                            }
                        }

                    ?>
                </tbody>
                
            </table>
        </div>
        
    </div>
    
</body>
</html>