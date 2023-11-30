<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="(( public_path('css/app.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Reporte PDF</title>
    <style>
        .div-con-imagen {
            width: 200px; /* Ajusta el ancho según tus necesidades */
            height: 200px; /* Ajusta la altura según tus necesidades */
            overflow: hidden;
            border-radius: 50%; /* Hace que el contenedor tenga bordes redondos */
            border: 2px solid white; /* Borde blanco delgado */
        }
        
        /* Estilos para la imagen dentro del div */
        .div-con-imagen img {
            width: 100%; /* Ajusta el ancho para que la imagen cubra todo el contenedor */
            height: auto; /* Mantiene la proporción original de la imagen */
            border-radius: 50%; /* Hace que la imagen tenga bordes redondos */
        }
    </style>
    
</head>
<body>
        <center>
            <div class="div-con-imagen">
                <img src="{{ public_path() . '/img/escudo.jfif' }}" >
            </div>
        </center>
    <h1>Reporte PDF, Registro de boletos</h1>

    <div class="containe r-fluid">
        <div class="row">
            <br>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                    <tr>
										<th>Idconductor</th>
										<th>Nombre</th>
										<th>Apellido</th>
										<th>Fecha de ingreso</th>
										<th>Fecha nacimiento</th>
										<th>Genero</th>
										<th>Telefono</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($conductors as $conductor)
                                        <tr>
											<td>{{ $conductor->idConductor }}</td>
											<td>{{ $conductor->NomConductor }}</td>
											<td>{{ $conductor->ApeConductor }}</td>
											<td>{{ $conductor->Fechaingreso }}</td>
											<td>{{ $conductor->FechaNa }}</td>
                                            <td>{{ $conductor->Genero }}</td>                                        
											<td>{{ $conductor->Telefono }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $conductors->links() !!}
            </div>
        </div>
    </div>
    <table class="table table-striped">
    <thead class="thead">
        <tr>
            <th>Genero</th>
            <th>Cantidad</th>
            <th>Porcentaje</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($porM as $key => $value)
            <tr>
                <td>{{ $value->Genero }}</td>
                <td>{{ $value->cantidad }}</td>
                <td>{{ $value->porcentaje }}%</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
    
</body>
</html>
    