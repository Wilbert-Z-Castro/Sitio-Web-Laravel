<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="(( public_path('css/app.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Reporte PDF</title>
</head>
<body>
<div class="container-fluid my-5">
        <div class="row">
            <br>
            <div class="col-sm-12">
                <div class="card">
                    
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="thead">
                                    <tr>
										<th>Idboleto</th>
										<th>Fechaboleto</th>
										<th>Cantidad</th>
										<th>Id Viaje</th>
										<th>Id User</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($boletos as $boleto)
                                        <tr>
											<td>{{ $boleto->idBoleto }}</td>
											<td>{{ $boleto->FechaBoleto }}</td>
											<td>{{ $boleto->Cantidad }}</td>
											<td>{{ $boleto->id_viaje }}</td>
											<td>{{ $boleto->id_user }}</td>
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
    <hr>
    <h1>Viajes mas reservados</h1>

    <table class="table table-striped">
    <thead class="thead">
        <tr>
            <th>ID</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>Cantidad</th>
            <th>Porcentaje</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($porM as $key => $value)
            <tr>
                <td>{{ $value->id_viaje }}</td>
                <td>{{ $value->Origen }}</td>
                <td>{{ $value->Destino }}</td>
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
    