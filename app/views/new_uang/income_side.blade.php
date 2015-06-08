
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
    <aside id="text-3" class="widget widget_text"><h3 class="widget-title"> 7 Months Income</h3>
	    <table class="table table-striped table-condensed">
			<?php
		        $date_time = FUNC\get_time_from_string( date("Y/m/01") );			
			?>
	        @for($x =  0 ; $x < 7 ; $x++)
				<?php $date = FUNC\add_month_to_date($date_time, sprintf('-%1$s',$x) , "Y-m-01"); ?>
				<tr>
					<td class="bold-font">
						
                        <?php $test = sprintf('%1$s-%2$s',FUNC\get_date_from_string( $date ,"Y") , FUNC\get_date_from_string( $date ,"m") ) ;?> 
                        <a href="{{ root::get_url_uang('/income/'.$test )}}" style="color:black">
							<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
							{{ $test }}:
                        </a>
                    </td>
					<td>Rp: {{ helper_get_rupiah( Income_Model::sumyearmonth( FUNC\get_date_from_string( $date ,"Y") , FUNC\get_date_from_string( $date ,"m")  )->jumlah  ) }}</td>
                </tr>
				
			@endfor			
		</table>
    </aside>            
	
@stop
