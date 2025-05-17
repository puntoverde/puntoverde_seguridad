<?php
namespace App\DAO;
use Illuminate\Support\Facades\DB;

class LoginDAO
{
    public function __construct(){
    }

    public static function InitSesion($username,$password,$ip){  

        /*
            SELECT 
                IFNULL(usuario_enmascarado.id_usuario,usuario.id_usuario) AS id_usuario, 
                usuario.id_usuario AS id_usuario_enmascarado 
                IFNULL(colaborador_enmascarado.id_colaborador,colaborador.id_colaborador) AS id_colaborador,
	            IFNULL(persona_enmascaro.cve_persona,usuario.cve_persona) AS cve_persona,
	            IFNULL(colaborador_enmascarado.foto,colaborador.foto) AS foto,
	            IFNULL(usuario_enmascarado.privilegios,usuario.privilegios) AS privilegios,
                IFNULL(usuario_enmascarado.permiso,usuario.permiso) AS permiso,
	            IFNULL(persona_enmascaro.nombre,persona.nombre) AS nombre,
	            IFNULL(persona_enmascaro.apellido_paterno,persona.apellido_paterno) AS paterno,
	            IFNULL(persona_enmascaro.apellido_materno,persona.apellido_materno) AS materno 
            FROM usuario
            INNER JOIN colaborador on usuario.cve_colaborador=colaborador.id_colaborador
            INNER JOIN persona ON colaborador.cve_persona=persona.cve_persona
            LEFT JOIN colaborador AS colaborador_enmascarado ON usuario.enmascarado=colaborador_enmascarado.id_colaborador
            LEFT JOIN usuario AS usuario_enmascarado on colaborador_enmascarado.id_colaborador=usuario_enmascarado.cve_colaborador
            LEFT JOIN persona AS persona_enmascaro ON colaborador_enmascarado.cve_persona=persona_enmascaro.cve_persona
            WHERE usuario.usuario="leonrp" AND usuario.contrasena="leonrp" AND usuario.estatus=1         
        */

        /*
            SELECT 
                perfiles.cve_perfil,
                perfiles.nombre 
            FROM perfiles
            INNER JOIN usuario_perfiles ON perfiles.cve_perfil=usuario_perfiles.cve_perfil
            WHERE usuario_perfiles.cve_usuario=32 AND perfiles.estatus=1
        */
        
        $data=DB::table("usuario")
        ->join("colaborador" , "usuario.cve_colaborador","colaborador.id_colaborador")       
        ->join("persona" , "colaborador.cve_persona","persona.cve_persona")
        ->leftJoin("colaborador AS colaborador_enmascarado" , "usuario.enmascarado","colaborador_enmascarado.id_colaborador")       
        ->leftJoin("usuario AS usuario_enmascarado" , "colaborador_enmascarado.id_colaborador","usuario_enmascarado.cve_colaborador")       
        ->leftJoin("persona AS persona_enmascaro", "colaborador_enmascarado.cve_persona","persona_enmascaro.cve_persona")       
        ->where("usuario.usuario",$username)
        ->where("usuario.contrasena",$password)
        ->where("usuario.estatus",1)
        ->select("usuario.id_usuario AS id_usuario_enmascarado","colaborador.id_colaborador AS id_colaborador_enmascarado")
        ->selectRaw("IFNULL(usuario_enmascarado.id_usuario,usuario.id_usuario) AS id_usuario")
        ->selectRaw("IFNULL(colaborador_enmascarado.id_colaborador,colaborador.id_colaborador) AS id_colaborador")
        ->selectRaw("IFNULL(persona_enmascaro.cve_persona,usuario.cve_persona) AS cve_persona")
        ->selectRaw("IFNULL(colaborador_enmascarado.foto,colaborador.foto) AS foto")
        ->selectRaw("IFNULL(usuario_enmascarado.privilegios,usuario.privilegios) AS privilegios")
        ->selectRaw("IFNULL(usuario_enmascarado.permiso,usuario.permiso) AS permiso")
        ->selectRaw("IFNULL(usuario_enmascarado.usuario,usuario.usuario) AS alias")
        ->selectRaw("IFNULL(persona_enmascaro.nombre,persona.nombre) AS nombre")
        ->selectRaw("IFNULL(persona_enmascaro.apellido_paterno,persona.apellido_paterno) AS paterno")
        ->selectRaw("IFNULL(persona_enmascaro.apellido_materno,persona.apellido_materno) AS materno" )      
        ->first();

        if($data)
        {
          $data->perfiles=DB::table("perfiles")
          ->join("usuario_perfiles" , "perfiles.cve_perfil","usuario_perfiles.cve_perfil")
          ->select("perfiles.cve_perfil","perfiles.nombre")
          ->where("usuario_perfiles.cve_usuario",$data->id_usuario)
          ->where("perfiles.estatus",1)
          ->get();

          //se guarda en la tabla de logs
          DB::table("seg_log_erp")->insert(
            [
                "colaborador_en_sesion"=>$data->id_colaborador_enmascarado,
                "movimiento"=>$data->id_colaborador==$data->id_colaborador_enmascarado?"inicio sesion el usuario:".$data->id_usuario." con id colaborador:".$data->id_colaborador:"inicio sesion el usuario:".$data->id_usuario." con id colaborador:".$data->id_colaborador.". pero se enmascaro con el usuario:".$data->id_usuario." y con id colaborador:". $data->id_colaborador,
                "ip"=>$ip
            ]
            );

        }        

        return $data;
    }


    
}