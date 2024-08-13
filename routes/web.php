<?php

use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Request\AreasController;
use App\Http\Controllers\Request\GrupoHorariosController;
use App\Http\Controllers\Request\UsuariosController;
use App\Http\Controllers\Request\TransaccionController;
use App\Http\Controllers\Request\InformesController;
use Illuminate\Support\Facades\Route;


Route::get("/", [MainController::class, "login"]);
Route::post("autenticar/comprobar", [AutenticacionController::class, "validarUser"]);
Route::get('/logout', [AutenticacionController::class, "logout"]);
Route::get('/transaccion', [MainController::class, "registroTransaccion"]);
Route::middleware("authSession")->group(function () {
    Route::prefix("main")->group(function () {
        Route::get("dashboard", [MainController::class, "dashboard"]);
        Route::get("cargarAreas", [MainController::class, "cargarAreas"]);
        Route::get("cargargrupos", [MainController::class, "cargarGrupoHorarios"]);
        Route::get("cargarusuarios", [MainController::class, "cargarUsuarios"]);
        Route::get("informes", [MainController::class, "informes_general"]);

        Route::prefix("areas")->group(function () {
            Route::post("registrar", [AreasController::class, "crearArea"]);
            Route::post("modificar", [AreasController::class, "actualizarArea"]);
        });

        Route::prefix("grupos")->group(function () {
            Route::post("registrar", [GrupoHorariosController::class, "crearGrupo"]);
            Route::post("modificar", [GrupoHorariosController::class, "actualizarGrupo"]);
        });

        Route::prefix("usuarios")->group(function () {
            Route::post("registrar", [UsuariosController::class, "crear"]);
            Route::post("modificar", [UsuariosController::class, "actualizar"]);
        });

        Route::prefix("informes")->group(function () {
            Route::post("seguimiento", [InformesController::class, "horarios_general"]);
        });
    });
});

Route::prefix("acceso")->group(function () {
    Route::post("registrar", [TransaccionController::class, "crear"]);
});
//Route::get('/', function () {
//    return view('welcome');
//});
