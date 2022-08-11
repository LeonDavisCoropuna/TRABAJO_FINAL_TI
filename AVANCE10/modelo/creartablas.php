<?php
    class CreateTable extends Model {
  
        private $new_mysql;
        public function __construct($new_mysql){
            parent::__construct();
            $this->new_mysql = $new_mysql;
        }

    
        public function crearTables($tablaA,$tablaB,$tablaC,$tablaD,$tablaE,$tablaF){

            $this->record_asistencia($tablaA);
            $this->asistencia_tabla($tablaB);
            $this->notasTabla($tablaC);
            $this->notas_Estado($tablaD);
            $this->alumnosTabla($tablaE);
            $this->pesosTabla($tablaF); 
        } 
        public function record_asistencia($nameTable){
            $sql = "CREATE TABLE IF NOT EXISTS $nameTable(N INT(5) NOT NULL AUTO_INCREMENT,
            NOMBRE VARCHAR(100),
            ASISTENCIAS INT(3) NOT NULL,
            FALTAS INT(3) NOT NULL, 
            POR_ASISTENCIAS FLOAT(4) NOT NULL, 
            POR_FALTAS FLOAT(4) NOT NULL, 
            ESTADO VARCHAR(20) NOT NULL,
            PRIMARY KEY (N))";

            $this->new_mysql->query($sql);
        }

        public function asistencia_tabla($nameTable){
            $sql = "CREATE TABLE IF NOT EXISTS $nameTable( N INT(5) NOT NULL AUTO_INCREMENT,
                                             NOMBRE VARCHAR(100),
                                             PRIMARY KEY (N))";

            $this->new_mysql->query($sql);
        }
        public function alumnosTabla($nameTable){
            $sql = "CREATE TABLE IF NOT EXISTS $nameTable( N INT(5) NOT NULL AUTO_INCREMENT,
            NOMBRE VARCHAR (100),
            PRIMARY KEY (N))
            ";
            $this->new_mysql->query($sql);
        }
        public function pesosTabla($nameTable){
            $sql = "CREATE TABLE IF NOT EXISTS $nameTable( N INT(5) NOT NULL AUTO_INCREMENT,
            PARCIAL_1 INT (5),
            PARCIAL_2 INT (5),
            PARCIAL_3 INT (5),
            PRIMARY KEY (N))";
            $this->new_mysql->query($sql);


            $conn = $this->db->connect();   
            $sql2 = "INSERT INTO $nameTable (PARCIAL_1,PARCIAL_2,PARCIAL_3) VALUES ('0','0','0') ";
            $sql3 = "INSERT INTO $nameTable  (PARCIAL_1,PARCIAL_2,PARCIAL_3) VALUES ('0','0','0')";

            mysqli_query($conn,$sql2);
            mysqli_query($conn,$sql3);
        }
        
        
        public function notasTabla($nameTable){
            $sql = "CREATE TABLE IF NOT EXISTS $nameTable( N INT(5) NOT NULL AUTO_INCREMENT,
            NOMBRE VARCHAR(100),
            CONTINUA1 FLOAT(3) NOT NULL,
            EXAMEN1 FLOAT(3) NOT NULL,
            CONTINUA2 FLOAT(3) NOT NULL,
            EXAMEN2 FLOAT(3) NOT NULL,
            CONTINUA3 FLOAT(3) NOT NULL,
            EXAMEN3 FLOAT(3) NOT NULL,
            NOTAFINAL FLOAT(3) NOT NULL,
            PRIMARY KEY (N))";

            $this->new_mysql->query($sql);
        }
        public function notas_Estado($nameTable){
            $sql = "CREATE TABLE IF NOT EXISTS $nameTable(N INT(5) NOT NULL AUTO_INCREMENT,
            MAYOR_CONTINUA INT(3) NOT NULL,
            MENOR_CONTINUA INT(3) NOT NULL,
            MAYOR_EXAMEN INT(3) NOT NULL,
            MENOR_EXAMEN INT(3) NOT NULL,
            PRIMARY KEY (N))";
            
            $this->new_mysql->query($sql);

            $conn = $this->db->connect();  

            for($h=0;$h<3;$h++){
                $sql2 = "INSERT INTO $nameTable (MAYOR_CONTINUA,MAYOR_EXAMEN,MENOR_CONTINUA,MENOR_EXAMEN) VALUES ('0','0','0','0')";
                mysqli_query($conn,$sql2);
            }
        }

    }
?>