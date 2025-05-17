<?php

namespace App\Controllers;
use App\DAO\NotificacionesDAO;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class NotificacionesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){}

    public function getAreas(){       
        return NotificacionesDAO::getAreas();
    }
    
    public function getNotificacionByUsuario(Request $req){
        $id_persona=$req->get("cve_persona");
        // dd($id_persona);
        return NotificacionesDAO::getNotificacionByUsuario($id_persona);
    }
    
    public function setNotificacionVista(Request $req){
        $id_notificacion=$req->input("id_notificacion");
        // dd($id_notificacion);
        return NotificacionesDAO::setNotificacionVista($id_notificacion);
    }
    
    public function getProyectos(Request $req){
        $id_perfil=$req->input("id_perfil");
        $id_modulo=$req->input("id_modulo");
        return NotificacionesDAO::getProyectos($id_perfil,$id_modulo);
    }

    public function createProyectos()
    {
        return NotificacionesDAO::createProyectos(1,1);
    }
    
    public function crearEvento(Request $req)
    {
        $id_usuario=$req->input("id_usuario");
        return NotificacionesDAO::crearEvento($id_usuario);
    }

    public function editarEvento(Request $req)
    {
        $id_perfil=$req->input("id_perfil");
        $id_usuario=$req->input("id_usuario");
        return NotificacionesDAO::editarEvento($id_perfil,$id_usuario);
    }
   
    public function eliminarEvento(Request $req)
    {
        $id_perfil=$req->input("id_perfil");
        $id_usuario=$req->input("id_usuario");
        return NotificacionesDAO::eliminarEvento($id_perfil,$id_usuario);
    }

    
}
