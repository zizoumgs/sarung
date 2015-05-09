@extends('layouts.admin')

@section('title')
	Nama Pelanggaran | Table 
@stop

@section('content')
    <h1 class="title">
		Peraturan 
		<a href="{{ root::get_url_admin_larangan_meta('add/')  }}" class="btn btn-primary btn-xs" >Add</a>
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
	{{ Form::open(array('url' => root::get_url_admin_larangan_meta() , 'method' => 'get' ,
		'role' => 'search' ,'class' => 'navbar-form pull-left ',
		"ng-app" => "NumberApp" ,"ng-controller" => "NumberController"  )) ; }}
			<div class="form-group">
				<label for="find_pelanggaran_name" >Nama Pelanggaran </label>
				<input type="text" name="find_pelanggaran_name" id="find_pelanggaran_name"  class="form-control"
					   value="{{ Input::get('find_pelanggaran_name') }}"
				>
			</div>
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
				<label for="find_session_name" >Type</label>
				<select class="form-control" name="find_type_name">
					<option value="All">All</option>
					@foreach( $types as $type )
						<option value="{{ $type }}"
							@if ( $type === Input::get('find_type_name') )
								selected
							@endif										
						>{{ $type }}</option>
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
				<th>Modify</th>
				<th>Nama</th>
				<th>Detail</th>
				<th>Hukuman</th>
				<th>Made</th>
            </tr>
            @foreach ($items as $item)
                <tr>
                    <td>
						{{ $item->id }}
					</td>
                    <td>
                        <a href="{{ root::get_url_admin_larangan_meta('edit/'.$item->id) }}" class="btn btn-primary btn-xs" >
							<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
						</a>
                        <a href="{{ root::get_url_admin_larangan_meta('delete') }}/{{ $item->id }}" class="btn btn-danger btn-xs" >
							<span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Delete
						</a>
                    </td>
					<td>
						{{ $item->namaObj->nama }}
					</td>
					<td>
						Point: {{ $item->point }} <br>
						Jenis: {{ $item->jenis }} <br>
						Session: {{ $item->sessionObj->nama }} <br>
					</td>
					<td>
						{{ $item->hukuman }}
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
