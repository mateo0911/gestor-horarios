@extends('layout.backoffice')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Crear/Actualizar</h3>
                </div>
                <div class="card-body">
                    <form id="formulario-grupos" action="">
                        <div class="row pt-2">
                            <input type="hidden" name="id_grupo" id="id_grupo" value="{{$grupoById["id_grupo_horario"] ?? ""}}">
                            <div class="col-12">
                                <label for="exampleDataList" class="form-label">Descripcion (almuerzo, desayuno, entrada, salida)</label>
                                <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{$grupoById["descripcion"] ?? ""}}" placeholder="Digite la descripcion del grupo">
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col-6">
                                <label for="exampleDataList" class="form-label">Hora Inicio</label>
                                <select name="hora_inicio" id="hora_inicio" class="form-select">
                                    <option value="{{!empty($grupoById["hora_inicio"]) ? $grupoById["hora_inicio"] : ""}}">{{!empty($grupoById["hora_inicio"]) ? $grupoById["hora_inicio"] : "Seleccione una hora"}}</option>
                                    <?php for ($i = 0;
                                               $i <= 24;
                                               $i++) { ?>
                                    <option value="{{$i}}">{{$i}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="exampleDataList" class="form-label">Minutos Inicio</label>
                                <select name="minuto_inicio" id="minuto_inicio" class="form-select">
                                    <option value="{{!empty($grupoById["minuto_inicio"]) ? $grupoById["minuto_inicio"] : ""}}">{{!empty($grupoById["minuto_inicio"]) ? $grupoById["minuto_inicio"] : "Seleccione los minutos"}}</option>
                                    <?php for ($j = 0;
                                               $j <= 55;
                                               $j += 5) { ?>
                                    <option value="{{$j}}">{{$j}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col-6">
                                <label for="exampleDataList" class="form-label">Hora Cierre</label>
                                <select name="hora_cierre" id="hora_cierre" class="form-select">
                                    <option value="{{!empty($grupoById["hora_cierre"]) ? $grupoById["hora_cierre"] : ""}}">{{!empty($grupoById["hora_cierre"]) ? $grupoById["hora_cierre"] : "Seleccione una hora"}}</option>
                                    <?php for ($i = 0;
                                               $i <= 24;
                                               $i++) { ?>
                                    <option value="{{$i}}">{{$i}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="exampleDataList" class="form-label">Minutos Cierre</label>
                                <select name="minuto_cierre" id="minuto_cierre" class="form-select">
                                    <option value="{{!empty($grupoById["minuto_cierre"]) ? $grupoById["minuto_cierre"] : ""}}">{{!empty($grupoById["minuto_cierre"]) ? $grupoById["minuto_cierre"] : "Seleccione los minutos"}}</option>
                                    <?php for ($j = 0;
                                               $j <= 55;
                                               $j += 5) { ?>
                                    <option value="{{$j}}">{{$j}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col-12">
                                <label for="exampleDataList" class="form-label">Estado</label>
                                <?php if (!empty($grupoById["estado"])) { ?>
                                <select name="estado_grupo" id="estado_grupo" class="form-select">
                                    <option value="<?= $grupoById["estado"]?>">{{$grupoById["estado"] == "1" ? "Activo" : "Inactivo"}}</option>
                                    <option value="<?= $grupoById["estado"] == "1" ? "0" : "1"?>">{{$grupoById["estado"] == "1" ? "Inactivo" : "Activo"}}</option>
                                </select>
                                <?php } else { ?>
                                <select name="estado_grupo" id="estado_grupo" class="form-select">
                                    <option value="">Seleccione Una Opcion</option>
                                    <option value="1">Activa</option>
                                    <option value="0">Inactiva</option>
                                </select>
                                <?php } ?>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <?php if (!empty($grupoById["id_grupo_horario"])) { ?>
                    <button type="button" class="btn btn-primary" id="actualizar_grupo">Actualizar</button>
                    <?php } else { ?>
                    <button type="button" class="btn btn-primary" id="crear_grupo">Crear</button>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Grupos Actuales
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-striped table-hover cf dinamyc-table">
                        <thead>
                        <tr>
                            <th>Detallar</th>
                            <th>Descripcion Grupo</th>
                            <th>Inicio</th>
                            <th>Cierre</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($listaGrupos as $grupo) { ?>
                        <tr>
                            <td>
                                <a href="<?= URL::asset('main/cargargrupos?id_grupo_horario=') . $grupo["id_grupo_horario"]?>">
                                    <button type="button" class="btn btn-primary btn-sm">Detallar</button>
                                </a>
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm">{{$grupo["descripcion"]}}</button>
                            </td>
                            <td>{{$grupo["horario_inicio"]}}</td>
                            <td>{{$grupo["horario_cierre"]}}</td>
                            <td>{{$grupo["estado"] == 1 ? "Activo" : "Inactivo" }}</td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        jQuery("#crear_grupo").on("click", () => {
            mostrarLoader()
            axios.post("main/grupos/modificar", jQuery("#formulario-grupos").serializeObject()).then((resp) => {
                if (resp.data.error === 0) {
                    Swal.fire({
                        title: "Exito",
                        text: "Grupo Creado Con Exito",
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

        jQuery("#actualizar_grupo").on("click", () => {
            mostrarLoader()
            axios.post("main/grupos/modificar", jQuery("#formulario-grupos").serializeObject()).then((resp) => {
                if (resp.data.error === 0) {
                    Swal.fire({
                        title: "Exito",
                        text: "Grupo Modificado Con Exito",
                        icon: "success"
                    }).then((resp) => {
                        if (resp.isConfirmed) {
                            location.reload();
                        }
                    });
                    ;
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
