<?php
    include("base_datos.php");  
    require_once 'dompdf/autoload.inc.php';
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRO DE NOTAS</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="datos_notas.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="registro_notas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.14.305/pdf.min.js" integrity="sha512-dw+7hmxlGiOvY3mCnzrPT5yoUwN/MRjVgYV7HGXqsiXnZeqsw1H9n9lsnnPu4kL2nx2bnrjFcuWK+P3lshekwQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


</head>
<body>
    
    <form id="notas">   
    <?php echo "<h2 class='h2'>PARCIALES ETAPA ".$_POST["parciales"]."</h2>";?>

    <select name="parciales" id="parciales" method="POST" hidden>
        <option value="1" <?php if( $_POST["parciales"] == 1){echo "selected";}?>>PARCIALES 1</option>
        <option value="2" <?php if( $_POST["parciales"] == 2){echo "selected";}?>>PARCIALES 2</option>
        <option value="3" <?php if( $_POST["parciales"] == 3){echo "selected";}?>>PARCIALES 3</option>
    </select>
        <table id="grafico_notas">
            <thead>
                <th>N</th>
                <th>APELLIDOS Y NOMBRES</th>
                <th>CONTINUA</th>
                <th>EXAMEN </th>
            </thead>
            <tbody id="contenedor">
            <?php
                $BaseDatos = new base_datos("localhost","root","","asistencia","registro_notas");
                $BaseDatos->conectar();
            
                $clientes = $BaseDatos->getNotas();
                if(!is_null($clientes)){
                    $i=0;
                    while($row = mysqli_fetch_assoc($clientes)){
                        echo "<tr class='tr'>";
                        echo "<td class='td'>".$row["N"]."</td>";
                        echo "<td class='td'>".$row['NOMBRE']."</td>";
                        echo "<td class='td'><input type='number' class='notas' name='continua".$i."' value=".$row['CONTINUA'.$_POST['parciales']]."  min='1' max='20' pattern='^[0-9]+'></td>";
                        echo "<td class='td'><input type='number' class='notas' name='examen".$i."' value=".$row['EXAMEN'.$_POST['parciales']]."    min='1'  max='20' pattern='^[0-9]+'></td>";
                        echo "</tr>";
                        $i++;
                    }
                }
            ?>
            </tbody>
        </table>
    </form>
    <div class="botones">
        <input type="button" value="REGISTRAR" id="registrar" onclick = "candown('grafico_notas','$aux5000')">
    </div>
    
    <!-- Muestra datos del grafico -->
    <div class="Contenedor1">
       
        <div class="tablasNotas">
            <table class="NotasContinuas">
                <thead>
                    <tr>
                        <th >Apellidos y Nombres</th>
                        <th>Continua</th>
                        <th>Notas</th>
                    </tr>
                </thead>
                <tbody class="cuerpoTabla">
                    <?php
                        
                        $Base_Datos = new base_datos("localhost","root","","asistencia","registro_notas");
                        $Base_Datos->conectar();

                        $parcial =$_POST["parciales"];
                        $tabla = $Base_Datos->Obtener_tablaEtapas($parcial);
                        $RegistroNotas = $Base_Datos->getNotas();

                        $parcial =$_POST["parciales"];
                        $continua="CONTINUA".$parcial;
                        while ($fila = $tabla->fetch_array()){
                            
                            while($row=$RegistroNotas->fetch_array()){
                                if($fila['MayorContinua']==$row['N']){
                                    echo "<tr>";
                                        echo "<td>".$row['NOMBRE']."</td>";
                                        echo "<td>Mayor</td>";
                                        echo "<td>".$row[$continua]."</td>";
                                    echo "</tr>";
                                }
                                if($fila['MenorContinua']==$row['N']){
                                    echo "<tr>";
                                        echo "<td>".$row['NOMBRE']."</td>";
                                        echo "<td>Menor</td>";
                                        echo "<td>".$row[$continua]."</td>";
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
                        <th >Apellidos y Nombres</th>
                        <th>Examen</th>
                        <th>Notas</th>
                    </tr>
                </thead>
                <tbody class="cuerpoTabla">
                    <?php
                        
                        $Base_Datos = new base_datos("localhost","root","","asistencia","registro_notas");
                        $Base_Datos->conectar();

                        $parcial =$_POST["parciales"];
                        $examen="EXAMEN".$parcial;

                        $tabla = $Base_Datos->Obtener_tablaEtapas($parcial);
                        $RegistroNotas = $Base_Datos->getNotas();
                        while ($fila = $tabla->fetch_array()){
                            
                            while($row=$RegistroNotas->fetch_array()){
                                if($fila['MayorExamen']==$row['N']){
                                    echo "<tr>";
                                        echo "<td>".$row['NOMBRE']."</td>";
                                        echo "<td>Mayor</td>";
                                        echo "<td>".$row[$examen]."</td>";
                                    echo "</tr>";
                                }
                                if($fila['MenorExamen']==$row['N']){
                                    echo "<tr>";
                                        echo "<td>".$row['NOMBRE']."</td>";
                                        echo "<td>Menor</td>";
                                        echo "<td>".$row[$examen]."</td>";
                                    echo "</tr>";
                                }
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="tablasPromedio">
            <table>
                <thead>
                    <tr>
                        <th colspan="2">Nota Promedio</th>
                    </tr>
                    <tr>
                        <th>Continua</th>
                        <th>Examen</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <?php
                        $BaseDatos = new base_datos("localhost","root","","asistencia","registro_notas");
                        $BaseDatos->conectar();
                        
                        $clientes = $BaseDatos->getNotas();
                        $i=0;
                        $promedioContinuas=0;
                        $promedioExamen=0;
                        if(!is_null($clientes)){
                            $i=0;
                            while($row = mysqli_fetch_assoc($clientes)){
                                $promedioContinuas += $row['CONTINUA'.$_POST['parciales']];
                                $promedioExamen += $row['EXAMEN'.$_POST['parciales']];
                                $i++;
                            }
                        }
                        
                        echo "<td>".$promedioContinuas/$i."</td>";
                        echo "<td>".$promedioExamen/$i."</td>";
                        ?>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="Contenedor2">
    <div class="grafico1">
            <?php   
            
            echo "<canvas id='myChart'>";
                    $BaseDatos = new base_datos("localhost","root","","asistencia","registro_notas");
                    $BaseDatos->conectar();
                    $clientes2 = $BaseDatos->getNotas();
                    $i=0;   
                    $aprobadosContinua=0;
                    $aprobadosExamen=0;
                    $desaprobadosContinua=0;
                    $desaprobadosExamen=0;
                    if(!is_null($clientes2)){
                        $i=0;
                        while($row = mysqli_fetch_assoc($clientes2)){
                            if($row['CONTINUA'.$_POST['parciales']]>=10){
                                $aprobadosContinua++;
                            }
                            if($row['EXAMEN'.$_POST['parciales']]>=10){
                                $aprobadosExamen++;
                            }
                            $i++;
                        }
                    }
                    $desaprobadosContinua=$i-$aprobadosContinua;
                    $desaprobadosExamen= $i-$aprobadosExamen;
                    $aux5000 = 'Parcial'.$_POST['parciales'];
                    echo "<script>mostrarGrafico(".$aprobadosContinua.",".$aprobadosExamen.",".$desaprobadosContinua.",".$desaprobadosExamen.",".$_POST['parciales'].")</script>";
            echo "</canvas>";
            echo "<input type='submit' onclick = candown('myChart','".$aux5000."') value ='DESCARGAR'>";

            ?>
        </div>
    </div>
        <?php 
        if($_POST['parciales']==2){
            echo "<div class='Contenedor3'>";
            echo "<table>
                    <thead>
                        <tr>
                            <th colspan='7'>Estudiantes en peligro de jalar el curso</th>
                        </tr>
                        <tr>
                            <th  rowspan='2'>Nombre y Apellidos</th>
                            <th class='detalles' colspan='4'>Nota</th>
                            <th class='detalles' rowspan='2'>Nota Promedio</th>
                            <th class='detalles' rowspan='2'>Minima Nota para aprobar</th>
                        </tr>
                       
                        <tr>
                            <th class='detalles2' >Continua 1 (10%)</th>
                            <th class='detalles2' >Examen 1 (10%)</th>
                            <th class='detalles2' >Continua 2 (10%)</th>
                            <th class='detalles2' >Examen 2 (10%)</th>
                        </tr>
                    </thead>
                    <tbody>";
                        $BaseDatos = new base_datos("localhost","root","","asistencia","registro_notas");
                        $BaseDatos->conectar();
                        $clientes3 = $BaseDatos->getNotas();
                        $continua=0;
                        $examen=0;
                        if(!is_null($clientes2)){
                            $i=0;
                            $aux;
                            while($row = mysqli_fetch_assoc($clientes3)){

                                $continua=$row['CONTINUA1']*0.1 + $row['CONTINUA2']*0.1;
                                $examen=$row['EXAMEN1']*0.1 + $row['EXAMEN2']*0.1;
                                $aux = round(((11-($continua+$examen))/0.6),1);
                                $aux2 = "normal";
                                if($aux > 12){$aux2 = "peligro";}
                                if($aux > 12){
                                    echo "<tr>";
                                    echo "<td class='".$aux2."'>".$row['NOMBRE']."</td>";
                                    echo "<td class='".$aux2."'>".$row['CONTINUA1']."</td>";
                                    echo "<td class='".$aux2."'>".$row['EXAMEN1']."</td>";
                                    echo "<td class='".$aux2."'>".$row['CONTINUA2']."</td>";
                                    echo "<td class='".$aux2."'>".$row['EXAMEN2']."</td>";
                                    echo "<td class='".$aux2."'>".$continua+$examen."</td>";
                                    echo "<td class='".$aux2."'>".$aux."</td>";
                                    echo "</tr>";
                                }
                                
                            }
                        }  
                echo "</table>";
            echo "</div>";
        }   
        ?>

    <div class="botones">
        <input type="submit" value="REGRESAR A ASISTENCIA" id="regresar" onclick="regresar()">
    </div>
    <?php

    if($_POST['parciales']==1){ 
        ?>
        <form action="parcial1_pdf.php" method="post" id="formulario3" target= "blank">
            <input hidden type="text" name="link" value="" id="linkImage">
            <input type="submit" id="enviar" value='GENERAR REGISTRO'>
        </form>
        
        <?php
    }

    if($_POST['parciales']==2){        
        ?>
        <form action="parcial2_pdf.php" method="post" id="formulario3" target= "blank">
            <input hidden type="text" name="link2" value="" id="linkImage">
            <input type="submit" id="enviar" value='GENERAR REGISTRO'>
        </form>
        
        <?php
    }
    
    if($_POST['parciales']==3){    
        ?>
        <form action="parcial3_pdf.php" method="post" id="formulario3" target= "blank">
            <input hidden type="text" name="link3" value="" id="linkImage">
            <input type="submit" id="enviar" value='GENERAR REGISTRO'>
        </form>
        <?php
    }
        
    ?>
</body>
</html>