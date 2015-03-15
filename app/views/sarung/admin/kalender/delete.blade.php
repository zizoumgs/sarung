@extends('layouts.admin')

@section('title')
	Kalender | Delete
@stop
@include( 'sarung.admin.kalender.common')

@section('content')
    <h1 class="title">Delete Kalender
        <a href="{{ root::get_url_admin_kalender()}}" class="btn btn-primary btn-xs" >View</a>
    </h1>
    <hr class="mar_25">
	<div class="col-md-7" style="padding:15px;">
    {{ Form::open(array('url' => root::get_url_admin_kalender('delete') , 'method' => 'post' ,
	'role' => 'form' ,'class' => 'form-horizontal'
	, "ng-app" => "NumberApp" ,"ng-controller" => "NumberController"  )) ; }}
        {{ Form::hidden('id',  $id ) }}
        <div class="form-group">
            <label for="{{ $helper::get_session_name }}" class="col-sm-2 control-label">Session</label>
            <div class="col-sm-10">
				<select class="form-control" name="{{ $helper::get_session_name }}">
					@foreach( Session_Model::orderBy('nama' , 'DESC')->get() as $model)
						<option value="{{ $model->nama }}"
							@if ($model->nama === $session)
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
            <label for="{{ $helper::get_event_name }}" class="col-sm-2 control-label">Event</label>
            <div class="col-sm-10">
				<select class="form-control" name="{{ $helper::get_event_name }}">
					@foreach( Event_Model::orderBy('nama' , 'DESC')->get() as $model)
						<option value="{{ $model->nama }}"
							@if ($model->nama === $event)
								selected
							@endif
						>								
							{{ $model->nama }}
						</option>
					@endforeach
				</select>
            </div>
        </div>
		<hr>
        <div class="form-group">
            <label for="stayed" class="col-sm-2 control-label" title="Rating antara 1-5 ">Rating</label>
            <div class="col-sm-10">
				<input  name="{{ $helper::get_rating_name }}" class="form-control "
						type="text" placeholder="Rating" title="Rating"
						value= "{{ $rating }}" disabled >
            </div>
        </div>
        <div class="form-group">
            <label for="stayed" class="col-sm-2 control-label">Money</label>
            <div class="col-sm-10">
				<input  name="{{ $helper::get_money_name }}" class="form-control "
						type="number" placeholder="Uang" title="Uang yang akan/sudah dikeluarkan!"
						require ng-pattern="/^\d{0,9}(\.\d{1,9})?$/"
						value= "{{ $money }}" disabled >
            </div>
        </div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-2 ">
				<div class="checkbox" title="Status sekolah Libur atau tidak">
					<label>
						<input type="checkbox" Value="1" name="{{ $helper::get_aktif_name}}"
							@if( $aktif == 1)
							   checked
							@endif
                            disabled >
                            Aktif
					</label>
				</div>
			</div>
		</div>
		<hr>
        <div class="form-group">
            <label for="awal" class="col-sm-2 control-label">Awal</label>
            <div class="col-sm-10">
				<input  name="{{ $helper::get_awal_name }}" class="form-control "
						id="{{ $helper::get_awal_name }}"
						type="text" placeholder="Awal" title="Awal Kalender"
						value="{{$awal}}" disabled >
            </div>
        </div>
		
        <div class="form-group">
            <label for="awal" class="col-sm-2 control-label">Akhir </label>
            <div class="col-sm-10">
				<input  name="{{ $helper::get_akhir_name }}" class="form-control "
						id="{{ $helper::get_akhir_name }}"
						type="text" placeholder="Akhir" title="Akhir Kalender"
						value="{{$akhir}}" disabled  >
            </div>
        </div>
		
		<hr>		
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-4">
                {{ Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) ) }}
            </div>
        </div>
    {{ Form::close() }}
	
    @if( Session::has('message')  )
        <div class="clear_25"></div>
        <div class="col-sm-offset-2 col-sm-10">
            <div class="alert alert-danger" role="alert">
                {{ Session::get('message') }}  
            </div>
        </div>
        <div class="clear_25"></div>
    @endif
	</div>
		
		
		
	<div class="col-md-5" style="padding:15px;">
		<div class="thumbnail">
			<h2><b>Information</b></h2><hr>
			<p>Table ini memerlukan pengisian table <a href="{{ root::get_url_admin_session("add") }}" class="btn btn-xs btn-link">Session</a> dan <a href="{{ root::get_url_admin_event("add") }}" class="btn btn-xs btn-link">Event</a> ,
			jadi bila and tidak menemukan session atau event yang anda inginkan anda harus menambahkannya terlebih dahulu!</p>
			<div class="clear"></div>
		</div>
	<div>
@stop

