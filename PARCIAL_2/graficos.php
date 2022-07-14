<?php
    include("base_datos.php");

    $Grafico = new base_datos("localhost","root","","asistencia","registro");
    $Grafico->conectar();
?>


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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.14.305/pdf.min.js" integrity="sha512-dw+7hmxlGiOvY3mCnzrPT5yoUwN/MRjVgYV7HGXqsiXnZeqsw1H9n9lsnnPu4kL2nx2bnrjFcuWK+P3lshekwQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>


</head>
<body>
    <div class="tablagraficos">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <table id="tablaUsuarios">
                <thead>
                    <tr>
                        <th >N°</th>
                        <th class="names">NOMBRES Y APELLIDOS</th>
                        <th id="estadosPTF">Graficos</th>
                    </tr>
                    
                </thead>
                <tbody id="inicio">
                    
                </tbody>
            </table>
        </form>
        <div class="contenedor_graficos">
            <div class="bloque">
                <canvas id="myChart" width="400" height="400">
                    <?php
                        $Base_datos = new base_datos("localhost","root","","asistencia","registro");
                        $Base_datos->conectar();
                        $datosRecord = $Base_datos->obtnerAsitenciaAlumno();
                    
                        $asistencia;
                        $falta;
                        $nombre;
                        $id;
                        $i=0;
                        if($_SERVER["REQUEST_METHOD"] == "POST"){
                            $id = $_POST["RAAA"];
                        }
                        while ($fila = $datosRecord->fetch_array()){
                            if($i==$id){
                                $asistencia = $fila["POR_ASISTENCIAS"];
                                $falta = $fila["POR_FALTAS"];
                                $nombre = $fila["NOMBRE"];
                            }
                            $i++;
                        }
                        
                        echo "<script>graficos(".$falta.",".$asistencia.",'$nombre')</script>";
                    ?>
                </canvas>  
                <?php 
                    $nombre =str_replace(' ', '_', $nombre);
                    $namePdf = "Asistencia_".$nombre; 
                    echo "<button id='descargar' onclick=candown('myChart','$namePdf')>DESCARGAR</button>";
                ?>
            </div>

            <div class="bloque">
                <canvas id="myChart2" width="400" height="400">

                <?php 
                    $Grafico->conectar();
                    $datosRecord = $Grafico->obtnerAsitenciaAlumno();
                    $presentes=0;
                    $faltas=0;
                    $abandonos=0;
                    while ($fila = $datosRecord->fetch_array()){
                        if($fila["ESTADO"] == "PRESENTE"){
                            $presentes++;
                        }
                        else if($fila["ESTADO"] == "FALTA"){
                            $faltas++;
                        }
                        else{
                            $abandonos++;
                        }
                    }
                    $aux4 = $Grafico->total_clases();
                    echo "<script>graficos_semestre(".$presentes.",".$faltas.",'$abandonos','$aux4')</script>";
                ?>
                </canvas>
                <button id='descargar' onclick="candown('myChart2','Asistencia')">DESCARGAR</button>
            </div>
            
            <div class="bloque">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <?php  
                        echo "<select name='clase' class='seleccionar'>";
                        echo "<option selected hidden>SELECCIONA UNA CLASE</option>";
                        for($i = 0;$i< $Grafico->total_clases();$i++){
                            $value = "clase".($i+1);
                            echo  "<option value='".($i+1)."'>$value</option>";
                        }
                        echo "</select>";
                        echo "<button class='btnMostrar'>MOSTRAR</button>";
                    ?>
                </form> 

                <canvas id="myChart3" width="400" height="400">
                    <?php 

                    $Grafico = new base_datos("localhost","root","","asistencia","registro");
                    $Grafico->conectar();

                    $presentes=0;
                    $faltas=0;

                    $dia;
                    if($_SERVER["REQUEST_METHOD"] == "POST"){
                        $dia = $_POST["clase"];
                        $presentes = $Grafico->asistencia_dia($dia);
                    }

                    $faltas = 40 - $presentes;

                    echo "<script>graficos_por_clase(".$presentes.",".$faltas.",'$dia')</script>";
                    ?>
                </canvas>
                <button id='descargar' onclick="captura('myChart3','clase')">DESCARGAR</button>;

            </div>
        </div>
    </div>
    <div class="btnFinal">
        <div id="btnSEND">
            <input type="submit" value="Regresar" id="regresar" onclick="regresar()">
        </div>        
        <div id="btnSEND">
            <form action="asistencia_pdf.php" method="post" id="formulario3" target= "blank">
                <input hidden type="text" name="link" value="" id="linkImage">
                <input type="submit" id="enviar" value='GENERAR REGISTRO'>
            </form>
        </div>        
    </div>
    
</body>
</html>