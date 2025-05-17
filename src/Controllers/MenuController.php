<?php

namespace App\Controllers;
use App\DAO\MenuDAO;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class MenuController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){}

    public function getMenuPerfil(Request $req){
        $id_perfil=$req->get("id_perfil");
        return MenuDAO::getMenuPerfil($id_perfil);
    }
    public function getMenuTemporal(Request $req){
        $user=$req->input("username");
        $pass=$req->input("password");
        return MenuDAO::getMenuTemporal($user,$pass);
    }

    
}
