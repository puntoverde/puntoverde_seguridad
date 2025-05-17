<?php
namespace App\DAO;
use Illuminate\Support\Facades\DB;


class GrupoSeguridadDAO {

    public function __construct(){}

    public static function getPerfiles(){

        return DB::table("perfiles")
        ->where("estatus" , 1)        
        ->select(
            "cve_perfil",
            "nombre")
        ->get();

   }

    public static function getModulosByPerfil($id_perfil){

        /*
            SELECT modulo.cve_modulo,modulo.nombre,modulo.tipo,grupo_seguridad.cve_perfil FROM modulo
            left join grupo_seguridad on modulo.cve_modulo=grupo_seguridad.cve_modulo and grupo_seguridad.cve_perfil=1
        */
        return DB::table("modulo")
        ->leftJoin("grupo_seguridad",function($join)use($id_perfil){ $join->on("modulo.cve_modulo","grupo_seguridad.cve_modulo")->where("grupo_seguridad.cve_perfil",$id_perfil);})
        ->select(
            "modulo.cve_modulo",
            "modulo.nombre",
            "modulo.tipo",
            "grupo_seguridad.cve_perfil")
        ->get();

   }

   public static function getUsuarios(){
    /* 
        SELECT 
	        usuario.id_usuario,
            usuario.cve_colaborador,
            colaborador.nomina,
            persona.nombre,
            persona.apellido_paterno,
            persona.apellido_materno,
            usuario.usuario,
            IF(usuario.enmascarado IS NULL,0,1) AS is_enmascarado,
            usuario.estatus,
            GROUP_CONCAT(perfiles.nombre) AS perfiles 
        FROM usuario
        LEFT JOIN usuario_perfiles ON usuario.id_usuario=usuario_perfiles.cve_usuario
        LEFT JOIN perfiles ON usuario_perfiles.cve_perfil=perfiles.cve_perfil AND perfiles.estatus=1
        left join colaborador on usuario.cve_colaborador=colaborador.id_colaborador
        left join persona on colaborador.cve_persona=persona.cve_persona
        GROUP BY usuario.id_usuario;;
    */
    return DB::table("usuario")
    ->leftJoin("usuario_perfiles" , "usuario.id_usuario","usuario_perfiles.cve_usuario")
    ->leftJoin("perfiles",function($join){ $join->on("usuario_perfiles.cve_perfil","perfiles.cve_perfil")->where("perfiles.estatus",1);})
    ->leftJoin("colaborador" , "usuario.cve_colaborador","colaborador.id_colaborador")
    ->leftJoin("persona" , "colaborador.cve_persona","persona.cve_persona")
    ->groupBy("usuario.id_usuario")
    ->select(
        "usuario.id_usuario",
        "usuario.cve_colaborador",
        "usuario.usuario",
        "colaborador.nomina",
        "persona.nombre",
        "persona.apellido_paterno",
        "persona.apellido_materno",
        "usuario.estatus")
    ->selectRaw("IF(usuario.enmascarado IS NULL,0,1) AS is_enmascarado")
    ->selectRaw("GROUP_CONCAT(perfiles.nombre) AS perfiles")
    ->get();
   }

//    public static function createPerfil(){}

//    public static function createModulo(){}

    public static function addModuloPerfil($id_perfil,$modulo){

        return DB::table("grupo_seguridad")->insert(["cve_perfil"=>$id_perfil,"cve_modulo"=>$modulo]);

   }

    public static function removeModuloPerfil($id_perfil,$modulo){

        return DB::table("grupo_seguridad")
        ->where("cve_perfil" , $id_perfil)
        ->where("cve_modulo" , $modulo)
        ->delete();

   }

   public static function getPerfilesByUsuario($id_usuario){
    /*
        SELECT 
	        perfiles.cve_perfil,
            perfiles.nombre,
            perfiles.estatus,
            perfiles.permiso,
            usuario_perfiles.cve_usuario_perfil 
        FROM perfiles
        LEFT JOIN usuario_perfiles ON perfiles.cve_perfil=usuario_perfiles.cve_perfil AND usuario_perfiles.cve_usuario=32
    */

    return DB::table("perfiles")
    ->leftJoin("usuario_perfiles",function($join)use($id_usuario){ $join->on("perfiles.cve_perfil","usuario_perfiles.cve_perfil")->where("usuario_perfiles.cve_usuario",$id_usuario);})
    ->select(
            "perfiles.cve_perfil",
            "perfiles.nombre",
            "perfiles.estatus",
            "perfiles.permiso",
            "usuario_perfiles.cve_usuario_perfil"
    )
    ->get();
   }

   public static function addPerfilUsuario($perfil,$usuario){
    return DB::table("usuario_perfiles")->insertGetId(["cve_perfil"=>$perfil,"cve_usuario"=>$usuario]);
   }

   public static function removePerfilUsuario($perfil,$usuario)
   {
    return DB::table("usuario_perfiles")->where("cve_perfil",$perfil)->where("cve_usuario",$usuario)->delete();
   }

   public static function getColaboradores()
   {
    /*
        SELECT 
            colaborador.id_colaborador,
            colaborador.nomina,
            persona.nombre,
            persona.apellido_paterno,
            persona.apellido_materno 
        FROM colaborador
        left join usuario on colaborador.id_colaborador=usuario.cve_colaborador
        inner join persona on colaborador.cve_persona=persona.cve_persona
        where colaborador.estatus=1 and usuario.cve_colaborador is null 
    */

    return DB::table("colaborador")
    ->leftJoin("usuario" , "colaborador.id_colaborador","usuario.cve_colaborador")
    ->join("persona" , "colaborador.cve_persona","persona.cve_persona")
    ->where("colaborador.estatus",1)
    ->whereNull("usuario.cve_colaborador")
    ->select(
        "colaborador.id_colaborador",
        "colaborador.nomina",
        "persona.nombre",
        "persona.apellido_paterno",
        "persona.apellido_materno"
    )
    ->get();
   }

   public static function createUsuario($p)
   {

    // dd($p);
    // dd(collect($p->perfiles)->map(function($item){return ["cve_perfil"=>$item,"cve_usuario"=>1];})->toArray());

    return DB::transaction(function() use($p){
        $id_usuario=DB::table("usuario")->insertGetId(["cve_colaborador"=>$p->id_colaborador,"usuario"=>$p->usuario,"contrasena"=>$p->usuario]);
        $perfiles=collect($p->perfiles)->map(function($item)use($id_usuario){return ["cve_perfil"=>$item,"cve_usuario"=>$id_usuario];})->toArray();
        return DB::table("usuario_perfiles")->insert($perfiles);
    });


   }

}
