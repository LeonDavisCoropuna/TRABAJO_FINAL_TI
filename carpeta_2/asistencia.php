<?php
    $datos = $_POST;
    //$fecha = $_POST['archivo'];
    $fecha = "pipipipi";

    $conexion = new mysqli("localhost","root","","asistencia");

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

    //ENCONTRAR UNA TABLA EN LA BASE DE DATOS
    $campo1 = "dia_2ddgfgh";
    $Object = new DateTime();  
    $diaActual = $Object->format("d-m-Y h:i:s a");
    $fechita="";
    // feca actual
    for($i=0;$i<5;$i++){
        $fechita=$fechita.$diaActual[$i];
    }
    

    for($i=0;$i<count($tablas);$i++){

        // verificar primero si existe la tabla para poder agregar columnas
        // caso contrario se crea una nueva tabla
        if($tablas[$i] == $fecha){
            $connection = new mysqli("localhost", "root", "","asistencia");
            // crear una nueva columna en la tabla
            $connection->query("alter table pipipipi add(`$fechita` VARCHAR(100))");
            
            // funcion a mejorar
            //insertarDatosColumna($fechita,$datos);
        }
    }

    function insertarDatosColumna($columName, $datos){
        $conexion = new mysqli("localhost", "root", "","asistencia");
        $result = $conexion->query("SHOW COLUMNS FROM pipipipi");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {                
                if($row['Field']==$columName){
                    $conn = mysqli_connect("localhost", "root", "", "asistencia");
                    for($j=1;$j<41;$j++){
                        $estado = $datos["estado".($j-1)];
                        echo "<script>consol.log($estado)</script>";
                        echo "<script>consol.log($columName)</script>";
                        $consulta = "insert into `pipipipi` ('diua1') values ('p')";
                        mysqli_query($conn,$consulta);
                    }
                }
            }
        }
    }
    


?>
