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
        $fecha = "tu-vieja3"; //agregar columnas
        return $fecha;
    }

    function crear_tabla($datos){
        $sql = "CREATE TABLE $this->tablename(
            N INT(5) NOT NULL AUTO_INCREMENT,
            NOMBRE VARCHAR(100),
            PRIMARY KEY (N)
        )";

        $this->new_mysql->query($sql);

        for($j=1;$j<41;$j++){
            $orden = $j;
            $name = $datos["nombre".($j-1)];
            $estado = $datos["estado".($j-1)];
            $consulta = "INSERT INTO `$this->tablename`(N,NOMBRE) VALUES ('$orden','$name')";
            mysqli_query($this->conexion,$consulta);
        }
    }
    
    function insertar_columna($datos){
        $dia = $this->getday();

        $this->new_mysql->query("alter table $this->tablename add(`$dia` VARCHAR(10) NOT NULL)");

        for($j=1;$j<41;$j++){
            $estado = $datos["estado".($j-1)];
            $queryUpdate = "UPDATE $this->tablename SET `$dia`='$estado' WHERE N='".$j."'";
            mysqli_query($this->conexion,$queryUpdate);
        }   
    }
}

?>