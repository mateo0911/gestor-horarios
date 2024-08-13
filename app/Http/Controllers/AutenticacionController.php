<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\SvcUsuario;
use App\Service\SvcControlAcceso;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AutenticacionController extends Controller
{

    function validarUser(Request $request, SvcUsuario $svcUsuario, SvcControlAcceso $svcControlAcceso)
    {
        $informacionUsuario = $request->json()->all();
        if (!empty($informacionUsuario)) {
            $usuarioEncontrado = $svcUsuario->getUsuarioByEmail($informacionUsuario["email"]);
            if (!empty($usuarioEncontrado)) {
                if (Hash::check($informacionUsuario["clave"], $usuarioEncontrado["clave"])) {
                    session(["id_usuario" => $usuarioEncontrado["id_usuario"]]);
                    session(["nombre_usuario" => $usuarioEncontrado["nombre"]]);
                    session(["email_usuario" => $usuarioEncontrado["email"]]);
                    session(['app_sesion' => 'xLXAiX0fFTjLKEiJam7X57']);
                    $registrarAcceso = [
                        "id_usuario" => $usuarioEncontrado["id_usuario"],
                        "registro_acceso" => date("Y-m-d H:i:s")
                    ];
                    $svcControlAcceso->registrarControlAccesoByUser($registrarAcceso);
                    $this->respuesta["error"] = 0;
                } else {
                    $this->respuesta["mensaje"] = "Usuario o clave equivocadas";
                }
            } else {
                $this->respuesta["mensaje"] = "Usuario o clave equivocadas";
            }
        }
        return response()->json($this->respuesta);
    }

    public function logout()
    {
        session_unset();
        Session::flush();
        return redirect('/');
    }
}
