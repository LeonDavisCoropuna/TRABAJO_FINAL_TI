<?php include("base_datos.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASISTENCIA</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="portal.js"></script>
</head>
<body>
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
        </div>
    </form>
    <div id="btnSEND">
        <form action="registro_notas.php" method="post">
            <select name="parciales" id="parciales">
                <option value="1">PARCIALES 1</option>
                <option value="2">PARCIALES 2</option>
                <option value="3">PARCIALES 3</option>
            </select>
            <input type="submit" value="REGISTRO NOTAS" id="registro_notas">
        </form>
    </div>
    <div>
        <input type="submit" value="Graficos" onclick="openGraficos()">
    </div>

    <br><br><br>

    

    <footer id="footer">unsa &copy 2022</footer>
</body>
</html>
