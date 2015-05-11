@extends('layouts.admin')

@section('title')
	Kasus | Edit
@stop
@include( 'sarung.admin.pelanggaran.larangan_kasus.common')

@section('content')
    <h1 class="title">Edit Kasus
        <a href="{{ root::get_url_admin_larangan_kasus()}}" class="btn btn-primary btn-xs" >View</a>
    </h1>
    @if( Session::has('message')  )
        <div class="clear_25"></div>
        <div class="col-sm-9">
            <div class="alert alert-danger" role="alert">
                {{ Session::get('message') }}  
            </div>
        </div>
        <div class="clear_25"></div>
    @endif
	
    <hr class="mar_25">
	<div class="col-md-8">
	{{ Form::open( array('url' => root::get_url_admin_larangan_kasus('edit/') , 'method' => 'post' ,
	    'role' => 'form'		,   'class' => 'form-horizontal',
        'name' => 'add_name'    ,   'id'    => 'add_name'
     ) ) }}
	{{ Form::hidden('id' , $id ,array('id'=>'id'))}}
	<div class="form-group">
		<label for="id_santri_name" class="col-sm-3 control-label">Id Santri</label>
	    <div class="col-sm-9">
			  <input class="form-control" type="number" id="id_santri_name" name="id_santri_name" VALUE="{{ $id_santri_name}}" />
		</div>
	</div>

	<div class="form-group">
		<label for="santri_name" class="col-sm-3 control-label">Nama</label>
	    <div class="col-sm-9">
			  <input class="form-control" type="text" id="santri_name" name="santri_name" READONLY VALUE="{{ $santri_name}}" />
		</div>
	</div>

	<div class="form-group">
		<label for="alamat_name" class="col-sm-3 control-label">Alamat</label>
	    <div class="col-sm-9">
			  <input class="form-control" type="text" id="alamat_name" name="alamat_name" READONLY VALUE="{{ $alamat_name}}" />
		</div>
	</div>


	<div class="form-group">
		<label for="date_name" class="col-sm-3 control-label">Tanggal</label>
	    <div class="col-sm-9">
			  <input class="form-control" type="text" id="date_name" name="date_name" VALUE="{{ $date_name}}" />
		</div>
	</div>

	<hr>
	
	<div class="form-group">
		<label for="id_pelanggaran_name" class="col-sm-3 control-label">Id Pelanggaran</label>
	    <div class="col-sm-9">
			  <input class="form-control" type="number" id="id_pelanggaran_name" name="id_pelanggaran_name" VALUE="{{ $id_pelanggaran_name}}"/>
		</div>
	</div>

	<div class="form-group">
		<label for="pelanggaran_name" class="col-sm-3 control-label">Nama</label>
	    <div class="col-sm-9">
			  <input class="form-control" type="text" id="pelanggaran_name" name="pelanggaran_name" READONLY VALUE="{{ $pelanggaran_name}}" />
		</div>
	</div>

	<div class="form-group">
		<label for="session_name" class="col-sm-3 control-label">Session</label>
	    <div class="col-sm-9">
			  <input class="form-control" type="text" id="session_name" name="session_name" READONLY VALUE="{{ $session_name}}"/>
		</div>
	</div>
	
	
	
	<div class="form-group">
		<div class="col-sm-offset-11 col-sm-1">
			{{ Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) ) }}
		</div>
	</div>
	{{ Form::close(); }}
	</div>
@stop
