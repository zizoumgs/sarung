@section('additional_css')
	<link rel="stylesheet" 			href="{{ root::base_url() }}/asset/jquery/jquery_ui/themes/smoothness/jquery-ui.css" >
	<link rel="stylesheet" 			href="{{ root::base_url() }}/asset/css/jquery.ui.timepicker.css" >
@stop
@section('additional_js')
	<script type="text/javascript" 	src="{{ root::base_url() }}/asset/jquery/jquery_ui/jquery-ui.js"></script>
	<script type="text/javascript" 	src="{{ root::base_url() }}/asset/js/jquery.ui.timepicker.js"></script>
	<script>
	function change_santri_handle(){
		//$("#LoadingImageSantri").show();
		//alert( "{{ root::get_url_admin_larangan_kasus('changesantriajax') }}" );
		$.ajax({
			url:"{{ root::get_url_admin_larangan_kasus('changesantriajax') }}",
			data : { 'id_santri_name' : $('#id_santri_name').val()  },
			dataType: "json",
			success:function(result){
				$("#santri_name").val(result.namaSantri);
				$("#alamat_name").val(result.alamatSantri);
			},
			error: function (xhr, status) {
				
				
				//$("#LoadingImageSantri").hide();
			}
		}); // end of ajax
		event.preventDefault(); // disable normal form submit behavior
		return false; // prevent further bubbling of event        
    }
	function change_pelanggaran_handle(){
		$("#LoadingImageSantri").show();
		//alert( "{{ root::get_url_admin_larangan_kasus('changesantriajax') }}" );
		$.ajax({
			url:"{{ root::get_url_admin_larangan_kasus('changepelanggaranajax') }}",
			data : { 'id_pelanggaran_name' : $('#id_pelanggaran_name').val()  },
			dataType: "json",
			success:function(result){
				$("#pelanggaran_name").val(result.pelanggaran_name);
				$("#session_name").val(result.session_name);
				$("#LoadingImageSantri").hide();
			},
			error: function (xhr, status) {
				$("#LoadingImageSantri").hide();
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
	$(function() {
		addTextAreaCallback(document.getElementById("id_santri_name"), change_santri_handle	, 200 );
		addTextAreaCallback(document.getElementById("id_pelanggaran_name"), change_pelanggaran_handle	, 200 );
		$( "#date_name" ).datepicker(	{
			changeMonth: true,changeYear: true ,
			dateFormat: "yy-mm-dd",
		});
		
		
	});
	</script>
@stop