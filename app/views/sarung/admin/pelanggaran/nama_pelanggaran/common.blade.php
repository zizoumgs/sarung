@section('additional_css')
	<link rel="stylesheet" 			href="{{ root::base_url() }}/asset/jquery/jquery_ui/themes/smoothness/jquery-ui.css" >
@stop
@section('additional_js')
	<script type="text/javascript" 	src="{{ root::base_url() }}/asset/jquery/jquery_ui/jquery-ui.js"></script>
	<script>
	//! for showing dialog
	function add_function(id , nama ){
		$("#myModalAdd").modal({keyboard: true});
        $("#dialog_user_id").val(id);
		$("#dialog_santri_name").val(nama);
	}
	function delete_class(id , idkelas , idsantri , session_name){
		if (confirm("This will delete pressed class !") == true) {
			$("#dialog_del_id_name").val(id);
			$("#dialog_del_id_kelas_name").val(idkelas);
			$("#dialog_del_id_santri_name").val(idsantri);
			$("#dialog_del_session_name").val(session_name);
			$("#dialog_del_form_name").submit();
		}
	};

	$(function() {
		$( "#keluar_name" ).datepicker(	{
			changeMonth: true,
			changeYear: true ,
			dateFormat: "yy-mm-dd",
		});
		$("#dialog_submit_name").click(function(){
			$("#dialog_name").submit();
		});
	});		
	</script>
@stop