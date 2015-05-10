@extends('layouts.admin')

@section('title')
	Peraturan | Delete
@stop

@section('content')
    <h1 class="title">Delete Peraturan
        <a href="{{ root::get_url_admin_larangan_meta()}}" class="btn btn-primary btn-xs" >View</a>
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
	{{ Form::open( array('url' => root::get_url_admin_larangan_meta('delete/') , 'method' => 'post' ,
	    'role' => 'form'            ,   'class' => 'form-horizontal',
        'name' => 'add_name'     ,   'id'    => 'add_name'
     ) ) }}
 	{{ Form::hidden('id' , $id ,array('id'=>'id'))}}

	<div class="form-group">
		<label for="pelanggaran_name" class="col-sm-3 control-label">Nama Pelanggaran</label>
	    <div class="col-sm-9">
			<select class="form-control" name="pelanggaran_name">
				@foreach( Larangan_Nama_Model::orderBy('nama' , 'DESC')->get() as $model)
					<option value="{{ $model->nama }}"
						@if ($model->nama === $pelanggaran_name )
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
		<label for="session_name" class="col-sm-3 control-label">Session</label>
	    <div class="col-sm-9">
			<select class="form-control" name="session_name">
				@foreach( Session_Model::orderBy('nama' , 'DESC')->get() as $model)
					<option value="{{ $model->nama }}"
						@if ($model->nama === $session_name ) )
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
		<label for="type_name" class="col-sm-3 control-label">Jenis</label>
	    <div class="col-sm-9">
				<select class="form-control" name="type_name">
					@foreach( $types as $type )
						<option value="{{ $type }}"
							@if ( $type === $type_name ) )
								selected
							@endif										
						>{{ $type }}</option>
					@endforeach
				</select>
		</div>
	</div>
	
	<div class="form-group">
		<label for="point_name" class="col-sm-3 control-label">Point</label>
	    <div class="col-sm-9">
			  <input class="form-control" type="number" name="point_name" value="{{ $point_name}}" READONLY/>
		</div>
	</div>

	
	<div class="form-group">
		<label for="hukuman_name" class="col-sm-3 control-label">Hukuman</label>
	    <div class="col-sm-9">
			<textarea class="form-control" rows="5" id="hukuman_name" name="hukuman_name" READONLY>{{ $hukuman_name}}</textarea>
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
