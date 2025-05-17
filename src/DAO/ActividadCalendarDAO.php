<?php
namespace App\DAO;
use Illuminate\Support\Facades\DB;


class ActividadCalendarDAO {

    public function __construct(){}

    public static function getAreas(){

     return DB::table("area_rh")->select("id_area_rh","nombre")->where("estatus",1)->get();

   }

    public static function getColaboradorByArea($id_area){

        /*
            SELECT 
                colaborador.id_colaborador,
                persona.nombre,
                persona.apellido_paterno,
                persona.apellido_materno 
            FROM colaborador 
            INNER JOIN persona ON colaborador.cve_persona=persona.cve_persona 
            WHERE colaborador.estatus=1 AND colaborador.id_area=4
        */
        return DB::table("colaborador")
        ->join("persona" , "colaborador.cve_persona","persona.cve_persona")
        ->where("colaborador.estatus",1)
        ->where("colaborador.id_area",$id_area)
        ->select(
            "colaborador.id_colaborador",
            "persona.nombre",
            "persona.apellido_paterno",
            "persona.apellido_materno")
        ->get();

   }

   //si se selecciona solo el area traera los eventos de todos los colaboradores del area 
   //si tambien se selecciona un colborador en especifico se traera solo los eventos de ese colaborador.
   public static function getEventosAreaAndColaborador(){
    return [];
   }

//    public static function createPerfil(){}

//    public static function createModulo(){}

    public static function getProyectos($id_perfil,$modulo){

        // return DB::table("grupo_seguridad")->insert(["cve_perfil"=>$id_perfil,"cve_modulo"=>$modulo]);

   }

    public static function createProyectos($id_perfil,$modulo){

        return DB::table("grupo_seguridad")
        ->where("cve_perfil" , $id_perfil)
        ->where("cve_modulo" , $modulo)
        ->delete();

   }

   public static function crearEvento($id_usuario){
    
   }

   public static function editarEvento($perfil,$usuario){
    return DB::table("usuario_perfiles")->insertGetId(["cve_perfil"=>$perfil,"cve_usuario"=>$usuario]);
   }
   
   public static function eliminarEvento($perfil,$usuario){
    return DB::table("usuario_perfiles")->insertGetId(["cve_perfil"=>$perfil,"cve_usuario"=>$usuario]);
   }

  

}
