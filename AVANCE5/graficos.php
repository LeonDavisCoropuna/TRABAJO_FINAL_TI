
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="graficos.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="graficos.js"></script>
</head>
<body>
    <table id="tablaUsuarios">
        <thead>
            <tr>
                <th >N°</th>
                <th >NOMBRES Y APELLIDOS</th>
                <th id="estadosPTF">Graficos</th>
            </tr>
            
        </thead>
        <tbody id="inicio">
            
        </tbody>
    </table>
    <div class="btnFinal">
        <div id="btnSEND">
            <input type="button" value="Regresar" id="regresar">
        </div>        
    </div>
    <div class="contenedorGrafico">
        <canvas id="myChart" width="400" height="400">
            <?php
                include("base_datos.php");
                $Base_datos = new base_datos("localhost","root","","asistencia","registro");
                $Base_datos->conectar();
                $datosRecord = $Base_datos->obtnerAsitenciaAlumno();
            
                $asistencia;
                $falta;
                $nombre;
               
                $i=0;
                
                while ($fila =$datosRecord->fetch_array()){
                    if($i==39){
                        $asistencia = $fila["ASISTENCIAS"];
                        $falta = $fila["FALTAS"];
                        $nombre = $fila["NOMBRE"];
                    }
                    $i++;
                }
                
                
                echo "<script>graficos(".$falta.",".$asistencia.",'$nombre')</script>";
            ?>
        </canvas>
                <?php
                 echo "<p>".$nombre."</p>"; 
                ?>
    </div>
</body>
</html>