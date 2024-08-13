@extends('layout.backoffice')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="m-2">
                        <h3 class="card-title">Informes</h3>
                    </div>
                    <div class="m-2" style="display: flex; justify-content: end; align-items: center; width: 100%;">
                        <button type="button" id="informe_general" style="background: #00d25c; color: white; padding: 4px; border: none; border-radius: 3px; font-size: 15px" data-general="1">Informe Completo</button>
                    </div>
                </div>
                <div class="card-body">
                    <form id="formulario-informes">
                        <label for="" class="form-label">Selecciona un Usuario</label>
                        <select name="id_usuario" id="id_usuario" class="form-select">
                            <option value="">Seleccione una Opcion</option>
                            @foreach($listaUsuarios as $usuario)
                                <option value="{{$usuario['id_usuario']}}">{{$usuario["nombre"]}}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="card-footer">
                    <button type="button" id="crear_informe" class="btn btn-sm btn-success">Crear Informe</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="resultadoInforme">
        </div>
    </div>

    <script>
        jQuery("#crear_informe").on("click", () => {
            mostrarLoader()
            axios.post("main/informes/seguimiento", jQuery("#formulario-informes").serializeObject()).then((resp) => {
                if (resp.data.error === "0") {
                    jQuery("#resultadoInforme").append(resp.data.data);
                }
            });
            ocultarLoader();
        });
    </script>
@endsection
