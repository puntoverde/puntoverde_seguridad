<?php
$router->group(['prefix'=>'login'],function() use($router){

    $router->post('','LoginController@InitSesion');
    
});