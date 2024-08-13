<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';

    const CREATED_AT = null;
    const UPDATED_AT = null;
    protected $fillable = [
        "id_usuario",
        "id_area",
        "nombre",
        "email",
        "clave",
        "documento",
        "rol",
        "estado",
        "registro_fecha"
    ];
}
