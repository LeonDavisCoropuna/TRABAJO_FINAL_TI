<?php
    class Main extends Controller{
        function __construct(){
            parent::__construct();
            $this->view->datos = [];

        }
        function render(){
            $this->view->datos =  $this->model->getCursosUsuario();
            $this->view->render('main/index');
        }
        
    }
?>