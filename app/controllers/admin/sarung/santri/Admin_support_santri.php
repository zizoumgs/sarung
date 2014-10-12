<?php
/**
 *     this class is for santri
*/
abstract class Admin_support_santri extends Admin_sarung_support{
    public function __construct(){
        parent::__construct();
    }
    /**
     *  @override
     *  form which will be used to filter table view
     *  return string
    **/
   	protected function get_form_filter( $go_where  , $method = 'get', $with_session = true ){
        $this->use_select();
        $additional = $hasil = "";
        
        $default = array( "class" => "selectpicker col-md-12" , "id" => "" ,
                         "name" => $this->get_status_select_name() ,
                         'selected' => $this->get_status_select_selected() 
						 );

		$tmp  = Form::text( $this->get_name_filter_name()  , '', array( 'class' => 'form-control input-sm' ,
                                                                       'placeholder' => 'Name' ,
                                                                       'Value' =>  $this->get_name_filter_selected() ));
		$additional .= $this->get_form_group( $tmp , '');

		$tmp  = Form::text( $this->get_id_filter_name()  , '', array( 'class' => 'form-control input-sm' ,
                                                                       'placeholder' => 'Id' ,
                                                                       'Value' =>  $this->get_id_filter_selected() ));
		$additional .= $this->get_form_group( $tmp , '');
        
        $statues = $this->get_select_by_key( $this->get_available_status() , $default);
        $additional .= $this->get_form_group( $statues , '12');
   		$hasil  = Form::open(array('url' => $go_where,
                                   'method' => $method ,
                                   'role' => 'form' ,
                                   'class' =>'form-inline form-filter navbar-form navbar-left')
                ) ;            
        $hasil .= $additional;            
    	$hasil .= '<div class="form-group">';
        	$hasil .= Form::submit('Filter' , array( 'class' => 'btn btn-primary btn-sm' ) );
    	$hasil .= '</div>';
        $hasil .= Form::close();
		return $hasil;
	}
    /* Below is name of select which contains status to filter*/
    protected function set_id_filter_name($val){ $this->input ['id_filter'] = $val ; }
    protected function get_id_filter_name(){ return $this->input ['id_filter'] ;}
    protected function get_id_filter_selected(){ return $this->get_value( $this->get_id_filter_name() ); }
    
    //
    protected function set_session_select_name($val){ $this->input ['session_select'] = $val ; }
    protected function get_session_select_name(){ return $this->input ['session_select'] ;}
    
    
    /**
     * this will filter view by id
     * Return obj
    */
    protected function set_filter_by_id($model_obj , & $wheres  , $mode = 0){
        $selected = $this->get_id_filter_selected() ;
        if(  $selected != "" && is_numeric($selected) ){
            $wheres [ $this->get_id_filter_name()  ] = $selected  ;
            if($mode == 0)
                return $model_obj->where('id' , '=' , $selected);
            return $model_obj->where('santri.id' , '=' , $selected);
        }
        return $model_obj;
    }
    /**
     *  will be filter for addition
     *  return none
    */
    protected function set_filter_for_add($model_obj){
        return $model_obj->getstatussantri(0);
    }
    /**
     *  will be filter for editing and deleting
     *  return none
    */
    protected function set_filter_for_non_add($model_obj){
        return $model_obj->getstatussantri(1);
    }

    /**
     *  get session 
    */
    protected function get_session_select(){
        $hasil = array();
        $session = new Session_Model();
        $sessions = $session->orderby('nama' , 'DESC')->get();
        foreach($sessions as $item){
            $hasil [] = $item->nama ;
        }
        $default = array( "class" => "selectpicker col-md-12",
                         "name" => $this->get_session_select_name() ,
                         'id'   => $this->get_session_select_name() , 
                         'selected' => '12-13',
						 );
        return $this->get_select( $hasil , $default);
    }
}

/**
 *  class for addition 
*/
class Admin_sarung_santri_add extends Admin_support_santri {
    private function set_id_add_name($val){ $this->input ['id_add_name'] = $val; }
    private function get_id_add_name(){ return $this->input ['id_add_name'] ;}
    private function set_url_add_ajax($val){ $this->input ['url_add_name'] = $val; }
    private function get_url_add_ajax(){ return $this->input ['url_add_name']; }

    public function __construct(){
        parent::__construct();
    }
    /**
     *  @override
     *  This is must be function you should make if you make subclass from this class 
     *  return  none
    **/    
    protected function set_default_value(){
        parent::set_default_value();
        $this->set_view('sarung/admin/index');
        $this->set_min_power( 1000 );
		$this->set_title('Santri Admin');
		$this->set_body_attribute( " class='admin admin_sarung_body' " );
        $this->set_table_name('santri');
        //! for url
        $this->set_url_this_dele($this->get_url_admin_sarung()."/santri/eventdel" );
        $this->set_url_this_edit($this->get_url_admin_sarung()."/santri/eventedit");
        $this->set_url_this_add ($this->get_url_admin_sarung()."/santri/eventadd" );
        $this->set_url_add_ajax( $this->get_url_admin_sarung()."/santri/eventaddform" ); 
        $this->set_url_this_view($this->get_url_admin_sarung()."/santri");
        //!
        $this->set_model_obj(new User_Model() );
    }    
    /**
     *  This is must be function you should make if you make subclass from this class 
     *  return  none
    **/    
    protected function set_default_value_for_this(){
        $this->set_model_obj(new Santri_Model() );
        $this->set_session_select_name('session_name');
    }
    /**
     *  navigation
    */
    public function get_common_navigation($aktif = 0 ){
        $array = array ( "btn-default" , "btn-default" , "btn-default");
        $array [$aktif ]= " btn-info ";
        $hasil = sprintf('
            <div class="navbar-form navbar-right" role="search">
                <a href="%1$s" class="btn  btn-sm %4$s">Add</a>
                <a href="%2$s" class="btn  btn-sm %5$s">Edit</a>
                <a href="%3$s" class="btn  btn-sm %6$s">Delete</a>
            </div>',
            $this->get_url_this_add() ,
            $this->get_url_this_edit(),
            $this->get_url_this_dele(),            
            $array [0] ,
            $array [1] ,
            $array [2] 
        );
        return $hasil ;
    }
	/**
	*   this function for add
	**/
    public function getEventadd($messages=""){
		parent::getIndex();
        $this->set_id_filter_name("id_fil");
        //!
        $text_on_top = '<span class="glyphicon glyphicon-user"></span> User Table <small>You are in see user which is not yet inserted to santri</small>';        
        $text_on_top .= $this->get_common_navigation()."<div style='clear:both;'></div>";
        $this->set_text_on_top($text_on_top);
        //!
        $form = $this->get_form_filter( $this->get_url_this_add()  );
        $wheres = array();
        $events  = $this->set_filter_by_user( $this->get_model_obj() );        
        $events = $this->set_filter_by_status( $events , $wheres);
        $events = $this->set_filter_for_add( $events);
        $events = $this->set_filter_by_id( $events , $wheres);
        $events = $this->set_filter_by_name( $events , $wheres);        
        /*Setting order*/
        $events = $this->get_obj_of_ordering($events , $wheres);
        //$form = $this->get_form_filter( $this->get_url_this_view()  );        
        $information  = $form;
        $information .= sprintf('<div class="navbar-text navbar-right information-box medium-font">
                                <span class="glyphicon glyphicon-info-sign "></span> Show %1$s of %2$s</div>', $events->getFrom() , $events->getTotal());
        $table = $this->get_add_table($events);
        $form_add = $this->get_form_default($messages);
        $body = sprintf('<div class="row">%1$s %2$s</div>' , $table , $form_add);
        //!
		$hasil = sprintf(
			'
			<h1 class="title">%1$s</h1>			
            <div class="table_div">
                %2$s
                %3$s
            </div>%4$s',
			 	$this->get_text_on_top()            ,
   				$information                        ,
                $body                              ,
			 	$this->get_pagination_link($events  , $wheres)
			);        
        $this->set_content(  $hasil );
        
        $this->set_js_for_this_add();
        return $this->index();
    }
    /**
     *  setting sorting of object model
     *  return obj 
    */
    protected function get_obj_of_ordering( $model_obj , & $wheres){
        $events = $model_obj->orderBy( "updated_at"  , "DESC")->paginate(10);
        return $events;
    }    
    /**
     *  input  model
     *  return table html
    */
    private function get_add_table($model ){
        $row = "";
        $count = 0 ; 
        foreach($model as $obj){
            $row .= sprintf('<tr id="row_%1$s">', $count);
                $row .= sprintf('<td><button class="btn btn-primary btn-xs" onclick="select_handle(%1$s,\'%2$s\',\'%3$s\')">select<br>%1$s</button></td>' ,
                                $obj->id , $obj->first_name , $obj->second_name );
                $row .= sprintf('<td>%1$s</td>' , $this->get_user_status($obj));
                $row .= sprintf('<td>%1$s</td>' , $this->get_user_data($obj , array( "col-md-3" , "col-md-9 x-small-font" )) );
            $row .= "</tr>";
            $count++;
        }
        $hasil = sprintf('
            <div class="col-md-8">
                <table class="table table-striped table-hover" >
                	<tr class ="header">
                		<th>Select</th>
                        <th>User Status</th>
                        <th>User Data</th>
                	</tr>
                	%1$s	
                </table>            
            </div>
            ',
                $row                
            );
        return $hasil ;
    }

    /**
     *
    **/
    protected function get_form_group_this($label , $input){
        return sprintf('
            <div class="form-group">
                %2$s
            </div>
        ', $label , $input);       
    }
    /**
     *  input  model
     *  return form for adding
    */
    private function get_form_default($message = ""){
        $this->use_select();
        $this->set_default_value_for_this();
   		$form  = Form::open(array('url' => $this->get_url_this_add(), 'method' => 'post' , 'role' => 'form' )) ;
            //! Session            
            $tmp = Form::text('second name', '', array('class' => 'form-control' ,'placeholder' => "Second_Name"));
            $form .= sprintf('<div class="form-group">%1$s</div>', $this->get_session_select());
            //! id
            $tmp = Form::text('id_user', '', array('class' => 'form-control' ,'placeholder' => "Id" , 'id' => 'id_user' , 'readonly'=>''));
            $form .= sprintf('<div class="form-group">%1$s</div>',$tmp);
            //! first name
            $tmp = Form::text('first_name', '', array('class' => 'form-control' ,'placeholder' => "First_Name" , 'id' => 'first_name' ,
                                                       'readonly'=>'' ));
            $form .= sprintf('<div class="form-group">%1$s</div>',$tmp);
            //! second name
            $tmp = Form::text('second name', '', array('class' => 'form-control' ,'placeholder' => "Second_Name" , 'id' => 'second_name' ,
                                                        'readonly'=>''));
            $form .= sprintf('<div class="form-group">%1$s</div>',$tmp);
            //! catatan
            $tmp = sprintf('<textarea class="form-control" rows="3" placeholder = "Catatan" name="catatan" id = "catatan" ></textarea>' );
            $form .= sprintf('<div class="form-group">%1$s</div>',$tmp);            
            //!
            $form .= '<div class="form-group pull-right">';
                $form .= Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) );
            $form .= '</div>';
        $form .= Form::close();
        $form .= $message;
        return sprintf('
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">Add Panel</div>
                    <div class="panel-body" id="panel-body-ku">
                        %1$s
                    </div>
                </div>
            </div>' , $form);
    }    
    /**
     *  input  model
     *  do not use underscore or("_")
     *  $this->set_url_add_ajax( $this->get_url_admin_sarung()."/santri/eventaddform" );
     *  return form for adding
    */
    public function getEventaddform(){
        echo '
                    <p>Sukses</p>
                ';
    }
    
 
    /**
     *  input  model
     *  return none
    */
    private function set_js_for_this_add(){
         $js = sprintf('<script>
            function select_handle(id , first_name , second_name){
                //var url= "%1$s";
                $("#id_user").val(id);
                $("#first_name").val(first_name);
                $("#second_name").val(second_name);
                return;
                $.ajax({
                    url:url             ,
                    data: {"sort": id } ,
                    type: "GET"         ,
                    success:function(result){
                        $("#panel-body-ku").html( result );
                    }
                });
                //  end of ajax                
            }
         ' , $this->get_url_add_ajax());         
         $js.= "</script>";
         $this->set_js($js);
    }
    /**
     *  no override
    */
    public final function postEventadd(){
        $this->set_default_value_for_this();
		$data = Input::all();
        //print_r( $data );
   		$rules = array( 'id_user' => 'required|numeric' , 'first_name' => 'required' );
    	$validator = Validator::make($data, $rules);
		if ($validator->fails())    {
			$messages = $validator->messages();
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages->all() ));
			return $this->getEventAdd($message);
		}
        else{
            $this->set_model_obj(new Santri_Model() );
            return $this->will_insert_to_db($data);
        }            
    }
	/**
	 *	@override
	 *	no child can override this function anymore
	 *	return postEventaddsucceded if succeded , getEventadd otherwise
	*/
	protected final  function Sarung_db_about_add($data , $edit = false , $values = array() ){
        $id_user = $data ["id_user"];
        $session = $data [ $this->get_session_select_name() ] ;
        //! take nis
        $nis_number = $this->get_nis( array('name_session' => $session) );
        //! get idsession
		$session_obj = new Session_Model();
		$there = $session_obj->getfirst($session);
        // change status
        $this->set_change_status_user( $id_user , 2);
        //! main database
        $santri = new Santri_Model();
        $santri->id             =   $data ['id']    ;
        $santri->nis            =   $nis_number     ;
        $santri->idsession      =   $there->id      ;
        $santri->idadmind       =   $id_user        ;
        $santri->catatan        =   $data ['catatan'];
        return $santri;
	}
    /**
     *  get nis number
     *  param is a array with column as a key 
     *  return number of nis 
    */
    protected function get_nis( $param = array()){
        if( !is_array($param)){
            $this->add_obj_dele_db( null );
            return null;
        }
        else{
            //! make nis` object
            $name_session = $param ['name_session'] ;
            $nis_number = 0 ; 
            $nis_obj = new Save_Nis_Model();
            $nis_obj = $nis_obj->getobj( $name_session );
            //! get number 
            if( ! is_null($nis_obj) && $nis_obj->first()){
                $this->add_obj_dele_db( $nis_obj );
                $nis_number = $nis_obj->first()->nis;                    
            }
            else{
                $santri = new Santri_Model();
                $nis_number =  $santri->getmaxnisplus($name_session);
            }
            return $nis_number;
        }
    }
    /**
     *  when there are adding or deleteing , we should change user status
     *  return none;
    **/
    protected function set_change_status_user( $id_user , $status){
        if($id_user){
            $user_my                = new User_Model();
            $user_my = $user_my->find( $id_user);
            $user_my->status        = $status ;
            $this->add_obj_save_db($user_my);
            return;
        }
        $this->add_obj_save_db(0);
    }
}
/**
 *  class for edit santri
*/
class Admin_sarung_santri_edit extends Admin_sarung_santri_add {
    private function set_id_add_name($val){ $this->input ['id_add_name'] = $val; }
    private function get_id_add_name(){ return $this->input ['id_add_name'] ;}
    private function set_url_add_ajax($val){ $this->input ['url_add_name'] = $val; }
    private function get_url_add_ajax(){ return $this->input ['url_add_name']; }

    public function __construct(){
        parent::__construct();
    }
    /**
     *  @override
     *  This is must be function you should make if you make subclass from this class 
     *  return  none
    **/    
    protected function set_default_value(){
        parent::set_default_value();
    }    
    /**
     *  This is must be function you should make if you make subclass from this class 
     *  return  none
    **/    
    protected function set_default_value_for_this(){
        $this->set_model_obj(new Santri_Model() );
        $this->set_session_select_name('session_name');
    }
    /**
     * this will display all user admind with respect to his admind status
     * Return string
    */
    protected function get_user_status_edit($model){
        $status  = sprintf('<span><span class="glyphicon glyphicon-question-sign"></span> status: %1$s</span><br>', $this->get_status($model->status) );
        $date = new DateTime($model->updated_at);
        $updated  = sprintf('<span><span class="glyphicon glyphicon-calendar"></span> Updated: %1$s</span><br>', $date->format('Y-m-d'));
        $date = new DateTime($model->created_at);
        $created  = sprintf('<span><span class="glyphicon glyphicon-time"></span> Created: %1$s</span>', $date->format('Y-m-d'));
        $role       = sprintf('<span><span class="glyphicon glyphicon-magnet"></span> Role: %1$s</span><br>', $model->nama);
        $nama = sprintf('<div class="x-small-font">%1$s %2$s %3$s %4$s</div>' , $status  , $role, $updated, $created );
        return $nama;
    }
    /**
     * this will display all user information
     * Return string
    */
    protected function get_user_data_edit($model , $col_array = array( "col-md-2" , "col-md-10 x-small-font" )){
        $date = new DateTime($model->awal);
        $nis = $date->format("y").str_pad($model->nis,$model->perkiraansantri,"0");
        $nis   = sprintf('<span><span class="glyphicon glyphicon-user"></span> Nis: %1$s</span>' , $nis);
        $nama = sprintf('<span><span class="glyphicon glyphicon-user"></span> Nama: %1$s %2$s</span>  %3$s<br>' ,
                        $model->first_name ,
                        $model->second_name ,
                        $nis);
        
        $foto  = sprintf('<img src="%1$s" class="small-img thumbnail">', $this->get_foto_file($model) );
        $jenis = sprintf('<span>%1$s</span>', $model->jenis);
        $email  = sprintf('<span><span class="glyphicon glyphicon-envelope"></span> Email: %1$s</span><br>', $model->email);
        /*
        $ttl    = sprintf('<span><span class="glyphicon glyphicon-info-sign"></span> TTL: %1$s %2$s</span>', $model->user->tempat->nama , $model->user->lahir);
        $alamat = sprintf('<span><span class="glyphicon glyphicon-map-marker"></span> Alamat:%1$s %2$s</span><br>' ,
                          $model->user->desa->kecamatan->nama ,
                          $model->user->desa->nama);
        */
        $alamat = $ttl = "";
        //$id = 5;
        $sessi = sprintf('<span><span class="glyphicon glyphicon-user"></span> Session: %1$s</span>' , $model->nama);
        $nama = sprintf('<div class="row">
                        <div class="%6$s">%1$s</div>                        
                        <div class="%7$s">%2$s %3$s %4$s %5$s</div>
                        <div class="%7$s">%8$s</div>
                        </div>' , $foto  , $nama, $email, $alamat , $ttl  ,
						$col_array [0] , $col_array[1] ,
                        $sessi);
        return $nama;
	}    
	/**
	*   this function for edit
	**/
    public final function getEventedit( $id = 1, $values = array(), $messages = ''){
		parent::getIndex();
        $this->set_id_filter_name("id_fil");
        //!
        $text_on_top = '<span class="glyphicon glyphicon-user"></span> User Table <small>You are in see user who has been inserted to santri</small> ';
        $text_on_top .= $this->get_common_navigation(1)."<div style='clear:both;'></div>";
        $this->set_text_on_top($text_on_top);
        //!
        $form = $this->get_form_filter( $this->get_url_this_edit()  );
        $wheres = array();

        $events = new Santri_Model();
        $events = $events->get_santri_raw();
        $events = $this->set_filter_by_id( $events , $wheres    , parent::EDIT);
        $events = $this->set_filter_by_name( $events , $wheres  , parent::EDIT);
        $events = $this->set_filter_by_status( $events , $wheres);

        $events = $events->orderby('updated_at' , 'DESC');
        $events = $events->paginate(10);
        $information  = $form;
        $information .= sprintf('<div class="navbar-text navbar-right information-box medium-font">
                                <span class="glyphicon glyphicon-info-sign "></span> Show %1$s of %2$s</div>', $events->getFrom() , $events->getTotal());
        $table = $this->get_table_n_delete( $events );
        $form_edit = $this->get_form_default_edit_n_delete($this->get_url_this_edit() , $messages);
        $body = sprintf('<div class="row">%1$s %2$s</div>' , $table , $form_edit);
		$hasil = sprintf(
			'
			<h1 class="title">%1$s</h1>			
            <div class="table_div">
                %2$s
                %3$s
            </div>%4$s',
			 	$this->get_text_on_top()            ,
   				$information                        ,
                $body                               ,                
			 	$this->get_pagination_link($events  , $wheres)
			);
        $this->set_content(  $hasil );        
        $this->set_js_for_this_edit_n_delete();
        return $this->index();
    }
    /**
     *  input  model
     *  return table html
    */
    protected function get_table_n_delete($model ){
        $row = "";
        $count = 0 ; 
        foreach($model as $obj){
            //print_r($obj);
            $row .= sprintf('<tr id="row_%1$s">', $count);
                $row .= sprintf('<td><button class="btn btn-primary btn-xs" onclick="select_handle(%1$s,\'%2$s\',\'%3$s\',\'%4$s\',\'%5$s\')">select<br>%1$s</button>
                                </td>' ,
                                $obj->id , $obj->first_name , $obj->second_name, $obj->nama , $obj->catatan);
                $row .= sprintf('<td>%1$s</td>' , $this->get_user_status_edit($obj));
                $row .= sprintf('<td>%1$s</td>' , $this->get_user_data_edit($obj , array( "col-md-3" , "col-md-9 x-small-font" )) );
            $row .= "</tr>";
            $count++;
        }
        $hasil = sprintf('
            <div class="col-md-8">
                <table class="table table-striped table-hover" >
                	<tr class ="header">
                		<th>Id</th>
                        <th>User Status</th>
                        <th>User Data</th>
                	</tr>
                	%1$s	
                </table>            
            </div>
            ',
                $row                
            );
        return $hasil ;
    }

    /**
     *  input  model
     *  return form for adding
    */
    protected function get_form_default_edit_n_delete( $url , $message , $purpose = "Edit Panel"){
        $this->use_select();
        $this->set_default_value_for_this();
   		$form  = Form::open(array('url' => $url, 'method' => 'post' , 'role' => 'form' , "name" =>"edit_form" )) ;
            //! Session
            $form .= sprintf('<div class="form-group">%1$s</div>', $this->get_session_select());
            //! id, i change to read only , since laravel didnt send if i disabled the input
            $tmp = Form::text('id_user', '', array('class' => 'form-control' ,'placeholder' => "Id" , 'id' => 'id_user' , 'readonly'=>''));
            $form .= sprintf('<div class="form-group">%1$s</div>',$tmp);
            //! first name
            $tmp = Form::text('first_name', '', array('class' => 'form-control' ,'placeholder' => "First_Name" , 'id' => 'first_name' ,
                                                       'readonly'=>'' ));
            $form .= sprintf('<div class="form-group">%1$s</div>',$tmp);
            //! second name
            $tmp = Form::text('second name', '', array('class' => 'form-control' ,'placeholder' => "Second_Name" , 'id' => 'second_name' ,
                                                        'disabled'=>'disabled'));
            $form .= sprintf('<div class="form-group">%1$s</div>',$tmp);
            //! catatan
            $tmp = sprintf('<textarea class="form-control" rows="3" placeholder = "Catatan" name="catatan" id = "catatan" ></textarea>' );
            $form .= sprintf('<div class="form-group">%1$s</div>',$tmp);
            //! id
            $form .=  Form::hidden("id" , "" , array("id" => "id"));
            //!
            $form .= '<div class="form-group pull-right">';
                $form .= Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) );
            $form .= '</div>';
        $form .= Form::close();
        $form .= $message;
        return sprintf('
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">%2$s</div>
                    <div class="panel-body" id="panel-body-ku">
                        %1$s
                    </div>
                </div>
            </div>' , $form , $purpose);
    }    
    /**
     *  input  model
     *  return none
    */
    protected function set_js_for_this_edit_n_delete(){
         $js = sprintf('<script>
            function select_handle(id , first_name , second_name , session , catatan){
                //var url= "%1$s";
                $("#id_user").val(id);
                $("#first_name").val(first_name);
                $("#second_name").val(second_name);
                $("#catatan").val(catatan);
                $("#id").val(id);
                //var valu = $("#%1$s option:selected").val();
                
                $("#%1$s").selectpicker("refresh");
                //$("#%1$s").selectpicker("hide");
                $("#%1$s").selectpicker("val", session );
            }
         ' , $this->get_session_select_name());         
         $js.= "</script>";
         $this->set_js($js);
    }
    /**
     *  no override
    */
    public final  function postEventedit(){
        $this->set_default_value_for_this();        
		$data = Input::all();
        $id =   $data ['id'] ;
        //print_r( $data );
   		$rules = array( 'id_user' => 'required|numeric' );
    	$validator = Validator::make($data, $rules);
		if ($validator->fails())    {
			$messages = $validator->messages();
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages->all() ));
			return $this->getEventEdit($id ,array(), $message);
		}
        else{
            $this->set_model_obj(new Santri_Model() );
            return $this->will_edit_to_db($data);
        }            
    }
	/**
	 *	@override 
	 *	return postEventaddsucceded if succeded , getEventadd otherwise
	*/
	protected final function Sarung_db_about_edit($data , $values = array() ){
        //! session
        $session        = $data [ $this->get_session_select_name() ] ;
 		$session_obj    = new Session_Model();
		$there          = $session_obj->getfirst($session);
        $new_id_session    = $there->id;
        //! santri
        $santri = new Santri_Model();
        $santri = $santri->find($data ['id']);
        $old_id_session =   $santri->idsession;
        $old_id_nis     =   $santri->nis;  
        //! hardest think , change nis and session
        if($old_id_session != $there->id){
            //! insert old nis
            $nis_obj = new Save_Nis_Model();
            $nis_obj->nis           =   $old_id_nis;
            $nis_obj->idsession     =   $old_id_session;
            $this->add_obj_save_db($nis_obj);
            //! find nis according to new session
            $nis = $this->get_nis( array('name_session' => $session ));
        }
        //! get into santri`s table
        $santri->idsession      =   $there->id      ;
        $santri->nis            =   $nis;
        $santri->catatan        =   $data ['catatan'];
        
        return $santri;
	}    
}
/**
 *  class for delete as well as last class for santri
*/
class Admin_sarung_santri_cud extends Admin_sarung_santri_edit{
    public function __construct(){
        parent::__construct();
    }
    /**
     *  first view during click in side bar
    */
    public final function getIndex(){
        return $this->getEventadd();
    }
    /**
     *  view for deleting
    */
    public final function getEventdel($id = 0 , $messages = ""){
		parent::getIndex();
        $this->set_id_filter_name("id_fil");
        //!
        $text_on_top = '<span class="glyphicon glyphicon-user"></span> Delete Table <small>You are in see user who has been inserted to santri</small> ';
        $text_on_top .= $this->get_common_navigation(2)."<div style='clear:both;'></div>";
        $this->set_text_on_top($text_on_top);
        //!
        $form = $this->get_form_filter( $this->get_url_this_dele()  );
        $wheres = array();

        $events = new Santri_Model();
        $events = $events->get_santri_raw();
        $events = $this->set_filter_by_id( $events , $wheres    , parent::EDIT);
        $events = $this->set_filter_by_name( $events , $wheres  , parent::EDIT);
        $events = $this->set_filter_by_status( $events , $wheres);

        $events = $events->orderby('updated_at' , 'DESC');
        $events = $events->paginate(10);
        $information  = $form;
        $information .= sprintf('<div class="navbar-text navbar-right information-box medium-font">
                                <span class="glyphicon glyphicon-info-sign "></span> Show %1$s of %2$s</div>', $events->getFrom() , $events->getTotal());
        $table = $this->get_table_n_delete( $events );
        $form_edit = $this->get_form_default_edit_n_delete($this->get_url_this_dele() , $messages , "Delete Panel");
        $body = sprintf('<div class="row">%1$s %2$s</div>' , $table , $form_edit);
		$hasil = sprintf(
			'
			<h1 class="title">%1$s</h1>			
            <div class="table_div">
                %2$s
                %3$s
            </div>%4$s',
			 	$this->get_text_on_top()            ,
   				$information                        ,
                $body                               ,                
			 	$this->get_pagination_link($events  , $wheres)
			);
        $this->set_content(  $hasil );        
        $this->set_js_for_this_edit_n_delete();
        return $this->index();       
    }
	/**
	 *	function to get column which will dele db
	 *	return @ Sarung_db_about
	*/
	protected function Sarung_db_about_dele($data , $values = array() ){
        $this->set_model_obj( new Santri_Model() );
		$obj = $this->get_model_obj()->find( $data ['id'] );
        //! gather all required value
        $nis = $obj->nis;
        $idsession = $obj->idsession;
        $idadmind  = $obj->idadmind;
        //! will insert into nis
        $nis_obj = new Save_Nis_Model();
        $nis_obj->nis           =   $nis;
        $nis_obj->idsession     =   $idsession;
        if($nis_obj)
            $this->add_obj_save_db($nis_obj);
        //! will change user status in admind`s table
        $this->set_change_status_user($idadmind , 0);
        //! finish
        return $obj;
	}
}