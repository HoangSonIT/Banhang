@extends('master')
@section('content')
	<div class="inner-header">
		<div class="container">
			<div class="pull-left">
				<h6 class="inner-title">Đăng kí</h6>
			</div>
			<div class="pull-right">
				<div class="beta-breadcrumb">
					<a href="{{route('trang-chu')}}">Trang chủ</a> / <span>Đăng kí</span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	@if(count($errors) > 0)
		<div class="alert alert-danger">
			@foreach($errors->all() as $err)
				<p style="text-align: center">{{$err}}</p><br>
			@endforeach
		</div>
	@endif	
	<div class="container">
		<div id="content">
			
			<form action="{{route('signup')}}" method="post" class="beta-form-checkout">
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<div class="row">
					<div class="col-sm-3"></div>
					<div class="col-sm-6">
						<h4>Đăng kí</h4>
						<div class="space20">&nbsp;</div>

						
						<div class="form-block">
							<label for="email">Email address*</label>
							<input type="email" id="mail" placeholder="example@gmail.com" name="email" required>
						</div>

						<div class="form-block">
							<label for="your_last_name">Fullname*</label>
							<input type="text" id="your_last_name" placeholder="Your name..." name="name" required>
						</div>

						<div class="form-block">
							<label for="address">Address*</label>
							<input type="text" id="adress" placeholder="Street Address" name="address" required>
						</div>


						<div class="form-block">
							<label for="phone">Phone*</label>
							<input type="text" id="phone" placeholder="Exp: 025-366-252" name="phone" required>
						</div>
						<div class="form-block">
							<label for="password">Password*</label>
							<input type="password" id="phone" placeholder="********" name="password" required>
						</div>
						<div class="form-block">
							<label for="password">Re password*</label>
							<input type="password" id="phone" placeholder="********" name="passwordAgain" required>
						</div>
						<div class="form-block">
							<button type="submit" class="btn btn-primary">Đăng kí</button>
						</div>
					</div>
					<div class="col-sm-3"></div>
				</div>
			</form>
		</div> <!-- #content -->
	</div> <!-- .container -->
@endsection