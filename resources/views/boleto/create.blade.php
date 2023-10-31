@extends('layouts.menubase')

@section('template_title')
    {{ __('Confirmación de datos del ') }} Boleto
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Confirmación de datos del Boleto</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('boletos.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('boleto.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
