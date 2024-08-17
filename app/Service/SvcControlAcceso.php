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

    function obtenerAccesosUsuario($idUsuario, $fecha, $ordenar = "", $limit = 0)
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

            if (!empty($ordenar)) {
                $lista->orderBy("control_acceso.registro_acceso", $ordenar);
            } else {
                $lista->orderBy("control_acceso.registro_acceso");
            }

            if ($limit > 0) {
                $lista->limit($limit);
                 $resultado = $lista->get()?->first()?->toArray() ?? [];
                 return  $resultado;
            }

            $resultado = $lista->get()?->toArray() ?? [];
            return $resultado;
        } catch (Exception $e) {
            Log::channel("database")->info($e);
            return $resultado;
        }
    }
}
