@section('additional_css')
	<link rel="stylesheet" 			href="{{ root::base_url() }}/asset/jquery/jquery_ui/themes/smoothness/jquery-ui.css" >
	<style>
        .fileinput-button {
            position: relative;
            overflow: hidden;
        }
        .fileinput-button input {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            opacity: 0;
            -ms-filter: 'alpha(opacity=0)';
            font-size: 200px;
            direction: ltr;
            cursor: pointer;
        }
        /* Fixes for IE < 8 */
        @media screen\9 {
            .fileinput-button input {
                filter: alpha(opacity=0);
                font-size: 100%;
                height: 100%;
            }
        }
	</style>
@stop

@section('additional_js')
<!-- 	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script> -->
	<script type="text/javascript" src="{{ root::get_url_base() }}/asset/blueimp/js/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="{{ root::get_url_base() }}/asset/blueimp/js/jquery.iframe-transport.js"></script>
    <script type="text/javascript" src="{{ root::get_url_base() }}/asset/blueimp/js/jquery.fileupload.js"></script>
	<script type="text/javascript">
	function show_all_value( data ){
		$.each(data.result, function (index, file) {
			alert( index + "-" + file );					
		});		
	}
	$(function() {
		
		$('#dialog_upload_button_name').fileupload({
			dataType:'json',
			url: '{{ root::get_url_admin_user('startupload') }}',
		    error: function (jqXHR, textStatus, errorThrown) {
				alert( errorThrown );
		    },
		    done: function (e, data) {
				//show_all_value(data);
				 $('#image_url_name').attr("src", data.result.url);
				 $('#file_name').val(data.result.fileName);
				 $('#url_name').val(data.result.url);
				 $('#sign_name').val('1');
			}
		}).prop("disabled", !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : "disabled");
		$.ajaxSetup({
	        headers:{   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  }
        });
	
		$( "#tanggal_lahir_name" ).datepicker(	{
			changeMonth: true,changeYear: true ,
			dateFormat: "yy-mm-dd",
		});
        $("#submit_alamat_name").click(function(e) {
			var address_name = $('#find_alamat_name').val();
			var url = "{{ root::get_url_admin_user('findalamat') }}";
			$.ajax({
	            url:url,
                data : { 'find_alamat_name' : address_name } ,
                success:function(result){
	                $("#result_alamat_div").html( result );
                }
			}); // end of ajax
            e.preventDefault(); //STOP default action
            e.unbind(); //unbind. to stop multiple form submit.
            return false;			
		}); // end of submit    
		//! prevent from click
		$(".disabled").click(function(e){e.preventDefault();return false;});
	});
	</script>
@stop