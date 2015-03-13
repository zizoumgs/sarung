@extends('layouts.admin')

@section('title')
	Event
@stop

@section('content')
    <h1 class="title"> Event Table <a href="{{ root::get_url_admin_event('add')}}" class="btn btn-primary btn-xs" >Add</a></h1>
    <div class="table_div">
        <table class="table table-striped table-hover" >
            <tr class ="header">
        		<th>Id</th>
                <th>Edit/Delete</th>
    			<th>Name</th>
        		<th>Short_Name</th>
    			<th>Updated_at</th>
    			<th>Created_at</th>
    		</tr>
            @foreach ($events as $event)
                <tr>
                    <td>{{ $event->id }} </td>
                    <td>
                        <a href="{{ root::get_url_admin_event('edit/'.$event->id) }}" class="btn btn-primary btn-xs" >Edit</a>
                        <a href="{{ root::get_url_admin_event('delete') }}/{{ $event->id }}" class="btn btn-danger btn-xs" >Delete</a>
                    </td>
                    <td>{{ $event->nama }}</td>
                    <td>{{ $event->inisial }} </td>
                    <td>{{ $event->updated_at }} </td>
                    <td>{{ $event->created_at }}</td>
                </tr>
            @endforeach
        </table>
        {{ $events->appends( $wheres )->links() }}
    </div>
    <div class="clear_10"></div>
@stop
