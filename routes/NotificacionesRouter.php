<?php
$router->group(['prefix'=>'notificaciones','middleware' => 'auth'],function() use($router){
    
    $router->get('','NotificacionesController@getNotificacionByUsuario');

    
    $router->post('/visto','NotificacionesController@setNotificacionVista');


    $router->put('','NotificacionesController@editarEvento');
    $router->delete('','NotificacionesController@eliminarEvento');

    $router->get('areas','NotificacionesController@getAreas');
    $router->get('colaborador-by-area','NotificacionesController@getColaboradorByArea');

    $router->get('proyectos','NotificacionesController@getProyectos');
    $router->post('proyectos','NotificacionesController@createProyectos');    
});