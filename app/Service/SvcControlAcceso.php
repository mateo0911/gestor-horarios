<?php

namespace App\Service;

use App\Models\ControlAcceso;
use Exception;
use Illuminate\Support\Facades\Log;

class SvcControlAcceso
{

    function registrarControlAccesoByUser($datos)
    {
        try {
            ControlAcceso::create($datos);
            return true;
        } catch (Exception $e) {
            Log::channel("database")->info($e);
            return false;
        }
    }

    function obtenerAccesosUsuario($idUsuario, $fecha, $ordenar = false)
    {
        $resultado = [];
        try {
            $lista = ControlAcceso::select(
                "control_acceso.id_control_acceso",
                "control_acceso.id_usuario",
                "control_acceso.registro_acceso",
                "u.id_area",
                "u.nombre",
                "u.email",
                "u.clave",
                "u.documento",
                "u.rol",
                "u.estado",
                "u.registro_fecha")
                ->join("usuario AS u", "u.id_usuario", "=", "control_acceso.id_usuario")
                ->where("control_acceso.id_usuario", $idUsuario)
                ->whereRaw("DATE(control_acceso.registro_acceso) = '" . $fecha . "'");

            if ($ordenar) {
                $lista->orderBy("control_acceso.registro_acceso");
            }

            return $resultado = $lista->get()?->toArray() ?? [];
        } catch (Exception $e) {
            Log::channel("database")->info($e);
            return $resultado;
        }
    }
}
