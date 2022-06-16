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
                    <td id="ID">${txtID}</td>
                    <td><input type="hidden" class="nombres" name="nombre${i}" id="${i}n"}" value ="${lista[i]}">${lista[i]}</td>
                    <td id="estadoAsistencia">
                        <input name="estado${i}" value="P" type="radio" checked="checked">
                        <input name="estado${i}" value="F" type="radio">
                    </td>
                    </tr>
        `
        tabla.insertAdjacentHTML('beforeend',texto);
    }
}

function agregar(){
    let xhr = new XMLHttpRequest();
    let data = document.getElementById("registro");  //registro= id del formulario
    let form = new FormData(data);

    xhr.open('POST',"main.php");
    xhr.onload;
    xhr.send(form);
    alert("ASISTENCIA REGISTRADA CORRECTAMENTE");

}

function asignar(){
    generarbody();
    graficos();

    btnAgregar = document.getElementById("enviar");
    btnAgregar.addEventListener("click" , agregar);

}

function graficos(falta, asistencia){
    
const ctx = document.getElementById('myChart').getContext('2d');
const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['FALTAS', 'ASISTENCIAS'],
        datasets: [{
            label: 'ESTUDIANTE 1',
            data: [74,23],
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
}


window.addEventListener("load" , asignar);