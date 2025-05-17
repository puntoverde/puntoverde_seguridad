<?php

namespace App\Controllers;
use App\DAO\GrupoSeguridadDAO;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class GrupoSeguridadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){}

    public function getPerfiles(){       
        return GrupoSeguridadDAO::getPerfiles();
    }
    
    public function getModulosByPerfil(Request $req){
        $id_perfil=$req->input("id_perfil");
        return GrupoSeguridadDAO::getModulosByPerfil($id_perfil);
    }
    
    public function addModuloPerfil(Request $req){
        $id_perfil=$req->input("id_perfil");
        $id_modulo=$req->input("id_modulo");
        return GrupoSeguridadDAO::addModuloPerfil($id_perfil,$id_modulo);
    }
    
    public function removeModuloPerfil(Request $req){
        $id_perfil=$req->input("id_perfil");
        $id_modulo=$req->input("id_modulo");
        return GrupoSeguridadDAO::removeModuloPerfil($id_perfil,$id_modulo);
    }

    public function getUsuarios()
    {
        return GrupoSeguridadDAO::getUsuarios();
    }
    
    public function getPerfilesByUsuario(Request $req)
    {
        $id_usuario=$req->input("id_usuario");
        return GrupoSeguridadDAO::getPerfilesByUsuario($id_usuario);
    }

    public function addPerfilUsuario(Request $req)
    {
        $id_perfil=$req->input("id_perfil");
        $id_usuario=$req->input("id_usuario");
        return GrupoSeguridadDAO::addPerfilUsuario($id_perfil,$id_usuario);
    }
   
    public function removePerfilUsuario(Request $req)
    {
        $id_perfil=$req->input("id_perfil");
        $id_usuario=$req->input("id_usuario");
        return GrupoSeguridadDAO::removePerfilUsuario($id_perfil,$id_usuario);
    }

    public function getColaboradores()
    {
         return GrupoSeguridadDAO::getColaboradores();
    }

    public function createUsuario(Request $req)
    {
        $reglas=["id_colaborador"=>"required","usuario"=>"required","perfiles"=>"required"];       

        $this->validate($req,$reglas);
        return GrupoSeguridadDAO::createUsuario((object)$req->all());
    }

    
}
