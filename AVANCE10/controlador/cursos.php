<?php

class Cursos extends Controller{
    
    function __construct(){
        parent::__construct();
        $this->view->datos = [];  
        $this->view->pesosCurso = [];
        $this->view->tableName = "";
        $this->view->alumnos = [];


        $this->view->all_cursos = "";
        
    }
    function render(){
        $this->view->datos =  $this->model->getCursosUsuario();
        $this->view->all_cursos = $this->model->get_table_all_cursos();
        $this->view->render('cursos/index');
    }
    
    function registrarCurso(){
        // $curso      = $_POST['curso'];  
        // $creditos   = $_POST['creditos'];
        // $next       = $_POST['next'];
//        $this->model->insertUserCurso($curso,$creditos,$next);
        $this->model->insertUserCurso($_POST['cursos_list']);
        $this->view->render('cursos/index');
    }
    
    function editarCurso($param = null){
        
        $this->view->tableName = $param[0];
        $this->view->pesosCurso = $this->model->getPesosCurso($param[0]);
        $this->view->alumnos = $this->model->getAlumnos($param[0]); 
        $this->view->render('cursos/editarCurso');
    }

    function eliminarCurso(){
        //$this->view->render('cursos/eliminarCurso');
    }
    function guardarPesos($param = null){
        
        $continua1 = $_POST['continua1'];
        $continua2 = $_POST['continua2'];
        $continua3 = $_POST['continua3'];

        $examen1 = $_POST['examen1'];
        $examen2 = $_POST['examen2'];
        $examen3 = $_POST['examen3'];
        
        $this->model->insertPesos($param[0],$continua1,$continua2,$continua3,$examen1,$examen2,$examen3);
        echo "Registro de pesos EXITOSO";
    }   
    function insertAlumno($param = null){
        $tipo = $_FILES['archivoExel']['type'];
        $size = $_FILES['archivoExel']['size'];
        $archivotemp = $_FILES['archivoExel']['tmp_name'];
        $lineas = file($archivotemp);

        foreach ($lineas as $linea){
            $datos = explode(";",$linea);
            $nombre = !empty($datos[0]) ? ($datos[0]) : '';
            if(!empty($nombre)){   
                $nombre= utf8_encode($nombre);
                $this->model->matricularAlumno($param[0],$nombre);
            }
        }
    }   
}

?>