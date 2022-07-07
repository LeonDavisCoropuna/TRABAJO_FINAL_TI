const lista = ["APAZA APAZA NELZON JORGE","APAZA QUISPE ANGEL ABRAHAM","BENAVENTE AGUIRRE PAOLO DANIEL",
"CACSIRE SANCHEZ JHOSEP ANGEL","CARAZAS QUISPE ALESSANDER JESUS","CASTILLO SANCHO SERGIO","CAYLLAHUA GUTIERREZ DIEGO YAMPIER",
"CCAMA MARRON GUSTAVO ALONSO","CERPA GARCIA JEAN FRANCO","CONDORI CASQUINO EBERT LUIS","DAVIS COROPUNA LEON FELIPE",
"ESCARZA PACORI ALEXANDER RAUL","GONZALES CONDORI ALEJANDRO JAVIER","GUTIERREZ ZEVALLOS JAIME JOSÉ","HUALPA LOPEZ JOSE MAURICIO",
"HUAMAN COAQUIRA LUCIANA JULISSA","LAZO PAXI NATALIE MARLENY","LOPEZ CONDORI ANDREA DEL ROSARIO","LUPO CONDORI AVELINO",
"MALDONADO CASILLA BRAULIO NAYAP","MALDONADO P ROY ABEL","MARIÑOS HILARIO PRINCCE YORWIN","MARTÍNEZ CHOQUE ALDO RAÚL",
"MAYORGA VILLENA JHAROLD ALONSO","MENA QUISPE SERGIO SEBASTIAN SANTOS","MOGOLLON CACERES SERGIO DANIEL","MONTOYA CHOQUE LEONARDO",
"NIZAMA CESPEDES JUAN CARLOS ANTONIO","OLAZÁBAL CHÁVEZ NEILL ELVERTH","PARDAVÉ ESPINOZA CHRISTIAN","PARIZACA MOZO PAUL ANTONY",
"QUILCA HUAMANI BRYAN","QUISPE ROJAS JAVIER WILBER","ROQUE SOSA OWEN HAZIEL","RUIZ MAMANI EDUARDO GERMAN","SUCASACA CHIRE EDWARD HENRY",
"TAYA YANA SAMUEL OMAR","YAVAR GUILLEN ROBERTO GUSTAVO","ZAMALLOA MOLINA SEBASTIAN AGENOR","ZHONG CALLASI LINGHAI JOAQUIN"];

function generarbody(){

    for(let i=0;i<lista.length;i++){
        let tabla = document.getElementById('inicio');
    
        let txt;
        let txtID;
        if(i==39){
            txt ="finalFila"
        }else{
            txt="fila";
        }
    
    
        if(i<9){
            txtID=`0${i+1}`;
        }else{
            txtID=i+1;
        }
    
        let texto =`<tr class ="${txt}">
                    <td id="ID" name="${i}">${txtID}</td>
                    <td><input type="hidden" class="nombres" name="${i}" id="${i}n"}" value ="${i}">${lista[i]}</td>
                    <td id="estadoAsistencia">
                        <button id="${i}" name="RAAA" value="${i}" class='btnMostrar'>Mostrar</button>
                    </td>
                    </tr>
        `
        tabla.insertAdjacentHTML('beforeend',texto);
    }
}


function asignar(){
    generarbody();
}




function graficos(falta, asistencia, nombre){
    var asis= asistencia;
    var fal= falta;
    var name = nombre;

    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
    type: 'pie',
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



function graficos_semestre(presente, falta, abandono){

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
              text: "ASISTENCIA DURANTE EL SEMESTRE"
            }
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
    type: 'pie',
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

function regresar(){
    window.open("portal.php");
    window.focus();
}

window.addEventListener("load" , asignar);