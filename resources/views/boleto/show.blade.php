@extends('layouts.menubase')

@section('template_title')
    {{ $boleto->name ?? "{{ __('Show') Boleto" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Datos del ') }} Boleto</span>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Idboleto:</strong>
                            {{ $boleto->idBoleto }}
                        </div>
                        <div class="form-group">
                            <strong>Fechaboleto:</strong>
                            {{ $boleto->FechaBoleto }}
                        </div>
                        <div class="form-group">
                            <strong>Cantidad:</strong>
                            {{ $boleto->Cantidad }}
                        </div>
                        <div class="form-group">
                            <strong>Id Viaje:</strong>
                            {{ $boleto->id_viaje }}
                        </div>
                        <div class="form-group">
                            <strong>Id User/Nombre:</strong>
                            {{ $boleto->id_user }}
                            @foreach($user as $use)
                            @if($use->id == $boleto->id_user)
							{{ $use->Nombre }}
                            @endif
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
