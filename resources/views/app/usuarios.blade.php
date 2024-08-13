@extends('layout.backoffice')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Crear/Actualizar</h3>
                </div>
                <div class="card-body">
                    <form id="formulario-usuarios" action="">
                        <div class="row pt-2">
                            <input type="hidden" name="id_usuario" id="id_usuario" value="{{$usuaroById["id_usuario"] ?? ""}}">
                            <div class="col-12">
                                <label for="exampleDataList" class="form-label">Nombre</label>
                                <input type="text" name="nombre_usuario" id="nombre_usuario" class="form-control" value="{{$usuaroById["nombre"] ?? ""}}" placeholder="Digite el nombre de usuario">
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col-6">
                                <label for="exampleDataList" class="form-label">Email</label>
                                <input type="text" name="email_usuario" id="email_usuario" class="form-control" value="{{$usuaroById["email"] ?? ""}}" placeholder="Digite el email de usuario">
                            </div>
                            <div class="col-6">
                                <label for="exampleDataList" class="form-label">Clave</label>
                                <input type="text" name="clave_usuario" id="clave_usuario" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col-6">
                                <label for="exampleDataList" class="form-label">Documento</label>
                                <input type="text" name="documento_usuario" id="documento_usuario" class="form-control" value="{{$usuaroById["documento"] ?? ""}}" placeholder="Digite el documento del usuario">
                            </div>
                            <div class="col-6">
                                <label for="exampleDataList" class="form-label">Rol</label>
                                <select name="rol_usuario" id="rol_usuario" class="form-select">
                                    <option value="">Seleccione un rol</option>
                                    <option value="ADMINISTRADOR">Administrador</option>
                                </select>
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col-12">
                                <label for="exampleDataList" class="form-label">Area Asignar</label>
                                <select name="id_area" id="id_area" class="form-select">
                                    <option value="">Selecciona Alguna Opcion</option>
                                    @foreach($listaAreas as $area)
                                        <option value="{{$area["id_area"]}}">{{$area["nombre_area"]}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col-12">
                                <label for="exampleDataList" class="form-label">Estado</label>
                                <?php if (!empty($usuaroById["estado"])) { ?>
                                <select name="estado_usuario" id="estado_usuario" class="form-select">
                                    <option value="<?= $usuaroById["estado"]?>">{{$usuaroById["estado"] == "1" ? "Activo" : "Inactivo"}}</option>
                                    <option value="<?= $usuaroById["estado"] == "1" ? "0" : "1"?>">{{$usuaroById["estado"] == "1" ? "Inactivo" : "Activo"}}</option>
                                </select>
                                <?php } else { ?>
                                <select name="estado_usuario" id="estado_usuario" class="form-select">
                                    <option value="">Seleccione Una Opcion</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                                <?php } ?>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <?php if (!empty($usuaroById["id_usuario"])) { ?>
                    <button type="button" class="btn btn-primary" id="actualizar_usuario">Actualizar</button>
                    <?php } else { ?>
                    <button type="button" class="btn btn-primary" id="crear_usuario">Crear</button>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Usuarios Actuales
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-striped table-hover cf dinamyc-table">
                        <thead>
                        <tr>
                            <th>Detallar</th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Fecha de Registro</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($listaUsuarios as $usuario) { ?>
                        <tr>
                            <td>
                                <a href="<?= URL::asset('main/cargarusuarios?id_usuario=') . $usuario["id_usuario"]?>">
                                    <button type="button" class="btn btn-primary btn-sm">Detallar</button>
                                </a>
                            </td>
                            <td>{{$usuario["nombre"]}}</button></td>
                            <td>{{$usuario["documento"]}}</td>
                            <td>{{$usuario["email"]}}</td>
                            <td>{{$usuario["rol"]}}</td>
                            <td>{{$usuario["registro_fecha"]}}</td>
                            <td>{{$usuario["estado"] == 1 ? "Activo" : "Inactivo" }}</td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        jQuery("#crear_usuario").on("click", () => {
            mostrarLoader()
            axios.post("main/usuarios/registrar", jQuery("#formulario-usuarios").serializeObject()).then((resp) => {
                if (resp.data.error === 0) {
                    Swal.fire({
                        title: "Exito",
                        text: "Usuario Creado Con Exito",
                        icon: "success"
                    }).then((resp) => {
                        if (resp.isConfirmed) {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: resp.data.mensaje,
                        icon: "error"
                    });
                }
            });
            ocultarLoader();
        });

        jQuery("#actualizar_usuario").on("click", () => {
            mostrarLoader()
            axios.post("main/usuarios/modificar", jQuery("#formulario-usuarios").serializeObject()).then((resp) => {
                if (resp.data.error === 0) {
                    Swal.fire({
                        title: "Exito",
                        text: "Usuario Modificado Con Exito",
                        icon: "success"
                    }).then((resp) => {
                        if (resp.isConfirmed) {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: resp.data.mensaje,
                        icon: "error"
                    });
                }
            });
            ocultarLoader();
        });
    </script>
@endsection
