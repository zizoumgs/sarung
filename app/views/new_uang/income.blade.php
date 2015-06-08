@extends('layouts.sidebar')

@section('title')
	Income
@stop

@section('title_post')
	<h1 class="title title_post">Income</h1>
@stop

@include('new_uang.income_side')

@section('content')

				<table class="table table-striped table-hover table-condensed" style="margin-bottom:5px">
					<tr class ="header">
						<th>Divisi</th>
						<th>Sub Divisi</th>
						<th>Jumlah</th>
						<th>Tanggal</th>
					</tr>
					@foreach ($posts as $post)
						<tr>
							<td>{{ $post->divisisub->divisi->nama }}</td>
							<td><a href="?cat={{$post->divisisub->nama}} "> {{ $post->divisisub->nama }} </a></td>							
							<td> {{ helper_get_rupiah($post->jumlah) }} </td>
							<td> {{ $post->tanggal }} </td>
						</tr>
					@endforeach
				</table>
	            <hr style="margin:0px 0px;">
				{{ $posts->appends( $wheres )->links() }}
@stop