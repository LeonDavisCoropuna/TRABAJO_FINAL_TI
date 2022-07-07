<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="pdf.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>


    <title>Document</title>
</head>
<body>

<canvas id="myCanvas" width="200" height="200"></canvas>

<button>
  download
</button>

<script>
  const canvas = document.getElementById('myCanvas');
const download = document.querySelector('button');
const context = canvas.getContext('2d');
const {
  jsPDF
} = window.jspdf;
const pdf = new jsPDF();

context.fillStyle = 'yellow';
context.fillRect(0, 0, 100, 100);

download.addEventListener("click", () => {
  const imgData = canvas.toDataURL("image/jpeg", 1.0);
  pdf.addImage(imgData, 'JPEG', 0, 0);
  pdf.save("download.pdf");
}, false);
</script>
    
</body>
</html>