<?php

namespace App\Service;

use App\Models\GrupoHorarios;

use Exception;
use Illuminate\Support\Facades\Log;

class SvcGrupoHorarios
{
    function cargar()
    {
        try {
            $lista = GrupoHorarios::all();
            if (!empty($lista)) {
                return $lista->toArray();
            }
            return [];

        } catch (Exception $e) {
            Log::channel("database")->info($e);
            return [];
        }
    }

    function getGrupoByGrupo($id)
    {
        try {
            $grupoEncontrado = GrupoHorarios::select(
                "id_grupo_horario",
                "descripcion",
                "horario_inicio",
                "horario_cierre",
                "estado")
                ->where("id_grupo_horario", $id)
                ->get()
                ->first();

            if (!empty($grupoEncontrado)) {
                $grupoEncontrado = $grupoEncontrado->toArray();
                return $grupoEncontrado;
            }
            return [];
        } catch (Exception $e) {
            Log::channel("database")->info($e);
            return [];
        }
    }

    function registrar($datosCrear)
    {
        try {
            GrupoHorarios::create($datosCrear);
            return true;
        } catch (Exception $e) {
            Log::channel("database")->info($e);
            return false;
        }
    }

    function actualizar($id, $datos)
    {
        try {
            GrupoHorarios::where("id_grupo_horario", $id)->update($datos);
            return true;
        } catch (Exception $e) {
            Log::channel("database")->info($e);
            return false;
        }
    }

    function HorariosByIdArea($idArea)
    {
        try {
            $resultado = [];
            $lista = GrupoHorarios::select(
                "id_grupo_horario",
                "id_area",
                "descripcion",
                "horario_inicio",
                "horario_cierre",
                "estado")
                ->where("id_area", $idArea)
                ->get();
            if (!empty($lista)) {
                $resultado = $lista->toArray();
            }
            return $resultado;
        } catch (Exception $e) {
            Log::channel("database")->info($e);
            return $resultado;
        }
    }

    function getHorarioMascercanoByHora($hora, $idArea)
    {
        $resultado = [];
        try {
            $horarioMasCercano = GrupoHorarios::select('*')
                ->selectRaw('ABS(TIME_TO_SEC(TIMEDIFF(horario_inicio, ?))) AS diferencia_segundos', [$hora])
                ->where('id_area', $idArea)
                ->where('estado', '1')
                ->orderBy('diferencia_segundos', 'ASC')
                ->first();

            if (!empty($horarioMasCercano)) {
                $resultado = $horarioMasCercano->toArray();
                return $resultado;
            }
            return $resultado;
        } catch (Exception $e) {
            Log::channel("database")->info($e);
            return $e;
        }

    }
}
