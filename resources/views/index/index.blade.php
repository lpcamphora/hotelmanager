@extends('index.layout')
@section('content')



				<div class="container-fluid p-0">

					<h1 class="h3 mb-3"><strong>Controle</strong><a href="{{ route('index.register') }}" class="btn btn-secondary" style="float:right;">Registrar Entrada</a></h1>

					<div class="row">
						<div class="col-xl-12 col-xxl-5 d-flex">
							<div class="w-100">
								<div class="row">
									@foreach ($controls as $control)
									<div class="col-sm-3">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">{{ $control['name'] }} {{ $control['number'] }}</h5>
													</div>

													<div class="col-auto">
                                                        @if ($control['status'] === 1)
														<div class="stat text-primary">
                                                            <a href="{{ route('index.release', $control['id_control']) }}" title="Liberar">
                                                                <i class="align-middle" data-feather="log-in"></i>
                                                            </a>
														</div>
                                                        @endif
													</div>
												</div>
												<!--<h1 class="mt-1 mb-3">2.382</h1>-->
												<h1 class="mt-1 mb-3">{{ $control['total'] }}</h1>
												<div class="mb-0">
													@if ($control['status'] === 1)
													<span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i>Ocupado</span>
													@else
													<span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i>Liberado</span>
													@endif
												</div>
											</div>
										</div>
									</div>
									@endforeach
                                                                        
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
                    /*$.getJSON("", (data) => {
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
                    });*/
                }
                $('#btn-add-service').click((e) => {
                    /*e.preventDefault();
                    var data = {
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
                    });        */
                });
                $('#plan').change((e) => {
                    e.preventDefault();
                    values.price = parseFloat($('select[name=id_plan] option').filter(':selected').attr('data-price'));
                    calcTotal();
                });
				</script>				

    @endsection