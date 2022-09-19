@extends('index.layout')
@section('content')



				<div class="container-fluid p-0">

					<h1 class="h3 mb-3"><strong>Clientes</strong></h1>

					<div class="row">
					@if(Session::has('message'))
                        <p>{{ Session::get('message') }}</p>
                    @endif

                    <div class="col-12 col-lg-12 col-xxl-9 d-flex">
							<div class="card flex-fill">
								<div class="card-header">
								<a href="{{ route('clients.add') }}" class="btn btn-secondary" style="float:right;">Novo Cliente</a>
								<a href="{{ route('clients.export') }}" class="btn btn-secondary" style="float:right; margin-right:4px;">Exportar Excel</a>
								</div>
								<table class="table table-hover my-0">
									<thead>
										<tr>
											<th>Nome</th>
											<th class="d-none d-xl-table-cell">CPF</th>
											<th>Criado</th>
											<th>Atualizado</th>
											<th class="d-none d-md-table-cell">Ação</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($clients as $client)											
										<tr>
											<td>{{ $client->name }} {{ $client->last_name }}</td>
											<td class="d-none d-xl-table-cell">{{ $client->cpf }}</td>
											<td><span class="badge bg-success">{{ $client->created }}</span></td>
											<td><span class="badge bg-success">{{ $client->updated }}</span></td>
											<td class="d-none d-md-table-cell">
												<a href="{{ route('clients.change', $client->id_client) }}" title="Editar"><i class="align-middle" data-feather="edit"></i></a>
												<a href="javascript:;" title="Excluir" onclick="deleteClient({{ $client->id_client }})"><i class="align-middle" data-feather="delete"></i></a>
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
				function deleteClient(id) {
					if (confirm('Deseja excluir este registro?')) {
						document.location = '/clients/delete/' + id;
					}
					return;
				}
				</script>

    @endsection