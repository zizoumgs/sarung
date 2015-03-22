@extends('layouts.admin')

@section('title')
	Ujian | Table 
@stop
@include( 'sarung.admin.kelas_isi.common')
@include( 'sarung.admin.kelas_isi.dialog_add')
@include( 'sarung.admin.kelas_isi.dialog_del')

@section('content')
    <h1 class="title"> Kelas Siswa Table </h1>
    @if( Session::has('message')  )
        <div class="clear_25"></div>
        <div class="col-sm-9">
            <div class="alert alert-danger" role="alert">
                {{ Session::get('message') }}  
            </div>
        </div>
        <div class="clear_25"></div>
    @endif


		{{ Form::open(array('url' => root::get_url_admin_kelas_isi() , 'method' => 'get' ,
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
				<label for="find_event_name" >Santri</label>			
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
				<th>User Data</th>
				<th>Kelas</th>		
            </tr>
            @foreach ($items as $item)
                <tr>
					<td><button class="btn btn-primary btn-xs"		
						onclick="select_handle( {{ $item->id }},
								'{{ htmlentities(str_replace("'","\'",$item->first_name)) }} 	',
								'{{ htmlentities(str_replace("'","\'",$item->second_name))   }}	',
								'{{ $item->nama }}'												 ,
								'{{ $item->catatan }}'											)"
								>
						increase<br>{{ $item->id }}
						</button>
					</td>
					<td>
						<div class="col-md-2" >
							<img src="{{ Santri_Helper::get_foto_url($item->id_user,$item->foto) }}" class="small-img thumbnail" />
						</div>
						<div class="col-md-10">
							<span>
								<span class="glyphicon glyphicon-user"></span> Nama: {{ $item->first_name }} {{ $item->second_name }}</span>
								<span><span class="glyphicon glyphicon-user"></span> Nis: {{ Santri_Helper::get_nis( $item->id ) }}</span><br>
								<span><span class="glyphicon glyphicon-envelope"></span> Email: {{ $item->email }}</span><br>
								<span><span class="glyphicon glyphicon-user"></span> Session: {{ $item->nama }}</span><br>
							 <br>
						</div>
					</td>
					<td>
						@foreach ( Class_Model::getkelassantribyid ($item->id) as $kelas )
							<button title="Click to delete" class="btn btn-default btn-xs mar-rig-lit"
									onclick="
									delete_handle(  {{ $kelas->id}}			,
									'{{ $kelas->idkelas}}'			,
									'{{ $item->id }}'				,
									'{{ FUNC\get_escape($kelas->session_name) }}' )"
							>
								<b>{{ $kelas->kelas_name }}</b><br>
								{{ $kelas->session_name }}
							</button>	
						@endforeach						
					</td>
                </tr>
            @endforeach
        </table>
		<hr>
        {{ $items->appends( $wheres )->links() }}
    </div>
    <div class="clear_10"></div>

@stop
