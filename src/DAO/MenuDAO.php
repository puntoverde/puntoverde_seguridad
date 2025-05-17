<?php
namespace App\DAO;
use Illuminate\Support\Facades\DB;


class MenuDAO {

    public function __construct(){}

    public static function getMenuPerfil($id_perfil){

        // $menu=DB::table("modulos")
        // ->join("perfil_modulos","modulos.id_modulo","perfil_modulos.id_modulo")
        // ->where("perfil_modulos.id_perfil",$perfil)
        // ->where("modulos.estatus",1)
        // ->select("modulos.id_modulo","nombre AS title","iconoIOS AS iosIcon","iconoAndroid AS mdIcon","path AS url","permiso")
        // ->get();

        // return $menu;

        /*
            SELECT 
                modulo.cve_modulo,
                modulo.nombre,
                modulo.tipo,
                modulo.area,
                modulo.ruta
            FROM grupo_seguridad
            INNER JOIN modulo ON grupo_seguridad.cve_modulo = modulo.cve_modulo
            WHERE
                cve_perfil = 1
            GROUP BY modulo.cve_modulo
        */

        return DB::table("grupo_seguridad")
        ->join("modulo" , "grupo_seguridad.cve_modulo" , "modulo.cve_modulo")
        ->where("cve_perfil" , $id_perfil)
        ->groupBy("modulo.cve_modulo")
        ->select(
            "modulo.cve_modulo",
            "modulo.nombre",
            "modulo.tipo",
            "modulo.area",
            "modulo.ruta")
        ->get();

   }

   public static function getMenuTemporal($user,$pass){
    /*
        SELECT 
            modulo.cve_modulo,
            modulo.nombre,
			modulo.tipo,
			modulo.area,
            modulo.ruta
        FROM modulo
        INNER JOIN grupo_seguridad ON(modulo.cve_modulo=grupo_seguridad.cve_modulo)
        INNER JOIN usuario USING(cve_persona)
        WHERE usuario.usuario=? AND usuario.contrasena=?
		ORDER BY modulo.tipo, modulo.area, modulo.nombre
    */

    DB::select(
        "SELECT 
            modulo.cve_modulo,
            modulo.nombre,
			modulo.tipo,
			modulo.area,
            modulo.ruta
        FROM modulo
        INNER JOIN grupo_seguridad ON(modulo.cve_modulo=grupo_seguridad.cve_modulo)
        INNER JOIN usuario USING(cve_persona)
        WHERE usuario.usuario=? AND usuario.contrasena=?
		ORDER BY modulo.tipo, modulo.area, modulo.nombre",[$user,$pass]);
   }

}
