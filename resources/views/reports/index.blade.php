@extends('index.layout')
@section('content')



				<div class="container-fluid p-0">

					<h1 class="h3 mb-3"><strong>Relatórios</strong></h1>

					<div class="row">
					@if(Session::has('message'))
                        <p>{{ Session::get('message') }}</p>
                    @endif

                    <div class="col-12 col-lg-12 col-xxl-9 d-flex">
							<div class="card flex-fill">
								<div class="card-header">
								<a href="{{ route('reports.export') }}" class="btn btn-secondary" style="float:right;">Exportar Excel</a>
								</div>
								<table class="table table-hover my-0">
									<thead>
										<tr>
											<th>Cliente</th>
											<th class="d-none d-xl-table-cell">Apartamento</th>
											<th>Plano</th>
											<th>Forma Pgto.</th>
											<th>Data / Hora</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($reports as $report)											
										<tr>
											<td>{{ $report->client }}</td>
											<td class="d-none d-xl-table-cell">{{ $report->apartment }}</td>
											<td>{{ $report->plan }}</td>
											<td>
												@if ($report->payment_method == 1)
													Dinheiro
												@elseif ($report->payment_method == 2)
													Cartão de Crédito
												@elseif ($report->payment_method == 3)
													Cartão de Débito
												@else
													PIX
												@endif
											</td>
											<td><span class="badge bg-success">{{ $report->created }}</span></td>
										</tr>
										@endforeach
									</tbody>
								</table>
								<br />
								<h4 class="h4 mb-3"><strong>Estatísticas de Pagamentos</strong></h4>								
								<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
								<canvas id="myChart" style="width:100%; height:30vh;"></canvas>
							</div>
						</div>
					</div>

				</div>
				<script type="text/javascript">









var dataSet1 = {
    label: "Dinheiro",
    data: {!! json_encode($chartData->datasets[0]) !!},
    lineTension: 0,
    fill: false,
    borderColor: 'red',
	opacity: 0.5
  };

var dataSet2 = {
    label: "Cartão de Crédito",
    data: {!! json_encode($chartData->datasets[1]) !!},
    lineTension: 0,
    fill: false,
  	borderColor: 'blue',
  };

var dataSet3 = {
    label: "Cartão de Débito",
    data: {!! json_encode($chartData->datasets[2]) !!},
    lineTension: 0,
    fill: false,
  	borderColor: 'yellow',
  };

var dataSet4 = {
    label: "PIX",
    data: {!! json_encode($chartData->datasets[3]) !!},
    lineTension: 0,
    fill: false,
  	borderColor: 'green',
  };



var data = {
  labels: {!! json_encode($chartData->labels) !!},
  datasets: [dataSet1, dataSet2, dataSet3, dataSet4]
};

var chartOptions = {
  legend: {
    display: true,
    position: 'top',
    labels: {
      boxWidth: 80,
      fontColor: 'black'
    }
  }
};

const ctx = document.getElementById('myChart').getContext('2d');
const myChart = new Chart(ctx, {
  type: 'line',
  data: data,
  options: chartOptions
});
</script>					

    @endsection