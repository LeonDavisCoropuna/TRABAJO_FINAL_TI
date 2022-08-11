<?php

class View{
    function __construct(){
    }
    function render($nombre){
        require 'vista/' .$nombre. '.php';
    }   
}
?>