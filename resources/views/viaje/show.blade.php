@extends('layouts.app')

@section('template_title')
    {{ $viaje->name ?? "{{ __('Show') Viaje" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Consultar registro') }} Viaje</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('viajes.index') }}"> {{ __('Regresar') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Idviaje:</strong>
                            {{ $viaje->idViaje }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha del viaje:</strong>
                            {{ $viaje->FechaViaje }}
                        </div>
                        <div class="form-group">
                            <strong>Paradas:</strong>
                            {{ $viaje->Descripcion }}
                        </div>
                        <div class="form-group">
                            <strong>Origen:</strong>
                            {{ $viaje->Origen }}
                        </div>
                        <div class="form-group">
                            <strong>Destino:</strong>
                            {{ $viaje->Destino }}
                        </div>
                        <div class="form-group">
                            <strong>Disponibles:</strong>
                            {{ $viaje->Disponibles }}
                        </div>
                        <div class="form-group">
                            <strong>Autobus asignado:</strong>
                            {{ $viaje->id_autobus }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
