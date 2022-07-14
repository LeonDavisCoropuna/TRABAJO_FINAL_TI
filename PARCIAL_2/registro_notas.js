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
    parcial = document.getElementById("parciales").value;
    for(let i=0;i<lista.length;i++){
        let tabla = document.getElementById('contenedor');
    
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
                    <td id="ID">${txtID}</td>
                    <td><input type="hidden" class="nombres" name="nombre${i}" id="${i}n"}" value ="${lista[i]}">${lista[i]}</td>
                    <td><input type="number" name="continua${i}" min='1' max='20' pattern='^[0-9]+'></td>
                    <td><input type="number" name="examen${i}" min='1' max='20' pattern='^[0-9]+'></td>
        `
        tabla.insertAdjacentHTML('beforeend',texto);
    }
}

function agregar(){
    let xhr = new XMLHttpRequest();
    let data = document.getElementById("notas");  //registro= id del formulario
    let form = new FormData(data);

    xhr.open('POST',"main2.php");
    xhr.onload;
    xhr.send(form);
    alert("NOTAS REGISTRADAS CORRECTAMENTE");
}

function regresar(){
    window.close();
    window.open("portal.php");
    window.focus();
}

function formularioLinkear(){
    const imageLink = document.createElement('a');
   const canvas = document.getElementById("myChart");
   imageLink.href = canvas.toDataURL('image/jpeg',1);
   let imagen = document.getElementById("linkImage");
   imagen.value = imageLink;
}   
 

function asignar(){
 
    btnRegistrar = document.getElementById("registrar");
    btnRegistrar.addEventListener("click" , agregar);
    btnEnviar = document.getElementById("formulario3");
    btnEnviar.addEventListener("click",formularioLinkear);

}
function mostrarGrafico(apContinua, apExamen, dsContinua, dsExamen, parcial){
    var ctx = document.getElementById('myChart').getContext('2d');
    let canvas=document.getElementById('myChart');
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

window.addEventListener("load" , asignar);