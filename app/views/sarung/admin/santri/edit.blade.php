@extends('layouts.admin')

@section('title')
	Santri | Edit
@stop

@include( 'sarung.admin.santri.common')

@section('content')
    <h1 class="title">Edit Santri
        <a href="{{ root::get_url_admin_user()}}" class="btn btn-primary btn-xs" >View</a>
    </h1>
	
    <hr class="mar_25">
	<div class="col-md-8">
	{{ Form::open( array('url' => root::get_url_admin_santri('edit') , 'method' => 'post' ,
	    'role' => 'form'            ,   'class' => 'form-horizontal',
        'name' => 'dialog_edit_name'     ,   'id'    => 'dialog_edit_name'
     ) ) }}
	 {{ Form::hidden('id' , $id_santri_name ,array('id'=>'id'))}}
	<div class="form-group">
		<label for="session_name" class="col-sm-3 control-label">Awal Session</label>
	        <div class="col-sm-9">
				<select class="form-control col-sm-2" name="session_name">
					@foreach( Session_Model::orderBy('nama' , 'DESC')->get() as $model)
						<option value="{{ $model->id }}"
							@if ($model->id == $session_name )
								selected
   							@endif							
						>
							{{ $model->nama }}
   						</option>
   					@endforeach
   				</select>
			</div>
	</div>
    <div class="form-group">
		<label for="keluar_name" class="col-sm-3 control-label">Berhenti</label>
		<div class="col-sm-9">
	        {{ Form::text('keluar_name', $keluar_name , array('id' => 'keluar_name' ,
			'class' => 'form-control' ,
			'title' => 'Kosongkan untuk yang belum berhenti' )) }}
    	</div>
    </div>
	
    <div class="form-group">
		<label for="id_santri_name" class="col-sm-3 control-label">Id Santri</label>
		<div class="col-sm-9">
	        {{ Form::text('id_santri_name', $id_santri_name , array('id' => 'id_santri_name' , 'class' => 'form-control' ,'ReadOnly'=>'' )) }}
    	</div>
    </div>
    <div class="form-group">
		<label for="dialog_santri_name" class="col-sm-3 control-label">Santri Name</label>
		<div class="col-sm-9">
	       {{ Form::text('santri_name', $santri_name , array('id' => 'santri_name' , 'class' => 'form-control' ,'ReadOnly'=>'' )) }}
		</div>
    </div>
    <div class="form-group">
		<label for="catatan_name" class="col-sm-3 control-label">Catatan</label>
    	<div class="col-sm-9">
			{{ Form::TextArea(	'catatan_name', '' ,
				array('id' => 'catatan_name' ,
				'class' => 'form-control' ,'Rows'=>'5' )) }}
    	</div>
    </div>
	<div class="form-group">
		<div class="col-sm-offset-10 col-sm-1">
			{{ Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) ) }}
		</div>
	</div>
	{{ Form::close(); }}
	</div>
	<div class="col-md-2">
		<img src="{{ $foto }}" class="fancy_img">
	</div>
@stop
