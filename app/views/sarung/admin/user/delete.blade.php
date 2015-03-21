@extends('layouts.admin')

@section('title')
	User | Edit
@stop

@include( 'sarung.admin.user.common')
@section('content')
    <h1 class="title">Edit User
        <a href="{{ root::get_url_admin_user()}}" class="btn btn-primary btn-xs" >View</a>
    </h1>
		
    <hr class="mar_25">
    {{ Form::open(array('url' => root::get_url_admin_user('delete') , 'method' => 'post' ,	'role' => 'form' ,'class' => 'form-horizontal' )) }}
		{{ Form::hidden('id',  $id ) }}
		<div class="col-md-8">
			<div class="form-group" title="Nama Awal Siswa">
				<label for="first_name" class="col-sm-3 control-label" >First Name</label>
				<div class="col-sm-9">
					<input  name="first_name" class="form-control"
							type="text" placeholder="First Name" 
							value="{{ $first_name }}" disabled
					>
				</div>
			</div>
			<div class="form-group" title="Jika kosong Berikan nama ayah">
				<label for="second_name" class="col-sm-3 control-label" >Second Name</label>
				<div class="col-sm-9">
					<input  name="second_name" class="form-control"
							type="text" placeholder="Second Name" 
							disabled value="{{ $second_name }}"
					>
				</div>
			</div>
			<hr>
			<div class="form-group" title="Email ini akan dibuat untuk login">
				<label for="email_name" class="col-sm-3 control-label" >Email</label>
				<div class="col-sm-9">
					<input  name="email_name" class="form-control"
							type="email" placeholder="Email" 
							disabled	value="{{ $email_name }}"
					>
				</div>
			</div>
			<hr>
			<div class="form-group">
				<label for="tanggal_lahir_name" class="col-sm-3 control-label">Tanggal</label>
				<div class="col-sm-5">
					<input type="text" name="tanggal_lahir_name" id="tanggal_lahir_name"
						   class="form-control" value="{{ $tanggal_lahir_name }}" disabled 
					>
				</div>
			</div>
			<div class="form-group">
				<label for="tempat_lahir_name" class="col-sm-3 control-label" >Tempat Lahir</label>
				<div class="col-sm-5">
					<select class="form-control input-sm" name="tempat_lahir_name">
						@foreach( Kabupaten_Model::get() as $val )
							<option value="{{ $val->id }}"
								@if ( $val->id === (int) $tempat_lahir_name ) &&  $tempat_lahir_name != "All" )
									selected
								@endif
							>
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
						<input type="radio" name="gender_name" id="gender_id" value="1"
							   @if ( $gender_name == 'L' )
									checked
							   @endif
							   > Pria
					</label>
					<label class="radio-inline">
						<input type="radio" name="gender_name" id="gender_id" value="0"
							   @if ( $gender_name == 'W' )
									checked
							   @endif
							   > Wanita
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
								@if ( $key === (int) $status_name &&  $status_name != "All" )
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
							<option value="{{ $val->id }}"
								@if ( $val->id === (int) $group_name ) &&  $group_name != "All" )
									selected
								@endif
							>
								{{ $val->nama }}
							</option>
						@endforeach
					</select>
				</div>
			</div>
			<hr>
			<div class="form-group" id="result_alamat_div">
				{{ $alamat_desa }}
			</div>
			<hr>
			{{ Form::hidden('file_name' 	, $file_name	, array('id' => 'file_name') ) }}
			{{ Form::hidden('url_name' 		, $url_name		, array('id' => 'url_name') ) }}
			{{ Form::hidden('path_name' 	, $path_name	, array('id' => 'path_name') ) }}
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
					<img id='image_url_name' class="img-responsive" src='{{ $url_name }}' >
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

