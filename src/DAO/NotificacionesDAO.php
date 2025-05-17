<?php
namespace App\DAO;
use Illuminate\Support\Facades\DB;


class NotificacionesDAO {

    public function __construct(){}

    public static function getAreas(){

     return DB::table("area_rh")->select("id_area_rh","nombre")->where("estatus",1)->get();

   }

    public static function getNotificacionByUsuario($id_persona){

        /*
            SELECT cve_notificacion,cve_usuario,descripcion FROM notificaciones WHERE cve_usuario=42 AND activa=1
        */
        return DB::table("notificaciones")        
        ->where("activa",1)
        ->where("cve_usuario",$id_persona)
        ->select(
            "cve_notificacion","cve_usuario","descripcion")
        ->get();

   }

   //si se selecciona solo el area traera los eventos de todos los colaboradores del area 
   //si tambien se selecciona un colborador en especifico se traera solo los eventos de ese colaborador.
   public static function setNotificacionVista($id_notificacion){
       return DB::table("notificaciones")->where("cve_notificacion",$id_notificacion)->update(["activa"=>0]);
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
