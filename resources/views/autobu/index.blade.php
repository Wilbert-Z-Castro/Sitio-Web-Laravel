@extends('layouts.menubase')

@section('template_title')
    Autobu
@endsection
  
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Gestión de autobuces') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('autobus.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Nuevo registro') }}
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
                                        
										<th>Idautobus</th>
										<th>Id Conductor</th>
										<th>Matricula</th>
										<th>Modelo</th>
										<th>Color</th>
										<th>Capacidad</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($autobus as $autobu)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $autobu->idAutobus }}</td>
											<td>{{ $autobu->id_Conductor }}</td>
											<td>{{ $autobu->Matricula }}</td>
											<td>{{ $autobu->Modelo }}</td>
											<td>{{ $autobu->Color }}</td>
											<td>{{ $autobu->Capacidad }}</td>

                                            <td>
                                                <form action="{{ route('autobus.destroy',$autobu->idAutobus) }}" method="POST"  class="eliminar-autobus-form" id="form-eliminar-{{ $autobu->idAutobus }}">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('autobus.show',$autobu->idAutobus) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('autobus.edit',$autobu->idAutobus) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm eliminar-autobus"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $autobus->links() !!}
            </div>
        </div>
    </div>
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success')=='Autobu deleted successfully')
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
        const deleteForms = document.querySelectorAll('.eliminar-autobus-form');

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