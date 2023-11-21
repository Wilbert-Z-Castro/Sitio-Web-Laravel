@extends('layouts.menubase')

@section('template_title')
    Conductor
@endsection 
@section('content')
    <div class="containe r-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                               Usuarios
                            </span>

                             <div class="float-right">
                                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                        <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        
										<th>id</th>
										<th>Nombre</th>
										<th>Apellido</th>
										<th>email</th>
										<th>Rol</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $user->id }}</td>
											<td>{{ $user->Nombre }}</td>
											<td>{{ $user->Apellido }}</td>
											<td>{{ $user->email }}</td>
											<td>{{ $user->Rol }}</td>
                                            <td>
                                                <form action="{{ route('users.destroy',$user->id) }}" method="POST" class="eliminar-usuario-form" id="form-eliminar-{{ $user->id }}">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('users.show',$user->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('users.edit',$user->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button  type="submit" class="btn btn-danger btn-sm "><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $users->links() !!}
            </div>
        </div>
    </div>
@endsection 
@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success')=='User deleted successfully')
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
        const deleteForms = document.querySelectorAll('.eliminar-usuario-form');

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

