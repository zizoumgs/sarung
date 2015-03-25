@section('additional_css')
	<link rel="stylesheet" 			href="{{ root::base_url() }}/asset/jquery/jquery_ui/themes/smoothness/jquery-ui.css" >
	<link rel="stylesheet" 			href="{{ root::base_url() }}/asset/css/jquery.ui.timepicker.css" >
@stop
@section('additional_js')
	<script type="text/javascript" 	src="{{ root::base_url() }}/asset/jquery/jquery_ui/jquery-ui.js"></script>
	<script type="text/javascript" 	src="{{ root::base_url() }}/asset/js/jquery.ui.timepicker.js"></script>
	<script>
	function edit_handle
	(
		id_santri_name		,
		santri_name			,
		pelajaran_name		,
		session_name 		,
		event_name 			,
		pelaksanaan_name	,
		kelas_name			,
		nilai_name			,
		id_ujian_name		,
		id_name		
		
	){
		$('#dialog_edit_id_santri_name').val(id_santri_name);
		$('#dialog_edit_santri_name').val(santri_name);
		$('#dialog_edit_session_name').val(session_name);
		$('#dialog_edit_pelajaran_name').val(pelajaran_name);
		$('#dialog_edit_kelas_name').val(kelas_name);
		$('#dialog_edit_pelaksanaan_name').val(pelaksanaan_name);
		$('#dialog_edit_nilai_name').val(nilai_name);
		$('#dialog_edit_id_ujian_name').val(id_ujian_name);
		$('#id_name').val(id_name);
		$('#id_information_name').text(id_name);
		$("#myModalDialogEdit").modal({keyboard: true});		
	}
	//! for showing dialog
	function delete_handle
	(
		id_santri_name		,
		santri_name			,
		pelajaran_name		,
		session_name 		,
		event_name 			,
		pelaksanaan_name	,
		kelas_name			,
		nilai_name			,
		id_ujian_name		,
		id_name		
		
	){
		$('#dialog_delete_id_santri_name').val(id_santri_name);
		$('#dialog_delete_santri_name').val(santri_name);
		$('#dialog_delete_session_name').val(session_name);
		$('#dialog_delete_pelajaran_name').val(pelajaran_name);
		$('#dialog_delete_kelas_name').val(kelas_name);
		$('#dialog_delete_pelaksanaan_name').val(pelaksanaan_name);
		$('#dialog_delete_nilai_name').val(nilai_name);
		$('#dialog_delete_id_ujian_name').val(id_ujian_name);
		$('#dialog_delete_id_name').val(id_name);
		$('#dialog_delete_id_information_name').text(id_name);
		$("#myModalDialogDelete").modal({keyboard: true});		
	}	
	function change_santri_handle(){
		$("#LoadingImageSantri").show();
		$.ajax({
			url:"{{ root::get_url_admin_ujis('changesantriajax') }}",
			data : { 'dialog_edit_id_santri_name' : $('#dialog_edit_id_santri_name').val()  },
			dataType: "json",
			success:function(result){
				$("#LoadingImageSantri").hide();
				$("#dialog_edit_santri_name").val(result.dialog_edit_santri_name);
			},
			error: function (xhr, status) {
				$("#LoadingImageSantri").hide();
			}
		}); // end of ajax
		
		event.preventDefault(); // disable normal form submit behavior
		return false; // prevent further bubbling of event        
    }	
    function change_ujian_handle(){
		$("#LoadingImage").show();
		$.ajax({
			url:"{{ root::get_url_admin_ujis('changeujianajax') }}",
			data : { 'dialog_edit_id_ujian_name' : $('#dialog_edit_id_ujian_name').val() },
			dataType: "json",
			success:function(result){
				$("#LoadingImage").hide();				
				$("#dialog_edit_session_name")		.val(result.dialog_edit_session_name);
				$("#dialog_edit_pelajaran_name")	.val(result.dialog_edit_pelajaran_name);
				$("#dialog_edit_kelas_name")		.val(result.dialog_edit_kelas_name);
				$("#dialog_edit_pelaksanaan_name")	.val(result.dialog_edit_pelaksanaan_name);
			},
			error: function (xhr, status) {
				$("#LoadingImage").hide();
			}
		}); // end of ajax
		event.preventDefault(); // disable normal form submit behavior
		return false; // prevent further bubbling of event
    }
	function addTextAreaCallback(textArea, callback, delay) {
	    var timer = null;
	   	textArea.onkeyup = function() {
	       	if (timer) {
	       		window.clearTimeout(timer);
	   		}
	   		timer = window.setTimeout( function() {
	   			timer = null;
	   			callback();
	   		}, delay );
		};
		textArea = null;
	}
	//! for showing dialog
	function select_handle(id , first_name , second_name , session , catatan){
		$("#myModal").modal({keyboard: true});
        $("#dialog_santri_id").val(id);
		$("#dialog_santri_name").val(first_name +" "+ second_name);
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
	function add_handle( id_santri , santri_name , idujian){
        $("#dialog_add_id_ujian_name").val(idujian);
		$("#dialog_add_id_santri_name").val(id_santri);
		$("#dialog_add_santri_name").val(santri_name);
		$("#dialog_add").modal({keyboard: true});
	};
	
	$(function() {
		$("#dialog_edit_submit_name").click(function(){
			$("#dialog_edit_form_name").submit();
		});
		$("#dialog_delete_submit_name").click(function(){
			$("#dialog_delete_form_name").submit();
		});
		$("#dialog_add_submit_name").click(function(){
			$("#dialog_add_form_name").submit();
		});
		addTextAreaCallback(document.getElementById("dialog_edit_id_ujian_name"), change_ujian_handle	, 200 );
		addTextAreaCallback(document.getElementById("dialog_edit_id_santri_name"), change_santri_handle	, 200 );
	});
	</script>
@stop