<?php 
    include("base_datos.php");
    require_once 'dompdf/autoload.inc.php';
    include_once "dompdf/vendor/autoload.php";
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
    <script src="graficos.js"></script>
    <title>PDF ASISTENCIA</title>
</head>
<body>
    <h1> Registro de Asistencia</h1>
    <table class="registro tabla2">
        <thead>
            <tr>
                <th class='ids'>N</th>
                <th>Nombres y Apellidos</th>
                <th class="separar">Asistencias</th>
                <th class="separar">Faltas</th>
                <th>Porcentaje Asistencia</th>
                <th>Porcentaje Falta</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $Base_datos = new base_datos("localhost","root","","asistencia","registro");
                $Base_datos->conectar();

                $datosRecord = $Base_datos->obtnerAsitenciaAlumno();
                    
                $asistencia;
                $falta;
                $nombre;
                $id;
             
                while ($fila = $datosRecord->fetch_array()){
                    if($fila["ESTADO"]=="PRESENTE"){

                        echo "<tr class='normal'>";
                    }
                    
                    if($fila["ESTADO"]=="ABANDONO"){

                        echo "<tr class='rojo'>";
                    }
                    
                    if($fila["ESTADO"]=="FALTA"){

                        echo "<tr class='verde'>";
                    }
                    
                        echo "<td >".$fila["N"]."</td>";
                        echo "<td class='names'>".$fila["NOMBRE"]."</td>";
                        echo "<td>".$fila["ASISTENCIAS"]."</td>";
                        echo "<td>".$fila["FALTAS"]."</td>";
                        echo "<td>".$fila["POR_ASISTENCIAS"]."</td>";
                        echo "<td>".$fila["POR_FALTAS"]."</td>";
                        echo "<td>".$fila["ESTADO"]."</td>";
                    echo "<tr>";
                }
            ?>
        </tbody>
    </table>
    <br>
    <br>
    <?php
        $aux5 = $_POST["link"];
        echo "<img src='$aux5' width='600' height='500'/>";
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
        th{
            padding: 5px 0px;
        }
        .registro th{
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