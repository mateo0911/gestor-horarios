@extends('layout.backoffice')
@section('content')
    <div class="row">
        <div class="col-6">
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
                        <input class="form-control hasDatepicker" id="fecha_inicio" value="<?= date("Y-m-d", strtotime(date("Y-m-d") . "- 1 month")); ?>" name="fecha_inicio" placeholder="Seleccione fecha" readonly="">
                        <input class="form-control hasDatepicker" id="fecha_limite" value="<?= date("Y-m-d"); ?>" name="fecha_limite" placeholder="Seleccione fecha" readonly="">
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
        <div class="col-6" id="resultadoHorasExtras"></div>
    </div>
    <div class="row">
        <div class="col-12" id="resultadoInforme"></div>
    </div>

    <script>

        jQuery("#fecha_inicio").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayBtn: false,
            pickerPosition: "bottom-left"
        });
        jQuery("#fecha_limite").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayBtn: false,
            pickerPosition: "bottom-left"
        });

        jQuery("#crear_informe").on("click", () => {
            mostrarLoader()
            axios.post("main/informes/seguimiento", jQuery("#formulario-informes").serializeObject()).then((resp) => {
                if (resp.data.error === "0") {
                    jQuery("#resultadoInforme").append(resp.data.data.informeGeneral);
                    jQuery("#resultadoHorasExtras").append(resp.data.data.informeCalculoHoras);
                    new DataTable('.tablaInformes', {
                        dom: 'QBfltipr'
                    });
                }
            });
            ocultarLoader();
        });
    </script>
@endsection
