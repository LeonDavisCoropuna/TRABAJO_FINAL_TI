<?php
    include("base_datos.php");
    require_once 'dompdf/autoload.inc.php';
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();
    ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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
                
                if($row['NOTAFINAL'] < 11){
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
    echo "<style>
        *{  
            font-size: 15px;
            font-family: sans-serif;
            text-align: center;
        }
        .names{
            text-align:left;
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
    $dompdf->setPaper('letter');
    $dompdf->render();
    $dompdf->stream("NOTA_FINAL.pdf",array("Attachment" => true));
?>
</body>
</html>