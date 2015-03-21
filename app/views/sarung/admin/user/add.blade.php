@extends('layouts.admin')

@section('title')
	User | Add
@stop

@include( 'sarung.admin.user.common')
@section('content')


    <h1 class="title">Add User
        <a href="{{ root::get_url_admin_user()}}" class="btn btn-primary btn-xs" >View</a>
    </h1>
		
    <hr class="mar_25">
    {{ Form::open(array('url' => root::get_url_admin_user('add') , 'method' => 'post' ,	'role' => 'form' ,'class' => 'form-horizontal' )) }}
		<div class="col-md-8">
			<div class="form-group" title="Nama Awal Siswa">
				<label for="first_name" class="col-sm-3 control-label" >First Name</label>
				<div class="col-sm-9">
					<input  name="first_name" class="form-control"
							type="text" placeholder="First Name" 
							require value="{{ Input::old('first_name') }}"
					>
				</div>
			</div>
			<div class="form-group" title="Jika kosong Berikan nama ayah">
				<label for="second_name" class="col-sm-3 control-label" >Second Name</label>
				<div class="col-sm-9">
					<input  name="second_name" class="form-control"
							type="text" placeholder="Second Name" 
							require value="{{ Input::old('second_name') }}"
					>
				</div>
			</div>
			<hr>
			<div class="form-group" title="Email ini akan dibuat untuk login">
				<label for="email_name" class="col-sm-3 control-label" >Email</label>
				<div class="col-sm-9">
					<input  name="email_name" class="form-control"
							type="email" placeholder="Email" 
							require	value="{{ Input::old('email_name') }}"
					>
				</div>
			</div>
			<hr>
			<div class="form-group" title="password">
				<label for="first_password_name" class="col-sm-3 control-label" >Password</label>
				<div class="col-sm-9">
					<input  name="first_password_name" class="form-control"
							type="password" placeholder="Password" 
							require
					>
				</div>
			</div>
			<div class="form-group" title=" Repeated Password">
				<label for="second_password_name" class="col-sm-3 control-label" >Repeated Password </label>
				<div class="col-sm-9">
					<input  name="second_password_name" class="form-control"
							type="password" placeholder="Repeated Password" 
							require
					>
				</div>
			</div>
		
			<hr>
			<div class="form-group">
				<label for="tanggal_lahir_name" class="col-sm-3 control-label">Tanggal</label>
				<div class="col-sm-5">
					<input type="text" name="tanggal_lahir_name" id="tanggal_lahir_name"
						   class="form-control" value="{{ Input::old('tanggal_lahir_name') }}" 
					>
				</div>
			</div>
			<div class="form-group">
				<label for="tempat_lahir_name" class="col-sm-3 control-label" >Tempat Lahir</label>
				<div class="col-sm-5">
					<select class="form-control input-sm" name="tempat_lahir_name">
						@foreach( Kabupaten_Model::get() as $val )
							<option value="{{ $val->id }}" >
								{{ $val->nama }}
							</option>
						@endforeach
					</select>
				</div>
			</div>
			<hr>
			<div class="form-group">
				<label for="gender_name" class="col-sm-3 control-label" >Gender</label>
				<div class="col-sm-5">
					<label class="radio-inline">
						<input type="radio" name="gender_name" id="gender_id" value="1" checked> Pria
					</label>
					<label class="radio-inline">
						<input type="radio" name="gender_name" id="gender_id" value="0"> Wanita
					</label>
				</div>
			</div>
			<hr>
			<div class="form-group">
				<label for="status_name" class="col-sm-3 control-label" >Status</label>
				<div class="col-sm-9">
					<select class="form-control input-sm" name="status_name">
						@foreach( $helper::get_status_values() as $key => $val )
							<option value="{{ $key }}"
								@if ( $key === (int) Input::old('status_name') &&  Input::get('status_name') != "All" )
									selected
								@endif
							>
								{{ $val }}
							</option>
						@endforeach
					</select>
				</div>
			</div>
	
			<hr>
			<div class="form-group">
				<label for="group_name" class="col-sm-3 control-label" >Group</label>
				<div class="col-sm-9">
					<select class="form-control" name="group_name">
						@foreach( AdmindGroup_Model::where('id','>',1)->get() as $val )
							<option value="{{ $val->id }}" >
								{{ $val->nama }}
							</option>
						@endforeach
					</select>
				</div>
			</div>
			<hr>
			<div class="form-group">
				<label for="find_alamat_name" class="col-sm-3 control-label" >Find alamat</label>
				<div class="col-sm-6">
					<input type="text" name="find_alamat_name" id="find_alamat_name"
						   class="form-control" title="Ketikkan nama kecamatan disini dan lihatlah hasilnya di Result alamat" > 
				</div>
	            <div class="col-sm-3">
					{{ Form::button('Cari' ,	array( 'class' => 'btn btn-primary btn-sm' , 'id' => 'submit_alamat_name' ) ) }}
				</div>
			</div>				
			<div class="form-group" id="result_alamat_div">
				{{ $alamat_desa }}
			</div>
			<hr>
			{{ Form::hidden('file_name' 	, Input::old('file_name')		, array('id' => 'file_name') ) }}
			{{ Form::hidden('url_name' 		, Input::old('url_name')		, array('id' => 'url_name') ) }}
			{{ Form::hidden('path_name' 	, Input::old('path_name') 		, array('id' => 'path_name') ) }}
			{{ Form::hidden('sign_name' 	, '0'			, array('id' => 'sign_name') ) }}
			<div class="form-group">
				<div class="col-sm-offset-10 col-sm-1">
					{{ Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) ) }}
				</div>
			</div>
		</div>
		{{ Form::close() }}		
		<div class="col-md-4">
			<div class="thumbnail">
				<div class="col-md-4">
					<img id='image_url_name' class="img-responsive" src='{{ Input::old("url_name") }}' >
				</div>
				<div class="col-md-6">
	                <span class="btn btn-success fileinput-button">
	                    <i class="glyphicon glyphicon-plus"></i>
                        <span>Select files...</span>
	                        <input type="file" name="files[]" multiple id="dialog_upload_button_name">
                        </span>
				</div>
				<div class="clear"></div>
			</div>
		</div>

			@if( Session::has('message')  )
			    <div class="clear_25"></div>
			    <div class="col-sm-10">
			        <div class="alert alert-danger" role="alert">
			            {{ Session::get('message') }}  
			        </div>
			    </div>
			    <div class="clear_25"></div>
			@endif
@stop

