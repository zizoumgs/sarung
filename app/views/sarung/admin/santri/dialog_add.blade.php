
<div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    	<div class="modal-content">
    		<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
   				<h4 class="modal-title">
					<label class="btn btn-link">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						Insert Into Siswa
					</label>
				</h4>
			</div>
			<div class="modal-body">
                {{ Form::open( array('url' => root::get_url_admin_santri('add') , 'method' => 'post' ,
                    'role' => 'form'            ,   'class' => 'form-horizontal',
                    'name' => 'dialog_name'     ,   'id'    => 'dialog_name'
                ) ) }}
    			<div class="form-group">
    				<label for="dialog_session_name" class="col-sm-3 control-label">Session</label>
                    <div class="col-sm-9">
        				<select class="form-control col-sm-2" name="dialog_session_name">
        					@foreach( Session_Model::orderBy('nama' , 'DESC')->get() as $model)
        						<option value="{{ $model->nama }}"
        							@if ($model->nama === Input::get('find_session_name') )
        								selected
        							@endif							
        							>
        							{{ $model->nama }}
        						</option>
        					@endforeach
        				</select>
                    </div>
    			</div>
                <div class="form-group">
    				<label for="dialog_user_id" class="col-sm-3 control-label">Id Santri</label>
       				<div class="col-sm-9">
                        {{ Form::text('dialog_user_id', '' , array('id' => 'dialog_user_id' , 'class' => 'form-control' ,'ReadOnly'=>'' )) }}
       				</div>
    			</div>
                <div class="form-group">
    				<label for="dialog_santri_name" class="col-sm-3 control-label">Santri Name</label>
       				<div class="col-sm-9">
	                    {{ Form::text('dialog_santri_name', '' , array('id' => 'dialog_santri_name' , 'class' => 'form-control' ,'ReadOnly'=>'' )) }}
      				</div>
    			</div>
                <div class="form-group">
    				<label for="dialog_catatan_name" class="col-sm-3 control-label">Catatan</label>
       				<div class="col-sm-9">
						{{ Form::TextArea(	'catatan_name', '' ,
										array('id' => 'catatan_name' ,
										'class' => 'form-control' ,'Rows'=>'5' ,'required' => '')) }}
      				</div>
    			</div>
			</div>
			{{ Form::close(); }}
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="dialog_submit_name">Insert</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
        