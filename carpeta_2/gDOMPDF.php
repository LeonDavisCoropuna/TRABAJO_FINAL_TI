<?php
    $leer = $_GET['base'];
    function obtenerTablasDeUnaBaseDeDatos($host, $usuario, $pass, $nombreDeLaBaseDeDatos){
        try {
            $base_de_datos = new PDO("mysql:host=$host;dbname=$nombreDeLaBaseDeDatos",
                $usuario, $pass);
        } catch (Exception $e) {
            echo "Ocurrió algo con la base de datos: " . $e->getMessage();
        }
        return $base_de_datos
            ->query("SELECT table_name AS nombre FROM information_schema.tables WHERE table_schema = '$nombreDeLaBaseDeDatos';")
            ->fetchAll(PDO::FETCH_COLUMN);
    }
    $encontrar = 0;

    $tablas = obtenerTablasDeUnaBaseDeDatos("localhost", "root", "", "asistencia");

    for($i=0;$i<count($tablas);$i++){
        if($tablas[$i] == $leer){
            $encontrar = 1;
        }
    }
?>
<?php
require_once 'dompdf/autoload.inc.php';
    
use Dompdf\Dompdf;
$dompdf = new Dompdf();
ob_start();
$conex = mysqli_connect("localhost","root","","asistencia");
    if($encontrar == 1){
        $consulta = "SELECT * FROM  `$leer`";
        $resultado = mysqli_query($conex,$consulta);
        if($resultado){
            echo "<h4>Fecha: $leer</h4>";
            echo "<table>";
            echo "<thead";
            echo "<tr>";
            echo "<th>N</th>";
            echo "<th>APELLIDOS Y NOMBRES</th>";
            echo "<th>ESTADO</th>";
            echo "</thead";
    
            while($row = $resultado->fetch_array()){    
    
                $id = $row['N'];
                $nombre = $row["NOMBRE"];
                $estado = $row["ASISTENCIA"];
                
                $iDtxt;
                if($id<10){
                    $iDtxt='0'.$id;
                }else{
                    $iDtxt=$id;
                }
    
                echo "<tr>";
                    echo "<td class='orden'>$iDtxt</td>";
                    echo "<td class='name'>$nombre</td>";
                    echo "<td class='estado'>$estado</td>";
    
                echo "</tr>";
            }
            echo "</table>";
            echo "<style> 
                    h4{
                        text-align: center;
                    }
                    table, td, th {
                        border: 1px solid;
                        padding: 5px;
                        font-size:10px;s
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        font-family: 'Lucida Sans Unicode', sans-serif;
                    }
                    table th{
                        background-color:#000;
                        color:white;
                    }
                    .orden{
                        text-align: center;
                        width:5%;
                        
                    }
                    .estado{
                        width:5%;
                        text-align: center;
                    }
                    .name{
                        width:35%;
                    }
                </style>";
        }
    
        $html = ob_get_clean();
    
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter');
        $dompdf->render();
        $dompdf->stream("{$leer}.pdf",array("Attachment" => true));
        echo "<tr><td>ff</td></tr>";
    }
    else{
        echo "<script>
        alert('NO SE ENCUENTRA');
        let win = window.open('consulta.php','_blank');
        </script>";
    }
?>
