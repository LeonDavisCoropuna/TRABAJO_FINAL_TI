<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asisitencia</title>
    
    <link rel="stylesheet" href="<?php echo constant('URL') ?>public/estilos/grafico_asis.css">
    
    <script src="<?php echo constant('URL') ?>public/js/asistencia.js"></script>
    <script src="<?php echo constant('URL') ?>public/js/graficos.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.14.305/pdf.min.js" integrity="sha512-dw+7hmxlGiOvY3mCnzrPT5yoUwN/MRjVgYV7HGXqsiXnZeqsw1H9n9lsnnPu4kL2nx2bnrjFcuWK+P3lshekwQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

</head>
<body>
    <?php require_once 'vista/header.php'; ?>
    
    <h1><?php echo $this->table_name;  ?></h1>
    <?php
        $curso = strtr($this->table_name," ","-");
        if($this->select_asistencia == "registro"){
    ?>
    <form id="registro" action='<?php echo constant('URL')?>modulos/Asistencia/<?php echo $curso?>/registrarAsistencia' method='POST'>
        <select name="asistencia" id="asistencia" method="POST" hidden>
            <option value="registro" <?php if( $this->select_asistencia == "registro"){echo "selected";}?>></option>
            <option value="estadistica" <?php if( $this->select_asistencia == "estadistica"){echo "selected";}?>></option>
        </select>
        <label for="dia">Fecha: </label>        
        <input type="date" name="dia" value='<?php $d=strtotime("yesterday");echo date("Y-m-d",$d);?>'>    
        
        <?php 
            echo $this->inicializar_tabla;
            
        ?>
       
        <div class="btnFinal">
            <div id="btnSEND">
                <input type="submit" value="Enviar" id="enviar">
            </div>      
        </div>
    </form>
    
    
    
    <?php 
    }     
    //INICIO ELSE
    else{  

    ?>
    <div class='contenedor_estadistica'>
        <div>
        
            <form method="post" action='<?php echo constant('URL')?>modulos/Asistencia/<?php echo $curso?>/registrarAsistencia'>            
                <?php echo $this->inicializar_tabla_graficos;?>
            </form>
        </div>
        <div class="contenedor_graficos">
            <div class="bloque">
                <canvas id="myChart" width="400" height="400">
                    <?php
                        $datosRecord = $this->asistencia_alumno_Record;
                        $asistencia;
                        $falta;
                        $nombre;
                        $i=0;
                        $id = $_POST["btnGrafico"];
                        while ($fila = $datosRecord->fetch_array()){
                            if($i==$id){
                                $asistencia = $fila["POR_ASISTENCIAS"];
                                $falta = $fila["POR_FALTAS"];
                                $nombre = $fila["NOMBRE"];
                            }
                            $i++;
                        }                        
                        echo "<script>graficos_por_alumno(".$falta.",".$asistencia.",'$nombre')</script>";
                    ?>
                </canvas>  
                <?php 
                    $nombre =str_replace(' ', '_', $nombre);
                    $namePdf = "Asistencia_".$nombre; 
                ?>
            </div>
            <div>
            <div class="bloque">
                <canvas id="myChart2" width="400" height="400">

                <?php 
                    $datosRecord = $this->asistencia_alumno_Record;
                    $presentes=0;
                    $faltas=0;
                    $abandonos=0;
                    foreach ($datosRecord as $fila){
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
                    
                    $aux4 = $this->totalClases;
                    echo "<script>graficos_por_semestre(".$presentes.",".$faltas.",'$abandonos','$aux4')</script>";
                ?>
                </canvas>

            </div>



            <div class="bloque">
                <form method="post" action='<?php echo constant('URL')?>modulos/Asistencia/<?php echo $curso?>/registrarAsistencia'>
                    <?php  
                        echo "<select name='clase' class='seleccionar'>";
                        echo "<option selected hidden>SELECCIONA UNA CLASE</option>";                        
                        foreach($this->total_name_dias as $row){
                            if($row != "N" && $row != "NOMBRE")
                                echo  "<option value='".$row."'>$row</option>";
                        }                        
                        echo "</select>";
                        echo "<button class='btnMostrar'>MOSTRAR</button>";                        
                    ?>
                </form> 
                <canvas id="myChart3" width="400" height="400">
                    <?php
                    
                    echo "<script>graficos_por_clase(".$this->asistencia_en_un_dia[0].",".$this->asistencia_en_un_dia[1].",'".$this->asistencia_en_un_dia[2]."')</script>";
                    ?>
                </canvas>
            </div>
        </div>

        <?php }?>
        <?php require_once 'vista/footer.php'; ?>
                   
    <div>
</body>
</html>