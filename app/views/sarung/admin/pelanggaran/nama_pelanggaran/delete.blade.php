@extends('layouts.admin')

@section('title')
	Nama Pelanggaran | Delete
@stop

@section('content')
    <h1 class="title">Menghapus Nama Pelanggaran
        <a href="{{ root::get_url_admin_nama_pelanggaran()}}" class="btn btn-primary btn-xs" >View</a>
    </h1>
    <hr class="mar_25">
    @if( Session::has('message')  )
        <div class="clear_25"></div>
        <div class="col-sm-9">
            <div class="alert alert-danger" role="alert">
                {{ Session::get('message') }}  
            </div>
        </div>
        <div class="clear_25"></div>
    @endif		
	<div class="col-md-8">
	{{ Form::open( array('url' => root::get_url_admin_nama_pelanggaran('delete/') , 'method' => 'post' ,
	    'role' => 'form'            ,   'class' => 'form-horizontal',
        'name' => 'add_name'     ,   'id'    => 'add_name'
     ) ) }}
	{{ Form::hidden('id' , $id_pelanggaran ,array('id'=>'id'))}}
	<div class="form-group">
		<label for="session_name" class="col-sm-3 control-label">Nama Pelanggaran</label>
	    <div class="col-sm-9">
			{{ Form::text('nama_pelanggaran_name', $nama_pelanggaran_name , array('id' => 'nama_pelanggaran_name' , 'class' => 'form-control' ,'Readonly'=>'' )) }}
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-11 col-sm-1">
			{{ Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ,'Readonly'=>'' ) ) }}
		</div>
	</div>
	{{ Form::close(); }}
	</div>
@stop
