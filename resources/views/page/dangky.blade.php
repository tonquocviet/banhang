@extends('master')
@section('content')
	<div class="inner-header">
		<div class="container">
			<div class="pull-left">
				<h6 class="inner-title">Đăng ký</h6>
			</div>
			<div class="pull-right">
				<div class="beta-breadcrumb">
					<a href="{{route('trang-chu')}}">Home</a> / <span>Đăng ký</span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	
	<div class="container">
		<div id="content">
			<form action="{{route('register')}}" method="post" class="beta-form-checkout">
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
					@if(Session::has('thongbao'))
						<div class="alert alert-success">* {{Session::get('thongbao')}}</div>
					@endif
					<div class="col-sm-6">
						<h4 align="center">Đăng ký</h4>
						<div class="space20">&nbsp;</div>
						
						<div class="form-block">
							<label for="email">Email*</label>
							<input type="email" name="email" placeholder="example@gmail.com" required>
						</div>

						<div class="form-block">
							<label for="your_last_name">Họ và tên*</label>
							<input type="text" name="fullname" placeholder="Tôn Quốc Việt" required>
						</div>

						<div class="form-block">
							<label for="adress">Địa chỉ*</label>
							<input type="text" name="address" placeholder="Hải Châu - Đà Nẵng" required>
						</div>


						<div class="form-block">
							<label for="phone">Số điện thoại*</label>
							<input type="text" name="phone" placeholder="0979.797.797" required>
						</div>
						<div class="form-block">
							<label for="phone">Mật khẩu*</label>
							<input type="password" name="password" placeholder="*******" required>
						</div>
						<div class="form-block">
							<label for="phone">Nhập lại mật khẩu*</label>
							<input type="password" name="re_password" placeholder="*******" required>
						</div>
						<div class="pull-center" align="center">
							<button type="submit" class="btn btn-primary">Đăng ký</button>
						</div>
					</div>
					<div class="col-sm-3"></div>
				</div>
			</form>
		</div> <!-- #content -->
	</div> <!-- .container -->
@endsection