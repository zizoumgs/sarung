@extends('layouts.login')

@section('title')
	Login
@stop

@section('content')
		<div class="container">
			<div class="row">	
				<div class="col-md-3 col-md-offset-4 login-area">
					{{ Form::open(array('url' => '/login/trylogin' )) }}
					<div class="form-group">
						<label for="user_name">User Name</label>
						<input name="user_name" type="text" class="form-control"  id="user_name" placeholder="User Name"  required>
					</div>
					<div class="form-group">
						<label for="password_name">Password</label>
						{{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) }}
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" name="%3$s" > <span class="item">Remember Me</span>
						</label>
					</div>
					<input type="submit" class="btn btn-primary" Value ="Login">
				{{ Form::close() }}
				<hr>
				<a href="{{ URL::to('/') }} " class="item">Back to Home</a>
				</div>
			</div>
		</div>
@stop
