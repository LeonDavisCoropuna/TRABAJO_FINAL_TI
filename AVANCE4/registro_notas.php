<?php
    include("base_datos.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRO DE NOTAS</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <form id="notas">
    <?php echo "<h2 class='h2'>PARCIALES ETAPA ".$_POST["parciales"]."</h2>"; ?>

    <select name="parciales" id="parciales" method="POST" hidden>
        <option value="1" <?php if( $_POST["parciales"] == 1){echo "selected";}?>  >PARCIALES 1</option>
        <option value="2" <?php if( $_POST["parciales"] == 2){echo "selected";}?>>PARCIALES 2</option>
        <option value="3" <?php if( $_POST["parciales"] == 3){echo "selected";}?>>PARCIALES 3</option>
    </select>

        <table>
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
                        echo "<td class='td'><input type='number' class='notas' name='continua".$i."' value=".$row['CONTINUA'.$_POST['parciales']]."></td>";
                        echo "<td class='td'><input type='number' class='notas' name='examen".$i."' value=".$row['EXAMEN'.$_POST['parciales']]."></td>";
                        echo "</tr>";
                        $i++;
                    }
                }
            ?>
            </tbody>
        </table>
    </form>
    <div class="botones">
        <input type="button" value="REGISTRAR" id="registrar">
        <input type="submit" value="REGRESAR A ASISTENCIA" id="regresar" onclick="regresar()">
    </div>
    
    <?php
        echo "<h2 id='perro' value=''></h2>";
    ?>

    <script src="registro_notas.js"></script>
</body>
</html>