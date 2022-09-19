@extends('index.layout')
@section('content')

				<div class="container-fluid p-0">
					<h1 class="h3 mb-3"><strong>Novo Cliente</strong></h1>
					<div class="row">
                    <div class="col-12 col-lg-12">
							<div class="card">
								<div class="card-body">
                                @if(Session::has('message'))
                                    <p style="color:#c90000;">{{ Session::get('message') }}</p>
                                 @endif
                                <form method="post" action="{{ route('clients.add') }}">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-4 themed-grid-col">
                                        <div class="form-group">
                                        <label class="form-label">Nome</label>
                                            <input type="text" class="form-control" name="name" required>
                                        </div>
                                    </div>
                                    <div class="col-4 themed-grid-col">
                                        <div class="form-group">
                                        <label class="form-label">Sobrenome</label>
                                            <input type="text" class="form-control" name="last_name" required>
                                        </div>
                                    </div>
                                    <div class="col-4 themed-grid-col">
                                        <div class="form-group">
                                            <label class="form-label">CPF</label>
                                            <input type="text" class="form-control" name="cpf" data-mask="000.000.000-00" required>
                                        </div>
                                    </div>
                                    
                                </div>

                                <!--<div class="row mb-3">
                                    <div class="col-4 themed-grid-col">
                                        <div class="form-group">
                                            <label class="form-label">Forma Pagamento</label>
                                            <select class="form-control" name="payment_method" required>
                                                <option value="1">Dinheiro</option>
                                                <option value="2">Cartão Crédito</option>
                                                <option value="3">Cartão Débito</option>
                                                <option value="3">PIX</option>
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