<?php
    
    include("base_datos.php");
    require_once 'dompdf/autoload.inc.php';
    include_once "dompdf/vendor/autoload.php";
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();
    ob_start();
    $datos = $_POST['link'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="registro_notas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <title>Document</title>
</head>
<body>
    <?php
        $BaseDatos = new base_datos("localhost","root","","asistencia","registro_notas");
        $BaseDatos->conectar();
        $clientes3 = $BaseDatos->getNotas();
        echo "<h2>REGISTRO DE NOTAS PARCIALES 1</h2>";
        echo "<table class='registro'>";
        echo "<thead>";
            echo "<tr>";
                echo "<th> N </th>"; 
                echo "<th> Apellidos y Nombres </th>"; 
                echo "<th> C1 </th>";
                echo "<th> E1 </th>";
                echo "<th> Nota  </th>";
            echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        if(!is_null($clientes3)){
            $i=0;
            $aux;
            while($row = mysqli_fetch_assoc($clientes3)){
                $aux = "normal";

                $aux4 = round(($row['CONTINUA1'] + $row['EXAMEN1'])/2);
                echo "<tr>";
                    echo "<td class='ids ".$aux."'>".$row['N']."</td>";
                    echo "<td class='names ".$aux."'>".$row['NOMBRE']."</td>";
                    echo "<td class='notas ".$aux."'>".$row['CONTINUA1']."</td>";
                    echo "<td class='notas ".$aux."'>".$row['EXAMEN1']."</td>";

                    echo "<td class='notas ".$aux."'>".$aux4."</td>";
                echo "</tr>";
            }
        } 
        echo "</tbody>";
    echo "</table>";
    echo "<br><br>";
    echo "<br><br><br>";

?>
<table class="tabla2 registro ">
                <thead>
                    <tr>
                        <th >Apellidos y Nombres</th>
                        <th class="separar">Continua 1</th>
                        <th class="separar">Nota</th>
                    </tr>
                </thead>
                <tbody class="cuerpoTabla">
                    <?php
                        
                        $Base_Datos = new base_datos("localhost","root","","asistencia","registro_notas");
                        $Base_Datos->conectar();

                        $parcial ="1";
                        $tabla = $Base_Datos->Obtener_tablaEtapas($parcial);
                        $RegistroNotas = $Base_Datos->getNotas();

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
                        <th class="separar">Examen 1</th>
                        <th class="separar">Nota</th>
                    </tr>
                </thead>
                <tbody class="cuerpoTabla">
                    <?php
                        
                        $Base_Datos = new base_datos("localhost","root","","asistencia","registro_notas");
                        $Base_Datos->conectar();

                        $parcial ="1";
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
                        <th colspan="2">Nota Promedio Parcial 1</th>
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
                        if(!is_null($clientes)){
                            $i=0;
                            while($row = mysqli_fetch_assoc($clientes)){
                                $promedioContinuas += $row['CONTINUA1'];
                                $promedioExamen += $row['EXAMEN1'];
                                $i++;
                            }
                        }
                        echo "<td>".round(($promedioContinuas)/$i)."</td>";
                        echo "<td>".round(($promedioExamen)/$i)."</td>";
                        ?>
                        </tr>
                </tbody>
            </table>
<?php
    echo "<br><br><br>";
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