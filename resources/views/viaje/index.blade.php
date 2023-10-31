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
                                  {{ __('Create New') }}
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
										<th>Fechaviaje</th>
										<th>Descripcion</th>
										<th>Origen</th>
										<th>Destino</th>
										<th>Disponibles</th>
										<th>Id Autobus</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($viajes as $viaje)
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
                                                <form action="{{ route('viajes.destroy',$viaje->idViaje) }}" method="POST" class="eliminar-viajes-form" id="form-eliminar-{{ $viaje->idViaje }}">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('viajes.show',$viaje->idViaje) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('viajes.edit',$viaje->idViaje) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
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
@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success')=='Viaje deleted successfully')
    <script>
        Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
            )
    </script>
@endif
<script>
    // Escuchar el envío de los formularios de eliminación
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.eliminar-viajes-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Evita el envío del formulario por defecto

                const conductorId = this.getAttribute('id').replace('form-eliminar-', '');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Si se confirma la eliminación, envía el formulario
                        this.submit();
                    }
                });
            });
        });
    });
</script>




@endsection