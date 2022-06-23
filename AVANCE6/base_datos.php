<?php 

class base_datos{
    private $tablename;
    private $host;
    private $user;
    private $password;
    private $dbname;

    private $conexion;
    private $new_mysql;

    function __construct($host, $user , $password , $dbname , $tablename){
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->tablename = $tablename;
    }

    function conectar(){
        $this->conexion = mysqli_connect($this->host, $this->user,$this->password,$this->dbname);
        $this->conexion->set_charset("utf8");

        $this->new_mysql = new mysqli($this->host, $this->user,$this->password,$this->dbname);
    }

    function obtenerTablasDeUnaBaseDeDatos(){
        try{
            $base_de_datos = new PDO("mysql:host=$this->host;dbname=$this->dbname",$this->user, $this->password);
        } catch (Exception $e) {
            echo "Ocurrió algo con la base de datos: " . $e->getMessage();
        }
        return $base_de_datos
            ->query("SELECT table_name AS nombre FROM information_schema.tables WHERE table_schema = '$this->dbname';")
            ->fetchAll(PDO::FETCH_COLUMN);
    }

    function getday(){
        $Object = new DateTime();  
        $diaActual = $Object->format("d-m-Y h:i:s a");
        $fecha="";
        // fecha actual
        for($i=0;$i<5;$i++){
            $fecha=$fecha.$diaActual[$i];
        }
        $fecha = "gato7"; //agregar columnas
        return $fecha;
    }

    function crear_tabla($datos){
        $sql = "CREATE TABLE $this->tablename(
            N INT(5) NOT NULL AUTO_INCREMENT,
            NOMBRE VARCHAR(100),
            PRIMARY KEY (N)
        )";

        $sql2 = "CREATE TABLE record_asistencia(
            N INT(5) NOT NULL AUTO_INCREMENT,
            NOMBRE VARCHAR(100),
            ASISTENCIAS INT(3) NOT NULL,
            FALTAS INT(3) NOT NULL, 
            POR_ASISTENCIAS FLOAT(4) NOT NULL, 
            POR_FALTAS FLOAT(4) NOT NULL, 
            ESTADO VARCHAR(20) NOT NULL,
            PRIMARY KEY (N)
        )";

        $this->new_mysql->query($sql);
        $this->new_mysql->query($sql2);



        for($j=1;$j<41;$j++){
            $orden = $j;
            $name = $datos["nombre".($j-1)];
            $estado = $datos["estado".($j-1)];
            $consulta1 = "INSERT INTO `$this->tablename`(N,NOMBRE) VALUES ('$orden','$name')";
            $consulta2 = "INSERT INTO `record_asistencia`(N,NOMBRE) VALUES ('$orden','$name')";

            mysqli_query($this->conexion,$consulta1);
            mysqli_query($this->conexion,$consulta2);
        }
        $this->crear_notas($datos);
    }

    function record_asistencia($datos){

    }

    function insertar_estados($datos){
        $dia = $this->getday();

        for($j=1;$j<41;$j++){
            $estado = $datos["estado".($j-1)];
            $queryUpdate = "UPDATE $this->tablename SET `$dia`='$estado' WHERE N='".$j."'";
            mysqli_query($this->conexion,$queryUpdate);
        }   

    }
    
    function insertar_columna($datos){

        $bool = 0;
        $dia = $this->getday();

        $result = $this->new_mysql->query("SHOW COLUMNS FROM $this->tablename");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {                
                if($row['Field'] == $dia){
                    $bool = 1;
                    $this->insertar_estados($datos);
                }
            }
        }
        if($bool == 0){
            $this->new_mysql->query("alter table $this->tablename add(`$dia` VARCHAR(10) NOT NULL)");
            $this->insertar_estados($datos);
        }

        $this->alumnos_presentes();
    }

    function crear_notas($datos){
        $sql2 = "CREATE TABLE registro_notas(
            N INT(5) NOT NULL AUTO_INCREMENT,
            NOMBRE VARCHAR(100),
            CONTINUA1 FLOAT(3) NOT NULL,
            EXAMEN1 FLOAT(3) NOT NULL,
            CONTINUA2 FLOAT(3) NOT NULL,
            EXAMEN2 FLOAT(3) NOT NULL,
            CONTINUA3 FLOAT(3) NOT NULL,
            EXAMEN3 FLOAT(3) NOT NULL,
            PRIMARY KEY (N)
        )";

        $this->new_mysql->query($sql2);

        for($j=1;$j<41;$j++){
            $orden = $j;
            $name = $datos["nombre".($j-1)];
            $estado = $datos["estado".($j-1)];
            $consulta1 = "INSERT INTO `registro_notas`(N,NOMBRE) VALUES ('$orden','$name')";

            mysqli_query($this->conexion,$consulta1);

        }

    }

    function total_clases(){
        $contador=0;
        $result = $this->new_mysql->query("SHOW COLUMNS FROM $this->tablename");
        if ($result->num_rows > 0){
            while ($row = $result->fetch_assoc()) {                
               $contador++;
            }
            return $contador-2;
        }
        
        return $contador;
    }
    function alumnos_presentes(){
        $aux = 1;
        $query = "SELECT * FROM $this->tablename";
        $ra = mysqli_query($this->conexion, $query);
        while($row = $ra->fetch_array()){

            $contfalta = 0;
            $contasis = 0;

            for($i = 2; $i < $this->total_clases()+2;$i++){
                if($row[$i] == "F"){
                    $contfalta++;
                }
                else{
                    $contasis++;
                }
            }
            $por_asistencia = round($contasis*100/$this->total_clases(),2);
            $por_faltas = round(100 - $por_asistencia,2);

            $queryUpdate1 = "UPDATE record_asistencia SET ASISTENCIAS='".$contasis."' WHERE N='".$aux."'";
            $queryUpdate2 = "UPDATE record_asistencia SET FALTAS='".$contfalta."' WHERE N='".$aux."'";

            if($contfalta == $this->total_clases()){
                $queryUpdate3 = "UPDATE record_asistencia SET ESTADO= 'ABANDONO' WHERE N='".$aux."'";
            }
            elseif($contfalta > 1 ){
                $queryUpdate3 = "UPDATE record_asistencia SET ESTADO= 'FALTA' WHERE N='".$aux."'";
            }
            else{
                $queryUpdate3 = "UPDATE record_asistencia SET ESTADO= 'PRESENTE' WHERE N='".$aux."'";
            }

            $queryUpdate4 = "UPDATE record_asistencia SET POR_ASISTENCIAS= '".$por_asistencia."' WHERE N='".$aux."'";
            $queryUpdate5 = "UPDATE record_asistencia SET POR_FALTAS= '".$por_faltas."' WHERE N='".$aux."'";

            
            mysqli_query($this->conexion,$queryUpdate1);
            mysqli_query($this->conexion,$queryUpdate2);
            mysqli_query($this->conexion,$queryUpdate3);
            mysqli_query($this->conexion,$queryUpdate4);
            mysqli_query($this->conexion,$queryUpdate5);

            $aux++;
        }
    }
    function insertar_notas($datos){
        $aux = 1;
        $query = "SELECT * FROM registro_notas";
        $ra = mysqli_query($this->conexion, $query);
        
        $continua = "CONTINUA".$datos["parciales"];
        $examen = "EXAMEN".$datos["parciales"];

        while($row = $ra->fetch_array()){
            $notacontinua = $datos["continua".($aux-1)];
            $notaexamen = $datos["examen".($aux-1)];


            $queryUpdate1 = "UPDATE registro_notas SET $continua='".$notacontinua."' WHERE N='".$aux."'";
            $queryUpdate2 = "UPDATE registro_notas SET $examen='".$notaexamen."' WHERE N='".$aux."'";
            
            mysqli_query($this->conexion,$queryUpdate1);
            mysqli_query($this->conexion,$queryUpdate2);

            $aux++;
        }
    }

    function getNotas(){
        $resul = mysqli_query($this->conexion, "SELECT * FROM registro_notas");
        $error = mysqli_error($this->conexion);
        if(empty($error)){
            if(mysqli_num_rows($resul) > 0){
                return $resul;
            }
        }
        else{
            echo "error al obtener clientes";
        }
        return null;
    }

    function obtener_aprobados(){
        $contador=0;
        $result = $this->new_mysql->query("SHOW COLUMNS FROM record_asistencia");
        if ($result->num_rows > 0){
            while ($row = $result->fetch_assoc()) {                
               $contador++;
            }
            return $contador-2;
        }
        
        return $contador;
    }
    function obtnerAsitenciaAlumno(){
        $resul = mysqli_query($this->conexion, "SELECT * FROM record_asistencia");
        $error = mysqli_error($this->conexion);
        if(empty($error)){
            if(mysqli_num_rows($resul) > 0){
                return $resul;
            }
        }
        else{
            echo "error al obtener asistencias";
        }
        return null;   
    }

    function asistencia_dia($dia){
        /*
        $resul = mysqli_query($this->conexion, "SHOW COLUMNS FROM $this->tablename");
        $resul2 = mysqli_query($this->conexion, "SELECT * FROM $this->tablename");
        $error = mysqli_error($this->conexion);
        */
        $contpre=0;
        $query = "SELECT * FROM $this->tablename";
        $ra = mysqli_query($this->conexion, $query);
        $gato = "gato".$dia;
        while($row = $ra->fetch_array()){
            if($row[$gato] == "P"){
                $contpre++;
            }
        }  
        
        return $contpre;
    }

}
?>