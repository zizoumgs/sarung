<div class="modal fade" id="myModalDialogDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Will delete class with id :<span class="label label-info" id="dialog_delete_id_information_name"></span></h4>
			</div>
			<div class="modal-body">
				{{
					$form	= Form::open( array( 'url' => root::get_url_admin_ujis('delete') ,
					'method'	=>	'post'  ,
					'class' 	=>	'form-horizontal'   ,
					'name'		=>	'dialog_delete_form_name'  ,
					'id'        =>  'dialog_delete_form_name'  ) )
				}}
				{{ Form::hidden('dialog_delete_id_name' ,'' , array('id' => 'dialog_delete_id_name' ) ) }}
				<div class="form-group">
					<label for="dialog_edit_id_ujian_name" >Id Ujian</label>
					{{ Form::text('dialog_delete_id_ujian_name', '' ,
					array('id' => 'dialog_delete_id_ujian_name' , 'class' => 'form-control' ,
					'title'=>"Type your id ujian here" , 'readonly' => '' ))   }}
				</div>
				<hr>
				<div class="col-md-6">
					<div class="form-group">
						<label for="dialog_edit_session_name" >Session</label>
						{{
							Form::text('dialog_delete_session_name', '' ,
								array('id' => 'dialog_delete_session_name' ,
								'readonly' => '' ,'class' => 'form-control'))
						}}
				</div></div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="dialog_edit_pelajaran_name" >Pelajaran</label>
							{{
								Form::text('dialog_delete_pelajaran_name', '' ,
									array('id' => 'dialog_delete_pelajaran_name' ,
									'readonly' => '' , 'class' => 'form-control'))
							}}
					</div></div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="dialog_edit_kelas_name" >Kelas</label>
							{{
								Form::text('dialog_delete_kelas_name', '' ,
								array('id' => 'dialog_delete_kelas_name' ,
								'readonly' => '' , 'class' => 'form-control'))
							}}
					</div></div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="dialog_edit_pelaksanaan_name" >Pelaksanaan</label>
							{{
								Form::text('dialog_delete_pelaksanaan_name', '' ,
									array('id' => 'dialog_delete_pelaksanaan_name' ,
									'readonly' => '' , 'class' => 'form-control'))
							}}
					</div></div>
				</div>
				<hr>
				<div class="form-group">
					<label for="dialog_edit_id_santri" >Id Santri</label>
					{{
						Form::text('dialog_delete_id_santri_name', '' ,
						array('id' => 'dialog_delete_id_santri_name' , 'class' => 'form-control' , 'readonly' => ''  ));
					}}
				</div>
				<div class="form-group">
					<label for="dialog_edit_santri_name" >Nama</label>
					{{
					Form::text('dialog_delete_santri_name', '' ,
						array('id' => 'dialog_delete_santri_name' , 'readonly' => '' ,
						'class' => 'form-control' , 'readonly' => ''  ));
					}}
				</div>
				<div class="form-group">
					<label for="dialog_edit_nilai_name" >Nilai</label>
					{{
						Form::text('dialog_delete_nilai_name', '' ,
						array('id' => 'dialog_delete_nilai_name' ,
						'class' => 'form-control' , 'readonly' => ''  ));
					}}
				</div>
				{{ Form::close() }}
			</div>
			<div class="modal-footer">	
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary btn-sm" id="dialog_delete_submit_name">Submit Edit</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
