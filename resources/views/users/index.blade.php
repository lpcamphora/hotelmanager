@extends('index.layout')
@section('content')



				<div class="container-fluid p-0">

					<h1 class="h3 mb-3"><strong>Usuários</strong></h1>

					<div class="row">
					@if(Session::has('message'))
                        <p>{{ Session::get('message') }}</p>
                    @endif

                    <div class="col-12 col-lg-12 col-xxl-9 d-flex">
							<div class="card flex-fill">
								<div class="card-header">
								<a href="{{ route('users.add') }}" class="btn btn-secondary" style="float:right;">Novo Usuário</a>
								</div>
								<table class="table table-hover my-0">
									<thead>
										<tr>
											<th>Nome</th>
											<th class="d-none d-xl-table-cell">Grupo</th>
											<th class="d-none d-xl-table-cell">E-Mail</th>
											<th>Criado</th>
											<th>Atualizado</th>
											<th class="d-none d-md-table-cell">Ação</th>
										</tr>
									</thead>
									<tbody>
										<tr>
										@foreach ($users as $user)											
											<td>{{ $user->user }}</td>
											<td class="d-none d-xl-table-cell">{{ $user->role }}</td>
											<td class="d-none d-xl-table-cell">{{ $user->email }}</td>
											<td><span class="badge bg-success">{{ $user->created }}</span></td>
											<td><span class="badge bg-success">{{ $user->updated }}</span></td>
											<td class="d-none d-md-table-cell">
												<a href="{{ route('users.change', $user->id_user) }}" title="Editar"><i class="align-middle" data-feather="edit"></i></a>
												<a href="javascript:;" title="Excluir" onclick="deleteUser({{ $user->id_user }})"><i class="align-middle" data-feather="delete"></i></a>
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
						document.location = '/users/delete/' + id;
					}
					return;
				}
				</script>

    @endsection