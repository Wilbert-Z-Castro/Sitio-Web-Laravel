
@extends('layouts.menubase')
@section('template_title')
    Menu principal
    
@endsection
@section('content')
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
            ['Task', 'Genero de los empleados'],
            /*['Work',     11],
            ['Eat',      2],
            ['Commute',  2],
            ['Watch TV', 2],
            ['Sleep',    7]*/
            <?php
            foreach($Consulta1 as $key => $value):
                echo "['". $value->Genero ."', " .$value->cantidad."],";
            endforeach;
            ?>
            ]);

            var options = {
            title: 'Género de los empleados'
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
        </script>
        <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
            ['Task', 'Género de los empleados'],
            <?php
            foreach($Consulta2 as $key => $value2):
                echo "['ID:". $value2->id_viaje." ". $value2->Origen."-". $value2->Destino."', " .$value2->cantidad."],";
            endforeach;
            ?>
            ]);

            var options = {
            title: 'Viajes realizados (Destino - origen)'
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

            chart.draw(data, options);
        }
        </script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Meses', 'Viajes realizados',{ role: 'style' }],
          <?php
          $meses = [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre",
          ];
          $NMeses=[0,0,0,0,0,0,0,0,0,0,0,0];
          foreach($Consulta3 as $key => $value3):
                $cabezalMes=$value3->mes;
                $NMeses[$cabezalMes-1]=$value3->cantidad;
          endforeach;
          $colores = [
            "FF00FF",
            "E6E6FA",
            "0000FF",
            "FF7F00",
            "00FFFF",
            "FF00CC",
            "FFFF00",
            "F5F5DC",
            "FFD700",
            "C0C0C0",
            "000080",
            "8FBC8F",
          ];

          for($i=0; $i<12;$i++){
                echo"['".$meses[$i]."',". $NMeses[$i].",'#". $colores[$i]."'],";
          }

          ?>
          /*
                    foreach($Consulta3 as $key => $value3):
                $mes=$meses[$key];
                $color=$colores[$key];
                echo "['". $mes."',". $value3->cantidad.",'#". $color."'],"; 
          endforeach;
          ['2014', 1000, 400, 200],
          ['2015', 1170, 460, 250],
          ['2016', 660, 1120, 300],
          ['2017', 1030, 540, 350]* 
                <p>{{$value3->mes}}</p>
                <p>{{$value3->cantidad}}</p>*/
        ]);

        var options = {
          chart: {
            title: 'Cantidad de viajes realizados al mes',
            subtitle: '2023-2024',
          },
          bars: 'vertical' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
        <div class="containe r-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                               panel de control
                            </span>

                             <div class="float-right">
                             
                                
                            
                                
                              </div>
                        </div>
                    </div>
                    

                    <div class="card-body">
                        <a href="{{ route('conductores.pdf') }}" class="btn btn-primary btn-lg "  data-placement="left" >
                                  {{ __('Reporte PDF conductores') }}
                        </a>
                        <a href="{{ route('Boletos.pdf') }}" class="btn btn-primary btn-lg"  data-placement="left">
                                  {{ __('Reporte PDF de Boletos') }}
                                </a>
                                <div class="mb-3">
                                <hr>
                          <h1>Respaldo</h1>
                          @if($errors->any())
                          <div class="alert alert-danger">
                              <ul>
                                  @foreach($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                          @endif
                          
                          <a href="{{ route('home.respaldo') }}" class="btn btn-primary btn-lg "  data-placement="left">
                                  {{ __('Respaldo') }}
                                </a>
                            <h3>Restaurar Base de datos</h3>
                          
                          @if ($message = Session::get('success'))
                              <div class="alert alert-success">
                                  <p>{{ $message }}</p>
                              </div>
                          @endif

                          @if($errors->any())
                          <div class="alert alert-danger">
                              <ul>
                                  @foreach($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                          @endif
                          <form action="{{ route('home.restauracion') }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <input type="file" name="backup_file" accept=".sql">
                          <button type="submit" class="btn btn-success btn-sm">Restaurar</button>
                          </form>
                          
                        </div>
                        <hr>
                        <div id="piechart" style="width: auto; height: 450px;" ></div>
                        <div id="piechart2" style="width: auto; height: 450px;"  ></div>
                        <div id="barchart_material" style="width: auto; height: 450px;" ></div>
                        
                    </div>
                </div>
               <br>
            </div>
        </div>
    </div>
@endsection
        





