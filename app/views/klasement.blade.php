@extends('layouts.klasement_layout')

@section('title')
	Klasement
@stop

@section('content')
	<hr>				
	<div class="page-header">
		<div class="row">
			<div class="col-md-7">
				<h1>Klasement<small> Santri Fatihul Ulum</small></h1>
	        </div>
	        <div class="col-md-5">
				<div class="pull-right">
					{{ Form::open( array('class' => "form-inline " , 'url' => root::get_url_klasement())) }}							
					<select class="form-control form-control-xs" name="session">
						<option value="All">ALL</option>
						@foreach( Session_Model::orderBy('created_at' , 'desc' )->get() as $res )
							@if( $res->nama  === Input::get('session') )
								<option value="{{ $res->nama }}" selected>{{ $res->nama}}</option>
							@else
								<option value="{{ $res->nama }}" >{{ $res->nama}}</option>
							@endif
						@endforeach
					</select>
					<select class="form-control form-control-xs" name="kelas">
						<option value="All">ALL</option>
						@foreach( Kelas_Model::orderBy('created_at' , 'desc' )->get() as $res )
							@if( $res->nama  === Input::get('kelas') )
								<option value="{{ $res->nama }}" selected>{{ $res->nama}}</option>
							@else
								<option value="{{ $res->nama }}" >{{ $res->nama}}</option>
							@endif
						@endforeach
					</select>
					<button type="submit" class="btn btn-default">
						<span class="glyphicon glyphicon-search"></span>
					</button>
					{{ Form::close(); }}
	            </div>
	        </div>
        </div>
    </div>
    <hr>
	<div class="table-responsive">
	<table class="table table-condensed table-bordered table-striped">
		<tr>
			<th> Nama </th>
			<th> Score </th>
			<th> Takzir </th>
			<th> Total </th>
		</tr>
		<?php $total_row = count($santries) ; ?>
		@foreach($santries as $santri)
			<tr>
				<td>
					<a href="{{ root::get_url_profile( 'santri/'.$santri->id_santri )}}">
						@if ( $total_row <= $total_stay )
							<span style="text-decoration: line-through;"> {{ $santri->name}}</span>
						@else
							{{ $santri->name}}
						@endif						
					</a>
					<span class="badge pull-right blue">{{$santri->id_santri}}</span>					
				</td>
				<td> {{ $santri->score}} </td>
				<td> {{ $santri->takzir}} </td>
				<td> {{ $santri->nilai }} </td>
			</tr>
			<?php $total_row--; ?>
		@endforeach
	</table>
	<br>
	<br>	
@stop
