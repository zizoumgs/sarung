@extends('layouts.admin')

@section('title')
	Event
@stop

@section('content')
    <h1 class="title"> Session Table <a href="{{ root::get_url_admin_session('add')}}" class="btn btn-primary btn-xs" >Add</a></h1>
    <div class="table_div">
        <table class="table table-striped table-hover" >
            <tr class ="header">
				<th>Id</th>
                <th>Edit/Delete</th>
				<th>Name</th>
				<th>Awal</th>
                <th>Akhir</th>
                <th>Nominal santri</th>
 				<th>Kenaikan</th>
 				<th>Date</th>
    		</tr>
            @foreach ($sessions as $item)
                <tr>
                    <td>{{ $item->id }} </td>
                    <td>
                        <a href="{{ root::get_url_admin_session('edit/'.$item->id) }}" class="btn btn-primary btn-xs" >Edit</a>
                        <a href="{{ root::get_url_admin_session('delete') }}/{{ $item->id }}" class="btn btn-danger btn-xs" >Delete</a>
                    </td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->awal }} </td>
					<td>{{ $item->akhir }} </td>
					<td>{{ $item->perkiraansantri }} </td>
                    <td>
						Model: {{ Session_Addon_Model::sessionid($item->id)->first()->model }} <br>
						Nilai: {{ Session_Addon_Model::sessionid($item->id)->first()->nilai }} <br>
					</td>
                    <td>
						<span class="label label-primary">Last Update:{{ root::get_diff_date($item->updated_at) }} </span><br>
						<span class="label label-primary">Created :{{ root::get_diff_date($item->created_at) }} </span>
					</td>
                </tr>
            @endforeach
        </table>
        {{ $sessions->appends( $wheres )->links() }}
    </div>
    <div class="clear_10"></div>
@stop
