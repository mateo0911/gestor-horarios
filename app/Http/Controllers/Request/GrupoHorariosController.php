<?php

namespace App\Http\Controllers\Request;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\SvcGrupoHorarios;

class GrupoHorariosController extends Controller
{
    private $respuesta = ["error" => "1", "mensaje" => "", "data" => []];

    function crearGrupo(Request $request, SvcGrupoHorarios $grupoHorarios)
    {
        $datosFormulario = $request->json()->all();

        if (!empty($datosFormulario)) {
            $crearGrupo = [
                "descripcion"      => $datosFormulario["descripcion"],
                "horario_inicio"   => $datosFormulario["hora_inicio"] . ":" . $datosFormulario["minuto_inicio"],
                "horario_cierre"    => $datosFormulario["hora_cierre"] . ":" . $datosFormulario["minuto_cierre"],
                "estado"           => $datosFormulario["estado_grupo"]
            ];

            $grupoHorarios->registrar($crearGrupo);
            $this->respuesta["error"] = 0;
        }

        return response()->json($this->respuesta);
    }

    function actualizarGrupo(Request $request, SvcGrupoHorarios $grupoHorarios)
    {
        $datosFormulario = $request->json()->all();

        if (!empty($datosFormulario)) {
            $modificarGrupo = [
                "descripcion"    => $datosFormulario["descripcion"],
                "horario_inicio" => $datosFormulario["hora_inicio"] . ":" . $datosFormulario["minuto_inicio"],
                "horario_cierre"  => $datosFormulario["hora_cierre"] . ":" . $datosFormulario["minuto_cierre"],
                "estado"         => $datosFormulario["estado_grupo"]
            ];

            $grupoHorarios->actualizar($datosFormulario["id_grupo"], $modificarGrupo);
            $this->respuesta["error"] = 0;
        }

        return response()->json($this->respuesta);
    }
}
