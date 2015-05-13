@extends('layouts.klasement_layout')

@section('title')
	Profile
@stop

@section('content')
	<hr>
	<div class="page-header">
		<div class="row">
			<div class="col-md-7">
				<h1>Profile<small> Santri Fatihul Ulum</small></h1>
	        </div>
        </div>
    </div>
    <hr>
	<div class="table-responsive">
		<table class="table table-condensed table-bordered table-striped">
            <tr>
                <td>Id</td>
                <td>Nama</td>
                <td>Point</td>
                <td>Pelanggaran</td>
                <td>Session</td>
                <td>Tanggal</td>
            </tr>
 			@foreach($santri as $san)
                <tr>
                    <td>{{ $san->idsantri_name }}</td>
                    <td>{{ $san->santri_name }}</td>
                    <td>{{ $san->point_name }}</td>
                    <td>{{ $san->pelanggaran_name}}</td>
                    <td>{{ $san->session_name}}</td>
                    <td>{{ $san->time_name }}</td>                    
                </tr>
            @endforeach
        </table>
    </div>    
    
@stop