@extends('layouts.admin')

@section('title')
	Santri | Table 
@stop
@include( 'sarung.admin.santri.common')
@include( 'sarung.admin.santri.dialog_add')

@include( 'sarung.admin.kelas_isi.dialog_del')

@section('content')
    <h1 class="title"> Siswa Formal Info <small>adalah santri yang masuk sekolah formal.</small> </h1>
    @if( Session::has('message')  )
        <div class="clear_25"></div>
        <div class="col-sm-9">
            <div class="alert alert-danger" role="alert">
                {{ Session::get('message') }}  
            </div>
        </div>
        <div class="clear_25"></div>
    @endif
		{{ Form::open(array('url' => root::get_url_admin_santri() , 'method' => 'get' ,
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
				<label for="find_santri_name" >Santri</label>			
				<input type="text" name="find_santri_name" id="find_santri_name"  class="form-control"
					   value="{{ Input::get('find_santri_name') }}"
				>
			</div>
			<div class="input-group">
				<span class="input-group-addon">					
					<input type="checkbox" aria-label="" name="find_formal_name" value="1"
						@if ( Input::get('find_formal_name') == 1 )
							checked
						@endif						   
					>
				</span>
				<input type="text" class="form-control" value="Sekolah Formal" disabled>
			</div>
			<div class="form-group">
				{{ Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) ) }}
			</div>
		{{ Form::close() }}
		<p class="navbar-text navbar-right well well-sm x-small-font">{{$info}}</p>
		<div class="clear"></div>


    <div class="table_div medium-font">
		<div class="thumbnail">
			<p>Segala informasi Santri yang
				@if( Input::get('formal_name') != 1)
					tidak
				@endif
				sekoah formal</p>
		</div>
        <table class="table table-striped table-hover" >
			<tr class ="header">
				<th>Id</th>
				<th>User Data</th>
				<th>Dll</th>		
            </tr>
            @foreach ($items as $item)
                <tr>
					<td>
						<?php $santri = false; ?>
						@if ($item->santri)
							<a href="{{ root::get_url_admin_santri('edit/'.$item->santri->id) }}" class="btn btn-primary btn-xs" target='_blank' >
								<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
							</a>
							@if( Santri_Model::can_be_deleted($item->santri->id) )
								<a href="{{ root::get_url_admin_santri('delete/'.$item->santri->id) }}" class="btn btn-danger btn-xs" target='_blank'>
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete
								</a>
							@endif
							<?php $santri = true; ?>
						@else
							<button type="button" class="btn btn-link btn-xs" data-toggle="modal"
									onclick="add_function({{ $item->id }} ,
									'{{$item->first_name .' '. $item->second_name}}' )"
							>
								Add To
							</button>
						@endif
					</td>
					<td>
						<div class="col-md-2" >
							<img src="{{ $item->foto }}" class="small-img thumbnail" />
						</div>
						<div class="col-md-10">
							<span>
								<span class="glyphicon glyphicon-user"></span> Nama: {{ $item->first_name }} {{ $item->second_name }}
							</span><br>
							<span>
								<span class="glyphicon glyphicon-envelope"></span> Email: {{ $item->email }}
							</span><br>
							<span>
								@if ( $item->santri  )
									<span class="glyphicon glyphicon-user"></span>
									Nis:
									{{ Nis_Helper::get_nis( $item->santri->id ) }}
								@else
									<div class="alert alert-warning" role="alert">
										<b>Tidak sekolah formal</b>
									</div>
								@endif
							</span><br>
								@if ( $santri )
									@if ( $item->santri->keluar == "0000-00-00")
										<span><span class="glyphicon glyphicon-ok"></span> Active</span><br>
									@else
										<span title="{{ $item->santri->keluar }}"><span class="glyphicon glyphicon-remove"></span>
											Keluar: {{ root::get_diff_date($item->santri->keluar) }}
										</span><br>
									@endif
								@endif
							 <br>
						</div>
					</td>
					<td>
						<span class="glyphicon glyphicon-magnet"></span> Status user: {{ User_Helper::get_status($item->status) }}<br>
						<span class="glyphicon glyphicon-chevron-down"></span> Last Login: {{ $item->last_login }}<br>
						@if ( $santri )
							@foreach ( Santri_Model::getHisClass($item->santri->id)->get() as $class)
								<button title="Click to delete" class="btn btn-default btn-xs mar-rig-lit"
									onclick="
									delete_class(  {{ $class->id}}			,
									'{{ $class->idkelas}}'			,
									'{{ $item->santri->id }}'				,
									'{{ FUNC\get_escape($class->session->nama) }}' )"												
									>
									<b>{{ $class->kelas->nama }}</b><br>
									{{ $class->session->nama }}
								</button>											
							@endforeach
						@endif
					</td>
                </tr>
            @endforeach
        </table>
		<hr>
        {{ $items->appends( $wheres )->links() }}
    </div>
    <div class="clear_10"></div>

@stop
