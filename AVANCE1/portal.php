<?php include("base_datos.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
</head>
<body>
    <h2 id="titulo">LISTA DE ALUMNOS</h2>
    <div id="btnCONSULTA">
        <input type="button" value="REALICE UNA CONSULTA DE UN REGISTRO ANTERIOR" id="consultar">
    </div>
    <form id="registro">
        
        <table id="tablaUsuarios">
            <thead>
                <tr>
                    <th rowspan="2">N°</th>
                    <th rowspan="2">NOMBRES Y APELLIDOS</th>
                    <th id="estadosPTF">ASISTENCIA</th>
                </tr>
                <tr>
                    <th id="estadosPTF2">
                        <div>P</div> 
                        <div>F</div>
                    </th>
                </tr>   
            </thead>
            <tbody id="inicio">
                
            </tbody>
        </table>
        <div class="btnFinal">
            <div id="btnSEND">
                <input type="button" value="Enviar" id="enviar">
            </div>
            <div id="btnSEND2">
                <input type="text" class="btnSEND2" placeholder="Nombre del archivo" name="archivo">
            </div>
        </div>
    </form>

    <script src="interfaz.js"></script>
    <footer id="footer">unsa &copy 2022</footer>
</body>
</html>