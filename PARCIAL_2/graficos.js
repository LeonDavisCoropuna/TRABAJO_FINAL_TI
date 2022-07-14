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
//captura
function captura(ubi,nombre){
    const $elementoParaConvertir = document.querySelector("#" + ubi); // <-- Aquí puedes elegir cualquier elemento del DOM
    html2pdf()
    .set({
        margin: 1,
        filename: nombre + ".pdf",
        image: {
            type: 'jpeg',
            quality: 0.98
        },
        html2canvas: {
            scale: 7, // A mayor escala, mejores gráficos, pero más peso
            letterRendering: true,
        },
        jsPDF: {
            unit: "in",
            format: "a4",
            orientation: 'portrait' // landscape o portrait
        }
    })
    .from($elementoParaConvertir)
    .save()
    .catch(err => console.log(err));
}

function graficos(falta, asistencia, nombre){
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

function graficos_semestre(presente, falta, abandono,total){

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

function regresar(){
    window.open("portal.php");
    window.focus();
}

function candown(chartID,nombre){
    
    const canvas = document.getElementById(chartID);
    const {
    jsPDF
    } = window.jspdf;
    const pdf = new jsPDF('L','mm','A4');
    pdf.text(130, 20, 'Grafico de Asistencia');
    const canvasImage = canvas.toDataURL('image/jpeg',1.0);

    pdf.addImage(canvasImage,'JPEG',100,30);
    pdf.save(nombre + ".pdf");  
}
function asignar(){
    generarbody();
    btnREGISTRO = document.getElementById("enviar");
    btnREGISTRO.addEventListener("click",formularioLinkear)
}
    
function formularioLinkear(){
   const imageLink = document.createElement('a');
   const canvas = document.getElementById("myChart2");
   imageLink.href = canvas.toDataURL('image/jpeg',1);
   let imagen = document.getElementById("linkImage");
   imagen.value = imageLink;
}  
window.addEventListener("load" , asignar);