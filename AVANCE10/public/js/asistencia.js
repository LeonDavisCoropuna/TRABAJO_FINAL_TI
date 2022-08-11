/*
function asignar(){
     addEventListener("click", (e) =>{ 
        
        if(e.target.value != undefined && e.target.value != "Enviar"){
            let alumno = e.target.value;
            //document.getElementById('alumnos_aprobados').insertAdjacentHTML("beforeend","<script>mostrarGrafico(45,65,78,10)</script>")

            mostrarGrafico(15,20,56,12);
            if(window.XMLHttpRequest){
                ajax = new XMLHttpRequest();
            }
            else{
                ajax = new ActiveXObject("Microsoft.XMLHTTP");
            }
        
            let contenido = document.getElementById("tbody");
            ajax.onreadystatechange = function(){
                if(ajax.readyState === 4 && ajax.status === 200){
                    contenido.innerHTML = ajax.responseText;
                }
            }
            
            // document.getElementById('Hola_Mundo').lastElementChild.insertAdjacentHTML("beforeEnd",'<h1>HOLA</h1>');
            
            // ajax.open("POST","http://localhost/AVANCE10/modulos/Asistencia/CIENCIAS-DE-LA-COMPUTACION-II");        
        
            // ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
            // ajax.send("alumno=" + alumno);
        }
     })

     
    //document.addEventListener('click', document.querySelector("button"))

}

function mostrarGrafico(apContinua, apExamen, dsContinua, dsExamen, parcial){

    var ctx = document.getElementById('alumnos_aprobados').getContext('2d');
    let canvas=document.getElementById('alumnos_aprobados');
    canvas.setAttribute('width', window.innerWidth);
    canvas.setAttribute('height', window.innerHeight);
    ctx.fillStyle = 'blue';
    ctx.fillRect(0,0,canvas.width, canvas.height);
    const canvasBackgroundColor = {
        id:'canvasBackgroundColor',
        beforeDraw(chart,args,pluginsOptions){
            console.log(chart)
            const {ctx, chartArea: {top,bottom, left, right, width},scales: {x,y}} =chart;
            ctx.fillStyle = 'rgba(255,26,104,0.2)';
            ctx.fillRect(left, y.getPixelForValue(18) , width, y.getPixelForValue(2))
        }
    }
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
                labels: ['CONTINUAS', 'EXAMENES'],
                datasets: [
                    {
                        hoverBorderColor : "#000",
                    label: 'Aprobados',
                    data: [apContinua,apExamen],
                    backgroundColor: [
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderColor: [
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                    
                    },{
                    label: 'Desaprobados',
                    hoverBorderColor : "#000",
                    data: [dsContinua,dsExamen],
                    backgroundColor: [
                        'rgba(0, 206, 86, 1)'   
                    ],
                    borderColor: [
                        'rgba(0, 206, 86, 1)'
                        
                    ],
                    borderWidth: 1
                }
                ]
            },
            options: {
               
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                
                plugins: {
                    legend: {
                        display : true
                    },                    
                    title: {
                        display: true,
                        text: "NOTAS PARCIAL "+parcial
                    },
                },
                chartArea: {
                    backgroundColor: 'white',
                },
                animation: {
                    duration: 0
                },
                canvasBackgroundColor   
            }        
        }
    );
}
window.addEventListener('load' , asignar);
*/