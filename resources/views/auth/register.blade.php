@extends('app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">注册</div>
				<div class="panel-body">
					 {{-- @if(count($errors)>0 )
					<div class="alert alert-danger">
						<strong>Whoops!</strong>你的输入有误。<br><br>
						<ul>
							@foreach( $errors->all() as $error )
							<li> {{$error}} </li>
							@endforeach
						</ul>
					</div>
					@endif  --}}
				
					<form class="form-horizontal" role="form" method="post" action="{{ url('/webauth/register') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group" >
							<label class="col-md-4 control-label">用户名</label>
							<div class="col-md-6">
							  <input type="text" class="form-control" name="username" value="{{ old('name') }}">
							</div>
						</div>
						<div class="form-group" >
							<label class="col-md-4 control-label">登录账户</label>
							<div class="col-md-6">
							  <input type="text" class="form-control" name="account" value="{{ old('account') }}">
							</div>
						</div>
						<div class="form-group" >
							<label class="col-md-4 control-label">密码</label>
							<div class="col-md-6">
							  <input type="password" class="form-control" name="password" >
							</div>
						</div>
						<div class="form-group" >
							<label class="col-md-4 control-label">确认密码</label>
							<div class="col-md-6">
							  <input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>
						<div class="form-group" >
							<div class="col-md-6 col-md-offset-4">
							  <button type="submit" class="btn btn-primary">注册</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection