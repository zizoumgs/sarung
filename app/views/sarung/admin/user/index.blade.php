@extends('layouts.admin')

@section('title')
	User | Table 
@stop
@include( 'sarung.admin.user.common')

@section('content')
    <h1 class="title"> Santri Info
		<a href="{{ root::get_url_admin_user('add')}}" class="btn btn-primary btn-xs" >Add</a>
		<small>adalah santri yang mondok.</small>		
	</h1><hr>
		{{ Form::open(array('url' => root::get_url_admin_user() , 'method' => 'get' ,
		'role' => 'search' ,'class' => 'navbar-form pull-left ',
		"ng-app" => "NumberApp" ,"ng-controller" => "NumberController"  )) ; }}
			<div class="form-group">
				<label for="find_email_name" >Email</label>
				{{ Form::text('find_email_name', Input::get('find_email_name') , array('id' => 'find_email_name' , 'class' => 'form-control input-sm' )) }}
			</div>
			<div class="form-group">
				<label for="find_status_name" >Status</label>
				<select class="form-control input-sm" name="find_status_name">
					<option value="All">All</option>
					@foreach( $helper::get_status_values() as $key => $val )
						<option value="{{ $key }}"
							@if ( $key === (int) Input::get('find_status_name') &&  Input::get('find_status_name') != "All" )
								selected
							@endif
						>
							{{ $val }}
						</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				{{ Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) ) }}
			</div>
		{{ Form::close() }}
		<p class="navbar-text navbar-right well well-sm">{{$info}}</p>
		<div class="clear"></div>
    <div class="table_div">
        <table class="table table-striped table-hover" >
            	<tr class ="header">
            		<th>Id</th>
                    <th>Edit/Delete</th>
                    <th><a href="%2$s/1">User Status</a></th>
                    <th><a href="%3$s/2">User Data</a></th>
    			</tr>
				@foreach (  $items as $item)
                <tr>
                    <td>
						{{ $item->id }}
					</td>
                    <td>
                        <a href="{{ root::get_url_admin_user('edit/'.$item->id) }}" class="btn btn-primary btn-xs" >
							<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
						</a>
                        <a href="{{ root::get_url_admin_user('delete') }}/{{ $item->id }}" class="btn btn-danger btn-xs" >
							<span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Delete
						</a>
                    </td>
                    <td >
						<div class="x-small-font">
							<span><span class="glyphicon glyphicon-question-sign"></span> status: {{ $helper->get_status( $item->status) }}</span><br>
							<span><span class="glyphicon glyphicon-magnet"></span> Role: {{ $item->admindgroup->nama }}</span><br>
							<span><span class="glyphicon glyphicon-calendar"></span> Last Update:{{ root::get_diff_date($item->updated_at) }} </span><br>
							<span><span class="glyphicon glyphicon-time"></span> Created :{{ root::get_diff_date($item->created_at) }}</span><br>
						</div>
                    </td>
                    <td>
						<div class="col-md-2" >
							<img src="{{ $item->foto }}" class="small-img thumbnail" />
						</div>
						<div class="col-md-10 x-small-font">
							<div style="margin-left:5px;">
								<span>
									<span class="glyphicon glyphicon-user"></span> Nama: {{ $item->first_name }} {{ $item->second_name }}
								</span><br>
								<span>
									<span class="glyphicon glyphicon-envelope"></span> Email: {{ $item->email }}
								</span><br>
								<span><span class="glyphicon glyphicon-map-marker"></span> Alamat:
										{{ $item->desa->kecamatan->kabupaten->nama}}
										{{ $item->desa->kecamatan->nama }}
										{{ $item->desa->nama }}
								</span><br>
									<span class="glyphicon glyphicon-info-sign"></span> TTL: {{$item->tempat->nama}} {{$item->lahir}}</span>
								 <br>
							</div>
						</div>
                    </td>
                </tr>
            @endforeach
        </table>
		<hr>
        {{ $items->appends( $wheres )->links() }}
    </div>
    <div class="clear_10"></div>
@stop
