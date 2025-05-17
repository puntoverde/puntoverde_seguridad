<?php
$router->group(['prefix'=>'grupo-seguridad','middleware' => 'auth'],function() use($router){
    
    $router->get('','GrupoSeguridadController@getModulosByPerfil');
    $router->post('','GrupoSeguridadController@addModuloPerfil');
    $router->delete('','GrupoSeguridadController@removeModuloPerfil');
    $router->get('perfiles','GrupoSeguridadController@getPerfiles');

    $router->get('usuarios-perfiles','GrupoSeguridadController@getPerfilesByUsuario');
    $router->post('usuarios-perfiles','GrupoSeguridadController@addPerfilUsuario');
    $router->delete('usuarios-perfiles','GrupoSeguridadController@removePerfilUsuario');
    $router->get('usuarios','GrupoSeguridadController@getUsuarios');
    $router->post('usuarios','GrupoSeguridadController@createUsuario');
    
    $router->get('colaboradores-disponibles','GrupoSeguridadController@getColaboradores');
});