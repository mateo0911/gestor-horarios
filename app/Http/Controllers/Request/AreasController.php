<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use App\Service\SvcAreas;
use Illuminate\Http\Request;

class AreasController extends Controller
{
    private $respuesta = ["error" => "1", "mensaje" => "", "data" => []];
    function crearArea(SvcAreas $svcAreas, Request $request)
    {
        $datosFormulario = $request->json()->all();

        if (!empty($datosFormulario)) {
            $datosCrear = [
                "nombre_area" => $datosFormulario["nombre_area"],
                "estado" => $datosFormulario["estado_area"],
                "registro_area" => date("Y-m-d H:i:s")
            ];
            $svcAreas->crear($datosCrear);

            $this->respuesta["error"] = 0;
        }
        return response()->json($this->respuesta);
    }

    function actualizarArea(SvcAreas $svcAreas, Request $request)
    {
        $datosFormulario = $request->json()->all();

        if (!empty($datosFormulario)) {
            $listaModificar = [
                "nombre_area" => $datosFormulario["nombre_area"],
                "estado" => $datosFormulario["estado_area"]
            ];
            $svcAreas->actualizar($datosFormulario["id_area"], $listaModificar);
        }

        $this->respuesta["error"] = 0;
        return response()->json($this->respuesta);
    }
}
