
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRO DE NOTAS</title>
    <link rel="stylesheet" href="<?php echo constant('URL') ?>public/estilos/asistencia.css">
    <link rel="stylesheet" href="<?php echo constant('URL') ?>public/estilos/graficonotas.css">
    <script src="<?php echo constant('URL') ?>public/js/graficos.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.14.305/pdf.min.js" integrity="sha512-dw+7hmxlGiOvY3mCnzrPT5yoUwN/MRjVgYV7HGXqsiXnZeqsw1H9n9lsnnPu4kL2nx2bnrjFcuWK+P3lshekwQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>
<body>

    <?php require_once 'vista/header.php'; ?>
    <?php require_once 'modelo/clasenotasresaltantes.php';?>
    <h1>NOTAS <?php echo $this->table_name;  ?></h1>
    <?php $curso = strtr($this->table_name," ","-"); ?>
    <form id="notas" action='<?php echo constant('URL')?>modulos/Notas/<?php echo $curso?>/actualizarNotas' method ='POST'>   
    <?php echo "<h2 class='h2'>PARCIALES ETAPA ".$this->parcial."</h2>";?>

    <select name="parciales" id="parciales" method="POST" hidden>
        <option value="1" <?php if( $this->parcial == "1"){echo "selected";}?>></option>
        <option value="2" <?php if( $this->parcial == "2"){echo "selected";}?>></option>
        <option value="3" <?php if( $this->parcial == "3"){echo "selected";}?>></option>
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
                $auxNotas = [];
                $auxNotas2 = [];
                     while($row = mysqli_fetch_assoc($this->notas)){
                        array_push($auxNotas,$row);
                        array_push($auxNotas2,$row);

                     }

                if(!is_null($this->notas)){
                    $i=0;
                    foreach($auxNotas as $row){
                        
                        echo "<tr class='tr'>";
                        echo "<td class='td'>".$row["N"]."</td>";
                        echo "<td class='td'>".$row['NOMBRE']."</td>";
                        echo "<td class='td'><input type='number' class='notas' name='continua".$i."' value=".$row['CONTINUA'.$_POST['parciales']]."  min='0' max='20' pattern='^[0-9]+'></td>";
                        echo "<td class='td'><input type='number' class='notas' name='examen".$i."' value=".$row['EXAMEN'.$_POST['parciales']]."    min='0'  max='20' pattern='^[0-9]+'></td>";
                        echo "</tr>";
                        $i++;
                    }
                }
            ?>
            </tbody>
        </table>
        <div class="botones">
            <input type="submit" value="REGISTRAR" id="registrar">
        </div>
    </form>

    <div class="Contenedor1">
       
        <div class="tablasNotas">
            <table class="NotasContinuas">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>#</th>
                        <th>Apellidos y Nombres</th>
                        <th>Notas</th>
                        
                    </tr>
                </thead>
                <tbody class="cuerpoTabla">
                    <?php
                    
                        $contador = 2;
                        foreach($this->notasResaltantes as $row){
                            $item = new NotasResaltantes();
                            $item = $row;
                            echo "<tr>";
                            if($contador == 2){
                                echo "<td rowspan='2'>MENOR</td>";
                            }
                            if($contador == 4){
                                echo "<td rowspan='2'>MAYOR</td>";
                            }
                            if($contador%2 == 0){
                                echo "<td>Examen</td>";
                            }
                            else{
                                echo "<td>Continua</td>";
                            }

                            echo "<td>".$item->nombre."</td>"; 
                            echo "<td>".$item->nota."</td>";
                            echo "</tr>";
                            $contador++;
                        }
                    ?>
                </tbody>
            </table>
        </div>
         
        <div class="Contenedor2">
            <div class="grafico1">
                <?php
                
                echo "<canvas id='alumnos_aprobados' width ='600px' height='600px'>";
                echo "<script>mostrarGrafico(".$this->alumnos_aprobados[0].",".$this->alumnos_aprobados[1].",".$this->alumnos_aprobados[2].",".$this->alumnos_aprobados[3].",".$this->parcial.")</script>";
                echo "</canvas>";
                ?>
            </div>
        </div>
        <?php 
        
        if($_POST['parciales'] == "2"){
            echo "<div class='Contenedor3'>";
            echo $this->estudiantesPeligro;
            echo "</div>";
        }   
        
        ?>

    </div>
    <?php require_once 'vista/footer.php'; ?>


</body>
</html>