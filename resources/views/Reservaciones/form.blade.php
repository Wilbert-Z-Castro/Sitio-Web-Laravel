<div class="box box-info padding-1">
    <div class="box-body">
        
        <br>
        
        <div class="form-group">
            {{ Form::label('Cantidad') }}
            {{ Form::text('Cantidad', $boleto->Cantidad, ['class' => 'form-control' . ($errors->has('Cantidad') ? ' is-invalid' : ''), 'placeholder' => 'Cantidad']) }}
            {!! $errors->first('Cantidad', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        
        <div class="form-group">
            {{ Form::label('id_viaje') }}
            {{ Form::text('id_viaje',$idViaje, ['readonly','class' => 'form-control' . ($errors->has('id_viaje') ? ' is-invalid' : ''), 'placeholder' => 'Id Viaje']) }}
            {!! $errors->first('id_viaje', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Numero de asientos Diponibles') }}
            {{ Form::text('Disponibles',$Disponibles, ['readonly','class' => 'form-control' . ($errors->has('id_viaje') ? ' is-invalid' : ''), 'placeholder' => 'Id Viaje']) }}
            {!! $errors->first('Disponibles', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Fecha y hora del viaje') }}
            {{ Form::text('viaje',$FechaViaje, ['readonly','class' => 'form-control' . ($errors->has('id_viaje') ? ' is-invalid' : ''), 'placeholder' => 'Id Viaje']) }}
            {!! $errors->first('viaje', '<div class="invalid-feedback">:message</div>') !!}
        </div>
<br>
    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-success">{{ __('Reservar') }}</button>
        <a href="{{ route('reservaciones.index') }}" class="btn btn-primary">{{ __('Regresar') }}</a>
    </div>
</div>