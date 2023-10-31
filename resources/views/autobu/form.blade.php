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
            {{ Form::label('idAutobus') }}
            
                {{ Form::number('idAutobus', $autobu->idAutobus, ['readonly' => $num != 0,'class' => 'form-control' . ($errors->has('idAutobus') ? ' is-invalid' : ''), 'placeholder' => 'Idautobus']) }}
            {!! $errors->first('idAutobus', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        
        <div class="form-group">
            {{ Form::label('id_Conductor') }}
            {{ Form::select('id_Conductor',$conductor , $autobu->id_Conductor, ['class' => 'form-control' . ($errors->has('id_Conductor') ? ' is-invalid' : ''), 'placeholder' => 'Id Conductor']) }}
            {!! $errors->first('id_Conductor', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Matricula') }}
            {{ Form::text('Matricula', $autobu->Matricula, ['class' => 'form-control' . ($errors->has('Matricula') ? ' is-invalid' : ''), 'placeholder' => 'Matricula']) }}
            {!! $errors->first('Matricula', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Modelo') }}
            {{ Form::text('Modelo', $autobu->Modelo, ['class' => 'form-control' . ($errors->has('Modelo') ? ' is-invalid' : ''), 'placeholder' => 'Modelo']) }}
            {!! $errors->first('Modelo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Color') }}
            {{ Form::text('Color', $autobu->Color, ['class' => 'form-control' . ($errors->has('Color') ? ' is-invalid' : ''), 'placeholder' => 'Color']) }}
            {!! $errors->first('Color', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Capacidad') }}
            {{ Form::text('Capacidad', $autobu->Capacidad, ['class' => 'form-control' . ($errors->has('Capacidad') ? ' is-invalid' : ''), 'placeholder' => 'Capacidad']) }}
            {!! $errors->first('Capacidad', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <br>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-success">{{ __('Enviar') }}</button>
        <a href="{{ route('autobus.index') }}" class="btn btn-primary">{{ __('Regresar') }}</a>
    </div>
</div>