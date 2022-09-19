@extends('index.layout')
@section('content')

				<div class="container-fluid p-0">
					<h1 class="h3 mb-3"><strong>Editar Apartamento</strong></h1>
					<div class="row">
                    <div class="col-12 col-lg-12">
							<div class="card">
								<div class="card-body">
                                @if(Session::has('message'))
                                    <p style="color:#c90000;">{{ Session::get('message') }}</p>
                                @endif
                                <form method="post" action="{{ route('apartments.change', $apartment->id_apartment) }}">
                                @csrf
                                <input type="hidden" name="id_apartment" value="{{ $apartment->id_apartment }}">
                                <div class="row mb-3">
                                    <div class="col-6 themed-grid-col">
                                        <div class="form-group">
                                        <label class="form-label">Nome</label>
                                            <input type="text" class="form-control" name="name" value="{{ $apartment->name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-6 themed-grid-col">
                                        <div class="form-group">
                                        <label class="form-label">Número</label>
                                            <input type="number" class="form-control" name="number" value="{{ $apartment->number }}" required>
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