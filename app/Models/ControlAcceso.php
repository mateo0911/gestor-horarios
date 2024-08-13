<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class  ControlAcceso extends Model
{
    use HasFactory;

    protected $table = 'control_acceso';
    protected $primaryKey = 'id_control_acceso';

    const CREATED_AT = null;
    const UPDATED_AT = null;
    protected $fillable = [
        "id_control_acceso",
        "id_usuario",
        "registro_acceso",
    ];
}
