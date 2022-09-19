@extends('index.layout')
@section('content')

				<div class="container-fluid p-0">
					<h1 class="h3 mb-3"><strong>Editar Cliente</strong></h1>
					<div class="row">
                    <div class="col-12 col-lg-12">
							<div class="card">
								<div class="card-body">
                                @if(Session::has('message'))
                                    <p style="color:#c90000;">{{ Session::get('message') }}</p>
                                @endif
                                <form method="post" action="{{ route('clients.change', $client->id_client) }}">
                                @csrf
                                <input type="hidden" name="id_client" value="{{ $client->id_client }}">
                                <div class="row mb-3">
                                    <div class="col-4 themed-grid-col">
                                        <div class="form-group">
                                        <label class="form-label">Nome</label>
                                            <input type="text" class="form-control" name="name" value="{{ $client->name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-4 themed-grid-col">
                                        <div class="form-group">
                                        <label class="form-label">Sobrenome</label>
                                            <input type="text" class="form-control" name="last_name" value="{{ $client->last_name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-4 themed-grid-col">
                                        <div class="form-group">
                                            <label class="form-label">CPF</label>
                                            <input type="text" class="form-control" name="cpf" value="{{ $client->cpf }}" data-mask="000.000.000-00" required>
                                        </div>
                                    </div>
                                    
                                </div>

                                <!--<div class="row mb-3">
                                    <div class="col-4 themed-grid-col">
                                        <div class="form-group">
                                            <label class="form-label">Forma Pagamento</label>
                                            <select class="form-control" name="payment_method" required>
                                                <option value="1"{{ $client->payment_method == '1' ? ' selected': '' }}>Dinheiro</option>
                                                <option value="2"{{ $client->payment_method == '2' ? ' selected': '' }}>Cartão Crédito</option>
                                                <option value="3"{{ $client->payment_method == '3' ? ' selected': '' }}>Cartão Débito</option>
                                                <option value="3"{{ $client->payment_method == '4' ? ' selected': '' }}>PIX</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>-->

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