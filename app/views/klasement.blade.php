@extends('layouts.klasement_layout')

@section('title')
	Klasement
@stop

@section('content')
            <hr>				
            <div class="page-header">
                <div class="row">
                    <div class="col-md-7">
                        <h1>Klasement Nilai <small>Santri Fatihul Ulum</small></h1>
                    </div>
                   <div class="col-md-5">
                        <div class="pull-right">
							{{ Form::open( array('class' => "form-inline " , 'url' => root::get_url_klasement())) }}							
							<select class="form-control form-control-xs" name="session">
								<option value="All">ALL</option>
								@foreach( Session_Model::orderBy('created_at' , 'desc' )->get() as $res )
									@if( $res->nama  === Input::get('session') )
										<option value="{{ $res->nama }}" selected>{{ $res->nama}}</option>
									@else
										<option value="{{ $res->nama }}" >{{ $res->nama}}</option>
									@endif
								@endforeach
							</select>
							<select class="form-control form-control-xs" name="kelas">
								<option value="All">ALL</option>
								@foreach( Kelas_Model::orderBy('created_at' , 'desc' )->get() as $res )
									@if( $res->nama  === Input::get('kelas') )
										<option value="{{ $res->nama }}" selected>{{ $res->nama}}</option>
									@else
										<option value="{{ $res->nama }}" >{{ $res->nama}}</option>
									@endif
								@endforeach
							</select>
							<select class="form-control form-control-xs" name="pelajaran">
								<option value="All">ALL</option>
								<?php $tmp = new Ujian_Model() ;?>
								@foreach( $tmp->get_names_of_pelajaran() as $res )
									@if( $res->name  === Input::get('pelajaran') )
										<option value="{{ $res->name }}" selected>{{ $res->name}}</option>
									@else
										<option value="{{ $res->name }}">{{ $res->name}}</option>
									@endif
								@endforeach
							</select>
							<button type="submit" class="btn btn-default">
								<span class="glyphicon glyphicon-search"></span>
							</button>
							{{ Form::close(); }}
                        </div>
                   </div>
               </div>
            </div>
            <hr>
			{{ $pg->appends( $wheres )->links() }}
			<div class="table-responsive">
				<table class="table table-condensed table-bordered table-striped">
					<tr>
						@foreach ( $headers as $header )
							<th colspan="4" class="text-center"  >{{ $header }} </th>
						@endforeach
					</tr>
					<tr>
					@for($x = 0 ; $x < count($headers) ;$x++)
						@if($x === 0 )
							<td colspan="4" ></td>
						@else
							@foreach( array("Sco","Tot","LPos","CPos")  as $val)
								<td colspan="1" class="text-center"><small>{{ $val }}</small></td>
							@endforeach
						@endif
					@endfor
					</tr>
					@foreach($santries as $santri)
						<tr>
							<td colspan="4" >{{ $santri->first_name ." ". $santri->second_name}}<span class="badge pull-right blue">{{$santri->id_santri}}</span></td>
							@foreach( $html_santri [$santri->id_santri] [0] as $ind)
								<td class="text-center">{{ $ind }} </td>
							@endforeach
							@foreach( $html_santri [$santri->id_santri] [1] as $ind)
								<td class="text-center">	<b>{{ $ind }} </b></td>
							@endforeach
							@foreach( $html_santri [$santri->id_santri] [2] as $ind)
								<td class="text-center">{{ $ind }} </td>
							@endforeach
							@foreach( $html_santri [$santri->id_santri] [3] as $ind)
								<td class="text-center"><b>{{ $ind }} </b></td>
							@endforeach
						</tr>
					@endforeach
					
				</table>
			</div>
			{{ $pg->appends( $wheres )->links() }}
@stop
