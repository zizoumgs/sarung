@extends('layouts.admin')

@section('title')
	Session|Delete
@stop
@include( 'sarung.admin.session.common')
@section('content')
    <h1 class="title">Delete Session
        <a href="{{ root::get_url_admin_session()}}" class="btn btn-primary btn-xs" >View</a>
    </h1>
    <hr class="mar_25">
    {{ Form::open(array('url' => root::get_url_admin_session('delete') , 'method' => 'post' , 'role' => 'form' ,'class' => 'form-horizontal')) ; }}
        {{ Form::hidden('id',  $id ) }}
        <div class="form-group">
            <label for="{{ Session_Helper::get_up_model_name }}" class="col-sm-2 control-label">Model Kenaikan</label>
            <div class="col-sm-4">
				<select class="form-control" name="{{ Session_Helper::get_up_model_name }}">
					@foreach( $models as $model)
						<option value="{{ $model }}"
								@if ($model === $selected)
									selected
								@endif
						>{{ $model }}</option>
					@endforeach
				</select>
            </div>
        </div>

        <div class="form-group">
            <label for="stayed" class="col-sm-2 control-label">Tidak Naik</label>
            <div class="col-sm-4">
				<input  name="{{ Session_Helper::get_nilai_name }}" class="form-control "
						type="text" placeholder="Standard ketidak-naikan" title="Total santri tidak naik"
						value="{{ $tidak_naik_value}}"  disabled>
            </div>
        </div>
		<hr>

        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Name Session</label>
            <div class="col-sm-4">
				<input  name="{{ Session_Helper::get_session_name }}" class="form-control "
						type="text" placeholder="Session" title="Name Example: 07-08"
						value="{{ $session_value}}" disabled>
            </div>
        </div>
		
        <div class="form-group">
            <label for="perkiraan_nominal_santri" class="col-sm-2 control-label" >Perkiraan Nominal Santri</label>
            <div class="col-sm-4">
				<input  name="{{ Session_Helper::get_perkiraan_santri_name }}" class="form-control " type="text"
						placeholder="Perkiraan nominal santri" title="Perkiraan nominal santri , eg: 100 = 2"
						value="{{ $perkiraan_santri_value}}" disabled >
            </div>
        </div>

        <div class="form-group">
            <label for="awal" class="col-sm-2 control-label">Awal Session</label>
            <div class="col-sm-4">
				<input  name="{{ Session_Helper::get_awal_name }}" class="form-control "
						id="{{ Session_Helper::get_awal_name }}"
						type="text" placeholder="Awal" title="Awal Session"
						value="{{ $awal_value}}" disabled >
            </div>
        </div>
		
        <div class="form-group">
            <label for="awal" class="col-sm-2 control-label">Akhir Session</label>
            <div class="col-sm-4">
				<input  name="{{ Session_Helper::get_akhir_name }}" class="form-control "
						id="{{ Session_Helper::get_akhir_name }}"
						type="text" placeholder="Akhir" title="Akhir Session"
						value="{{ $akhir_value}}" disabled>
            </div>
        </div>
		
		<hr>		
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-4">
                {{ Form::submit('Submit' , array( 'class' => 'btn btn-danger btn-sm' ) ) }}
            </div>
        </div>
    {{ Form::close() }}
	
    @if( Session::has('message')  )
        <div class="clear_25"></div>
        <div class="col-sm-offset-2 col-sm-4">
            <div class="alert alert-danger" role="alert">
                {{ Session::get('message') }}  
            </div>
        </div>
        <div class="clear_25"></div>
    @endif
@stop

