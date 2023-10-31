<div class="box box-info padding-1">
    <div class="box-body">
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="form-group">
            {{ Form::label('idViaje') }}
            {{ Form::text('idViaje', $viaje->idViaje, ['readonly' => $num != 0,'class' => 'form-control' . ($errors->has('idViaje') ? ' is-invalid' : ''), 'placeholder' => 'Idviaje']) }}
            {!! $errors->first('idViaje', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('FechaViaje') }}
            <div class="input-group">
                {{ Form::text('FechaViaje', $viaje->FechaViaje, ['class' => 'form-control date-time-picker' . ($errors->has('FechaViaje') ? ' is-invalid' : ''), 'placeholder' => 'Fechaviaje']) }}
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
            {!! $errors->first('FechaViaje', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Descripcion') }}
            {{ Form::text('Descripcion', $viaje->Descripcion, ['class' => 'form-control' . ($errors->has('Descripcion') ? ' is-invalid' : ''), 'placeholder' => 'Descripcion']) }}
            {!! $errors->first('Descripcion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Origen') }}
            {{ Form::text('Origen', $viaje->Origen, ['class' => 'form-control' . ($errors->has('Origen') ? ' is-invalid' : ''), 'placeholder' => 'Origen']) }}
            {!! $errors->first('Origen', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Destino') }}
            {{ Form::text('Destino', $viaje->Destino, ['class' => 'form-control' . ($errors->has('Destino') ? ' is-invalid' : ''), 'placeholder' => 'Destino']) }}
            {!! $errors->first('Destino', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('id_autobus') }}
            {{ Form::select('id_autobus',$autobus, $viaje->id_autobus, ['class' => 'form-control' . ($errors->has('id_autobus') ? ' is-invalid' : ''), 'placeholder' => 'Id Autobus']) }}
            {!! $errors->first('id_autobus', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
<br>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-success">{{ __('Enviar') }}</button>
        <a href="{{ route('viajes.index') }}" class="btn btn-primary">{{ __('Regresar') }}</a>
    </div>
</div>

<!-- Incluye jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Incluye datetimepicker -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>

<script>
    $(document).ready(function () {
        $('.date-time-picker').datetimepicker({
            format: 'Y-m-d H:i:s', // Formato de fecha y hora
            minDate: new Date(), // Fecha mínima
            step: 15, // Incremento de minutos
            
        });
    });
</script>
