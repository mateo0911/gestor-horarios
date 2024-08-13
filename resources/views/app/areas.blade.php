@extends('layout.backoffice')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="m-2">
                        <h3 class="card-title">Crear/Actualizar</h3>
                    </div>
                    <div class="m-2" style="display: flex; justify-content: end; align-items: center; width: 100%;">
                       <button type="button" style="background: #00d25c; color: white; padding: 4px; border: none; border-radius: 3px; font-size: 19px">Agregar Grupo <i class="fa-solid fa-plus fa-beat-fade"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <form id="formulario-areas" action="">
                        <input type="hidden" name="id_area" id="id_area" value="{{$areaById["id_area"] ?? ""}}">
                        <label for="exampleDataList" class="form-label">Nombre Area</label>
                        <input type="text" name="nombre_area" id="nombre_area" class="form-control" value="{{$areaById["nombre_area"] ?? ""}}" placeholder="digite el nombre de la area">

                        <div class="row" id="id-grupos-horarios">
                            <select name="grupos_horarios" id="grupo_horario">
                                <option value="">Seleccione Opcion</option>
                                @foreach($listaGrupos as $grupo)

                                @endforeach
                            </select>
                        </div>

                        <label for="exampleDataList" class="form-label">Estado</label>
                        <?php if (!empty($areaById["estado"])) { ?>
                        <select name="estado_area" id="estado_area" class="form-select">
                            <option value="<?= $areaById["estado"]?>">{{$areaById["estado"] == "1" ? "Activa" : "Inactiva"}}</option>
                            <option value="<?= $areaById["estado"] == "1" ? "0" : "1"?>">{{$areaById["estado"] == "1" ? "Inactiva" : "Activa"}}</option>
                        </select>
                        <?php } else { ?>
                        <select name="estado_area" id="estado_area" class="form-select">
                            <option value="">Seleccione Una Opcion</option>
                            <option value="1">Activa</option>
                            <option value="0">Inactiva</option>
                        </select>
                        <?php } ?>
                    </form>
                </div>
                <div class="card-footer">
                    <?php if (!empty($areaById["id_area"])) { ?>
                    <button type="button" class="btn btn-primary" id="actualizar_area">Actualizar</button>
                    <?php } else { ?>
                    <button type="button" class="btn btn-primary" id="crear_area">Crear</button>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Areas Actuales
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-striped table-hover cf dinamyc-table">
                        <thead>
                        <tr>
                            <th>Detallar</th>
                            <th>Nombre Area</th>
                            <th>Fecha Registro</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($listaAreas as $area) { ?>
                        <tr>
                            <td>
                                <a href="<?= URL::asset('main/cargarAreas?id_area=') . $area["id_area"]?>">
                                    <button type="button" class="btn btn-primary btn-sm btn-flat">Detallar</button>
                                </a>
                            </td>
                            <td>{{$area["nombre_area"]}}</td>
                            <td>{{$area["registro_area"]}}</td>
                            <td>{{$area["estado"] == 1 ? "Activo" : "Inactivo" }}</td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        jQuery("#crear_area").on("click", () => {
            mostrarLoader()
            axios.post("main/areas/registrar", jQuery("#formulario-areas").serializeObject()).then((resp) => {
                if (resp.data.error === 0) {
                    Swal.fire({
                        title: "Exito",
                        text: "Area Creada Con Exito",
                        icon: "success"
                    }).then((resp)=> {
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

        jQuery("#actualizar_area").on("click", () => {
            mostrarLoader()
            axios.post("main/areas/modificar", jQuery("#formulario-areas").serializeObject()).then((resp) => {
                if (resp.data.error === 0) {
                    Swal.fire({
                        title: "Exito",
                        text: "Area Modificada Con Exito",
                        icon: "success"
                    }).then((resp)=> {
                        if (resp.isConfirmed) {
                            location.reload();
                        }
                    });;
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
