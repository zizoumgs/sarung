@extends('layouts.admin')

@section('title')
	Ujian | Santri
@stop
@include( 'sarung.admin.ujian_santri.common')
@include( 'sarung.admin.ujian_santri.dialog_add')
@section('content')
	<div class="bs-callout bs-callout-success" id="callout-progress-animation-css3">
		<h4 id="cross-browser-compatibility">Baca yang dibawah ini</h4>
		<p>Silahkan isi id ujian dengan ujian yang ingin tambahkan.</p>
	</div>

    <h1 class="title">Ujian Santri Information
	<a href="{{ root::get_url_admin_ujis()}}" class="btn btn-primary btn-xs" >Non Add</a> </h1>
    @if( Session::has('message')  )
        <div class="clear_25"></div>
        <div class="col-sm-9">
            <div class="alert alert-danger" role="alert">
                {{ Session::get('message') }}  
            </div>
        </div>
        <div class="clear_25"></div>
    @endif
		{{ Form::open(array('url' => root::get_url_admin_ujis('indexadd') , 'method' => 'get' ,
		'role' => 'search' ,'class' => 'navbar-form pull-left '	)) ; }}
			<div class="form-group">
                <div class="input-group ">
                	<input name="find_santri_name" id="find_santri_name" type="text"
                           class="form-control input-sm" title="Type santry name here"
                    placeholder="Type santry name here" Value="{{ Input::get('find_santri_name') }}" >
				</div>                
			</div>
			<div class="form-group">
                <div class="input-group ">
                    <input name="find_id_ujian_name" id="find_id_ujian_name" type="text" class="form-control input-sm" title="Type Id Ujian Here Here.."
                        placeholder="Type Id Ujian Here" Value="{{ Input::get('find_id_ujian_name') }}" >
                    <span class="input-group-btn"  >
                        <button type="submit" class="btn btn-success btn-sm" >
                        	<span class="glyphicon glyphicon-search"></span> &nbsp;
                        </button>
                    </span>						
                </div>

			</div>
		{{ Form::close() }}


		<p class="navbar-text navbar-right well well-sm x-small-font">{{$info}}</p>
		<div class="clear"></div>


    <div class="table_div medium-font">
        <table class="table table-striped table-hover" >
			<tr class ="header">
				<th>Id</th>
				<th>Santri</th>
				<th>Keterangan</th>
				<th>Class History</th>		
            </tr>
            @foreach ($items as $item)
                <tr>
					<td>
						<div class="btn-group-vertical">
                            <button class="btn btn-primary btn-sm"
                                    onclick="
                                    add_handle(
                                    {{ $item->santri_id}},
                                    '{{ $item->first_name .' '. $item->second_name}}',
                                    '{{ $item->id_from_outside_db}}'
                                    )
                                    "
                            >
                                Add
                            </button>
                            
						</div>
					</td>
					<td>
						<div class="col-md-4">
							<img src="{{ $item->foto }}" class="small-img my-thumbnail">
						</div>                        
                        <div class="col-md-8">
							<div class="inline">
								<span><span class="glyphicon glyphicon-user"></span> Nama: {{$item->first_name}} {{$item->second_name}} </span>
								<span><span class="glyphicon glyphicon-envelope"></span> Id: {{$item->santri_id}} </span>
								<span><span class="glyphicon glyphicon-envelope"></span> Created: {{ root::get_diff_date($item->created_at) }} </span>
								<span><span class="glyphicon glyphicon-envelope"></span> Updated: {{ root::get_diff_date($item->updated_at) }} </span>
							</div>
						</div>
					</td>
					<td>
						<button title="Event Name" class="btn btn-default btn-xs mar-rig-lit disabled">{{ $ujian_ket->kalender->event->nama		}}</button>
						<button title="Session" class="btn btn-default btn-xs mar-rig-lit disabled">{{ $ujian_ket->kalender->session->nama 	}}</button>
						<button title="Pelajaran" class="btn btn-default btn-xs mar-rig-lit disabled">{{ $ujian_ket->pelajaran->nama	 	}}</button>
						<button title="kelas" class="btn btn-default btn-xs mar-rig-lit disabled">{{ $ujian_ket->kelas->nama 		}}</button>
						<button title="Kelipatan" class="btn btn-default btn-xs mar-rig-lit disabled">{{ $ujian_ket->kalinilai		}}</button>
						<button title="Pelaksanaan" class="btn btn-default btn-xs mar-rig-lit disabled">{{ $ujian_ket->pelaksanaan	}}</button>
					</td>
					<td>
                        <button title="Pelaksanaan" class="btn btn-default btn-xs mar-rig-lit disabled">{{ $item->kelas_name }} <br> {{ $item->session_name	}}</button>
					</td>
                </tr>
            @endforeach
        </table>
		<hr>
        {{ $pagination->appends( $wheres )->links() }}
    </div>
    <div class="clear_10"></div>

@stop
