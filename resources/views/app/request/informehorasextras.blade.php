<section class="card">
    <div class="card-header">
        Informe Horas
    </div>
    <div class="card-body">
        <table class="display table table-bordered table-striped table-condensed tablaInformes">
            <thead>
            <tr>
                <th>Fecha y Hora Registro</th>
                <th>Horas Extra</th>
                <th>Horas Perdidas</th>
                <th>Horas Trabajadas</th>
                <th>Registros Realizados</th>
            </tr>
            </thead>
            <tbody>
            @foreach($informe as $fecha => $valor)
                <tr>
                    <td>{{$fecha}}</td>
                    <td>{{$valor["horas_extras"]}}</td>
                    <td>{{$valor["horas_perdidas"]}}</td>
                    <td>{{$valor["horas_trabajadas"]}}</td>
                    <td>{{$valor["total_registros_por_dia"]}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</section>
