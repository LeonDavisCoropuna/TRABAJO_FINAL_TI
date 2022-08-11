<?php
    
    include_once 'modelo/clasecurso.php';
    include_once 'modelo/creartablas.php';
    include_once 'modelo/clasepesos.php';
    
class cursosModel extends Model{
    public function __construct(){
        parent::__construct();
    }
    public function get_table_all_cursos(){
        $all_cursos = mysqli_query($this->db->connect(), "SELECT * FROM all_cursos_carrera");
        $tabla_inicial = "<table>
                                <thead>
                                    <tr>
                                        <th>N</th>
                                        <th>Cursos</th>
                                        <th>Selleccionar</th>
                                    </tr>
                                </thead>
                                <tbody>";
        
        while($row = $all_cursos->fetch_array()){
            $tabla_inicial.= "<tr>";
            $tabla_inicial.= "<td>".$row['N']."</td>";
            $tabla_inicial.= "<td>".$row['curso']."</td>";
            $tabla_inicial.= "<td><input type='checkbox' name='cursos_list[]' value='".$row['curso']."'></td>";
            $tabla_inicial.= "</tr>";
        }

        $tabla_inicial.="</tbody></table>";
        return $tabla_inicial;
    }
    public function insertUserCurso($curso){
        try{
            $conn = $this->db->connect();   
                        
            foreach($curso as $selected){
                $sql =  "INSERT INTO cursosusuario (curso) VALUES ('".$selected."')";
                mysqli_query($conn,$sql);

                $curso = strtr($selected, " ", "_");
    
                $asistencia = $curso."_Asistencia_Record";
                $asistencia_record = $curso."_Asistencia";
                $notas = $curso."_Notas";
                $notas_estado = $curso."_Notas_Estado";           
                $alumnos = $curso."_Alumnos";           
                $pesos = $curso."_Pesos";      
                     
    
                $crear_tabla = new CreateTable($this->db->new_mysql());
                $crear_tabla->crearTables($asistencia,$asistencia_record,$notas,$notas_estado,$alumnos,$pesos);
            }


            /*$curso = strtr($curso, " ", "_");

            $asistencia = $curso."_Asistencia_Record";
            $asistencia_record = $curso."_Asistencia";
            $notas = $curso."_Notas";
            $notas_estado = $curso."_Notas_Estado";           
            $alumnos = $curso."_Alumnos";           
            $pesos = $curso."_Pesos";      
                 

            $crear_tabla = new CreateTable($this->db->new_mysql());
            $crear_tabla->crearTables($asistencia,$asistencia_record,$notas,$notas_estado,$alumnos,$pesos);*/

            return true;
        } catch (PDOException $e){
            echo "Error al insertar curso";
            return false;
        }
    }

    public function matricularAlumno($curso,$nombre){
        try{
            $cursoAlumno = $curso."_Alumnos";
            $cursoAsistencia = $curso."_asistencia";
            $cursoAstenciaRecord = $curso."_asistencia_record";
            $cursoNotas = $curso."_notas";
            $conn = $this->db->connect();   
            $sql =  "INSERT INTO $cursoAlumno (NOMBRE) VALUES ('".$nombre."')";
            $sql2 =  "INSERT INTO $cursoAsistencia (NOMBRE) VALUES ('".$nombre."')";
            $sql3 =  "INSERT INTO $cursoAstenciaRecord (NOMBRE) VALUES ('".$nombre."')";
            $sql4 =  "INSERT INTO $cursoNotas (NOMBRE) VALUES ('".$nombre."')";

            mysqli_query($conn,$sql);
            mysqli_query($conn,$sql2);
            mysqli_query($conn,$sql3);
            mysqli_query($conn,$sql4);

            return true;
        } catch (PDOException $e){
            echo "Error al insertar curso";
            return false;
        }
    }
    
    public function insertPesos($curso,$c1,$c2,$c3,$e1,$e2,$e3){
        $curso = $curso."_Pesos";
        
        try{
            $conn = $this->db->connect();   
            $sql =  "UPDATE $curso SET PARCIAL_1 = '".$c1."' , PARCIAL_2 = '".$c2."' , PARCIAL_3 = '".$c3."' WHERE N='1'";
            $sql2 =  "UPDATE $curso SET PARCIAL_1 = '".$e1."' , PARCIAL_2 = '".$e2."' , PARCIAL_3 = '".$e3."' WHERE N='2'";

            mysqli_query($conn,$sql);
            mysqli_query($conn,$sql2);
            return true;
            echo "Registro de pesos EXITOSO";

        } catch (PDOException $e){
            echo "Error al insertar pesos";
            return false;
        }
    }
    
    public function  deleteCurso($cursosName){
        //$sqlAction = mysqli_query($this->db->connect()->prepare("DELETE FROM cursosUsuario WHERE CustomerName='".$cursosName."'");

    }

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

        return null;
        
    }

    public function getPesosCurso($curso){
        $curso = $curso."_Pesos";
        $resul = mysqli_query($this->db->connect(), "SELECT * FROM $curso");
        $error = mysqli_error($this->db->connect());
        $items = [];
        $i=1;
        if(empty($error)){
            while($row = $resul->fetch_array()){
                $item = new Pesos();
                if($i==1){
                    $item->continua1 = $row['PARCIAL_1'];
                    $item->continua2 = $row['PARCIAL_2'];
                    $item->continua3 = $row['PARCIAL_3'];
                }
                if($i>1){
                    $item->examen1 = $row['PARCIAL_1'];
                    $item->examen2 = $row['PARCIAL_2'];
                    $item->examen3 = $row['PARCIAL_3'];
                }
                $i++;
                array_push($items,$item);
            }
            return $items;
        }
        else{
            echo "error al obtener cursos";
        }
        return null;
    }
}

?>