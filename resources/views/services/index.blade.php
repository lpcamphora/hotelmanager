@extends('index.layout')
@section('content')



				<div class="container-fluid p-0">

					<h1 class="h3 mb-3"><strong>Serviços</strong></h1>

					<div class="row">
					@if(Session::has('message'))
                        <p>{{ Session::get('message') }}</p>
                    @endif

                    <div class="col-12 col-lg-12 col-xxl-9 d-flex">
							<div class="card flex-fill">
								<div class="card-header">
								<a href="{{ route('services.add') }}" class="btn btn-secondary" style="float:right;">Novo Serviço</a>
								</div>
								<table class="table table-hover my-0">
									<thead>
										<tr>
											<th>Nome</th>
											<th class="d-none d-xl-table-cell">Valor (R$)</th>
											<th>Criado</th>
											<th>Atualizado</th>
											<th class="d-none d-md-table-cell">Ação</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($services as $service)											
										<tr>
											<td>{{ $service->name }}</td>
											<td class="d-none d-xl-table-cell">@convert($service->price)</td>
											<td><span class="badge bg-success">{{ $service->created }}</span></td>
											<td><span class="badge bg-success">{{ $service->updated }}</span></td>
											<td class="d-none d-md-table-cell">
												<a href="{{ route('services.change', $service->id_service) }}" title="Editar"><i class="align-middle" data-feather="edit"></i></a>
												<a href="javascript:;" title="Excluir" onclick="deleteUser({{ $service->id_service }})"><i class="align-middle" data-feather="delete"></i></a>
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
				function deleteUser(id) {
					console.log(id);
					if (confirm('Deseja excluir este registro?')) {
						document.location = '/services/delete/' + id;
					}
					return;
				}
				</script>

    @endsection