@extends('layouts.admin')

@section('title')
	Nama Pelanggaran | Add 
@stop

@section('content')
    <h1 class="title">Add Santri
        <a href="{{ root::get_url_admin_user()}}" class="btn btn-primary btn-xs" >View</a>
    </h1>
	
    <hr class="mar_25">
	<div class="col-md-8">
	{{ Form::open( array('url' => root::get_url_admin_nama_pelanggaran('add/') , 'method' => 'post' ,
	    'role' => 'form'            ,   'class' => 'form-horizontal',
        'name' => 'add_name'     ,   'id'    => 'add_name'
     ) ) }}
	<div class="form-group">
		<label for="session_name" class="col-sm-3 control-label">Nama Pelanggaran</label>
	    <div class="col-sm-9">
			{{ Form::text('nama_pelanggaran_name', '' , array('id' => 'nama_pelanggaran_name' , 'class' => 'form-control' )) }}
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
