@extends('layouts.menubase')

@section('template_title')
    {{ $conductor->name ?? "{{ __('Show') Conductor" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Consulta de registro') }} Conductor</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('conductors.index') }}"> {{ __('Regresar') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Idconductor:</strong>
                            {{ $conductor->idConductor }}
                        </div>
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $conductor->NomConductor }}
                        </div>
                        <div class="form-group">
                            <strong>Apellido:</strong>
                            {{ $conductor->ApeConductor }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha de ingreso:</strong>
                            {{ $conductor->Fechaingreso }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha de nacimiento:</strong>
                            {{ $conductor->FechaNa }}
                        </div>
                        <div class="form-group">
                            <strong>Genero:</strong>
                            {{ $conductor->Genero }}
                        </div>
                        <div class="form-group">
                            <strong>Telefono:</strong>
                            {{ $conductor->Telefono }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
