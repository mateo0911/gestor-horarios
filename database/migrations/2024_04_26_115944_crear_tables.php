<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \DB::unprepared("CREATE TABLE `usuario`
            (`id_usuario` INT NOT NULL AUTO_INCREMENT
            , `nombre` VARCHAR(500) NOT NULL
            , `email` VARCHAR(100) NOT NULL
            , `clave` VARCHAR(500) NOT NULL
            , `documento` VARCHAR(50) NOT NULL
            , `rol` VARCHAR(100) NOT NULL
            , `estado` VARCHAR(1) NOT NULL
            , `registro_fecha` DATETIME NOT NULL
            , PRIMARY KEY (`id_usuario`)) ENGINE = InnoDB;");

        \DB::unprepared("CREATE TABLE `areas`
            (`id_area` INT NOT NULL AUTO_INCREMENT
            , `nombre_area` VARCHAR(500) NOT NULL
            , `estado` VARCHAR(500) NOT NULL
            , `registro_area` DATETIME NOT NULL
            , PRIMARY KEY (`id_area`)) ENGINE = InnoDB;");

        \DB::unprepared("CREATE TABLE `grupo_horarios`
            (`id_grupo_horario` INT NOT NULL AUTO_INCREMENT
            ,`id_area` INT NULL
            , `descripcion` VARCHAR(500) NOT NULL
            , `horario_inicio` DATETIME NOT NULL
            , `horario_cierre` DATETIME NOT NULL
            , `estado` VARCHAR(1) NOT NULL
            , PRIMARY KEY (`id_grupo_horario`)) ENGINE = InnoDB;");

        \DB::unprepared("CREATE TABLE `control_acceso`
            (`id_control_acceso` INT NOT NULL AUTO_INCREMENT
            , `id_usuario` INT(11) NULL
            , `id_grupo_horario` VARCHAR(200) NULL
            , `registro_acceso` DATETIME NOT NULL
            , PRIMARY KEY (`id_control_acceso`)) ENGINE = InnoDB;");

        \DB::unprepared("ALTER TABLE control_acceso ADD FOREIGN KEY (`id_usuario`) REFERENCES usuario(id_usuario)");
        \DB::unprepared("ALTER TABLE grupo_horarios ADD FOREIGN KEY (`id_area`) REFERENCES areas(id_area)");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::unprepared("DROP TABLE usuario");
        \DB::unprepared("DROP TABLE areas");
        \DB::unprepared("DROP TABLE grupo_horarios");
        \DB::unprepared("DROP TABLE control_acceso");
    }
};
