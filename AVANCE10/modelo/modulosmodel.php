<?php
include_once 'modelo/clasecurso.php';
include_once 'modelo/creartablas.php';
include_once 'modelo/clasenotasresaltantes.php';
    class modulosModel extends Controller{

        public function __construct(){
            parent::__construct();
            $this->db = new DataBase();
            $this->new_mysql = $this->db->new_mysql();

        }
        //FUNCIONES RELACIONADAS A LA ASISTENCIA 
        public function getCursosUsuario(){

            $resul = mysqli_query($this->db->connect(), "SELECT * FROM cursosUsuario");
            $error = mysqli_error($this->db->connect());
            $items = [];
            if(empty($error)){
    
                while($row = $resul->fetch_array()){
                    $item = new Curso();
                    $item->nameCurso = $row['curso'];
                    $item->nextCurso = $row['next'];
                    $item->creditos = $row['creditos'];
    
                    array_push($items,$item);
                }
                return $items;
            }
            else{
                echo "error al obtener cursos";
            }
            return null;
        }
        public function getAlumnos($curso){

            $curso = $curso."_Alumnos";
            $curso = strtr($curso, "-", "_");

            $resul = mysqli_query($this->db->connect(), "SELECT * FROM $curso");
            $error = mysqli_error($this->db->connect());
            $items = [];
            if(empty($error)){

                while($row = $resul->fetch_array()){
                    array_push($items,$row['NOMBRE']);
                   
                }
                return $items;
            }
            else{
                echo "error al obtener alumnos";
            }
            
        }
        

        /// Funciones encargadas de actualizar todo lo concerniente a la asistencia
        
        function actualizar_asistencia($curso, $datos){
            $dia = "";
            if(isset($datos['dia'])){
                $dia = $datos['dia'];
            } else {
                return;
            }
                $curso = strtr($curso,"-","_");
                $cursoCopia = $curso."_asistencia";
                $bool = 0;
                $dia = $datos['dia'];
        
                $result = $this->new_mysql->query("SHOW COLUMNS FROM $cursoCopia");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {                
                        if($row['Field'] == $dia){
                            $bool = 1;
                            $this->registrarNueva_Asistencia($cursoCopia,$datos);
                        }
                    }
                }
                if($bool == 0){
                    
                        $this->new_mysql->query("ALTER TABLE $cursoCopia add(`$dia` VARCHAR(10) NOT NULL)");
                        $this->registrarNueva_Asistencia($cursoCopia,$datos);
                    } 
                    $this->actualizar_record_asistencia($curso);
                }
        

        function registrarNueva_Asistencia($curso, $datos){
            $dia = $datos['dia'];
            for($j=1;$j<sizeof($datos)-1 ;$j++){
                $estado = $datos["estado".($j)];
                $queryUpdate = "UPDATE $curso SET `$dia`='$estado' WHERE N='".$j."'";
                mysqli_query($this->db->connect(),$queryUpdate);
            }   
    
        }
        function actualizar_record_asistencia($curso){
            $curso_asistencia = $curso."_asistencia";
            $curso_aux = $curso."_asistencia_record";

            $aux = 1;
            $query = "SELECT * FROM $curso_asistencia";
            $ra = mysqli_query($this->db->connect(), $query);
            
            while($row = $ra->fetch_array()){
    
                $contfalta = 0;
                $contasis = 0;
    
                for($i = 2; $i < $this->total_clases($curso)+2;$i++){
                    if($row[$i] == "F"){
                        $contfalta++;
                    }
                    else{
                        $contasis++;
                    }
                }
                $por_asistencia = round($contasis*100/$this->total_clases($curso),2);
                $por_faltas = round(100 - $por_asistencia,2);
    
                $queryUpdate1 = "UPDATE $curso_aux SET ASISTENCIAS='".$contasis."' WHERE N='".$aux."'";
                $queryUpdate2 = "UPDATE $curso_aux SET FALTAS='".$contfalta."' WHERE N='".$aux."'";
    
                if($contfalta == $this->total_clases($curso)){
                    $queryUpdate3 = "UPDATE $curso_aux SET ESTADO= 'ABANDONO' WHERE N='".$aux."'";
                }
                elseif($contfalta > 1 ){
                    $queryUpdate3 = "UPDATE $curso_aux SET ESTADO= 'FALTA' WHERE N='".$aux."'";
                }
                else{
                    $queryUpdate3 = "UPDATE $curso_aux SET ESTADO= 'PRESENTE' WHERE N='".$aux."'";
                }
    
                $queryUpdate4 = "UPDATE $curso_aux SET POR_ASISTENCIAS= '".$por_asistencia."' WHERE N='".$aux."'";
                $queryUpdate5 = "UPDATE $curso_aux SET POR_FALTAS= '".$por_faltas."' WHERE N='".$aux."'";
    
                
                mysqli_query($this->db->connect(),$queryUpdate1);
                mysqli_query($this->db->connect(),$queryUpdate2);
                mysqli_query($this->db->connect(),$queryUpdate3);
                mysqli_query($this->db->connect(),$queryUpdate4);
                mysqli_query($this->db->connect(),$queryUpdate5);
    
                $aux++;
            }
        }

        function total_clases($curso){
            $cursoCopia = strtr($curso,"-","_")."_asistencia";
            
            $contador=0;
            $result = $this->new_mysql->query("SHOW COLUMNS FROM $cursoCopia");
            if ($result->num_rows > 0){
                while ($row = $result->fetch_assoc()) {                
                   $contador++;
                }
                return $contador-2;
            }
            
            return $contador;
        }
        // FIN



        /// FUNCIONES ENCARGAR DE ACTUALIZAR TODO LO RELACIONADO CON LAS NOTAS

        function insertar_notas($curso,$datos){
            $aux = 1;
            $cursoNotas = strtr($curso,"-","_")."_notas";
            $cursoPesos = strtr($curso,"-","_")."_pesos";
            $notasEstado = strtr($curso,"-","_")."_notas_estado";
            
            $resul = mysqli_query($this->db->connect(), "SELECT * FROM $cursoNotas");
            
            
            $continua = "CONTINUA".$datos['parciales'];
            $examen = "EXAMEN".$datos['parciales'];
            $mayorC = $datos["continua".($aux-1)];
            $auxAlumnoCM = $aux;
            $auxAlumnoEM = $aux;
    
            $menorC = $datos["continua".($aux-1)];
            $auxAlumnoCMenor = $aux;
            $auxAlumnoEMenor = $aux;
            $mayorE = $datos["examen".($aux-1)];
            $menorE = $datos["examen".($aux-1)];
            
            while($row = $resul->fetch_array()){

                $pesosArray = mysqli_query($this->db->connect(), "SELECT * FROM $cursoPesos");

                $notacontinua = $datos["continua".($aux-1)];
                $notaexamen = $datos["examen".($aux-1)];
                $contador=1;

                $notaC1;
                $notaC2;
                $notaC3;
                $notaE1;
                $notaE2;
                $notaE3;
                while($row2= $pesosArray->fetch_array()){
                    if($contador==1){
                        $notaC1= $row['CONTINUA1'] * ($row2['PARCIAL_1'] / 100);
                        $notaC2= $row['CONTINUA2'] * ($row2['PARCIAL_2'] / 100);
                        $notaC3= $row['CONTINUA3'] * ($row2['PARCIAL_3'] /100);
                    }else{
                        $notaE1 = $row['EXAMEN1'] * ($row2['PARCIAL_1'] / 100);
                        $notaE2 = $row['EXAMEN2'] * ($row2['PARCIAL_2'] / 100); 
                        $notaE3 = $row['EXAMEN3'] * ($row2['PARCIAL_3'] / 100);
                    }
                    $contador++;
                }
                    
                $notaFINAL = $notaC1 + $notaC2 + $notaC3 + $notaE1 + $notaE2 + $notaE3;
                if($mayorC < $notacontinua){
                    $mayorC = $notacontinua;
                    $auxAlumnoCM = $aux;
                }
                if($menorC > $notacontinua){
                    $menorC = $notacontinua;
                    $auxAlumnoCMenor = $aux;
                }
                if($menorE > $notaexamen){
                    $menorE = $notaexamen;
                    $auxAlumnoEMenor = $aux;
                }
                if($mayorE < $notaexamen){
                    $mayorE = $notaexamen;
                    $auxAlumnoEM = $aux;
                }
                if($notacontinua > 20 ){$notacontinua = NULL;}
                if($notacontinua < 0 ){$notacontinua = NULL;}   
                if($notaexamen > 20){$notaexamen = NULL;}
                if($notaexamen < 0){$notaexamen = NULL;}
    
                $queryUpdate1 = "UPDATE $cursoNotas SET $continua='".$notacontinua."' WHERE N='".$aux."'";
                $queryUpdate2 = "UPDATE $cursoNotas SET $examen='".$notaexamen."' WHERE N='".$aux."'";
                $queryUpdate7 = "UPDATE $cursoNotas SET NOTAFINAL='".$notaFINAL."' WHERE N='".$aux."'";
                mysqli_query($this->db->connect(),$queryUpdate1);
                mysqli_query($this->db->connect(),$queryUpdate2);
                mysqli_query($this->db->connect(),$queryUpdate7);
                $aux++;
            }

         
            $queryUpdate3 = "UPDATE $notasEstado SET MAYOR_CONTINUA='".$auxAlumnoCM."' WHERE N='".$datos['parciales']."'";
            $queryUpdate4 = "UPDATE $notasEstado SET MAYOR_EXAMEN='".$auxAlumnoEM."' WHERE N='".$datos['parciales']."'";
            $queryUpdate5 = "UPDATE $notasEstado SET MENOR_CONTINUA='".$auxAlumnoCMenor."' WHERE N='".$datos['parciales']."'";
            $queryUpdate6 = "UPDATE $notasEstado SET MENOR_EXAMEN='".$auxAlumnoEMenor."' WHERE N='".$datos['parciales']."'";
            
            mysqli_query($this->db->connect(),$queryUpdate3);
            mysqli_query($this->db->connect(),$queryUpdate4);
            mysqli_query($this->db->connect(),$queryUpdate5);
            mysqli_query($this->db->connect(),$queryUpdate6);        
        }
    
        
        function getNotas($curso){
            $cursoNotas = strtr($curso,"-","_")."_notas";
            $resul = mysqli_query($this->db->connect(), "SELECT * FROM $cursoNotas");
            $error = mysqli_error($this->db->connect());
            if(empty($error)){
                if(mysqli_num_rows($resul) > 0){
                    return $resul;
                }
            }
            else{
                echo "error al obtener Notas";
            }
            return null;
        }
        function getNotasEstado($curso){
            $cursoNotas = strtr($curso,"-","_")."_notas_estado";
            $resul = mysqli_query($this->db->connect(), "SELECT * FROM $cursoNotas");
            $error = mysqli_error($this->db->connect());
            if(empty($error)){
                if(mysqli_num_rows($resul) > 0){
                    return $resul;
                }
            }
            else{
                echo "error al obtener Notas";
            }
            return null;
        }

        function notasResaltantes($curso, $parcial){
            
            $continua="CONTINUA".$parcial;
            $examen="EXAMEN".$parcial;

            $cursoNotas = strtr($curso,"-","_")."_notas_estado";
            $notas_Estado = mysqli_query($this->db->connect(), "SELECT * FROM $cursoNotas");
            $items = [];
            $contador = 1;
            while ($fila = $notas_Estado->fetch_array()){
                $notas = $this->getNotas($curso);
                if($contador==$parcial){
                    while($row = $notas->fetch_array()){
                        $item = new NotasResaltantes();

                        if($fila['MAYOR_CONTINUA']==$row['N']){
                         
                            $item->nombre = $row['NOMBRE'];

                            $item->nota = $row[$continua];
                            array_push($items,$item);
                        }
                        if($fila['MENOR_CONTINUA']==$row['N']){
                         
                            $item->nombre = $row['NOMBRE'];
                            $item->nota = $row[$continua];
                            array_push($items,$item);

                        }
                        if($fila['MAYOR_EXAMEN']==$row['N']){
                         
                            $item->nombre = $row['NOMBRE'];
                            $item->nota = $row[$examen];
                            array_push($items,$item);

                        }
                        if($fila['MENOR_EXAMEN']==$row['N']){
                         
                            $item->nombre = $row['NOMBRE'];
                            $item->nota = $row[$examen];
                            array_push($items,$item);
                        }
                    }
                }
                $contador++;
            }
         
            return $items;
        }


        ## Modulo estudiantes en peligro

        function getEstudiantesPeligro($curso){
            $pesos_query = strtr($curso,"-","_")."_pesos";

            $pesos_tabla = mysqli_query($this->db->connect(), "SELECT * FROM $pesos_query");
            $items = [];
            while ($row = $pesos_tabla->fetch_array()){
                array_push($items, $row["PARCIAL_1"]);
                array_push($items, $row["PARCIAL_2"]);
            }

            $pesoC1 = $items[0];
            $pesoC2 = $items[1];
            $pesoE1 = $items[2];
            $pesoE2 = $items[3];
            
            $table_inicial = "<table>
            <thead>
                <tr>
                    <th colspan='7'>Estudiantes en peligro de jalar el curso</th>
                </tr>
                <tr>
                    <th  rowspan='2'>Nombre y Apellidos</th>
                    <th class='detalles' colspan='4'>Nota</th>
                    <th class='detalles' rowspan='2'>Nota Promedio</th>
                    <th class='detalles' rowspan='2'>Minima Nota para aprobar</th>
                </tr>
               
                <tr>
                    <th class='detalles2' >Continua 1 (".$pesoC1."%)</th>
                    <th class='detalles2' >Examen 1 (".$pesoC2."%)</th>
                    <th class='detalles2' >Continua 2 (".$pesoE1."%)</th>
                    <th class='detalles2' >Examen 2 (".$pesoE2."%)</th>
                </tr>
            </thead>
            <tbody>";
                
            $estudiantes = $this->getnotas(strtr($curso,"-", "_"));
            $continua=0;
            $examen=0;
            $i=0;
            $aux;

            $tbody_table ="";
            if(!is_null($this->getnotas($curso))){

            while ($row = $estudiantes->fetch_array()){ 
                $continua=$row['CONTINUA1']*0.1 + $row['CONTINUA2']*0.1;
                $examen=$row['EXAMEN1']*0.1 + $row['EXAMEN2']*0.1;
                $aux = round(((11-($continua+$examen))/0.6),1);
                $aux2 = "normal";
                if($aux > 12){$aux2 = "peligro";}
                if($aux > 12){
                    $tbody_table.="<tr>";
                    $tbody_table.="<td class='".$aux2."'>".$row['NOMBRE']."</td>";
                    $tbody_table.="<td class='".$aux2."'>".$row['CONTINUA1']."</td>";
                    $tbody_table.="<td class='".$aux2."'>".$row['EXAMEN1']."</td>";
                    $tbody_table.="<td class='".$aux2."'>".$row['CONTINUA2']."</td>";
                    $tbody_table.="<td class='".$aux2."'>".$row['EXAMEN2']."</td>";
                    $tbody_table.="<td class='".$aux2."'>".$continua+$examen."</td>";
                    $tbody_table.="<td class='".$aux2."'>".$aux."</td>";
                    $tbody_table.="</tr>";
                }
            }}
                        
            $tbody_table."</table>";                
            $table_inicial.=$tbody_table;

            return $table_inicial;

        }
    
        function obtener_aprobados_graficos($curso,$parcial){

            $items = [];
            $estudiantes = $this->getnotas(strtr($curso,"-", "_"));

            $i=0;   
            $aprobadosContinua=0;
            $aprobadosExamen=0;
            $desaprobadosContinua=0;
            $desaprobadosExamen=0;
            if(!is_null($estudiantes)){
                $i=0;
                while($row = mysqli_fetch_assoc($estudiantes)){
                    if($row['CONTINUA'.$parcial]>10){
                        $aprobadosContinua++;
                    }
                    if($row['EXAMEN'.$parcial]>10){
                        $aprobadosExamen++;
                    }
                    $i++;
                }
            }
            $desaprobadosContinua=$i-$aprobadosContinua;
            $desaprobadosExamen= $i-$aprobadosExamen;

            array_push($items,$aprobadosContinua);
            array_push($items,$aprobadosExamen);
            array_push($items,$desaprobadosContinua);
            array_push($items,$desaprobadosExamen);

            return $items;
        }

        function generar_tabla_usuarios($curso){
            $alumnos = $this->getAlumnos(strtr($curso[0],"-", "_"));
        
            $tabla_inicializar ="
                <table id='tablaUsuarios'>
                    <thead>
                    <tr>
                        <th rowspan='2'>N°</th>
                        <th rowspan='2'>NOMBRES Y APELLIDOS</th>
                        <th id='estadosPTF'>ASISTENCIA</th>
                    </tr>
                    <tr class='estados21'>
                        <th id='estadosPTF2'>
                            <div>P</div> 
                            <div>F</div>
                        </th>
                    </tr> 
                    </thead>
                    <tbody id='tbody'>";
                            $i=0;
                            foreach ($alumnos as $row){
                                $tabla_inicializar.="<tr>";
                                $tabla_inicializar.="<td>".($i+1)."</td>";
                                $tabla_inicializar.="<td>".$row."</td>";
                                $tabla_inicializar.="<td id='estadoAsistencia'>";
                                    $tabla_inicializar.="<input name='estado".$i."' value='P' type='radio' checked='checked'>";
                                    $tabla_inicializar.="<input name='estado".$i."' value='F' type='radio'>";
                                $tabla_inicializar.="</td>"; 
                                $tabla_inicializar.="</tr>";
                                $i++;
                            }   
                    $tabla_inicializar.="</tbody></table>";
                return $tabla_inicializar;
        }

        function generar_asistencia_grafico ($curso){

            $alumnos = $this->getAlumnos(strtr($curso[0],"-", "_"));
            $tabla_inicializar ="
                <table id='tablaUsuarios'>
                    <thead>
                        <tr>
                            <th> N°</th>
                            <th >NOMBRES Y APELLIDOS</th>
                            <th>GRAFICO</th>
                        </tr>
                    </thead>
                    <tbody id='tbody'>";
                            $i=0;
                            foreach ($alumnos as $row){
                                $tabla_inicializar.="<tr>";
                                $tabla_inicializar.="<td>".($i+1)."</td>";
                                $tabla_inicializar.="<td>".$row."</td>";
                                $tabla_inicializar.="<td><button name='btnGrafico' value='".($i)."' class='btnMostrar'>Mostrar</button></td>";
                                $tabla_inicializar.="</tr>";
                                $i++;
                            }   
                    $tabla_inicializar.="</tbody></table>";
                return $tabla_inicializar;
        }
        function get_record_asistencia($curso){      

            $asistencia = strtr($curso,"-","_")."_asistencia_record";
            $resul = mysqli_query($this->db->connect(), "SELECT * FROM $asistencia");
            $error = mysqli_error($this->db->connect());
            if(empty($error)){
                if(mysqli_num_rows($resul) > 0){
                    return $resul;
                }
            }
            else{
                echo "error al obtener Notas";
            }
            return null;
        }
        

        function asistencia_dia($curso,$dia){
            /*
            $items = [];
            $asistencia = strtr($curso,"-","_")."_asistencia";

            $contpre=0;
            $i = 0;
            $query = "SELECT * FROM $asistencia";
            $ra = mysqli_query($this->conexion, $query);
        
            while($row = $ra->fetch_array()){
                if($row[$dia] == "P"){
                    $contpre++;
                    $i++;
                }
            }  
            array_push($items,$contpre);
            array_push($items,$i - $contpre);
            array_push($items, $this->total_clases($curso));
            return $items;
            */
        }

        function getName_Days($curso){
            $items = [];
            $tabla_dias = strtr($curso,"-","_")."_asistencia";
           // $query = "SELECT * FROM $tabla_dias";

            $result = $this->new_mysql->query("SHOW COLUMNS FROM $tabla_dias");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {                
                    array_push($items,$row['Field']);
                }
            }
            
            return $items;            
        }

        function get_asistentes_dia($curso,$fecha){
            $items = [];
            $tabla_dias = strtr($curso,"-","_")."_asistencia";
            $presentes =0;
            $i=0;
            $result = mysqli_query($this->db->connect(), "SELECT * FROM $tabla_dias");
            
            foreach($result as $row){
                if ($row[$fecha] == "P")
                    $presentes++;
                
                $i++;
            }
            array_push($items, $presentes);
            array_push($items, $i-$presentes);
            array_push($items, $fecha);

            var_dump($items);

            return $items;
        }
    }

    
?>