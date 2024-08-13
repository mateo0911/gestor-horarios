<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use App\Service\SvcUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{

    private $respuesta = ["error" => "1", "mensaje" => "", "data" => []];

    function crear(Request $request, SvcUsuario $svcUsuario)
    {
        $datosFomrulario = $request->json()->all();

        if (!empty($datosFomrulario)) {
            $dataCrear = [
                "id_usuario"     => null,
                "nombre"         => $datosFomrulario["nombre_usuario"],
                "email"          => $datosFomrulario["email_usuario"],
                "clave"          => Hash::make($datosFomrulario["clave_usuario"]),
                "documento"      => $datosFomrulario["documento_usuario"],
                "rol"            => $datosFomrulario["rol_usuario"],
                "estado"         => $datosFomrulario["estado_usuario"],
                "registro_fecha" => date('Y-m-d H:i:s')
            ];

            $svcUsuario->crear($dataCrear);
            $this->respuesta["error"] = 0;
        }

        return response()->json($this->respuesta);
    }

    function actualizar(Request $request, SvcUsuario $svcUsuario)
    {
        $datosFomrulario = $request->json()->all();

        if (!empty($datosFomrulario)) {
            $dataCrear = [
                "nombre"         => $datosFomrulario["nombre_usuario"] ?? "",
                "email"          => $datosFomrulario["email_usuario"] ?? "",
                "documento"      => $datosFomrulario["documento_usuario"] ?? "",
                "rol"            => $datosFomrulario["rol_usuario"] ?? "",
                "estado"         => $datosFomrulario["estado_usuario"] ?? ""
            ];

            if (!empty($datosFomrulario["clave_usuario"])) {
                $dataCrear["clave"] = Hash::make($datosFomrulario["clave_usuario"]);
            }

            $svcUsuario->actualizar($datosFomrulario["id_usuario"], $dataCrear);
            $this->respuesta["error"] = 0;
        }
        return response()->json($this->respuesta);
    }
}
