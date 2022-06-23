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
                        <input name="estado${i}" value="Mostrar" type="submit">
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
                display : false
            },
            title: {
              display: true,
              text: name
            }
        }
    }
    
});
}


window.addEventListener("load" , asignar);