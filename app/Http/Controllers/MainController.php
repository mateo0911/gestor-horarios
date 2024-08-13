<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GrupoHorarios;
use Illuminate\Http\Request;
use App\Service\SvcAreas;
use App\Service\SvcGrupoHorarios;
use App\Service\SvcUsuario;

class MainController extends Controller
{
    function dashboard()
    {
        return view("dashboard");
    }

    function login()
    {
        return view("Main.login");
    }

    function cargarAreas(SvcAreas $svcAreas, Request $request)
    {
        $id = $request->get("id_area") ?? "";
        if (!empty($id)) {
            $templateView["areaById"] = $svcAreas->getAreaById($id);
        }
        $templateView["listaAreas"] = $svcAreas->getAreas();

        return view('app.areas', $templateView);
    }

    function cargarGrupoHorarios(SvcGrupoHorarios $svcGrupoHorarios, Request $request)
    {
        $id = $request->get("id_grupo_horario") ?? "";

        if (!empty($id)) {
            $grupoEncontrado = $svcGrupoHorarios->getGrupoByGrupo($id);
            $templateView["grupoById"] = $grupoEncontrado;
            $horarioInicioSeparado = explode(":", $grupoEncontrado["horario_inicio"]);
            $horarioCierreSeparado = explode(":", $grupoEncontrado["horario_cierre"]);
            $templateView["grupoById"]["hora_inicio"] = $horarioInicioSeparado[0] ?? "";
            $templateView["grupoById"]["minuto_inicio"] = $horarioInicioSeparado[1] ?? "";
            $templateView["grupoById"]["hora_cierre"] = $horarioCierreSeparado[0] ?? "";
            $templateView["grupoById"]["minuto_cierre"] = $horarioCierreSeparado[1] ?? "";
        }
        $templateView["listaGrupos"] = $svcGrupoHorarios->cargar();

        return view("app.grupohorarios", $templateView);
    }

    function cargarUsuarios(SvcUsuario $svcUsuario, Request $request, SvcAreas $svcAreas, SvcGrupoHorarios $grupoHorarios)
    {
        $id = $request->get("id_usuario");

        if (!empty($id)) {
            $templateView["usuaroById"] = $svcUsuario->getUsuarioById($id);
        }
        $templateView["listaUsuarios"] = $svcUsuario->getUsuarios();
        $templateView["listaAreas"] = $svcAreas->getAreas();
        $templateView["listaGruposHorarios"] = $grupoHorarios->cargar();
        return view("app.usuarios", $templateView);
    }

    function cargarControlesAcceso()
    {
        return view("main.controles");
    }

    function registroTransaccion()
    {
        return view("Main.transacionregistro");
    }

    function informes_general(SvcUsuario $svcUsuario)
    {
        $listaUsuarios = $svcUsuario->getUsuarios();
        $templateView["listaUsuarios"] = $listaUsuarios;
        return view("app.informesgeneral", $templateView);
    }
}
