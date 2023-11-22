@extends('layouts.menubase')

@section('template_title')
    Boleto
@endsection
 
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <form action="{{route('boletos.index')}}" method="get">
                    <div class="form row">
                    <label for="">Búsqueda por ID </label>
                        <div class="col-sm-4 my-1">
                            <input type="text" class="form-control" name="texto">
                        </div>
                        <div class="col-auto my-1">
                            <input type="submit" class="btn btn-primary" value="Buscar">
                            <input type="submit" class="btn btn-primary" value="Reiniciar">
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
                                {{ __('Gestión de Boletos') }}
                            </span>

                             <div class="float-right">
                             <a href="{{ route('Boletos.pdf') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Reporte PDF') }}
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
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Idboleto</th>
										<th>Fecha del boleto</th>
										<th>Cantidad</th>
										<th>Id Viaje</th>
										<th>Usuario</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($boletos as $boleto)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $boleto->idBoleto }}</td>
											<td>{{ $boleto->FechaBoleto }}</td>
											<td>{{ $boleto->Cantidad }}</td>
											<td>{{ $boleto->id_viaje }}</td>
                                            @foreach($user as $use)
                                            @if($use->id == $boleto->id_user)
											<td>{{ $use->Nombre }}</td>
                                            @endif
                                            @endforeach
                                            <td>
                                                <form action="{{ route('boletos.destroy',$boleto->idBoleto) }}" method="POST" class="eliminar-boletos-form" id="form-eliminar-{{ $boleto->idBoleto }}">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('boletos.show',$boleto->idBoleto) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('boletos.edit',$boleto->idBoleto) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $boletos->links() !!}
            </div>
        </div>
    </div>

@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success')=='Boleto deleted successfully')
    <script>
        Swal.fire(
            'Eliminado!',
            'Su registro ha sido eliminado.',
            'Exitosamente '
            )
    </script>
@endif
<script>
    // Escuchar el envío de los formularios de eliminación
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.eliminar-boletos-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Evita el envío del formulario por defecto

                const conductorId = this.getAttribute('id').replace('form-eliminar-', '');

                Swal.fire({
                    title: '¿Desea continuar ?',
                    text: "¿Seguro que quieres eliminar el registro?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminarlo!'
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
