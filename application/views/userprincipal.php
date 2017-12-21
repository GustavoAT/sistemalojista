<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <title>Login Quemcriou</title>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src=<?php echo base_url('jquery/jquery-3.2.1.js')?>></script>
        <!-- Bootstrap compiled plugins -->
        <script src=<?php echo base_url('bootstrap/js/bootstrap.min.js')?>></script>
        <!-- Bootstrap custom stylesheet -->
        <link href=<?php echo base_url('bootstrap/css/custom-quemcriou.css')?> rel="stylesheet">
    </head>    
    <body class="lightgray-background">
        <div id="topo"></div>
        <nav class="navbar navbar-default navbar-fixed-top drop-shadow" role = "navigation">

            <div class = "navbar-header">
                <button type = "button" class = "navbar-toggle" 
                    data-toggle = "collapse" data-target = "#barranav">
                    <span class = "sr-only">Toggle navigation</span>
                    <span class = "glyphicon glyphicon-menu-hamburger"></span>
                </button>
                <div class="navbar-brand logotab-img">
                    <a href = "#">
                        <img src=<?php echo base_url('media/logo/h1_quemcriou.png')?> alt="Logo">
                    </a>
                </div>   
                
            </div>
            <div id = "barranav">
                
                <ul class = "collapse navbar-collapse nav navbar-nav">
                    <li>
                        <form class="navbar-form navbar-left" role="search">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default" type="button">
                                        <span class = " glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                                <input type="search" class="form-control form-small" placeholder="Pesquisar">
                            </div>    
                        </form>
                    </li>
                    <li class = "navbar-right"><a href = "#">Favoritos</a></li> 
                    <li class = "navbar-right"><a href = "#">Comentarios</a></li>
                    <li class = "navbar-right"><a href = "#">Contatos</a></li>
                    <li class = "navbar-right"><a href = "#">Caixa de entrada</a></li> 
                    <li class = "active navbar-right"><a href = "#">Atividade</a></li>
                </ul>
            </div>
            <div class="navbar-brand navbar-right">
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <img class="img-circle" src=<?php echo base_url('/media/user_profile/default.jpg')?> alt="Userpic" width=30 height=30>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Ação</a></li>
                        <li><a href="#">Outra ação</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Configurar</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Sair</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </body>
</html>