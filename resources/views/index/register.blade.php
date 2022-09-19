@extends('index.layout')
@section('content')

<style type="text/css">
#add-service {
    position:absolute;
    left:35%;
    top:35%;
    width:400px;
    height:150px;
}
</style>
				<div class="container-fluid p-0">
					<h1 class="h3 mb-3"><strong>Registrar Entrada</strong></h1>
					<div class="row">
                    <div class="col-12 col-lg-12">
							<div class="card">
								<div class="card-body">
                                @if(Session::has('message'))
                                    <p style="color:#c90000;">{{ Session::get('message') }}</p>
                                 @endif
                                <form method="post" action="{{ route('index.register') }}">
                                <input type="hidden" name="id_control" value="{{ $id_control }}">
                                <input type="hidden" name="total" value="">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-4 themed-grid-col">
                                        <div class="form-group">
                                            <label class="form-label">Cliente</label>
                                            <select class="form-control" name="id_client" required>
                                                <option value=""> - Selecione - </option>
                                                @foreach ($clients as $client)											
                                                <option value="{{ $client->id_client }}">{{ $client->name }} {{ $client->last_name }}</option>
                                                @endforeach;

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 themed-grid-col">
                                        <div class="form-group">
                                            <label class="form-label">Apartamento</label>
                                            <select class="form-control" name="id_apartment" required>
                                                <option value=""> - Selecione - </option>  
                                                @foreach ($apartments as $apartment)											
                                                <option value="{{ $apartment->id_apartment }}">{{ $apartment->name }} - {{ $apartment->number }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 themed-grid-col">
                                        <div class="form-group">
                                            <label class="form-label">Plano</label>
                                            <select class="form-control" name="id_plan" id="plan" required>
                                                <option value=""> - Selecione - </option>                                            
                                                @foreach ($plans as $plan)											
                                                <option value="{{ $plan->id_plan }}" data-price="{{ $plan->price }}">{{ $plan->name }}</option>
                                                @endforeach;
                                            </select>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row mb-3">
                                    <div class="col-4 themed-grid-col">
                                        <div class="form-group">
                                            <label class="form-label">Forma Pagamento</label>
                                            <select class="form-control" name="payment_method" required>
                                                <option value="1">Dinheiro</option>
                                                <option value="2">Cartão Crédito</option>
                                                <option value="3">Cartão Débito</option>
                                                <option value="4">PIX</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <div class="col-12 themed-grid-col">

                                    <div class="container-fluid p-0">

                                        <h4 class="h4 mb-3"><strong>Serviços</strong></h4>

                                        <div class="row">

                                        <div class="col-12 col-lg-12 col-xxl-9 d-flex">
                                                <div class="card flex-fill">
                                                    <div class="card-header">
                                                        <select class="form-control" name="service_item" id="service-item" style="width:300px; float:left; margin-right:8px;" required>
                                                            @foreach ($services as $service)											
                                                            <option value="{{ $service->id_service }}">{{ $service->name }}</option>
                                                            @endforeach;
                                                        </select>
                                                        <a href="javascript:;" class="btn btn-secondary" id="btn-add-service" style="float:left;">Adicionar Serviço</a>
                                                    </div>
                                                    <table class="table table-hover my-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Nome</th>
                                                                <th class="d-none d-xl-table-cell">Valor (R$)</th>
                                                                <th class="d-none d-md-table-cell">Ação</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="controls-services">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

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

                                <div class="row mb-3">
                                    <div class="col-12 themed-grid-col">
                                        <div class="form-group">
                                            <p style="font-size:28px; float:right;">
                                            Total: <span id="total">0,00</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                </form>

								</div>
							</div>

						</div>                    
	                </div>

				</div>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

				<script type="text/javascript">
                var values = {
                    price: 0,
                    services: [],
                    total: 0
                };
                function format(val) {
                    var formatter = new Intl.NumberFormat('pt-BR', {
                        style: 'currency',
                        currency: 'BRL',
                    });
                    return formatter.format(val);
                }
                function calcTotal() {
                    var t = values.price;
                    $.each(values.services, (i, e) => {
                        t = t + parseFloat(e.price);
                    });
                    values.total = t;
                    $('input[name=total]').val(t);
                    $('#total').html(format(t));
                }
				function deleteService(id) {
					if (confirm('Deseja excluir este registro?')) {
                        $.getJSON("{{ route('index.delete.service') }}?s=" + id, (data) => {
                            loadServices();
                        });

					}
					return;
				}
                function loadServices() {
                    $.getJSON("{{ route('index.services', $id_control) }}", (data) => {
                        var json = JSON.parse(data.data);
                        var tpl = '<tr>' +
								  '     <td>{NAME}</td>' + 
								  '			<td class="d-none d-xl-table-cell">{PRICE}</td>' +
								  '			<td class="d-none d-md-table-cell">' +
								  '				<a href="javascript:;" title="Excluir" onclick="deleteService({ID})">Excluir</i></a>' +
								  '		</td>' +
								  '</tr>';
                        $('#controls-services').html('');
                        values.services = [];
                        $.each(json, (key, val) => {
                            item = tpl;
                            item = item.replace('{NAME}', val.service);
                            item = item.replace('{PRICE}', val.price);
                            item = item.replace('{ID}', val.id);
                            $('#controls-services').append(item);
                            values.services.push(val);
                        });
                        calcTotal();
                    });
                }
                $('#btn-add-service').click((e) => {
                    e.preventDefault();
                    var data = {
                        id_control: {{ $id_control }},
                        id_service: $('#service-item').val()
                    };
                    $.ajax({
                        type: 'post',
                        url: "{{ route('index.add.service') }}",
                        data: JSON.stringify(data),
                        contentType: "application/json; charset=utf-8",
                        traditional: true,
                        success: () => {
                            loadServices();
                        }
                    });        
                });
                $('#plan').change((e) => {
                    e.preventDefault();
                    values.price = parseFloat($('select[name=id_plan] option').filter(':selected').attr('data-price'));
                    calcTotal();
                });
				</script>

    @endsection