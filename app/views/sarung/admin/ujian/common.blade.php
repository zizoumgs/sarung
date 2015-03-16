@section('additional_css')
	<link rel="stylesheet" 			href="{{ root::base_url() }}/asset/jquery/jquery_ui/themes/smoothness/jquery-ui.css" >
	<link rel="stylesheet" 			href="{{ root::base_url() }}/asset/css/jquery.ui.timepicker.css" >
@stop
@section('additional_js')
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
	<script>
		angular.module('NumberApp', [])
			.controller('NumberController', ['$scope', function($scope) {
			}]
		);
</script>

	<script type="text/javascript" 	src="{{ root::base_url() }}/asset/jquery/jquery_ui/jquery-ui.js"></script>
	<script type="text/javascript" 	src="{{ root::base_url() }}/asset/js/jquery.ui.timepicker.js"></script>
	<script>
	$(function() {
		$( "#{{ $helper::get_date_name }}" ).datepicker(	{
			changeMonth: true,changeYear: true ,
			dateFormat: "yy-mm-dd",
		});
		$( "#{{ $helper::get_time_name }}" ).timepicker();
		//! prevent from click
		$(".disabled").click(function(e){e.preventDefault();return false;});
	});
	</script>
@stop