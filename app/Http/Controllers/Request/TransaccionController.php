<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\SvcUsuario;
use App\Service\SvcControlAcceso;
use App\Service\SvcGrupoHorarios;

class TransaccionController extends Controller
{
    private $respuesta = ["error" => "1", "mensaje" => "", "data" => []];

    function crear(Request $request, SvcUsuario $svcUsuario, SvcControlAcceso $svcControlAcceso, SvcGrupoHorarios $svcGrupoHorarios)
    {
        $fechaRegistro = date("Y-m-d H:i:s");
        $horaRegistro = date("H:i");
        $datosFormulario = $request->json()->all();
        if (!empty($datosFormulario)) {
            $documento = $datosFormulario["documento"];
            $infoUsuario = $svcUsuario->getUserByDocumento($documento);
            if (!empty($infoUsuario)) {
                $datosRegistrar = [
                    "id_usuario"      => $infoUsuario["id_usuario"],
                    "registro_acceso" => $fechaRegistro
                ];
                $svcControlAcceso->registrarControlAccesoByUser($datosRegistrar);

                $this->respuesta["error"] = 0;
                $this->respuesta["mensaje"] = "Se realizo el proceso de registro";
            } else {
                $this->respuesta["mensaje"] = "No se encontro el usuario para la gestion";
            }
        } else {
            $this->respuesta["mensaje"] = "No se envio informacion para procesar";
        }

        return response()->json($this->respuesta);
    }
}
