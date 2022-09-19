@extends('index.layout')
@section('content')

				<div class="container-fluid p-0">
					<h1 class="h3 mb-3"><strong>Editar Usuário</strong></h1>
					<div class="row">
                    <div class="col-12 col-lg-12">
							<div class="card">
								<div class="card-body">
                                @if(Session::has('message'))
                                    <p style="color:#c90000;">{{ Session::get('message') }}</p>
                                @endif
                                <form method="post" action="{{ route('users.change', $user->id_user) }}">
                                @csrf
                                <input type="hidden" name="id_user" value="{{ $user->id_user }}">
                                <div class="row mb-3">
                                    <div class="col-4 themed-grid-col">
                                        <div class="form-group">
                                        <label class="form-label">Nome</label>
                                            <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-4 themed-grid-col">
                                        <div class="form-group">
                                            <label class="form-label">Grupo</label>
                                            <select class="form-control" name="id_role" required>
                                                @foreach ($roles as $role)
                                                <option value="{{ $role->id_role }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 themed-grid-col">
                                        <div class="form-group">
                                            <label class="form-label">E-Mail</label>
                                            <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row mb-3">
                                    <div class="col-4 themed-grid-col">
                                        <div class="form-group">
                                            <label class="form-label">Senha</label>
                                            <input type="password" class="form-control" name="password" required>
                                        </div>
                                    </div>
                                    <div class="col-4 themed-grid-col">
                                        <div class="form-group">
                                            <label class="form-label">Confirmar Senha</label>
                                            <input type="password" class="form-control" name="password_confirm" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="row mb-3">
                                    <div class="col-12 themed-grid-col">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-secondary" style="float:right;">Salvar</button>
                                        </div>
                                    </div>
                                </div>
                                </form>

								</div>
							</div>

						</div>                    
	                </div>

				</div>

    @endsection