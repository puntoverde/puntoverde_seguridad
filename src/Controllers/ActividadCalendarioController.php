<?php

namespace App\Controllers;
use App\DAO\ActividadCalendarDAO;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class ActividadCalendarioController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){}

    public function getAreas(){       
        return ActividadCalendarDAO::getAreas();
    }
    
    public function getColaboradorByArea(Request $req){
        $reglas=["id_area"=>"required"];       
        $this->validate($req,$reglas);
        $id_area=$req->input("id_area");
        return ActividadCalendarDAO::getColaboradorByArea($id_area);
    }
    
    public function getEventosAreaAndColaborador(Request $req){
        $id_perfil=$req->input("id_perfil");
        $id_modulo=$req->input("id_modulo");
        return ActividadCalendarDAO::getEventosAreaAndColaborador($id_perfil,$id_modulo);
    }
    
    public function getProyectos(Request $req){
        $id_perfil=$req->input("id_perfil");
        $id_modulo=$req->input("id_modulo");
        return ActividadCalendarDAO::getProyectos($id_perfil,$id_modulo);
    }

    public function createProyectos()
    {
        return ActividadCalendarDAO::createProyectos(1,1);
    }
    
    public function crearEvento(Request $req)
    {
        $id_usuario=$req->input("id_usuario");
        return ActividadCalendarDAO::crearEvento($id_usuario);
    }

    public function editarEvento(Request $req)
    {
        $id_perfil=$req->input("id_perfil");
        $id_usuario=$req->input("id_usuario");
        return ActividadCalendarDAO::editarEvento($id_perfil,$id_usuario);
    }
   
    public function eliminarEvento(Request $req)
    {
        $id_perfil=$req->input("id_perfil");
        $id_usuario=$req->input("id_usuario");
        return ActividadCalendarDAO::eliminarEvento($id_perfil,$id_usuario);
    }

    
}
