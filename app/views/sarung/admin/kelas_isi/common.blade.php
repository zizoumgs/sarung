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
	//! for showing dialog
	function select_handle(id , first_name , second_name , session , catatan){
		$("#myModal").modal({keyboard: true});
        $("#dialog_santri_id").val(id);
		$("#dialog_santri_name").val(first_name +" "+ second_name);
	}
	function delete_handle(id , idkelas , idsantri , session_name){
		$("#dialog_del_id_name").val(id);
		$("#dialog_del_id_kelas_name").val(idkelas);
		$("#dialog_del_id_santri_name").val(idsantri);
		$("#dialog_del_session_name").val(session_name);
		$("#dialog_del_form_name").submit();
	};			
	$(function() {
		$("#dialog_submit_name").click(function(){
			$("#dialog_name").submit();
		});
	});		
	</script>
@stop