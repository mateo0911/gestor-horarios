<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GESTOR DE HORARIOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="{{URL::asset('app/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('app/css/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('app/css/datetimepicker.css') }}">
    <link rel="stylesheet" href="{{URL::asset('app/fontawesome-free/css/all.min.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>

    {{-- Data tables --}}
    <script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/jszip/jszip.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="{{URL::asset("app/js/utilidad.js")}}"></script>
    <script src="{{ URL::asset('app/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ URL::asset('app/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{URL::asset("app/js/tilt.jquery.min.js")}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
</head>
<body class="hold-transition layout-top-nav" style="background: #8dc2d0">
<div id="loader_proceso" class="loader_proceso">
    <img style="margin: 25% 50%;" src="{{URL::asset('app/images/loader-main.gif')}}"/>
</div>
<div class="container">
    <div class="card row" id="transaccion-card">
        <h4>Registro Transaccion</h4>
        <div id="formulario_transaccion">
            <form id="transaccion" style="width: 58%;">
                <label for="" class="form-label d-block">Digite su cedula</label>
                <input type="text" name="documento" id="documento" class="form-control form-icon d-block">
                <button type="button" id="registrar_transaccion" class="btn btn-primary btn-lg">Registrar</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
<script>
    axios.defaults.baseURL = "{{ URL::asset('') }}";

    jQuery("#registrar_transaccion").on("click", () => {
        axios.post("acceso/registrar", jQuery("#transaccion").serializeObject()).then((resp) => {
            console.log(resp);
            if (resp.data.error == 0) {
                Swal.fire({
                    title: "Registro Exitoso",
                    text: resp.data.mensaje,
                    icon: "success"
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: resp.data.mensaje,
                    icon: "error"
                });
            }
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="{{ URL::asset('app/js/adminlte.min.js') }}"></script>
<style>
    .loader_proceso {
        display: none;
        background: #000;
        position: fixed;
        height: 100%;
        width: 100%;
        top: 0;
        left: 0;
        z-index: 10000;
        opacity: 0.5
    }

    #transaccion-card {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 25%;
        height: 30%;
        border-radius: 18px;
    }

    #formulario_transaccion {
        position: fixed;
        top: 30%;
        width: 100%;
        display: flex;
        justify-content: center;
    }

    #formulario_transaccion input {
        margin-top: 10px;
    }

    #transaccion-card label {
        font-size: 18px;
        font-weight: bold;
        display: flex;
        align-content: end;
        margin-top: 10px;
    }

    #transaccion-card h4 {
        font-size: 30px;
        font-weight: bold;
        margin-top: 10px;
        display: flex;
        justify-content: center;
    }

    #registrar_transaccion {
        width: 100%;
        margin-top: 58px;
        text-transform: uppercase;
        box-shadow: 0 0 10px 0 rgba(16, 117, 162, 0.8);
    }
</style>

