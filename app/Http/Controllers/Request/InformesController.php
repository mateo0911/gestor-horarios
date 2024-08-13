<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Service\SvcUsuario;
use App\Service\SvcControlAcceso;
use App\Service\SvcGrupoHorarios;
use App\Service\SvcAreas;

class InformesController extends Controller
{
    private $respuesta = ["error" => "1", "mensaje" => "", "data" => []];


    function horarios_general(Request $request, SvcUsuario $svcUsuario, SvcControlAcceso $svcControlAcceso, SvcGrupoHorarios $svcGrupoHorarios, SvcAreas $svcAreas)
    {
        $informeGeneral = $request->get("general") ?? "";
        $idUsuario = $request->get("id_usuario") ?? "";

        $infoInforme = $request->json()->all();
        $fechaInicio = $request->post("fecha_inicio") ?? "";
        $fechaLimite = $request->post("fecha_limite") ?? "";
        $usuarioEncontrado = $svcUsuario->getUsuarioById($idUsuario);
        if (!empty($usuarioEncontrado)) {
            $horarios = $svcGrupoHorarios->HorariosByIdArea($usuarioEncontrado["id_area"]);
            $fechaInicio = Carbon::parse("2024-07-25");
            $fechaLimite = Carbon::parse("2024-08-05");
            $informe = [];

            for ($fecha = $fechaInicio; $fecha->lte($fechaLimite); $fecha->addDay()) {
                $informeDiario = $this->procesarInformeDiario($usuarioEncontrado["id_usuario"], $horarios, $fecha);
                $informe[$fecha->format('Y-m-d')] = $informeDiario;
            }
        }

//        $dataTemplate["listaInforme"] = $informeRetornar;
//        $html = view("app.request.informe", $dataTemplate)->render();
//        $this->respuesta["data"] = $html;
//        $this->respuesta["error"] = "0";

        return response()->json($this->respuesta);
    }

    function procesarInformeDiario($usuario, $horarios, $fecha)
    {
        $svcControlAcceso = new SvcControlAcceso();
        $registrosAcceso = $svcControlAcceso->obtenerAccesosUsuario($usuario, $fecha->format('Y-m-d'), true);

        $informeDiario = [
            'fecha' => $fecha->format('Y-m-d'),
            'registros' => [],
            'horas_extras' => 0,
            'horas_perdidas' => 0,
        ];

        foreach ($horarios as $horario) {
            $tipoHorario = $this->obtenerTipoHorario($horario['descripcion']);
            $horaProgramada = $fecha->copy()->setTimeFromTimeString($horario['horario_inicio']);
            $registro = $this->encontrarRegistroMasCercano($registrosAcceso, $horaProgramada);
            $informeDiario['registros'][$tipo] = $registro ? $registro["registro_acceso"] : null;

            if ($registro) {
                $diferencia = Carbon::parse($horaProgramada)->diffInMinutes($registro["registro_acceso"], false);
            }
        }
    }

    function encontrarRegistroMasCercano($registros, $horaProgramada)
    {
        $registroMasCercano = null;
        $diferenciaMinima = PHP_INT_MAX;

        foreach ($registros as $registro) {
            $tiempoRegistro = Carbon::parse($registro['registro_acceso']);
            $diferencia = abs($tiempoRegistro->diffInMinutes($horaProgramada));

            if ($diferencia < $diferenciaMinima) {
                $diferenciaMinima = $diferencia;
                $registroMasCercano = $registro;
            }
        }

        return $registroMasCercano;
    }

    private function obtenerTipoHorario($descripcion)
    {
        $mapeoTipos = [
            'entrada laboral' => 'entrada_laboral',
            'desayuno' => 'desayuno',
            'entrada desayuno' => 'entrada_desayuno',
            'almuerzo' => 'almuerzo',
            'entrada almuerzo' => 'entrada_almuerzo',
            'salida laboral' => 'salida_laboral',
        ];

        return $mapeoTipos[strtolower($descripcion)] ?? $descripcion;
    }
}
