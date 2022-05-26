<?php
    $datos = $_POST;
    $fecha = $_POST['archivo'];


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


    for($i=0;$i<count($tablas);$i++){
        if($tablas[$i] == $fecha){
            $encontrar = 1;
        }
    }


    if($encontrar == 1){
        $connection = new mysqli("localhost", "root", "","asistencia");
        $connection->query("DROP TABLE `$fecha`");
    }
    
    $sql = "CREATE TABLE `$fecha`(
        N INT(5),
        NOMBRE VARCHAR(100),
        ASISTENCIA VARCHAR(1),
        JUSTIFICACION TEXT(1000)
    )";

    $conexion->query($sql);
    
    $conex = mysqli_connect("localhost","root","","asistencia");

    for($j=1;$j<41;$j++){
        $orden = $j;
        $name = $datos["nombre".($j-1)];
        $estado = $datos["estado".($j-1)];
        $justi = $datos["justi".($j-1)];
        $consulta = "INSERT INTO `$fecha`(N,NOMBRE,ASISTENCIA,JUSTIFICACION) VALUES ('$orden','$name','$estado','$justi')";
        mysqli_query($conex,$consulta);
    }

    echo $datos['nombre10'];

?>
