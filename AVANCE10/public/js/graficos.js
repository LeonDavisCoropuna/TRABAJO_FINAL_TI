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


function graficos_por_alumno(falta, asistencia, nombre){
    var asis= asistencia;
    var fal= falta;
    var name = nombre;

    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['FALTAS', 'ASISTENCIAS'],
        datasets: [{
            label: 'Asistencia',
            data: [fal,asis],
            backgroundColor: [
                'rgba(255, 206, 86, 1)',
                'rgba(54, 162, 235,1)',
                
            ],
            borderColor: [
                'rgba(255, 206, 86, 1)',
                'rgba(54, 162, 235, 1)',
                
            ],
            borderWidth: 1,
            
        }]
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
              text: name
            }
        }
    }
    
});
}

function graficos_por_semestre(presente, falta, abandono,total){

    const ctx = document.getElementById('myChart2').getContext('2d');
    const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['ASISTENCIAS', 'FALTAS','ABANDONO'],
        datasets: [{
            label: 'Asistencia',
            data: [presente,falta,abandono],
            backgroundColor: [
                'rgba(255, 206, 86, 1)',
                'rgba(54, 162, 235,1)',
                'rgb(217, 25, 25)',

                
            ],
            borderColor: [
                'rgba(255, 206, 86, 1)',
                'rgba(54, 162, 235, 1)',
                'rgb(217, 25, 25)',
            ],
            borderWidth: 1,
            
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display : false
            },
            title: {
              display: true,
              text: "ASISTENCIA EN EL SEMESTRE TOTAL DE CLASES: " + total,
            }
        },
        animation: {
            duration: 0
        }
    }
    
});
}

function graficos_por_clase(asistencia,falta,nombre){
    var asis= asistencia;
    var fal= falta;
    var name = nombre;

    const ctx = document.getElementById('myChart3').getContext('2d');
    const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['FALTAS', 'ASISTENCIAS'],
        datasets: [{
            label: 'Asistencia',
            data: [fal,asis],
            backgroundColor: [
                'rgba(255, 206, 86, 1)',
                'rgba(54, 162, 235,1)',
                
            ],
            borderColor: [
                'rgba(255, 206, 86, 1)',
                'rgba(54, 162, 235, 1)',
                
            ],
            borderWidth: 1,
            
        }]
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
              text: "CLASE " + name
            }
        }
    }
    
});
}