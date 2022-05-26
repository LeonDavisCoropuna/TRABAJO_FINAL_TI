<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta</title>
    <style>
        body{
            text-align: center;
            margin-top: 10%;
            background-color: rgb(250, 249, 247);
        }
        input[type='submit'] {
            padding: 25px;
            margin-left: 20px;
            border-radius: 15px;
            background-color: black;
            font-weight: bold;
            color: white;
            font-size: 25px;
        }
        input[type='submit']:hover {
            background-color: white;
            font-weight: bold;
            color: black;
        }
        
        input[type='text'] {
            padding: 25px;
            margin-left: 50px;
            border-radius: 15px;
            font-size: 25px;
            width: 520px;
            background-color: rgb(230, 238, 238);
        }
        input[type='text']:hover{
            background-color: white;
        }

        table{
            margin: auto;
            border-radius: 10px;
            text-align: center;
            border-spacing: 20px;
        }
        table td{
            width: 200px;
            border: 1px solid black;
            border-radius: 10px;
            padding: 20px;
            font-size: 25px;
            background: #072168;
            color: #D2D2D4;
            font-family: 'Lucida Sans Unicode', sans-serif;

            font-weight:bold;

        }
    </style>
</head>
<body>
    <form action="gDOMPDF.php" method="get">
        <input type="submit" value="Descargar pdf">
        <input type="text" placeholder="Nombre_Archivo" name="base">      
    </form>

    <?php
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
        $tablas = obtenerTablasDeUnaBaseDeDatos("localhost", "root", "", "asistencia");
        echo "<h2>Fechas anteriores</h2>";
        echo "<table>";
        echo "<tr>";

        for($i=0;$i<count($tablas);$i++){
            if($i % 5 == 0){
                echo "</tr>";
                echo "<tr>";
            }
            echo "<td>$tablas[$i]</td>";
        }
        echo "</tr>";
        echo "</table";
    ?>
</body>
</html>