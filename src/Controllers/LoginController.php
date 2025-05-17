<?php

namespace App\Controllers;
use App\DAO\LoginDAO;
use App\Util\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){}

    public function InitSesion(Request $req){
        
        $reglas=["username"=>"required","password"=>"required"];


        $this->validate($req,$reglas);
        // dd($req->ip());
        $ip=$req->ip();

        $user= LoginDAO::InitSesion($req->input("username"),$req->input("password"),$ip);  
        if($user){
            $token = Auth::SignIn([
                "id_usuario" => $user->id_usuario,
                "id_usuario_enmascarado" => $user->id_usuario_enmascarado,
                "id_colaborador" => $user->id_colaborador,
                "cve_persona"=>$user->cve_persona,         
                "privilegios"=>$user->privilegios,         
                "permiso"=>$user->permiso,
                "perfiles"=>$user->perfiles??[]        
             ]);
       
            return response()->json([     
                "cve_persona"=>$user->cve_persona,        
                "alias"=>$user->alias,
                "nombre"=>$user->nombre,
                "paterno"=>$user->paterno,
                "materno"=>$user->materno,
                "perfiles"=>$user->perfiles??[],
                "token"=>$token
            ]);
        }
        else{
            return response('',Response::HTTP_NO_CONTENT);
        }
    }

}
