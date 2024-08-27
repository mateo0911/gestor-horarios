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

    private $totalHorasExtras = 0;
    private $totalHorasPerdidas = 0;
    function horarios_general(Request $request, SvcUsuario $svcUsuario, SvcControlAcceso $svcControlAcceso, SvcGrupoHorarios $svcGrupoHorarios, SvcAreas $svcAreas)
    {
        $idUsuario = $request->get("id_usuario") ?? "";
        $fechaInicio = $request->post("fecha_inicio") ?? "";
        $fechaLimite = $request->post("fecha_limite") ?? "";

        $usuarioEncontrado = $svcUsuario->getUsuarioById($idUsuario);
        if (!empty($usuarioEncontrado)) {
            $horarios = $svcGrupoHorarios->HorariosByIdArea($usuarioEncontrado["id_area"]);
            $fechaInicio = Carbon::parse($fechaInicio);
            $fechaLimite = Carbon::parse($fechaLimite);
            $informe = [];

            for ($fecha = $fechaInicio; $fecha->lte($fechaLimite); $fecha->addDay()) {
                $this->totalHorasPerdidas = 0;
                $this->totalHorasExtras = 0;
                $informeDiario = $this->procesarInformeDiario($usuarioEncontrado["id_usuario"], $horarios, $fecha);
                $informe[$fecha->format('Y-m-d')] = $informeDiario;
            }
        }

        $templateView["informe"] = $informe;
        $templateView["nombre_usuario"] = $usuarioEncontrado["nombre"];
        $templateView["documento"] = $usuarioEncontrado["documento"];

        $htmlInformeGeneral = view('app.request.informe', $templateView)->render();
        $htmlInformeCalculoHoras = view('app.request.informehorasextras', $templateView)->render();

        $this->respuesta["data"]["informeGeneral"] = $htmlInformeGeneral;
        $this->respuesta["data"]["informeCalculoHoras"] = $htmlInformeCalculoHoras;
        $this->respuesta["error"] = "0";
        return response()->json($this->respuesta);
    }

    function procesarInformeDiario($usuario, $horarios, $fecha)
    {
        $svcControlAcceso = new SvcControlAcceso();
        $registrosUsuario = $svcControlAcceso->obtenerAccesosUsuario($usuario, $fecha->format('Y-m-d'), "");

        $informeDiario = [
            'fecha' => $fecha->format('Y-m-d'),
            'total_registros_por_dia' => 0,
            'horas_extras' => 0,
            'horas_perdidas' => 0,
            'horas_trabajadas' => 0,
            'registros_generales' => 0
        ];

        if (!empty($registrosUsuario)) {
            $primerRegistrosAcceso = $svcControlAcceso->obtenerAccesosUsuario($usuario, $fecha->format('Y-m-d'), "", 1);
            $RegistrosAccesoSalida = $svcControlAcceso->obtenerAccesosUsuario($usuario, $fecha->format('Y-m-d'), "desc", 1);

            foreach ($horarios as $horario) {

                if (mb_strtolower($horario["descripcion"]) == "entrada_laboral") {
                    $horasCalculadas = $this->calcularHorasExtrasOPerdidas($horario["horario_inicio"], date("H:i:s", strtotime($primerRegistrosAcceso["registro_acceso"])));
                }

                if (mb_strtolower($horario["descripcion"]) == "cierre_laboral") {
                    $horasCalculadas = $this->calcularHorasPerdidas($horario["horario_inicio"], date("H:i:s", strtotime($RegistrosAccesoSalida["registro_acceso"])));
                }
            }

            $horasTrabajadas = $this->calcularHorasTrabajadas(date("H:i:s", strtotime($primerRegistrosAcceso["registro_acceso"])), date("H:i:s", strtotime($RegistrosAccesoSalida["registro_acceso"])));
            $informeDiario["horas_extras"] = $this->totalHorasExtras;
            $informeDiario["horas_perdidas"] = $this->totalHorasPerdidas;
            $informeDiario["horas_trabajadas"] = $horasTrabajadas;
            $informeDiario["total_registros_por_dia"] = count($registrosUsuario);
            $informeDiario["registros_generales"] = $registrosUsuario;
        }


        return $informeDiario;
    }

    function calcularHorasExtrasOPerdidas($horaEstupulada, $horaRegistrada)
    {
        // Convertir las cadenas de hora a objetos Carbon
        $esperada = Carbon::parse($horaEstupulada);
        $registrada = Carbon::parse($horaRegistrada);

        // Calcular la diferencia en minutos de la hora del horario que deberia ser versus el registro del usuario
        $diferenciaMinutos = $esperada->diffInMinutes($registrada, false);

        // Calculamos las horas dependiendo de la diferencia de minutos obtenida anteriormente
        $horas = abs(floor($diferenciaMinutos / 60));
        $minutos = abs($diferenciaMinutos % 60);

        // Determinar si son horas extras o perdidas
        if ($diferenciaMinutos < 0) {
            $this->totalHorasExtras += (int)$horas;
            $tipo = 'horas_extras';
        } elseif ($diferenciaMinutos > 0) {
            $this->totalHorasPerdidas += (int)$horas;
            $tipo = 'horas_perdidas';
        }

        // Formatear el resultado
        $diferencia = sprintf('%02d:%02d', $horas, $minutos);

        return [
            'diferencia' => $diferencia,
            'tipo' => $tipo,
        ];
    }

    function calcularHorasPerdidas($horaEstupulada, $horaRegistrada)
    {
        // Convertir las cadenas de hora a objetos Carbon
        $esperada = Carbon::parse($horaEstupulada);
        $registrada = Carbon::parse($horaRegistrada);

        // Calcular la diferencia en minutos de la hora del horario que deberia ser versus el registro del usuario
        $diferenciaMinutos = $esperada->diffInMinutes($registrada, false);

        // Calculamos las horas dependiendo de la diferencia de minutos obtenida anteriormente
        $horas = abs(floor($diferenciaMinutos / 60));
        $minutos = abs($diferenciaMinutos % 60);

        // Determinar si son horas extras o perdidas
        if ($diferenciaMinutos < 0) {
            $this->totalHorasPerdidas += (int)$horas;
            $tipo = 'horas_perdidas';
        } elseif ($diferenciaMinutos > 0) {
            $this->totalHorasExtras += (int)$horas;
            $tipo = 'horas_extras';
        }

        // Formatear el resultado
        $diferencia = sprintf('%02d:%02d', $horas, $minutos);

        return [
            'diferencia' => $diferencia,
            'tipo' => $tipo,
        ];
    }
    function calcularHorasTrabajadas($horaInicial, $horaCierre)
    {
        $inicial = Carbon::parse($horaInicial);
        $cierre = Carbon::parse($horaCierre);

        $diferenciaMinutos = $inicial->diffInMinutes($cierre, false);

        $horasTrabajadas = abs(floor($diferenciaMinutos / 60));
        $minutos = abs($diferenciaMinutos % 60);

        $diferencia = sprintf('%02d:%02d', $horasTrabajadas, $minutos);

        return $diferencia ?? 0;
    }
}
