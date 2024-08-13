<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GESTOR DE HORARIOS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{URL::asset("app/js/utilidad.js")}}"></script>
    <script src="{{URL::asset("app/js/tilt.jquery.min.js")}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
</head>
<body class="hold-transition login-page">
<div id="loader_proceso" class="loader_proceso">
    <img style="margin: 20% 50%;" src="{{URL::asset('app/images/loader-main.gif')}}"/>
</div>
<div class="login-box">
    <div class="card row" id="card_login">
        <div class="card-body row">
            <div class="login100-pic js-tilt col-6" data-tilt id="imagen-izquierda">
                <img src="<?= URL::asset("app")?>/images/img-01.png" alt="IMG">
            </div>
            <div class="col-6" id="formulario-div">
                <form id="loging_form">
                    <h3 style="font-size: 20px; text-align: center; font-weight: bold; text-transform: uppercase; margin-bottom: 59px;">Inicio de Sesion</h3>
                    <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
                    <input type="email" name="email" class="form-control form-control-border form-control-sm input-formulario" placeholder="Email" autocomplete="off">
                    <input type="password" name="clave" id="clave" class="form-control form-control-border form-control-sm input-formulario" placeholder="Password" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <button type="button" id="btn_validar">Ingresar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    body {
        background: royalblue;
    }

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

    #card_login {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 55%;
        height: 70%;
        border-radius: 18px;
    }

    #imagen-izquierda {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #loging_form {
        width: 100%;
    }

    #loging_form input {
        width: 100%;
        margin-top: 15px;
        border: none;
        border-bottom: solid 3px darkblue;
        padding: 10px;
        height: 55px;
        background: transparent;
    }

    #loging_form input:focus {
        box-shadow: 0 0 10px 0 rgba(16, 117, 162, 0.8);
    }

    #formulario-div {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #btn_validar {
        border: none;
        margin-top: 50px;
        border-radius: 8px;
        padding: 8px;
        width: 100%;
        background: darkblue;
        color: white;
    }

    #btn_validar:hover {
        background: deepskyblue;
        transition: background 0.3s ease;
    }
</style>
</body>

<script>
    axios.defaults.baseURL = "{{ URL::asset('') }}";

    jQuery("#btn_validar").on("click", () => {
        mostrarLoader();
        axios.post("autenticar/comprobar", jQuery("#loging_form").serializeObject()).then(function (resp) {
            if (resp.data.error === 0) {
                window.location.href = "{{URL::asset("main/dashboard")}}"
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

    jQuery('.js-tilt').tilt({
        scale: 1.1
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</html>
