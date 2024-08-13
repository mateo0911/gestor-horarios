<?php
namespace App\Service;

use App\Models\Usuario;
use App\Models\Areas;
use Exception;

class SvcUsuario
{
    function getUsuarioByEmail($email)
    {
        try {
            $resultado = Usuario::select(
                "id_usuario",
                "nombre",
                "email",
                "clave",
                "documento",
                "rol",
                "estado",
                "registro_fecha"
            )->where("email", $email)
                ->get()
                ->first();

            if (!empty($resultado)) {
                return $resultado->toArray();
            }

            return [];
        } catch (Exception $e) {
            return [];
        }
    }

    function getUsuarios()
    {
        $resultado = [];
        try {
            $lista = Usuario::select(
                "id_usuario",
                "id_area",
                "nombre",
                "email",
                "clave",
                "documento",
                "rol",
                "estado",
                "registro_fecha")
                ->where("estado", "1")
                ->get();
            if (!empty($lista)) {
                $resultado = $lista->toArray();
            }
            return $resultado;
        } catch (Exception $e) {
            return [];
        }
    }

    function getUsuarioById($id)
    {
        try {
            $lista = Usuario::select(
                "id_usuario",
                "nombre",
                "email",
                "clave",
                "documento",
                "rol",
                "estado",
                "registro_fecha",
                "id_area"
            )
                ->where("id_usuario", $id)
                ->get()
                ->first();

            $data = $lista->toArray();

            return $data;
        } catch (Exception $e) {
            return [];
        }
    }

    function crear($data)
    {
        try {
            Usuario::create($data);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function actualizar($id, $data)
    {
        try {
            Usuario::where("id_usuario", $id)->update($data);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function getUserByDocumento($documento)
    {
        try {
            $lista = Usuario::select(
                "u.id_usuario",
                "u.nombre",
                "u.email",
                "u.clave",
                "u.documento",
                "u.rol",
                "a.estado",
                "u.registro_fecha",
                "u.id_area"
            )
                ->from("usuario AS u")
                ->join("areas AS a", "u.id_area", "=", "a.id_area")
                ->where("u.documento", $documento)
                ->first()
                ->toArray();
            if (!empty($lista)) {
                return $lista;
            }
            return [];
        } catch (Exception $e) {
            return [];
        }
    }
}

?>
