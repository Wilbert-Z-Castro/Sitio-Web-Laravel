@extends('layouts.menubase')

@section('template_title')
    Conductor
@endsection 
@section('content')
    <div class="containe r-fluid">
        <div class="row">
            <div class="col-sm-12">
                <form action="{{route('conductors.index')}}" method="get">
                    <div class="form row">
                    <label for="">Busqueda por ID</label>
                        <div class="col-sm-4 my-1">
                            
                            <input type="text" class="form-control" name="texto">
                        </div>
                        <div class="col-auto my-1">
                            <input type="submit" class="btn btn-primary" value="Buscar">
                        </div>
                    </div>

                </form>
                <br>
            </div>
            <br>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                               Conductores
                            </span>

                             <div class="float-right">
                             <a href="{{ route('conductores.pdf') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('PDF') }}
                                </a>
                                <a href="{{ route('conductors.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
										<th>Idconductor</th>
										<th>Nomconductor</th>
										<th>Apeconductor</th>
										<th>Fechaingreso</th>
										<th>Fechana</th>
										<th>Genero</th>
										<th>Telefono</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($conductors as $conductor)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $conductor->idConductor }}</td>
											<td>{{ $conductor->NomConductor }}</td>
											<td>{{ $conductor->ApeConductor }}</td>
											<td>{{ $conductor->Fechaingreso }}</td>
											<td>{{ $conductor->FechaNa }}</td>
                                            <td>{{ $conductor->Genero }}</td>                                        
											<td>{{ $conductor->Telefono }}</td>

                                            <td>
                                                <form action="{{ route('conductors.destroy',$conductor->idConductor) }}" method="POST" class="eliminar-conductor-form" id="form-eliminar-{{ $conductor->idConductor }}" >
                                                    <a class="btn btn-sm btn-primary " href="{{ route('conductors.show',$conductor->idConductor) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('conductors.edit',$conductor->idConductor) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button  type="submit" class="btn btn-danger btn-sm eliminar-conductor"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
               <br>
            </div>
        </div>
        <div class="d-flex justify-content-end">
                {!! $conductors->links() !!}
        </div>
    </div>
    
@endsection 
@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success')=='Conductor deleted successfully')
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
        const deleteForms = document.querySelectorAll('.eliminar-conductor-form');

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