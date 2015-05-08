@extends('layouts.admin')

@section('title')
	Nama Pelanggaran | Table 
@stop

@section('content')
    <h1 class="title">
		Nama <small> Pelanggaran .</small>
		<a href="{{ root::get_url_admin_nama_pelanggaran('add/')  }}" class="btn btn-primary btn-xs" >Add</a>
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
	{{ Form::open(array('url' => root::get_url_admin_nama_pelanggaran() , 'method' => 'get' ,
		'role' => 'search' ,'class' => 'navbar-form pull-left ',
		"ng-app" => "NumberApp" ,"ng-controller" => "NumberController"  )) ; }}
			<div class="form-group">
			</div>			
			<div class="form-group">
				<label for="find_santri_name" >Nama Pelanggaran </label>
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
				<th>Modify</th>
				<th>Nama</th>		
            </tr>
            @foreach ($items as $item)
                <tr>
                    <td>
						{{ $item->id }}
					</td>
                    <td>
                        <a href="{{ root::get_url_admin_nama_pelanggaran('edit/'.$item->id) }}" class="btn btn-primary btn-xs" >
							<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
						</a>
                        <a href="{{ root::get_url_admin_nama_pelanggaran('delete') }}/{{ $item->id }}" class="btn btn-danger btn-xs" >
							<span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Delete
						</a>
                    </td>
					<td>
						{{ $item->nama }}
					</td>
                </tr>
            @endforeach
        </table>
		<hr>
        {{ $items->appends( $wheres )->links() }}
    </div>
    <div class="clear_10"></div>

@stop
