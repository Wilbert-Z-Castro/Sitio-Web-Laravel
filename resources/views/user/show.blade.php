@extends('layouts.menubase')

@section('template_title')
    {{ $conductor->name ?? "{{ __('Show') Usuarios" }}
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
                            <strong>Id del usuario:</strong>
                            {{ $user->id }}
                        </div>
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $user->Nombre }}
                        </div>
                        <div class="form-group">
                            <strong>Email:</strong>
                            {{ $user->email }}
                        </div>
                        
                        <div class="form-group">
                            <strong>Rol:</strong>
                            {{ $user->Rol }}
                        </div>
                        

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
