@extends('master')
@section('content')
	<div class="inner-header">
		<div class="container">
			<div class="pull-left">
				<h6 class="inner-title">Đăng nhập</h6>
			</div>
			<div class="pull-right">
				<div class="beta-breadcrumb">
					<a href="{{route('trang-chu')}}">Home</a> / <span>Đăng nhập</span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	
	<div class="container">
		<div id="content">
			<form action="{{route('login')}}" method="post" class="beta-form-checkout">
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<div class="row">
					<div class="col-sm-3"></div>
					@if(count($errors)>0)
						<div class="alert alert-danger">
							@foreach($errors-> all() as $err)
								* {{$err}}<br>
							@endforeach
						</div>
					@endif
					@if(Session::has('thanhcong'))
						<div class="alert alert-success">{{Session::get('thanhcong')}}</div>
					@endif
					@if(Session::has('flag'))
						<div class="alert alert-{{Session::get('flag')}}">{{Session::get('message')}}</div>
					@endif
					<div class="col-sm-6">
						<h4 align="center">Đăng nhập</h4>
						<div class="space20">&nbsp;</div>
						<div class="form-block">
							<label for="email">Email*</label>
							<input type="email" name="email" placeholder="example@gmail.com" required>
						</div>
						<div class="form-block">
							<label for="phone">Mật khẩu*</label>
							<input type="text" name="password" placeholder="*******" required>
						</div>
						<div class="pull-center" align="center">
								<a href="{{route('register')}}">Đăng ký tài khoản</a>
						</div>
						<div class="space20">&nbsp;</div>
						<div class="pull-center" align="center">
							<button type="submit" class="btn btn-primary">Đăng Nhập</button>
						</div>

						<div class="space20">&nbsp;</div>
						<div class="pull-center" align="center">
							<button {{-- href="{{route('provider_login_callback')}} --}} type="button" class="btn btn-primary">Đăng nhập bằng Facebook</button>
						</div>

						<div class="space20">&nbsp;</div>
						<div class="pull-center" align="center">
							<button type="button" class="btn btn-primary">Đăng nhập bằng G+</button>
						</div>
					</div>
					<div class="col-sm-3"></div>
				</div>
			</form>
		</div> <!-- #content -->
	</div> <!-- .container -->
@endsection 