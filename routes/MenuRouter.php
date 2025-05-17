<?php
$router->group(['prefix'=>'menu','middleware' => 'auth'],function() use($router){
    
    $router->get('','MenuController@getMenuPerfil');
    $router->get('/temporal','MenuController@getMenuPerfil');
});