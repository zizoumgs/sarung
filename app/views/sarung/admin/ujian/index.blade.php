@extends('layouts.admin')

@section('title')
	Ujian | Table 
@stop
@include( 'sarung.admin.kalender.common')

@section('content')
    <h1 class="title"> Ujian Table <a href="{{ root::get_url_admin_ujian('add')}}" class="btn btn-primary btn-xs" >Add</a></h1>

		{{ Form::open(array('url' => root::get_url_admin_ujian() , 'method' => 'get' ,
		'role' => 'search' ,'class' => 'navbar-form pull-left ',
		"ng-app" => "NumberApp" ,"ng-controller" => "NumberController"  )) ; }}
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
				<label for="find_event_name" >Event</label>			
				<select class="form-control" name="find_event_name">
					<option value="All">All</option>
					@foreach( Event_Model::orderBy('nama' , 'DESC')->get() as $model)
						<option value="{{ $model->nama }}"
							@if ($model->nama === Input::get('find_event_name') )
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
				{{ Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) ) }}
			</div>
		{{ Form::close() }}
		<p class="navbar-text navbar-right well well-sm x-small-font">{{$info}}</p>
		<div class="clear"></div>


    <div class="table_div medium-font">
        <table class="table table-striped table-hover" >
            <tr class ="header">
				<th>Id</th>
                <th>Edit/Delete</th>
				<th>Event</th>
                <th>Another</th>
 				<th>Aktif</th>
    		</tr>
            @foreach ($items as $item)
                <tr>
                    <td>
						{{ $item->id }}
					</td>
                    <td>
                        <a href="{{ root::get_url_admin_ujian('edit/'.$item->id) }}" class="btn btn-primary btn-xs" >
							<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
						</a>
                        <a href="{{ root::get_url_admin_ujian('delete') }}/{{ $item->id }}" class="btn btn-danger btn-xs" >
							<span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Delete
						</a>
                    </td>
                    <td>
                        Session : {{ $item->kalender->session->nama }} <br>
                        Pelajaran : {{ $item->pelajaran->nama }}    <br>
                        Event : {{ $item->kalender->event->nama }}      <br>
                    </td>

                    <td  >
                        Kelas:  {{ $item->kelas->nama  }}                       <br>
						Kelipatan:  {{ round($item->kalinilai,2)  }}                       <br>
						Harapan:    {{ round($item->minnilai,2)  }}                       <br>
                        <span title="Pelaksanaan: {{ $item->pelaksanaan }} " >Pelaksanaan:  {{ root::get_diff_date( $item->pelaksanaan ) }} </span><br>
                    </td>
                    <td>
                        <span class="label label-primary">Last Update:{{ root::get_diff_date($item->updated_at) }} </span><br>
                        <span class="label label-primary">Created :{{ root::get_diff_date($item->created_at) }} </span>
                    </td>
                </tr>
            @endforeach
        </table>
		<hr>
        {{ $items->appends( $wheres )->links() }}
    </div>
    <div class="clear_10"></div>
@stop
