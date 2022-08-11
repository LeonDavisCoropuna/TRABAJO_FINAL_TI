<?php

class Controller{
    function __construct(){
        $this->view = new View();
    }
    
    function loadModel($model){
        $url = 'modelo/'.$model.'model.php';
        if(file_exists($url)){
            require $url;
            $modelName = $model.'Model';
            $this->model = new $modelName();
        }
    }
}
?>