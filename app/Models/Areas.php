<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Areas extends Model
{
    use HasFactory;

    protected $table = 'areas';
    protected $primaryKey = 'id_area';

    const CREATED_AT = null;
    const UPDATED_AT = null;
    protected $fillable = [
        "id_area",
        "nombre_area",
        "estado",
        "registro_area"
    ];
}
