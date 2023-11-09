@extends('layouts.menubase')

@section('template_title')
    {{ $autobu->name ?? "{{ __('Show') Autobu" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Consultar registro') }} Autobu</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('autobus.index') }}"> {{ __('Regresar') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Idautobus:</strong>
                            {{ $autobu->idAutobus }}
                        </div>
                        <div class="form-group">
                            <strong>Conductor:</strong>
                            {{ $autobu->id_Conductor }}
                        </div>
                        <div class="form-group">
                            <strong>Matricula:</strong>
                            {{ $autobu->Matricula }}
                        </div>
                        <div class="form-group">
                            <strong>Modelo:</strong>
                            {{ $autobu->Modelo }}
                        </div>
                        <div class="form-group">
                            <strong>Color:</strong>
                            {{ $autobu->Color }}
                        </div>
                        <div class="form-group">
                            <strong>Capacidad:</strong>
                            {{ $autobu->Capacidad }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
