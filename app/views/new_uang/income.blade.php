@extends('layouts.sidebar')

@section('title')
	Income
@stop

@section('title_post')
	<h1 class="title title_post">Income</h1>
@stop

@section('sidebar')
	<!-- annual income -->
	<aside id="text-3" class="widget widget_text">
		<h3 class="widget-title"> 5 Year Income</h3>
		<table class="table table-striped table-condensed">
			<?php $last = 0; ?>
			@for ($i = date("Y") ; $i > (date("Y") - 5 ); $i--)
			<tr>
				<td class="bold-font">{{$i}}</td>
				<td>Rp: {{ helper_get_rupiah( Income_Model::sumyear($i)->jumlah ) }}</td>
	            @if($last === 0)
	                <td><span class="glyphicon glyphicon glyphicon-minus"></span></td>
	            @else
	                @if($last < Income_Model::sumyear($i)->jumlah )
	                    <td><span class="glyphicon glyphicon glyphicon-arrow-up green"></span></td>
	                @else
	                    <td><span class="glyphicon glyphicon glyphicon-arrow-down red"></span></td>
					@endif
	            @endif
			</tr>
			<?php $last = Income_Model::sumyear($i)->jumlah ?>
		@endfor
		</table>
	</aside>
	<!-- monthly income -->
    <aside id="text-3" class="widget widget_text"><h3 class="widget-title"> 5 Months Income</h3>
	    <table class="table table-striped table-condensed">
			<?php
		        $date_time = FUNC\get_time_from_string( date("Y/m/01") );			
			?>
	        @for($x =  0 ; $x < 5 ; $x++)
				<?php $date = FUNC\add_month_to_date($date_time, sprintf('-%1$s',$x) , "Y-m-01"); ?>
				<tr>
					<td class="bold-font">{{FUNC\get_date_from_string( $date ,"Y") }}-{{ FUNC\get_date_from_string( $date ,"m") }}:</td>
					<td>Rp: {{ helper_get_rupiah( Income_Model::sumyearmonth( FUNC\get_date_from_string( $date ,"Y") , FUNC\get_date_from_string( $date ,"m")  )->jumlah  ) }}</td>
				</tr>
				
			@endfor			
		</table>
    </aside>            
	
@stop

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