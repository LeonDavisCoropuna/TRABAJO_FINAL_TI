<?php
include_once 'modelo/clasecurso.php';
include_once 'modelo/creartablas.php';
    class mainModel extends Controller{

        public function __construct(){
            parent::__construct();
            $this->db = new DataBase();

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
    }
?>