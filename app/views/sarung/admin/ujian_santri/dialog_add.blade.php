<div class="modal fade" id="dialog_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    	<div class="modal-content">
    		<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    			<h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Add Nilai Santri</h4>
			</div>
			<div class="modal-body">
                {{
                    $form	= Form::open( array( 'url' => root::get_url_admin_ujis('add') ,
                        'method'	=>	'post'  ,
                        'class' 	=>	'form-horizontal'   ,
                        'name'		=>	'dialog_add_form_name'  ,
                        'id'        =>  'dialog_add_form_name'  ) )
                }}
                <div class="form-group">
                    <label for="dialog_add_id_ujian_name" class="col-sm-2 control-label">Id Ujian</label>
                    <div class="col-sm-10">
                        {{
                            Form::text('dialog_add_id_ujian_name', '' ,
                                array('id' => 'dialog_add_id_ujian_name' , 'class' => 'form-control' ,
								'readonly' => ''
                                ))
                        }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="dialog_add_id_santri_name" class="col-sm-2 control-label">Id Santri</label>
                    <div class="col-sm-10">
                        {{
                            Form::text('dialog_add_id_santri_name', '' ,
                                array('id' => 'dialog_add_id_santri_name' , 'class' => 'form-control' , 
								'readonly' => ''
                                ))
                        }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="dialog_add_santri_name" class="col-sm-2 control-label">Nama Santri</label>
                    <div class="col-sm-10">
                        {{
                            Form::text('dialog_add_santri_name', '' ,
                                array('id' => 'dialog_add_santri_name' , 'class' => 'form-control',
								'readonly' => ''
                                ))
                        }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="dialog_add_nilai_name" class="col-sm-2 control-label">Nilai</label>
                    <div class="col-sm-10">
                        {{
                            Form::text('dialog_add_nilai_name', '' ,
                                array('id' => 'dialog_add_nilai_name' , 'class' => 'form-control'
                                ))
                        }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
			<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="dialog_add_submit_name">Insert</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
