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
            $informeDiario['registros'][$tipoHorario] = $registro ? $registro["registro_acceso"] : null;

            if ($registro) {
                $tiempoRegistro = Carbon::parse($registro["registro_acceso"], false);
                $diferenciaMinutos = $horaProgramada->diffInMinutes($tiempoRegistro, false);

                if (mb_strtolower($tipoHorario) == 'entrada_laboral' && $diferenciaMinutos < 0) {
                    $informeDiario['horas_extras'] += abs($diferenciaMinutos / 60);
                } else if (mb_strtolower($tipoHorario) == 'salida_laboral' && $diferenciaMinutos > 0) {
                    $informeDiario['horas_extras'] += $diferenciaMinutos / 60;
                } else if ($diferenciaMinutos > 0) {
                    $informeDiario['horas_perdidas'] += $diferenciaMinutos / 60;
                }
            } else {
                if (in_array($tipoHorario, ['entrada_laboral', 'entrada_desayuno', 'entrada_almuerzo'])) {
                    $informeDiario['horas_perdidas'] += 1; // Asumimos 1 hora perdida por cada entrada no registrada
                }
            }
        }

        return $informeDiario;
    }


    // HORA PROGRAMADA ES LA HORA LA CUAL ESTA CONFIGURADA PARA EL EVENTO POR EJEMPLO ENTRADA_LABORAL ES A LAS 07:00
    // REGISTROS SON LOS EVENTOS QUE HA REGISTRADO EL USUARIO
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
