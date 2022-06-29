<?php
    include("base_datos.php");
    $datos = $_POST;
    echo "<h1>PARCIALES ETAPA ".$_POST["parciales"]."</h1>";
?>
    <table>
        <thead>
            <tr>
                <th>N</th>
                <th>APELLIDOS</th>
                <th>CONTINUA 1</th>
                <th>EXAMEN 1</th>
                <th>CONTINUA 2</th>
                <th>EXAMEN 2</th>
                <th>CONTINUA 3</th>
                <th>EXAMEN 3</th>
            </tr>
        </thead>
        <?php  
            $BaseDatos = new base_datos("localhost","root","","asistencia","registro_notas");
            $BaseDatos->conectar();
            
                $clientes = $BaseDatos->getNotas();
                if(!is_null($clientes)){
                    while($row = mysqli_fetch_assoc($clientes)){
                        echo "<tr class='tr'>";
                        echo "<td class='td'>".$row['N']."</td>";
                        echo "<td class='td'>".$row['NOMBRE']."</td>";
                        echo "<td class='td'>".$row ['CONTINUA1']."</td>";
                        echo "<td class='td'>".$row['EXAMEN1']."</td>";
                        echo "<td class='td'>".$row ['CONTINUA2']."</td>";
                        echo "<td class='td'>".$row['EXAMEN2']."</td>";
                        echo "<td class='td'>".$row ['CONTINUA3']."</td>";
                        echo "<td class='td'>".$row['EXAMEN3']."</td>";
                        echo "</tr>";
                    }
                }
        ?>
    </table>
