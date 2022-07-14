<?php
    
    include("base_datos.php");
    require_once 'dompdf/autoload.inc.php';
    include_once "dompdf/vendor/autoload.php";
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();
    ob_start();
    $datos = $_POST['link3'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="registro_notas.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body >
    <?php
        $BaseDatos = new base_datos("localhost","root","","asistencia","registro_notas");
        $BaseDatos->conectar();
        $clientes3 = $BaseDatos->getNotas();
        echo "<h2>REGISTRO DE NOTAS FINALES</h2>";
        echo "<table class='registro'>";
        echo "<thead>";
            echo "<tr>";
                echo "<th> N </th>"; 
                echo "<th> Apellidos y Nombres </th>"; 
                echo "<th> C1 </th>";
                echo "<th> E1 </th>";
                echo "<th> C2 </th>";
                echo "<th> E2 </th>";
                echo "<th> C3 </th>";
                echo "<th> E3 </th>";
                echo "<th> Nota Final </th>";
            echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        if(!is_null($clientes3)){
            $i=0;
            $aux;
            while($row = mysqli_fetch_assoc($clientes3)){
                $aux = "normal";
                
                if($row['NOTAFINAL'] < 10.5){
                    $aux = 'rojo';
                }
                if($row['NOTAFINAL'] > 16){
                    $aux = 'verde';
                }
                echo "<tr>";
                echo "<td class='ids ".$aux."'>".$row['N']."</td>";
                echo "<td class='names ".$aux."'>".$row['NOMBRE']."</td>";
                echo "<td class='notas ".$aux."'>".$row['CONTINUA1']."</td>";
                echo "<td class='notas ".$aux."'>".$row['EXAMEN1']."</td>";
                echo "<td class='notas ".$aux."'>".$row['CONTINUA2']."</td>";
                echo "<td class='notas ".$aux."'>".$row['EXAMEN2']."</td>";
                echo "<td class='notas ".$aux."'>".$row['CONTINUA3']."</td>";
                echo "<td class='notas ".$aux."'>".$row['EXAMEN3']."</td>";
                echo "<td class='notas ".$aux."'>".$row['NOTAFINAL']."</td>";
                echo "</tr>";
            }
        } 
        echo "</tbody>";
    echo "</table>";
    ?>
        <br>
<table class="tabla2 registro ">
                <thead>
                    <tr>
                        <th >Apellidos y Nombres</th>
                        <th class="separar">Continua 3</th>
                        <th class="separar">Nota</th>
                    </tr>
                </thead>
                <tbody class="cuerpoTabla">
                    <?php
                        
                        $Base_Datos = new base_datos("localhost","root","","asistencia","registro_notas");
                        $Base_Datos->conectar();

                        $parcial ="3";
                        $tabla = $Base_Datos->Obtener_tablaEtapas($parcial);
                        $RegistroNotas = $Base_Datos->getNotas();

                        $parcial ="3";
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
                        <th class="separar">Examen 3</th>
                        <th class="separar">Nota</th>
                    </tr>
                </thead>
                <tbody class="cuerpoTabla">
                    <?php
                        
                        $Base_Datos = new base_datos("localhost","root","","asistencia","registro_notas");
                        $Base_Datos->conectar();

                        $parcial ="3";
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
                        <th colspan="2">Nota Promedio Semestre</th>
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
                        $promedioContinuas3=0;
                        $promedioExamen3=0;
                        if(!is_null($clientes)){
                            $i=0;
                            while($row = mysqli_fetch_assoc($clientes)){
                                $promedioContinuas += $row['CONTINUA1'];
                                $promedioExamen += $row['EXAMEN1'];
                                $promedioContinuas2 += $row['CONTINUA2'];
                                $promedioExamen2 += $row['EXAMEN2'];
                                $promedioContinuas3 += $row['CONTINUA3'];
                                $promedioExamen3 += $row['EXAMEN3'];
                                $i++;
                            }
                        }
                        $i = $i*3;
                        echo "<td>".round(($promedioContinuas + $promedioContinuas2 + $promedioContinuas3)/$i)."</td>";
                        echo "<td>".round(($promedioExamen+ $promedioExamen2 + $promedioExamen3)/$i)."</td>";
                        ?>
                        </tr>
                </tbody>
            </table>
            <br><br>
    <?php

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
