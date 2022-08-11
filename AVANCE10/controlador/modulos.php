<?php
class Modulos extends Controller{
    function __construct(){
        parent::__construct();
        $this->view->datos = [];
        //VARIABLAES DE ASISTENCIA
        $this->view->nombres_alumnos = [];
        $this->view->table_name = "";
        $this->view->idAlumno = "1";
        $this->view->select_asistencia = "";
        $this->view->inicializar_tabla = "";
        $this->view->inicializar_tabla_graficos = "";
        $this->view->asistencia_alumno_Record = []; 
        $this->view->asistencia_al_dia = [];
        $this->view->totalClases = "";
        $this->view->total_name_dias = [];
        $this->view->asistencia_en_un_dia = [];
        
        //VARIABLES DE NOTAS
        $this->view->notas = [];
        $this->view->parcial = "";
        $this->view->notasEstado = [];
        $this->view->notasResaltantes =[];
        $this->view->estudiantesPeligro = "";
        $this->view->alumnos_aprobados = [];


    }
    function render(){
        $this->view->datos =  $this->model->getCursosUsuario();
        $this->view->render('modulos/index');   
    }
    
    function Asistencia($param = null){     
        if(isset($_POST['asistencia']))
            $this->view->select_asistencia = $_POST['asistencia'];
        if(isset($_POST['dia'])){
            $this->view->asistencia_al_dia = $this->model->get_record_asistencia($param[0],$_POST['dia']);
        }
        if(isset($_POST['clase'])){
            $this->view->asistencia_en_un_dia = $this->model->get_asistentes_dia($param[0],$_POST['clase']);;
        }
        $this->view->total_name_dias = $this->model->getName_Days($param[0]);
        $this->view->nombres_alumnos = $this->model->getAlumnos($param[0]); 
        $this->view->table_name = strtr($param[0],"-", " ");
        $this->view->inicializar_tabla = $this->model->generar_tabla_usuarios($param);
        $this->view->inicializar_tabla_graficos = $this->model->generar_asistencia_grafico($param);

        $this->view->asistencia_alumno_Record = $this->model->get_record_asistencia($param[0]);
        $this->view->totalClases = $this->model->total_clases($param[0]);


        $this->view->render('modulos/Asistencia');
        
    }

    function Notas($param = null){
        $this->view->parcial = $_POST['parciales'];
        $this->view->notas = $this->model->getNotas($param[0]);
        
        $this->view->notasResaltantes = $this->model->notasResaltantes($param[0],$this->view->parcial);
        $this->view->table_name = strtr($param[0],"-", " ");
        $this->view->estudiantesPeligro = $this->model->getEstudiantesPeligro($param[0]);
        $this->view->alumnos_aprobados = $this->model->obtener_aprobados_graficos($param[0],$this->view->parcial);
        $this->view->render('modulos/Notas');

    }
    function actualizarNotas($param = null){
        $this->model->insertar_notas($param[0],$_POST);
        
    }
    function registrarAsistencia($param = null){
        $datosAsistencia = $_POST;
        $this->model->actualizar_asistencia($param[0],$datosAsistencia); 
    }
}
?>