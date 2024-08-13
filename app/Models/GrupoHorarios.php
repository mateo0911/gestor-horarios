<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class GrupoHorarios extends Model
{
    use HasFactory;

    protected $table = 'grupo_horarios';
    protected $primaryKey = 'id_grupo_horario';

    const CREATED_AT = null;
    const UPDATED_AT = null;
    protected $fillable = [
        "id_grupo_horario",
        "id_area",
        "descripcion",
        "horario_inicio",
        "horario_cierre",
        "estado"
    ];
}
