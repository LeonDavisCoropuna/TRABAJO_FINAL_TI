<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="<?php echo constant('URL');?>public/estilos.css">
    <style type="text/css">
        *{
            padding: 0px;
            margin: 0px;
        }
        #header{
            margin: auto;
            width: 500px;
            font-family:Arial, Helvetica, sans-serif;
        }
        ul,ol{
            list-style: none;
        }
        .nav li a{
            background-color: black;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
        }
        .nav li a:hover{
            background-color: #434343;
        }

        .nav > li{
            float: left;
        }

        .nav li ul{
            display: none;
            position: absolute;
            min-width: 140px;
        }
        .nav li:hover>ul{
            display: block;
        }

        .nav li ul li{
            position: relative;
            
        }
        .nav li ul li ul{
            right: -140px;
            top:0px
        }
        .holaMundo{
            display: flex;
            flex-direction: column;            
            background-color:black;
        }
    </style>
</head>
<body>
    <div class="holaMundo">
        <div class="header">
            <ul class="nav">
                <li><a href="<?php echo constant('URL');?>main">UNSA</a></li>
                <li><a href="<?php echo constant('URL');?>modulos">Curso del Usuario</a></li>
                <li><a href="<?php echo constant('URL');?>cursos">Admin Cursos</a></li>
            </ul>
        </div>
    </div>
</body>
</html>