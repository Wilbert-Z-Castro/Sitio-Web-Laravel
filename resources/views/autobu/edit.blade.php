@extends('layouts.menubase')

@section('template_title')
    {{ __('Update') }} Autobu
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Autobu</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('autobus.update', $autobu->idAutobus) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('autobu.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
