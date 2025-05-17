<?php
$router->group(['prefix'=>'actividad-calendar','middleware' => 'auth'],function() use($router){
    
    $router->get('','ActividadCalendarioController@getEventosAreaAndColaborador');
    $router->post('','ActividadCalendarioController@crearEvento');
    $router->put('','ActividadCalendarioController@editarEvento');
    $router->delete('','ActividadCalendarioController@eliminarEvento');

    $router->get('areas','ActividadCalendarioController@getAreas');
    $router->get('colaborador-by-area','ActividadCalendarioController@getColaboradorByArea');

    $router->get('proyectos','ActividadCalendarioController@getProyectos');
    $router->post('proyectos','ActividadCalendarioController@createProyectos');    
});