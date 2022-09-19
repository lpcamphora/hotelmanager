@extends('index.layout')
@section('content')

				<div class="container-fluid p-0">
					<h1 class="h3 mb-3"><strong>Editar Serviço</strong></h1>
					<div class="row">
                    <div class="col-12 col-lg-12">
							<div class="card">
								<div class="card-body">
                                @if(Session::has('message'))
                                    <p style="color:#c90000;">{{ Session::get('message') }}</p>
                                @endif
                                <form method="post" action="{{ route('services.change', $service->id_service) }}">
                                @csrf
                                <input type="hidden" name="id_service" value="{{ $service->id_service }}">
                                <div class="row mb-3">
                                    <div class="col-6 themed-grid-col">
                                        <div class="form-group">
                                        <label class="form-label">Nome</label>
                                            <input type="text" class="form-control" name="name" value="{{ $service->name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-6 themed-grid-col">
                                        <div class="form-group">
                                        <label class="form-label">Valor (R$)</label>
                                            <input type="text" class="form-control" name="price" value="@convert($service->price)" data-prefix="" data-thousands="." data-decimal="," required>
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