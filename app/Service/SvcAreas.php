<?php

namespace App\Service;

use App\Models\Areas;
use Exception;
use Illuminate\Support\Facades\Log;
class SvcAreas
{
    function getAreas() {
        try {

            $lista = Areas::all();
            if (!empty($lista)) {
                $lista = $lista->toArray();
                return $lista;
            }
            return [];
        } catch (Exception $e) {
            Log::channel("database")->info($e);
            return [];
        }
    }

    function crear($datos)
    {
        try {
            Areas::create($datos);
            return true;
        } catch (Exception $e) {
            Log::channel("database")->info($e);
            return false;
        }
    }

    function actualizar($id, $listaModificar)
    {
        try {
            Areas::where("id_area", $id)->update($listaModificar);
            return true;
        } catch (Exception $e) {
            Log::channel("database")->info($e);
            return false;
        }
    }

    function getAreaById($id)
    {
        try {
            $areaEncontrada = Areas::select("id_area",
                "nombre_area",
                "estado",
                "registro_area")
                ->where("id_area", $id);
            $resultado = $areaEncontrada->get()->first();

            if (!empty($resultado)) {
                return $resultado->toArray();
            }
            return [];
        } catch (Exception $e) {
            Log::channel("database")->info($e);
            return [];
        }
    }
}
