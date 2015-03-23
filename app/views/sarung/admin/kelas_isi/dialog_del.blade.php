
    {{ Form::open(
        array	(
			'url'		=> 	root::get_url_admin_kelas_isi('delete') 	,
			'method'	=>	'post'					    				,
			'class' 	=>	'form-horizontal'		    				,
			'name'		=>	'dialog_del_form_name'  		            ,
			'id'		=>	'dialog_del_form_name'                		,
			'role' 		=> 	'form'
		)
        
    ) }}
        {{ Form::hidden( 'dialog_del_id_name'        , '' , array('id'=>  'dialog_del_id_name')         );  }}
    	{{ Form::hidden( 'dialog_del_id_kelas_name'  , '' , array('id'=>  'dialog_del_id_kelas_name')   );  }}
    	{{ Form::hidden( 'dialog_del_id_santri_name' , '' , array('id'=>  'dialog_del_id_santri_name' ) );  }}
    	{{ Form::hidden( 'dialog_del_session_name'   , '' , array('id'=>  'dialog_del_session_name' )   );  }}
    {{ Form::close() }}
