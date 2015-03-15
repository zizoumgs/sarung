@extends('layouts.admin')

@section('title')
	Event
@stop

@section('content')
    <h1 class="title"> Kalender Table <a href="{{ root::get_url_admin_kalender('add')}}" class="btn btn-primary btn-xs" >Add</a></h1>
    {{ Form::open(array('url' => root::get_url_admin_kalender() , 'method' => 'get' ,
	'role' => 'form' ,'class' => 'form-inline navbar-form navbar-left',
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
       {{ Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) ) }}
        </div>
    {{ Form::close() }}
	<p class="navbar-text navbar-right well well-sm x-small-font">{{$info}}</p>
	
    <div class="table_div medium-font">
        <table class="table table-striped table-hover" >
            <tr class ="header">
				<th>Id</th>
                <th>Edit/Delete</th>
				<th>Event</th>
                <th>Another</th>
 				<th>Aktif</th>
    		</tr>
            @foreach ($sessions as $item)
                <tr>
                    <td>{{ $item->id }} </td>
                    <td>
                        <a href="{{ root::get_url_admin_kalender('edit/'.$item->id) }}" class="btn btn-primary btn-xs" >
							<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
						</a>
                        <a href="{{ root::get_url_admin_kalender('delete') }}/{{ $item->id }}" class="btn btn-danger btn-xs" >
							<span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Delete
						</a>
                    </td>
                    <td>
						Session : {{ $item->session->nama }} 	<br>
						Event : {{ $item->event->nama }}		<br>
						Status:
						@if ( $item->aktif == 1) {{ "Aktif" }}
						@else {{ "Libur" }}
						@endif
					</td>
                    <td title="Awal: {{ $item->awal }} , Akhir: {{ $item->akhir }} " >
						<div class="rating-container">
							@for ($x = 0 ; $x < 5 ;$x++)
								<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
							@endfor
							<div class="rating-star">
								@for ($x = 0 ; $x < $item->rating ;$x++)
									<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
								@endfor
							</div>
						<div><div class="clear"></div>
						Money:  {{ $item->money  }}						<br>
						Awal:  {{ root::get_diff_date( $item->awal ) }} <br>
						Akhir: {{ root::get_diff_date($item->akhir ) }} <br>
					</td>
                    <td>
						<span class="label label-primary">Last Update:{{ root::get_diff_date($item->updated_at) }} </span><br>
						<span class="label label-primary">Created :{{ root::get_diff_date($item->created_at) }} </span>
					</td>
                </tr>
            @endforeach
        </table>
		<hr>
        {{ $sessions->appends( $wheres )->links() }}
    </div>
    <div class="clear_10"></div>
@stop
