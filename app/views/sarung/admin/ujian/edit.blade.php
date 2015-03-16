@extends('layouts.admin')

@section('title')
	Ujian | Edit
@stop
@include( 'sarung.admin.ujian.common')

@section('content')
    <h1 class="title">Edit Ujian
        <a href="{{ root::get_url_admin_ujian()}}" class="btn btn-primary btn-xs" >View</a>
    </h1>
    <hr class="mar_25">
	<div class="col-md-7" style="padding:15px;">
    {{ Form::open(array('url' => root::get_url_admin_ujian('edit') , 'method' => 'post' ,
	'role' => 'form' ,'class' => 'form-horizontal'
	, "ng-app" => "NumberApp" ,"ng-controller" => "NumberController"  )) ; }}
		{{ Form::hidden('id',  $id ) }}
        <div class="form-group">
            <label for="{{ $helper::get_event_name }}" class="col-sm-3 control-label">Session | Event</label>
            <div class="col-sm-9">
				<select class="form-control" name="{{ $helper::get_kalender_name }}">
					@foreach( Kalender_Model::orderBy('created_at' , 'DESC')->get(	) as $model)
						<option value="{{ $model->id }}"
						@if ( $id_kalender === $model->id)
							Selected 
						@endif
						> {{ $model->session->nama }} | {{ $model->event->nama }} </option>
					@endforeach
				</select>
            </div>
        </div>
		<hr>
        <div class="form-group">
            <label for="{{ $helper::get_pelajaran_name }}" class="col-sm-3 control-label">Pelajaran</label>
            <div class="col-sm-9">
				<select class="form-control" name="{{ $helper::get_pelajaran_name }}">
					@foreach( Pelajaran_Model::orderBy('created_at' , 'DESC')->get(	) as $model)
						<option value="{{ $model->id }}"
						@if ( $id_pelajaran === $model->id)
							Selected 
						@endif
						>{{ $model->nama }} </option>
					@endforeach
				</select>
            </div>
        </div>
		<hr>
        <div class="form-group">
            <label for="{{ $helper::get_kelas_name }}" class="col-sm-3 control-label">Kelas</label>
            <div class="col-sm-9">
				<select class="form-control" name="{{ $helper::get_kelas_name }}">
					@foreach( Kelas_Model::orderBy('created_at' , 'DESC')->get(	) as $model)
						<option value="{{ $model->id }}"
						@if ( $id_kelas === $model->id)
							Selected
						@endif	
						>{{ $model->nama }} </option>
					@endforeach
				</select>
            </div>
        </div>
		<hr>
		<div class="form-group" title="Nilai yang akan di kalikan ke nilai yang di dapat siswa">
		    <label for="stayed" class="col-sm-3 control-label" >Kelipatan</label>
		    <div class="col-sm-9">
				<input  name="{{ $helper::get_kelipatan_name }}" class="form-control"
						type="number" placeholder="Kelipatan" 
						step="0.1" max="100" min="-15"
						require value="{{ $kelipatan }}"
				>
		    </div>
		</div>
		<div class="form-group" title=" Nilai yang diharapkan oleh guru">
		    <label for="stayed" class="col-sm-3 control-label">Standard Nilai</label>
		    <div class="col-sm-9">
				<input  name="{{ $helper::get_nilai_name }}" class="form-control "
						type="number" placeholder="Standard Nilai"
						step="0.1"
						require ng-pattern="/^\d{0,9}(\.\d{1,9})?$/" value="{{ $nilai }}"
				>
		    </div>
		</div>			
		<hr>
        <div class="form-group">
            <label for="awal" class="col-sm-3 control-label">Tanggal</label>
            <div class="col-sm-5">
				<input type="text" name="{{ $helper::get_date_name }}" id="{{ $helper::get_date_name }}"
					   class="form-control" value="{{ $date }}" 
				>
            </div>
			<label for="awal" class="col-sm-1 control-label">Waktu</label>
            <div class="col-sm-3">
				<input type="text" name="{{ $helper::get_time_name }}" id="{{ $helper::get_time_name }}"
					   require ng-pattern="^(?:\d|[01]\d|2[0-3]):[0-5]\d$"	   class="form-control"
					   title="Format waktu hh:mm" value="{{$time}}"
				>
            </div>
        </div>
		<hr>		
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                {{ Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) ) }}
            </div>
        </div>
    {{ Form::close() }}
	
    @if( Session::has('message')  )
        <div class="clear_25"></div>
        <div class="col-sm-offset-3 col-sm-9">
            <div class="alert alert-danger" role="alert">
                {{ Session::get('message') }}  
            </div>
        </div>
        <div class="clear_25"></div>
    @endif
	</div>

	<div class="col-md-5" style="padding:15px;">
		<div class="thumbnail" style="padding:10px;">
			<h2><b>Information</b></h2><hr>
			<p>
				Table ini memerlukan pengisian table <a href="{{ root::get_url_admin_kalender("add") }}" class="btn btn-xs btn-link">Kalender</a>,<br>
			jadi bila anda tidak dapat menemukan kalender yang anda inginkan anda harus menambahkannya terlebih dahulu!</p>
			<div class="clear"></div>
		</div>
	<div>
@stop

