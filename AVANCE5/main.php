<?php

    include ("base_datos.php");

    $datos = $_POST;
    
    $Base_datos = new base_datos("localhost","root","","asistencia","registro");
    $Base_datos->conectar();
    $tablas = $Base_datos->obtenerTablasDeUnaBaseDeDatos();

    $boll = 1;

    for($i=0;$i<count($tablas);$i++){
        if($tablas[$i] == "registro"){
            $Base_datos->insertar_columna($datos);
            $boll = 0;
        }
    }
    if($boll == 1){
        $Base_datos->crear_tabla($datos);
        $Base_datos->insertar_columna($datos);
    }

?>