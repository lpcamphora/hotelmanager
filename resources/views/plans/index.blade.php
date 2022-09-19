@extends('index.layout')
@section('content')



				<div class="container-fluid p-0">

					<h1 class="h3 mb-3"><strong>Planos</strong></h1>

					<div class="row">
					@if(Session::has('message'))
                        <p>{{ Session::get('message') }}</p>
                    @endif

                    <div class="col-12 col-lg-12 col-xxl-9 d-flex">
							<div class="card flex-fill">
								<div class="card-header">
								<a href="{{ route('plans.add') }}" class="btn btn-secondary" style="float:right;">Novo Plano</a>
								</div>
								<table class="table table-hover my-0">
									<thead>
										<tr>
											<th>Nome</th>
											<th class="d-none d-xl-table-cell">Dias</th>
											<th class="d-none d-xl-table-cell">Valor (R$)</th>
											<th>Criado</th>
											<th>Atualizado</th>
											<th class="d-none d-md-table-cell">Ação</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($plans as $plan)											
										<tr>
											<td>{{ $plan->name }}</td>
											<td class="d-none d-xl-table-cell">{{ $plan->days }}</td>
											<td class="d-none d-xl-table-cell">@convert($plan->price)</td>
											<td><span class="badge bg-success">{{ $plan->created }}</span></td>
											<td><span class="badge bg-success">{{ $plan->updated }}</span></td>
											<td class="d-none d-md-table-cell">
												<a href="{{ route('plans.change', $plan->id_plan) }}" title="Editar"><i class="align-middle" data-feather="edit"></i></a>
												<a href="javascript:;" title="Excluir" onclick="deletePlan({{ $plan->id_plan }})"><i class="align-middle" data-feather="delete"></i></a>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>

				</div>
				<script type="text/javascript">
				function deletePlan(id) {
					if (confirm('Deseja excluir este registro?')) {
						document.location = '/plans/delete/' + id;
					}
					return;
				}
				</script>

    @endsection