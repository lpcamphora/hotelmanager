@extends('index.layout_login')
@section('content')
<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Hotel Manager</h1>
							<p class="lead">
								Digite seu e-mail e senha para continuar
							</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-4">
                                    @if(Session::has('message'))
                                    <p style="color:#c90000;">{{ Session::get('message') }}</p>
                                    @endif

									<form action="{{ route('index.auth') }}" method="post">
                                        @csrf
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input class="form-control form-control-lg" type="email" name="email" placeholder="Digite seu email" required />
										</div>
										<div class="mb-3">
											<label class="form-label">Senha</label>
											<input class="form-control form-control-lg" type="password" name="password" placeholder="Digite sua senha" required />
										</div>
										<div class="text-center mt-3">
											<button type="submit" class="btn btn-lg btn-primary" style="width:180px;">Sign in</button>
										</div>
										<div class="text-center mt-3">
											<a href="{{ route('index.signup') }}" class="btn btn-secondary" style="width:180px;">Sign Up</a>
										</div>
										<div class="text-center mt-3">
											<a href="{{ route('index.github') }}" class="btn btn-block btn-social btn-github" style="width:180px; height:36px;">
												<span class="fa fa-github"></span> Sign in with Github
											</a>										
										</div>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
    </main>
    
@endsection