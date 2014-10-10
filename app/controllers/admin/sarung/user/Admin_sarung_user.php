<?php
/**
 *  This claas will be crud for user table
*/
class Admin_sarung_user_support extends Admin_sarung_support{
	public function __construct(){
		parent::__construct();
	}
    /**
     *  @var array
    */
    protected $user_attr;
    protected function set_email_name($val){ $this->user_attr ['email_'] = $val ; }
    protected function get_email_name(){ return $this->user_attr ['email_'] ;}
    protected function get_email_selected(){return $this->get_value( $this->get_email_name() );}
    
    /* Below is name of filter input which will filter output by its name */
    protected function set_name_filter_name($val){ $this->user_attr ['filter_name'] = $val ; }
    protected function get_name_filter_name(){ return $this->user_attr ['filter_name'] ;}
    protected function get_name_filter_selected(){ return $this->get_value( $this->get_name_filter_name() ); }
    
    /* Below is name of filter input which will filter output by its email */
    protected function set_email_filter_name($val){ $this->user_attr ['filter_email'] = $val ; }
    protected function get_email_filter_name(){ return $this->user_attr ['filter_email'] ;}
    protected function get_email_filter_selected(){ return $this->get_value( $this->get_email_filter_name() ); }
    
    /* Below is name of filter input which will filter output by year created */
    protected function set_year_filter_name($val){ $this->user_attr ['filter_year'] = $val ; }
    protected function get_year_filter_name(){ return $this->user_attr ['filter_year'] ;}
    protected function get_year_filter_selected(){ return $this->get_value( $this->get_year_filter_name() ); }
    
    /* Below is name of select which contains status to filter*/
    protected function set_status_select_name($val){ $this->user_attr ['status_select'] = $val ; }
    protected function get_status_select_name(){ return $this->user_attr ['status_select'] ;}
    protected function get_status_select_selected(){ return $this->get_value( $this->get_status_select_name() ); }

    /*name for button to executed check button in table*/
    protected function set_apply_button_name($val){ $this->user_attr ['button_apply'] = $val ; }
    protected function get_apply_button_name(){ return $this->user_attr ['button_apply'] ;}

    /*select for bulk */
    protected function set_select_bulk_name($val){ $this->user_attr ['select_bulk'] = $val ; }
    protected function get_select_bulk_name(){ return $this->user_attr ['select_bulk'] ;}
    protected function get_select_bulk_selected(){ return $this->get_value( $this->get_select_bulk_name()) ;}
    
    /**url for bulk action*/
    protected function set_url_for_bulk_act( $val ) { $this->user_attr ['url_bulk_act'] = $val ; }
    protected function get_url_for_bulk_act() { return $this->user_attr ['url_bulk_act'] ;}

    /** name for form table */
    protected function set_table_form_name( $val ) { $this->user_attr ['table_form'] = $val ; }
    protected function get_table_form_name() { return $this->user_attr ['table_form'] ;}

    /** name for signal of form table */
    protected function set_signal_bulk_name( $val ) { $this->user_attr ['signal_bulk'] = $val ; }
    protected function get_signal_bulk_name() { return $this->user_attr ['signal_bulk']  ;}
    protected function get_signal_bulk_selected() { return $this->get_value( $this->get_signal_bulk_name()) ;}
    /** name for total item in table */
    protected function set_total_item_name( $val ) { $this->user_attr   ['total_item'] = $val ; }
    protected function get_total_item_name() { return $this->user_attr  ['total_item'] ;}
    protected function get_total_item_selected() { return $this->get_value( $this->get_total_item_name()  ) ;}

    /** name for prefix check box in table */
    protected function set_prefix_cb_name( $val ) { $this->user_attr   ['prefix_cb'] = $val ; }
    protected function get_prefix_cb_name() { return $this->user_attr  ['prefix_cb'] ;}
    
    /** url for click header **/
    protected function set_url_for_click_header( $val ) { $this->user_attr ['url_click_header'] = $val ; }
    protected function get_url_for_click_header() { return $this->user_attr ['url_click_header'] ;}
    /**
     *  folder of foto santri
    */
    protected function set_foto_folder($val){ $this->user_attr ['folder_foto_'] = $val ; }
    protected function get_foto_folder(){ return $this->user_attr ['folder_foto_'] ;}
    /**
     *  this class will save order data , it will save integer
    */
    protected function set_order($val){ $this->user_attr ['order_data'] = $val ; }
    protected function get_order()    { return $this->user_attr ['order_data'] ; }
    protected function set_order_name($val){ $this->user_attr ['order_data_name'] = $val ; }
    protected function get_order_name()    { return $this->user_attr ['order_data_name'] ; }
    protected function get_order_name_selected()    { return $this->get_value( $this->get_order_name() ) ; }	
}
class Admin_sarung_user_filter extends Admin_sarung_user_support{
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
        //! for bulk action
        $additional .= $this->get_form_group( $this->get_select_bulk() , '');
        $additional .= Form::button('apply' ,array('class' => 'btn btn-primary btn-sm' , 'id' => $this->get_apply_button_name() ) );
        
        $default = array( "class" => "selectpicker col-md-12" , "id" => "" ,
                         "name" => $this->get_status_select_name() ,
                         'selected' => $this->get_status_select_selected() 
						 );
        $statues = $this->get_select_by_key( $this->get_available_status() , $default);
		$tmp  = Form::text( $this->get_name_filter_name()  , '', array( 'class' => 'form-control input-sm' ,
                                                                       'placeholder' => 'Name' ,
                                                                       'Value' =>  $this->get_name_filter_selected() ));
		$additional .= $this->get_form_group( $tmp , '');
        $tmp = Form::text( $this->get_email_filter_name()  , '', array( 'class' => 'form-control input-sm' ,
                                                                       'placeholder' => 'Email' ,
                                                                       'Value' =>  $this->get_email_filter_selected() ));
        $additional .= $this->get_form_group( $tmp , '');
        $tmp = Form::text( $this->get_year_filter_name()  , '', array( 'class' => 'form-control input-sm' ,
                                                                       'placeholder' => 'Year Created' ,
                                                                       'Value' =>  $this->get_year_filter_selected() ));
        $additional .= $this->get_form_group( $tmp , '');
        $additional .= $this->get_form_group( $statues , '12');
        $additional .= Form::hidden( $this->get_order_name() , $this->get_order());
   		$hasil  = Form::open(array('url' => $go_where, 'method' => $method , 'role' => 'form' ,'class' =>'form-inline form-filter navbar-form navbar-left')) ;            
            $hasil .= $additional;            
    		$hasil .= '<div class="form-group">';
        		$hasil .= Form::submit('Filter' , array( 'class' => 'btn btn-primary btn-sm' ) );
    		$hasil .= '</div>';
        $hasil .= Form::close();
		//$hasil = sprintf('%1$s',$hasil );
		return $hasil;
	}
    /**
     * this will filter admind which will be seen , admind with lower/same power can`t see higher power
     * Return obj
    */
    protected function set_filter_by_user($model_obj){
        return $model_obj->getlesserPowerid($this->get_user_power());
    }
    /**
     * this will filter view by email
     * Return obj
    */
    protected function set_filter_by_email($model_obj , & $wheres ){
        if( $this->get_email_filter_selected() != ""){
            $wheres [$this->get_email_filter_name()] =  $this->get_email_filter_selected();
            return $model_obj->where('email' , 'LIKE' , "%".$this->get_email_filter_selected()."%");
        }
        return $model_obj;
    }
    /**
     * this will filter view by year
     * Return obj
    */
    protected function set_filter_by_year($model_obj , & $wheres ){
        if( $this->get_year_filter_selected() != ""){
            $wheres [$this->get_year_filter_name()] =  $this->get_year_filter_selected();
            return $model_obj->whereRaw(' YEAR(created_at) = ?' , array($this->get_year_filter_selected()) );
        }
        return $model_obj;
    }
    /**
     * this will filter view by name
     * Return obj
    */
    protected function set_filter_by_name($model_obj , & $wheres ){
        if( $this->get_name_filter_selected() != ""){
            $wheres [$this->get_name_filter_name()] = $this->get_name_filter_selected();
            return $model_obj->whereRaw(" (first_name LIKE ? or second_name LIKE ? ) " ,
                                        array( "%".$this->get_name_filter_selected()."%" ,
                                              "%".$this->get_name_filter_selected()."%" )
                                        );
        }
        return $model_obj;
    }
    /**
     * this will filter view by name
     * Return obj
    */
    protected function set_filter_by_status($model_obj , & $wheres ){
        $selected = $this->get_status_select_selected() ;
        if(  $selected != "" && $selected != -100){
            $wheres [ $this->get_status_select_name()  ] = $selected  ;
            return $model_obj->where('status' , '=' , $selected);
        }
        return $model_obj;
    }
}
class Admin_sarung_user extends Admin_sarung_user_filter{
	public function __construct(){
		parent::__construct();
	}
    /**
     *  @override
     *  This is must be function you should make if you make subclass from this class 
     *  return  none
    **/
    protected function set_default_value(){
        $this->set_view('sarung/admin/index');
        $this->set_min_power( 1000 );
		$this->set_title('User register');
		$this->set_body_attribute( " class='admin admin_sarung_body' " );
        $this->set_table_name('admind');
        //! filter
        $this->set_name_filter_name('name_filter');
        $this->set_email_filter_name('email_filter');
        $this->set_status_select_name('sinbad');
        $this->set_year_filter_name('year_filter');
        $this->set_apply_button_name('apply_button');
        $this->set_select_bulk_name('select_bulk');
        //! input
        $this->set_email_name('email_boss');
        //! for url
        $this->set_url_this_dele($this->get_url_admin_sarung()."/user/eventdel" );
        $this->set_url_this_edit($this->get_url_admin_sarung()."/user/eventedit");
        $this->set_url_this_add ($this->get_url_admin_sarung()."/user/eventadd" );
        $this->set_url_this_view($this->get_url_admin_sarung()."/user");
        $this->set_url_for_click_header($this->get_url_admin_sarung()."/user/clickheader");
        $this->set_url_for_bulk_act($this->get_url_admin_sarung()."/user/bulkaction");
        //!
        $this->set_model_obj(new User_Model() );
        //! special
        $this->set_foto_folder($this->base_url()."/foto");
        $this->set_order(2);
        $this->set_order_name('order_name');
        $this->set_table_form_name('tidak_penting');
        $this->set_signal_bulk_name('signal_bulk_name');
        $this->set_total_item_name('total_item');
        $this->set_prefix_cb_name('check_box');
        //! below is must be last command to executed
        //$this->set_special_js();
        
    }
    /**
     * this will display all user admind with respect to his admind status
     * Return string
    */
    protected function get_user_status($model){        
        $status  = sprintf('<span><span class="glyphicon glyphicon-question-sign"></span> status: %1$s</span><br>', $this->get_status($model->status) );
        $updated  = sprintf('<span><span class="glyphicon glyphicon-calendar"></span> Updated: %1$s</span><br>', $model->updated_at);
        $created  = sprintf('<span><span class="glyphicon glyphicon-time"></span> Created: %1$s</span>', $model->created_at);
        $role = '';
        $role       = sprintf('<span><span class="glyphicon glyphicon-magnet"></span> Role: %1$s</span><br>', $model->admindgroup->nama);
        $nama = sprintf('<div class="x-small-font">%1$s %2$s %3$s %4$s</div>' , $status  , $role, $updated, $created );
        return $nama;        
    }
    /**
     * this will display all user information
     * Return string
    */
    protected function get_user_data($model){
        $foto  = sprintf('<img src="%1$s/%2$s/%3$s" class="small-img thumbnail">',$this->get_foto_folder() , $model->id, $model->foto );
        $jenis = sprintf('<span>%1$s</span>', $model->jenis);
        $email  = sprintf('<span><span class="glyphicon glyphicon-envelope"></span> Email: %1$s</span><br>', $model->email);
        $ttl    = sprintf('<span><span class="glyphicon glyphicon-info-sign"></span> TTL: %1$s %2$s</span>', $model->tempat->nama , $model->lahir);
        $alamat = sprintf('<span><span class="glyphicon glyphicon-map-marker"></span> Alamat:%1$s %2$s %3$s</span><br>' ,
                          $model->desa->kecamatan->kabupaten->nama ,
                          $model->desa->kecamatan->nama ,
                          $model->desa->nama);
        $nama = sprintf('<span><span class="glyphicon glyphicon-user"></span> Nama: %1$s %2$s</span><br>' , $model->first_name , $model->second_name);
        $nama = sprintf('<div class="row">
                        <div class="col-md-2">%1$s</div>
                        <div class="col-md-10 x-small-font">%2$s %3$s %4$s %5$s</div>
                        </div>' , $foto  , $nama, $email, $alamat , $ttl );
        return $nama;
    }
    /**
     *  @override
     *  default view for get methode
     *  return  @index()
    **/
    public function getIndex(){
		parent::getIndex();
        $href = sprintf('<a href="%1$s" class="btn btn-primary btn-xs" >Add</a>' , $this->get_url_this_add() );
        $this->set_text_on_top('<span class="glyphicon glyphicon-user"></span> User Table  '.$href);        
        $form = $this->get_form_filter( $this->get_url_this_view()  );
        $wheres = array();
        $events  = $this->set_filter_by_user( $this->get_model_obj() );        
        $events = $this->set_filter_by_email($events  , $wheres);
        $events = $this->set_filter_by_status( $events , $wheres);
        $events = $this->set_filter_by_name( $events , $wheres);
        $events = $this->set_filter_by_year( $events , $wheres);
        /*Setting order*/
        $events = $this->get_obj_of_ordering($events , $wheres);
        
        $information  = $form;
        $information .= sprintf('<div class="navbar-text navbar-right information-box medium-font">
                                <span class="glyphicon glyphicon-info-sign "></span> Show %1$s of %2$s</div>', $events->getFrom() , $events->getTotal());
        $table = $this->get_table($events);
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
                $table           ,
			 	$this->get_pagination_link($events  , $wheres)
			);
        $this->set_content(  $hasil );
        return $this->index();
    }
    /**
     *  input  model
     *  return table html
    */
    protected function get_table($model ){
        $row = "";
        $count = 0 ; 
        foreach($model as $obj){            
            $row .= sprintf('<tr id="row_%1$s">', $count);
                $row .= sprintf('<td><input name="%2$s" type="checkbox" value="%1$s"></td>' , $obj->id , $this->get_prefix_cb_name().$count);
                $row .= sprintf('<td>%1$s</td>' , $this->get_edit_delete_row( $obj->id ));
                $row .= sprintf('<td>%1$s</td>' , $this->get_user_status($obj));
                $row .= sprintf('<td>%1$s</td>' , $this->get_user_data($obj) );
            $row .= "</tr>";
            $count++;
        }
        $hasil = sprintf('
            <table class="table table-striped table-hover" >
            	<tr class ="header">
            		<th>Bulk Action</th>
                    <th>Edit/Delete</th>
                    <th><a href="%2$s/1">User Status</a></th>
                    <th><a href="%3$s/2">User Data</a></th>
    			</tr>
    			%1$s	
    		</table>',
                $row , 
                $this->get_url_for_click_header() ,
                $this->get_url_for_click_header()            
            );
        $form  = Form::open(
                    array('url' => $this->get_url_for_bulk_act(),
                      'method' => 'get' ,
                      'role' => 'form_table' ,
                      'name' => $this->get_table_form_name(),
                      'id' => $this->get_table_form_name()
                    )
                );
        $form .= $hasil ;
        $form .= Form::hidden($this->get_signal_bulk_name() , '' , array( 'id' => $this->get_signal_bulk_name()) );
        $form .= Form::hidden($this->get_total_item_name()  , $count);
        $form .= Form::close();
        return $form ;
    }
    /**
     *  setting sorting of object model
     *  return obj 
    */
    protected function get_obj_of_ordering( $model_obj , & $wheres){
        $order = "";
        $which_header = $this->get_order();
        if($which_header == 1){
            //! watch out space
            $order = "updated_at";
        }
        else{
            $order = "id";
        }
        $kind_of_sorting = "DESC";
        $wheres [ $this->get_order_name() ] = $this->get_order();
        $events = $model_obj->orderBy( $order  , $kind_of_sorting )->paginate(10);
        return $events;
    }
    /**
     *  url for bulk action , it related with database
     *  return getIndex()
     */
    public function getBulkaction(){
        for($x = 0 ; $x < $this->get_total_item_selected() ; $x++){
            $id = $this->get_value( $this->get_prefix_cb_name().$x);
            if( $id != ""){
                if( $this->get_signal_bulk_selected() != 'Bulk Action'){
                    $user = new User_Model();
                    $user = $user->find($id);
                    $user->status = $this->get_status( $this->get_signal_bulk_selected() , 1);
                    $user->save();
                }
            }
        }
        return $this->getIndex();        
    }
    /**
     *  change order of displaying data
     *  return getIndex()
     */
    public function getClickheader($which_header){
        $this->set_order( $which_header );
        return $this->getIndex();
    }
  	/**
     *  will get user status , see admind`s table
     *  input : integer or Text 
     *  return string if input mode = 0 , meanwhile 1 return number
   	*/    
    protected function get_status( $signal , $mode = 0){
        /*
   		-1: banned studend 
   		0: not inserted into santri table , this for new registering student
   		1 : non_aktif -> cannot edit , just view 
   		2 : aktif 	 -> can edit
        */
        $value = array(
                       -1 => 'Banned users'     ,
                        0 => 'New Registering'  ,
                        1 => "Non Aktif"        ,
                        2 => "Aktif"
                       );
        if($mode == 0 ):
            if( isset($value [$signal]) ):
                return $value [$signal];
            endif;
        elseif($mode == 1):
            foreach($value as $key => $val){
                if( $val == $signal){
                    return $key;
                }
            }
        endif;
        return "Error";

    }
    /**
     *  return array
    */
    protected function get_available_status( $default = 'All'){
        return array(
                    '-100'    =>  $default,
                     '-1'  =>  'Banned',
                      '0'   =>  'Registered' ,
                      '1'   =>  'Non Aktif' ,
                      '2'   =>  'Aktif'                           
                     );        
    }
    /**
     *  return bulk select 
    */
    protected function get_select_bulk(){
        $default = array( "class" => "selectpicker col-md-12" , "id" => "" ,
                         "name" => $this->get_select_bulk_name() ,
                         "id"   => $this->get_select_bulk_name() ,
                         'selected' => $this->get_select_bulk_selected()
                         
						 );
        return $this->get_select( $this->get_available_status('Bulk Action') , $default);
    }
    /**
     *  js for button to executed check box
     *  return none
    */
    protected function set_special_js(){
		$js = sprintf('
		<script type="text/javascript">
			$(function() {
				$( "#%1$s"  ).click(function () {
                    var value = $("#%4$s").val();
                    $("#%3$s").val(value);
					$("#%2$s").submit();
                    //var isChecked = $("#row_1 input:checkbox")[0].checked;
                    //alert(isChecked);
				});
			});
		</script>' ,
        $this->get_apply_button_name(),
        $this->get_table_form_name(),
        $this->get_signal_bulk_name(),
        $this->get_select_bulk_name()
		);
        $this->set_js( $js);
    }
	/**
     *  @override
	 *	Usually it is used inside table view html
	 *	return add and edit html link
	*/
    protected final function get_edit_delete_row($additional = ""){
        $edi = sprintf('<a href="%1$s/%2$s" class="btn btn-default btn-xs" >Edit</a>'    , $this->get_url_this_edit() , $additional );
        $del = sprintf('<a href="%1$s/%2$s" class="btn btn-default btn-xs">Delete</a>'      , $this->get_url_this_dele() , $additional );
        return "<div class='btn-group-vertical btn-group-xs'>".$edi."  ".$del . "</div>";
    }

}
