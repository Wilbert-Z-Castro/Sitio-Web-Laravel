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
            {{ Form::label('idConductor') }}
            {{ Form::number('idConductor', $conductor->idConductor, ['readonly' => $num1 != 0,'class' => 'form-control' . ($errors->has('idConductor') ? ' is-invalid' : ''), 'placeholder' => 'Id del Conductor']) }}
            {!! $errors->first('idConductor', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Nombre') }}
            {{ Form::text('NomConductor', $conductor->NomConductor, ['class' => 'form-control' . ($errors->has('NomConductor') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            {!! $errors->first('NomConductor', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Apellido') }}
            {{ Form::text('ApeConductor', $conductor->ApeConductor, ['class' => 'form-control' . ($errors->has('ApeConductor') ? ' is-invalid' : ''), 'placeholder' => 'Apeconductor']) }}
            {!! $errors->first('ApeConductor', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Fecha de nacimiento') }}
            {{ Form::date('FechaNa', $conductor->FechaNa, ['class' => 'form-control' . ($errors->has('FechaNa') ? ' is-invalid' : ''), 'placeholder' => 'Fechana']) }}
            {!! $errors->first('FechaNa', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Genero') }}
            
            {{ Form::select('Genero', [
                'Hombre' => 'Hombre',
                'Mujer' => 'Mujer',
                'Otro' => 'Otro',
            ], $conductor->Genero, ['class' => 'form-control' . ($errors->has('Genero') ? ' is-invalid' : ''), 'placeholder' => 'Genero']) }}
            
            {!! $errors->first('Genero', '<div class="invalid-feedback">:message</div>') !!}
            
        </div>
        <div class="form-group">
            {{ Form::label('Telefono') }}
            {{ Form::text('Telefono', $conductor->Telefono, ['class' => 'form-control' . ($errors->has('Telefono') ? ' is-invalid' : ''), 'placeholder' => 'Telefono']) }}
            {!! $errors->first('Telefono', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <br>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-success">{{ __('Enviar') }}</button>
        <a href="{{ route('conductors.index') }}" class="btn btn-primary">{{ __('Regresar') }}</a>
    </div>
</div>