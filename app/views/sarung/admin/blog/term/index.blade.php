@extends('layouts.admin')

@section('title')
	Blog | Category
@stop

@section('content')
    <h1 class="title">
        Category
        <a href="{{ root::get_url_admin_blog_category('add') }}" class="btn btn-primary btn-xs" >Add</a>
    </h1>
    <div class="table_div medium-font">
        <table class="table table-striped table-hover" >
			<tr class ="header">
                <th>Modify</th>
				<th>Id</th>
				<th>Name</th>
				<th>Slug</th>
				<th>Parent</th>		
            </tr>
            @foreach ($items as $item)
                <tr>
					<td>
						<div class="btn-group-vertical">
							<a href="{{ root::get_url_admin_blog_category('edit/'.$item->id) }}" class="btn btn-primary btn-xs">Edit</a>
							<a href="{{ root::get_url_admin_blog_category('delete/'.$item->id) }}" class="btn btn-primary btn-xs">Delete</a>
						</div>
					</td>
					<td>
                        {{ $item->id }}
					</td>
					<td>
                        {{ $item->term->name }}
					</td>
					<td>
                        {{ $item->term->slug }}
					</td>
					<td>
                        @if( $item->parent == 0)
                            No Parent
                        @else
                            {{ Term_Model::find($item->parent)->name }}
                        @endif
					</td>
                </tr>
            @endforeach
        </table>
    </div>    
@stop
