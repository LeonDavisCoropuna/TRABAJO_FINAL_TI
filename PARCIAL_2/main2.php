<?php
    include("base_datos.php");
    $datos = $_POST;

    $BaseDatos = new base_datos("localhost","root","","asistencia","registro_notas");

    $BaseDatos->conectar();
    $BaseDatos->insertar_notas($datos);

?>