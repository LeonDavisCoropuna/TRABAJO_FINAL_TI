<?php
    include("base_datos.php");
    require_once 'dompdf/autoload.inc.php';
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();
    $datos = $_POST['link2'];
    ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="registro_notas.js"></script>
    <title>Document</title>
</head>
<body>
    <?php
        $BaseDatos = new base_datos("localhost","root","","asistencia","registro_notas");
        $BaseDatos->conectar();
        $clientes3 = $BaseDatos->getNotas();
        echo "<h2>REGISTRO DE NOTAS PARCIALES 2</h2>";
        echo "<table class='registro'>";
        echo "<thead>";
            echo "<tr>";
                echo "<th> N </th>"; 
                echo "<th> Apellidos y Nombres </th>"; 
                echo "<th> C1 </th>";
                echo "<th> E1 </th>";
                echo "<th> C2 </th>";
                echo "<th> E2 </th>";
                echo "<th> Nota  </th>";
            echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        if(!is_null($clientes3)){
            $i=0;
            $aux;
            while($row = mysqli_fetch_assoc($clientes3)){
                $aux = "normal";

                $continua=$row['CONTINUA1']*0.1 + $row['CONTINUA2']*0.1;
                $examen=$row['EXAMEN1']*0.1 + $row['EXAMEN2']*0.1;
                $aux3 = round(((11-($continua+$examen))/0.6),1);
                $aux4 = round(($row['CONTINUA1'] + $row['CONTINUA2'] + $row['EXAMEN1'] + $row['EXAMEN2'])/4);
                if($aux3 > 12){$aux = "rojo";}                
                echo "<tr>";
                    echo "<td class='ids ".$aux."'>".$row['N']."</td>";
                    echo "<td class='names ".$aux."'>".$row['NOMBRE']."</td>";
                    echo "<td class='notas ".$aux."'>".$row['CONTINUA1']."</td>";
                    echo "<td class='notas ".$aux."'>".$row['EXAMEN1']."</td>";
                    echo "<td class='notas ".$aux."'>".$row['CONTINUA2']."</td>";
                    echo "<td class='notas ".$aux."'>".$row['EXAMEN2']."</td>";
                    echo "<td class='notas ".$aux."'>".$aux4."</td>";
                echo "</tr>";
            }
        } 
        echo "</tbody>";
    echo "</table>";
    echo "<br><br><br>";
?>
<table class="tabla2 registro ">
                <thead>
                    <tr>
                        <th >Apellidos y Nombres</th>
                        <th class="separar">Continua 2</th>
                        <th class="separar">Nota</th>
                    </tr>
                </thead>
                <tbody class="cuerpoTabla">
                    <?php
                        
                        $Base_Datos = new base_datos("localhost","root","","asistencia","registro_notas");
                        $Base_Datos->conectar();

                        $parcial ="2";
                        $tabla = $Base_Datos->Obtener_tablaEtapas($parcial);
                        $RegistroNotas = $Base_Datos->getNotas();

                        $parcial ="2";
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
            <br>
            <table class="tabla2 registro">
                <thead>
                    <tr>
                        <th >Apellidos y Nombres</th>
                        <th class="separar">Examen 2</th>
                        <th class="separar">Nota</th>
                    </tr>
                </thead>
                <tbody class="cuerpoTabla">
                    <?php
                        
                        $Base_Datos = new base_datos("localhost","root","","asistencia","registro_notas");
                        $Base_Datos->conectar();

                        $parcial ="2";
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
            <br>
            <table class="registro tabla2">
                <thead>
                    <tr>
                        <th colspan="2">Nota Promedio Parcial 2</th>
                    </tr>
                    <th class="separar">Continua</th>
                    <th class="separar">Examen</th>
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
                        $promedioContinuas2=0;
                        $promedioExamen2=0;
                        if(!is_null($clientes)){
                            $i=0;
                            while($row = mysqli_fetch_assoc($clientes)){
                                $promedioContinuas += $row['CONTINUA1'];
                                $promedioExamen += $row['EXAMEN1'];
                                $promedioContinuas2 += $row['CONTINUA2'];
                                $promedioExamen2 += $row['EXAMEN2'];
                                $i++;
                            }
                        }
                        $i = $i*2;
                        echo "<td>".round(($promedioContinuas + $promedioContinuas2)/$i)."</td>";
                        echo "<td>".round(($promedioExamen + $promedioExamen2)/$i)."</td>";
                        ?>
                        </tr>
                </tbody>
            </table>
            <br><br>

<?php
    
            echo "<div class='Contenedor3'>";
            echo "<table class='tabla2 registro'>
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
                        if(!is_null($clientes3)){
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
            ?>
<?php
    echo "<br><br>";
    echo "<img src='$datos' width='600' height='300'>";

    echo "<style>
    *{  
        font-size: 15px;
        font-family: sans-serif;
        text-align: center;
    }
    .names{
        text-align:left;
    }
    .tabla2{
       margin:auto;
    }
    .ids{
        width: 40px;
    }
    .notas{
        width: 50px;
    }
    .registro{
        border-collapse: collapse;
    }
    .registro thead {
        background-color: #336288;
        color: white;
    }
    .separar{
       border-collapse: separate;
       border-spacing:  5px;
       padding: 0px 10px;
    }
    .registro tr{
        border-bottom: 2px solid #cbcbcb;
    }
    
    .registro th, .tabla td{
        border: none;            
    }
    .registro{
        background-color: white;
    }
    
    .normal{
        background: white;
    }
    .rojo{
        background: #FFCCCC;
    }
    .verde{
        background: #EAFFDC
    }
    </style>";
    
 $html = ob_get_clean();
 $dompdf->loadHtml($html);
 $dompdf->setPaper('A4', 'portrait');
 $dompdf->render();
 header("Content-type: application/pdf");
 $dompdf->stream("NOTA_FINAL.pdf",array("Attachment" => false));
    
?>
</body>
</html>