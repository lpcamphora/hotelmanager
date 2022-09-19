@extends('index.layout')
@section('content')



				<div class="container-fluid p-0">

					<h1 class="h3 mb-3"><strong>Apartamentos</strong></h1>

					<div class="row">
					@if(Session::has('message'))
                        <p>{{ Session::get('message') }}</p>
                    @endif

                    <div class="col-12 col-lg-12 col-xxl-9 d-flex">
							<div class="card flex-fill">
								<div class="card-header">
								<a href="{{ route('apartments.add') }}" class="btn btn-secondary" style="float:right;">Novo Apartamento</a>
								</div>
								<table class="table table-hover my-0">
									<thead>
										<tr>
											<th>Nome</th>
											<th class="d-none d-xl-table-cell">Número</th>
											<th>Criado</th>
											<th>Atualizado</th>
											<th class="d-none d-md-table-cell">Ação</th>
										</tr>
									</thead>
									<tbody>
										<tr>
										@foreach ($apartments as $apartment)											
											<td>{{ $apartment->name }}</td>
											<td class="d-none d-xl-table-cell">{{ $apartment->number }}</td>
											<td><span class="badge bg-success">{{ $apartment->created }}</span></td>
											<td><span class="badge bg-success">{{ $apartment->updated }}</span></td>
											<td class="d-none d-md-table-cell">
												<a href="{{ route('apartments.change', $apartment->id_apartment) }}" title="Editar"><i class="align-middle" data-feather="edit"></i></a>
												<a href="javascript:;" title="Excluir" onclick="deleteUser({{ $apartment->id_apartment }})"><i class="align-middle" data-feather="delete"></i></a>
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
						document.location = '/apartments/delete/' + id;
					}
					return;
				}
				</script>

    @endsection