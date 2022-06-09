<?php include("base_datos.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    <br><br><br>

    <canvas id="myChart" width="400" height="400"></canvas>
<script>
const ctx = document.getElementById('myChart').getContext('2d');
const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: false
            }
        }
    }
});
</script>
 

    <script src="interfaz.js"></script>
    <footer id="footer">unsa &copy 2022</footer>
</body>
</html>
