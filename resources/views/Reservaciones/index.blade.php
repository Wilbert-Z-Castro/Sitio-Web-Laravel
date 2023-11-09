@extends('layouts.menubase')

@section('template_title')
    Viaje
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Viaje') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('viajes.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Hacer reservación') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-dark">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Idviaje</th>
										<th>Fecha del viaje</th>
										<th>Paradas</th>
										<th>Origen</th>
										<th>Destino</th>
										<th>Lugares disponibles</th>
										<th>Id Autobus</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- ->where('FechaViaje', '>=', Carbon\Carbon::now()) --> 
                                    @foreach ($viajes  as $viaje)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $viaje->idViaje }}</td>
											<td>{{ $viaje->FechaViaje }}</td>
											<td>{{ $viaje->Descripcion }}</td>
											<td>{{ $viaje->Origen }}</td>
											<td>{{ $viaje->Destino }}</td>
											<td>{{ $viaje->Disponibles }}</td>
											<td>{{ $viaje->id_autobus }}</td>

                                            <td>
                                                <form action="{{ route('viajes.destroy',$viaje->idViaje) }}" method="POST"> 
                                                <a class="btn btn-sm btn-primary " href="{{ route('reservaciones.create', ['idViaje' => $viaje->idViaje, 'Disponibles' => $viaje->Disponibles,'FechaViaje'=>$viaje->FechaViaje]) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Hacer Reservacion') }}</a>                                                    
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $viajes->links() !!}
            </div>
        </div>
    </div>
@endsection
