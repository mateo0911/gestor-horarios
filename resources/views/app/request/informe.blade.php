<section class="card">
    <div class="card-header">
        Informe General usuario <?= $nombre_usuario ?>
    </div>
    <div class="card-body">
        <div class="row">

            <div class="col-12">


                <table class="display table table-bordered table-striped table-condensed tablaInformes">
                    <thead>
                    <tr>
                        <th>Nombre Usuario</th>
                        <th>Email Usuario</th>
                        <th>Documento Usuario</th>
                        <th>Estado Usuario</th>
                        <th>Fecha Registro Codigo Usuario</th>
                        <th>Hora Registro Codigo Usuario</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($informe as $key => $valor)
                        @foreach($valor["registros_generales"] as $campo)
                            <tr>
                                <td>{{$campo["nombre"]}}</td>
                                <td>{{$campo["email"]}}</td>
                                <td>{{$campo["documento"]}}</td>
                                <td>{{$campo["estado"]}}</td>
                                <td>{{date("Y-m-d", strtotime($campo["registro_acceso"]))}}</td>
                                <td>{{date("H:i:s", strtotime($campo["registro_acceso"]))}}</td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
