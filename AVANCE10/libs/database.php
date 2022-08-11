<?php

class DataBase{
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;
    private $conexion;
    private $new_mysql;

    public function __construct(){
        $this->host = constant('HOST');
        $this->db = constant('DB');
        $this->user = constant('USER');
        $this->password = constant('PASSWORD');
        $this->charset = constant('CHARSET');
    }

    function connect(){
        $conexion = mysqli_connect($this->host, $this->user,$this->password,$this->db);
        $conexion->set_charset($this->charset);

        return $conexion;
    }

    function new_mysql(){
        $new_mysql = new mysqli($this->host, $this->user,$this->password,$this->db);
        $new_mysql->set_charset($this->charset); 
        return $new_mysql;
    }
}

?>