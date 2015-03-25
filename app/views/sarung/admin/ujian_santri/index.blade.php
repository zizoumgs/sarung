@extends('layouts.admin')

@section('title')
	Ujian | Santri
@stop
@include( 'sarung.admin.ujian_santri.common')
@include( 'sarung.admin.ujian_santri.dialog_edit')
@include( 'sarung.admin.ujian_santri.dialog_delete')
@section('content')
	<div class="bs-callout bs-callout-success" id="callout-progress-animation-css3">
		<h4 id="cross-browser-compatibility">Baca yang dibawah ini</h4>
		<p>Pastikan anda mengetahui id ujiannya.</p>
	</div>

    <h1 class="title">Ujian Santri Information
	<a href="{{ root::get_url_admin_ujis('indexadd')}}" class="btn btn-primary btn-xs" >Add</a> </h1>
    @if( Session::has('message')  )
        <div class="clear_25"></div>
        <div class="col-sm-9">
            <div class="alert alert-danger" role="alert">
                {{ Session::get('message') }}  
            </div>
        </div>
        <div class="clear_25"></div>
    @endif
		{{ Form::open(array('url' => root::get_url_admin_ujis() , 'method' => 'get' ,
		'role' => 'search' ,'class' => 'navbar-form pull-left '	, 'name' => 'find_form')) ; }}
			<div class="form-group">
				<label for="find_session_name" >Session</label>
				<select class="form-control" name="find_session_name">
					<option value="All">All</option>
					@foreach( Session_Model::orderBy('nama' , 'DESC')->get() as $model)
						<option value="{{ $model->nama }}"
							@if ($model->nama === Input::get('find_session_name') )
								selected
							@endif							
							>
							{{ $model->nama }}
						</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label for="find_event_name" >Pelajaran</label>
				<select class="form-control" name="find_pelajaran_name">
					<option value="All">All</option>
					@foreach( Ujian_Model::get_ujian_pelajaran_names() as $model)
						<option value="{{ $model->nama }}"
							@if ($model->nama === Input::get('find_pelajaran_name') )
								selected
							@endif							
							>
							{{ $model->nama }}
						</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label for="find_event_name" >Kelas</label>
				<select class="form-control" name="find_kelas_name">
					<option value="All">All</option>
					@foreach( Kelas_Model::orderby('nama' , 'ASC')->get() as $model)
						<option value="{{ $model->nama }}"
							@if ($model->nama === Input::get('find_kelas_name') )
								selected
							@endif							
							>
							{{ $model->nama }}
						</option>
					@endforeach
				</select>
			</div>			
			<div class="form-group">
				<label for="find_santri_name" >Santri</label>			
				<input type="text" name="find_santri_name" id="find_santri_name"  class="form-control"
					   value="{{ Input::get('find_santri_name') }}"
				>
			</div>
			<div class="form-group">
				{{ Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) ) }}
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
				<th>Nilai</th>		
            </tr>
            @foreach ($items as $item)
                <tr>
					<td>
						<div class="btn-group-vertical">
							<button class="btn btn-primary btn-xs" onclick="edit_handle(
								{{ $item->santri_id	 }}									,
								'{{ $item->first_name." ". $item->second_name 	 }}'	,
								'{{ $item->course_name	}}'								,
								'{{ $item->session_name	}}'								,
								'{{ $item->event_name 	}}'								,
								'{{ $item->pelaksanaan	}}'								,
								'{{ $item->kelas_name	}}'								,
								'{{ $item->nilai 	 	}}'								,
								'{{ $item->id_ujian		}}'								,
								'{{ $item->id	 	 	}}'								
							)">Edit</button>
							<button class="btn btn-primary btn-xs" onclick="delete_handle(
								{{ $item->santri_id	 }}									,
								'{{ $item->first_name." ". $item->second_name 	 }}'	,
								'{{ $item->course_name	}}'								,
								'{{ $item->session_name	}}'								,
								'{{ $item->event_name 	}}'								,
								'{{ $item->pelaksanaan	}}'								,
								'{{ $item->kelas_name	}}'								,
								'{{ $item->nilai 	 	}}'								,
								'{{ $item->id_ujian		}}'								,
								'{{ $item->id	 	 	}}'								
							)">Delete</button>
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
						<button title="Event Name" class="btn btn-default btn-xs mar-rig-lit disabled">{{ $item->event_name		}}</button>
						<button title="Session" class="btn btn-default btn-xs mar-rig-lit disabled">{{ $item->session_name	}}</button>
						<button title="Pelajaran" class="btn btn-default btn-xs mar-rig-lit disabled">{{ $item->course_name	}}</button>
						<button title="kelas" class="btn btn-default btn-xs mar-rig-lit disabled">{{ $item->kelas_name		}}</button>
						<button title="Kelipatan" class="btn btn-default btn-xs mar-rig-lit disabled">{{ $item->kalinilai		}}</button>
						<button title="Pelaksanaan" class="btn btn-default btn-xs mar-rig-lit disabled">{{ $item->pelaksanaan	}}</button>
					</td>
					<td>
						<b> {{ $item->nilai }} </b>
					</td>
                </tr>
            @endforeach
        </table>
		<hr>
        {{ $pagination->appends( $wheres )->links() }}
    </div>
    <div class="clear_10"></div>

@stop
