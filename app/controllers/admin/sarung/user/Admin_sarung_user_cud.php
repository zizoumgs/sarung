<?php
/**
 *  This claas will handle add , edit and delete user
 *  of course power which is user has will be key
*/
class Admin_sarung_user_cud_support extends Admin_sarung_user{
    public function __construct(){
        parent::__construct();
    }
    protected function set_first_name_name($val){ $this->user_attr ['first_name'] = $val ; }
    protected function get_first_name_name(){ return $this->user_attr ['first_name'] ;}
    protected function get_first_name_selected(){return $this->get_value( $this->get_first_name_name() );}

    protected function set_second_name_name($val){ $this->user_attr ['second_name'] = $val ; }
    protected function get_second_name_name(){ return $this->user_attr ['second_name'] ;}
    protected function get_second_name_selected(){return $this->get_value( $this->get_second_name_name() );}

    protected function set_email_name($val){ $this->user_attr ['email'] = $val ; }
    protected function get_email_name(){ return $this->user_attr ['email'] ;}
    protected function get_email_selected(){return $this->get_value( $this->get_email_name() );}
    
    protected function set_password_name($val){ $this->user_attr ['password_'] = $val ; }
    protected function get_password_name(){ return $this->user_attr ['password_'] ;}
    protected function get_password_selected(){return $this->get_value( $this->get_password_name() );}

    protected function set_password_over_name($val){ $this->user_attr ['password__'] = $val ; }
    protected function get_password_over_name(){ return $this->user_attr ['password__'] ;}
    protected function get_password_over_selected(){return $this->get_value( $this->get_password_over_name() );}

    protected function set_day_name($val){ $this->user_attr ['day_date'] = $val ; }
    protected function get_day_name(){ return $this->user_attr ['day_date'] ;}
    protected function get_day_selected(){return $this->get_value( $this->get_day_name()  );}
    
    protected function set_mnt_name($val){ $this->user_attr ['mnt_date'] = $val ; }
    protected function get_mnt_name(){ return $this->user_attr ['mnt_date'] ;}
    protected function get_mnt_selected(){return $this->get_value( $this->get_mnt_name()  );}

    protected function set_year_name($val){ $this->user_attr ['year_date'] = $val ; }
    protected function get_year_name(){ return $this->user_attr ['year_date'] ;}
    protected function get_year_selected(){return $this->get_value( $this->get_year_name()  );}

    protected function set_tempat_lahir_name($val){ $this->user_attr ['tempat_lahir'] = $val ; }
    protected function get_tempat_lahir_name(){ return $this->user_attr ['tempat_lahir'] ;}
    protected function get_tempat_lahir_selected(){return $this->get_value( $this->get_tempat_lahir_name()  );}

    protected function set_group_name($val){ $this->user_attr ['group'] = $val ; }
    protected function get_group_name(){ return $this->user_attr ['group'] ;}
    protected function get_group_selected(){return $this->get_value( $this->get_group_name()  );}

    protected function set_propinsi_name($val){ $this->user_attr ['propinsi'] = $val ; }
    protected function get_propinsi_name(){ return $this->user_attr ['propinsi'] ;}
    protected function get_propinsi_selected(){return $this->get_value( $this->get_propinsi_name()  );}
    
    protected function set_kabupaten_name($val){ $this->user_attr ['kabupaten'] = $val ; }
    protected function get_kabupaten_name(){ return $this->user_attr ['kabupaten'] ;}
    protected function get_kabupaten_selected(){return $this->get_value( $this->get_kabupaten_name()  );}

    protected function set_kecamatan_name($val){ $this->user_attr ['kecamatan'] = $val ; }
    protected function get_kecamatan_name(){ return $this->user_attr ['kecamatan'] ;}
    protected function get_kecamatan_selected(){return $this->get_value( $this->get_kecamatan_name()  );}

    protected function set_desa_name($val){ $this->user_attr ['desa'] = $val ; }
    protected function get_desa_name(){ return $this->user_attr ['desa'] ;}
    protected function get_desa_selected(){return $this->get_value( $this->get_desa_name()  );}
    /* with this computer know how to make different between submit with button and with combobox/select */
    protected function set_signal_name($val){ $this->user_attr ['signal'] = $val ; }
    protected function get_signal_name(){ return $this->user_attr ['signal'] ;}
    protected function get_signal_selected(){return $this->get_value( $this->get_signal_name()  );}
    /* it relates with combobox/select */
    protected function set_store_url_name($val){ $this->user_attr ['store_url'] = $val ; }
    protected function get_store_url_name(){ return $this->user_attr ['store_url'] ;}
    protected function get_store_url_selected(){return $this->get_value( $this->get_store_url_name()  );}    
    /* name for woman gender*/
    protected function set_gender_name($val){ $this->user_attr ['gender'] = $val ; }
    protected function get_gender_name(){ return $this->user_attr ['gender'] ;}
    protected function get_gender_selected(){return $this->get_value( $this->get_gender_name() );}

}

/**
 *  this class contains  all input
*/
class Admin_sarung_user_cud_input extends Admin_sarung_user_cud_support{
    public function __construct(){
        parent::__construct();
    }
    /**
     *  return group input for adding , editing and deleting
    */
    protected function get_group_alamat($label , $input ){
        $names = sprintf ('
            <div class="form-group">                
                <div class="row">
                    <label class="col-xs-3 control-label"> %2$s </label>
                    <div class="col-xs-8">
                        %1$s
                    </div>
              </div>
            </div>
          ' ,
            $input , $label
          );
        return $names; 
    }
    /**
     *  return desa select 
    **/
    protected function get_desa_select( $values , $disable = ""){
        $propinsi = $values [$this->get_propinsi_name()]   ;
        $kabupaten = $values [$this->get_kabupaten_name()] ;
        $kecamatan = $values [$this->get_kecamatan_name()] ;
        $desa       = $values [ $this->get_desa_name()];
        $default = array( "class" => "selectpicker col-md-12",
                         "name" => $this->get_desa_name() ,
                         'id'   => $this->get_desa_name() , 
                         'selected' => $desa,
						 );
        $obj = new Desa_Model();
        $names = array();
        $lists = $obj->get_desas_of_kecamatan('Indonesia',$propinsi , $kabupaten , $kecamatan);
        foreach(  $lists as $kabs){
            $names [] = $kabs->nama;
        }
        $items = $this->get_select($names , $default , $disable);
        return $this->get_group_alamat('Desa' , $items);
    }

    /**
     *  return kecamatan select 
    **/
    protected function get_kecamatan_select( $values , $disable = ""){
        $propinsi = $values [$this->get_propinsi_name()]   ;
        $kabupaten = $values [$this->get_kabupaten_name()] ;
        $kecamatan = $values [$this->get_kecamatan_name()] ;
        $default = array( "class" => "selectpicker col-md-12",
                         "name" => $this->get_kecamatan_name() ,
                         'id'   => $this->get_kecamatan_name() , 
                         'selected' => $kecamatan
						 );
        $obj = new Kecamatan_Model();
        $names = array();
        $lists = $obj->get_kecamatans_of_kabupaten('Indonesia',$propinsi , $kabupaten);
        foreach(  $lists as $list){
            $names [] = $list->nama;
        }
        $items = $this->get_select($names , $default, $disable);
        return $this->get_group_alamat('Kecamatan' , $items);
    }
    /**
     *  return kabupaten select 
    **/
    protected function get_kabupaten_select( $values , $disable = ""){
        $propinsi = $values [$this->get_propinsi_name()] ;
        $kabupaten = $values [$this->get_kabupaten_name()] ;
        $default = array( "class" => "selectpicker col-md-12",
                         "name" => $this->get_kabupaten_name() ,
                         'id'   => $this->get_kabupaten_name() , 
                         'selected' => $kabupaten
						 );
        $obj = new Kabupaten_Model();
        $names = array();
        $lists = $obj->get_kabupatens_of_propinsi('Indonesia',$propinsi)->orderBy('nama')->get();
        if( !$lists->isEmpty()){
            foreach( $lists as $kabs){
                $names [] = $kabs->nama;
            }
        }
        $items = $this->get_select($names , $default, $disable);
        return $this->get_group_alamat('Kabupaten' , $items);
    }

    /**
     *  return propinsi select 
    **/
    protected function get_propinsi_select( $values = array() , $disable = ""){
        $default = array( "class" => "selectpicker col-md-12" , 
                         "name" => $this->get_propinsi_name() ,
                         "id"   => $this->get_propinsi_name() ,
                         'selected' => $values [$this->get_propinsi_name()]
						 );
        $obj = new Propinsi_Model();
        $items = $this->get_select( $obj->get_namas() , $default, $disable);
        return $this->get_group_alamat('Propinsi' , $items);
    }
    /**
     *  return status select 
    **/
    protected function get_group_select( $values = array() , $disable = ""){
        $default = array( "class" => "selectpicker col-md-12" , "id" => "" ,
                         "name" => $this->get_group_name() ,
                         'selected' => $values [$this->get_group_name()]
						 );
        $AdmindGroup = new AdmindGroup();
        $items = array();
        foreach( $AdmindGroup->get_lesser_power($this->get_user_power())->get() as $val){
            $items [] = $val->nama;
        }
        $statues = $this->get_select( $items , $default, $disable);
        return $this->get_group_alamat('Group' , $statues);
    }

    /**
     *  return status select 
    **/
    protected function get_status_select( $values = array() , $disable = ""){
        $default = array( "class" => "selectpicker col-md-12" , "id" => "" ,
                         "name" => $this->get_status_select_name() ,
                         'selected' => $values [$this->get_status_select_name()] ,
						 );
        $statues = $this->get_select_by_key( $this->get_available_status('Status') , $default ,  $disable);
        return $this->get_group_alamat('Status' , $statues);
    }
    /**
     *  return tempat lahir select 
    **/
    protected function get_tempat_lahir_select( $values = array() , $disable = ""){
        $default = array( "class" => "selectpicker col-md-12 form-control" , "id" => "" ,
                         "name" => $this->get_tempat_lahir_name() ,
                         "id"   => $this->get_tempat_lahir_name() ,
                         'selected' => $values [$this->get_tempat_lahir_name()]
						 );
        
        $items = array();
        $kabupaten = new Kabupaten_Model();
        $results = $kabupaten->orderBy('nama')->get();
        foreach($results as $result){
            $items [] = $result->nama;
        }
        $kabupaten_select = $this->get_select($items , $default , $disable);
        $names = sprintf ('
            <div class="form-group">                
                <div class="row">
                    <label class="col-xs-2 control-label">  Tempat Lahir </label>
                    <div class="col-xs-6">
                        %1$s
                    </div>
              </div>
            </div>
          ' ,
            $kabupaten_select
          );
        return $names;
    }
    
    /**
     *  return email input
    **/
    protected function get_date_input( $values = array() , $disable = ""){
        $names = sprintf ('
            <div class="form-group">
                <label> Tanggal Lahir </label>
                <div class="row">
                    <div class="col-xs-4">
                        <input type="number" class="form-control" id="%1$s"  placeholder="Day"  name="%1$s" %7$s value="%2$s" >
                    </div>
                    <div class="col-xs-4">
                        <input type="number" class="form-control" id="%3$s"  placeholder="Month" name="%3$s" %7$s value="%4$s" >
                    </div>
                    <div class="col-xs-4">
                        <input type="number" class="form-control" id="%5$s"  placeholder="Year" name="%5$s" %7$s value="%6$s" >
                    </div>

              </div>
            </div>
          ' , $this->get_day_name() ,   $values [$this->get_day_name()] ,
          $this->get_mnt_name()     ,   $values [$this->get_mnt_name()] ,
          $this->get_year_name()    ,   $values [$this->get_year_name()] ,
          $disable
          );
        return $names;
    }
    /**
     *  return email input
    **/
    protected function get_email_input( $values =array () , $disable = ""){
        $names = sprintf ('
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="input-group">
                            <div class="input-group-addon">@</div>
                            <input type="email" class="form-control" id="%1$s" placeholder="Email" name="%1$s" %3$s value="%2$s" >
                        </div>
                    </div>
              </div>
            </div>
          ' , $this->get_email_name() , $values [$this->get_email_name()] , $disable );
        return $names;
    }
    /**
     *  return input first and second name html
    **/
    protected function get_names_input( $values = array(), $disable = ""){
        $names = sprintf ('
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-6">
                        <input type="text" class="form-control" id="%1$s" placeholder="First Name" name="%1$s" %3$s value="%4$s" >
                    </div>
                    <div class="col-xs-6">
                        <input type="text" class="form-control" id="%2$s" placeholder="Second Name" name="%2$s" %3$s value="%5$s">
                    </div>
                </div>
            </div>
          ' , $this->get_first_name_name() , $this->get_second_name_name() , $disable ,
          $values [$this->get_first_name_name()]  , $values [$this->get_second_name_name()] );
        return $names;
    }
    
    /**
     *  return input first and second name html
    **/
    protected function get_passwords_input( $values = array() , $disable = ""){
        $names = sprintf ('
            <div class="form-group">
                <label> Password</label>
                <div class="row">
                    <div class="col-xs-6">
                        <input type="password" class="form-control" id="%1$s"  name="%1$s" %3$s value="%4$s" >
                    </div>
                    <div class="col-xs-6">
                        <input type="password" class="form-control" id="%2$s" name="%2$s" %3$s value="%5$s">
                    </div>
                </div>
            </div>
          ' , $this->get_password_name() , $this->get_password_over_name() , $disable ,
          $values [$this->get_password_name()]  , $values [$this->get_password_over_name()]);
        return $names;
    }
    /**
     *  return gender input
    */
    protected function get_gender_input($values , $disable = ""){
        $checked = array( '' , '' );
        if( $values [$this->get_gender_name()] == "L" ){
            $checked [0] = 'checked';
        }
        else{
            $checked [1] = 'checked';
        }
        $gender = sprintf('
            <div class="form-group">
                <div class="row">
                    <label for="exampleInputEmail1" class="col-xs-2" >Gender</label>
                    <label class="radio-inline">
                        <input type="radio" name="%1$s" id="%1$s" value="L" %2$s >Pria
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="%1$s" id="%1$s" value="W" %3$s >Wanita
                    </label>
                </div>
            </div>
            ' ,$this->get_gender_name() ,
            $checked [0] ,
            $checked [1]
            );
        return $gender;
    }    
    /**
     *  @override
     *  js for button to executed check box
     *  return none
    */
    protected function set_special_js(){
        //parent::set_special_js();
		$propinsi = sprintf('
				$( "#%1$s"  ).change(function () {
                    $("#%2$s").val("1");
					$("#%3$s").submit();
				});',
                $this->get_propinsi_name(),
                $this->get_signal_name(),
                $this->get_table_form_name()
		);
		$kabupaten = sprintf('
				$( "#%1$s"  ).change(function () {
                    $("#%2$s").val("1");
					$("#%3$s").submit();
				});',
                $this->get_kabupaten_name(),
                $this->get_signal_name(),
                $this->get_table_form_name()
		);
		$kecamatan = sprintf('
				$( "#%1$s"  ).change(function () {
                    $("#%2$s").val("1");
					$("#%3$s").submit();
				});',
                $this->get_kecamatan_name(),
                $this->get_signal_name(),
                $this->get_table_form_name()
		);
        
		$js = sprintf('
		<script type="text/javascript">
			$(function() {
                %1$s  %2$s %3$s
			});
		</script>' ,
            $propinsi ,
            $kabupaten,
            $kecamatan
		);
        $this->set_js( $js);

    }
    /**
     *  return index
    */
    protected function on_changing_select($values , $title = "Add"){        
        $heading    = $title;
        $body       = $this->get_form_cud( $values[$this->get_store_url_name()] , $values);        
        $this->set_content( $this->get_panel($heading , $body , '') );
        return $this->index();
    }
    /**
      *  form which is used by adding , editing and deleting
      *  return   form 
    **/
    protected function get_form_cud( $go_where  , $values = array()  ,$disabled = "" , $method = 'post'){
        $this->use_select();
        $array = $this->set_values_to_inputs();
        $values = $this->make_one_two_array($array , $values);

   		$hasil  = Form::open(array('url' => $go_where, 'method' => $method , 'role' => 'form' , 'id' => $this->get_table_form_name() )) ;
        
        $hasil .= '<div class="row"><div class="thumbnail col-md-7">';
            $hasil .= $this->get_names_input($values , $disabled). $this->get_email_input($values, $disabled).
            $this->get_passwords_input($values, $disabled).$this->get_date_input($values, $disabled).
            $this->get_tempat_lahir_select($values, $disabled) .
            $this->get_gender_input( $values, $disabled);
        $hasil .="</div>";
        
        $hasil .= '<div class="thumbnail col-md-4 col-md-offset-1">';
            $hasil .= $this->get_status_select($values, $disabled) . $this->get_group_select($values, $disabled).
            $this->get_propinsi_select($values, $disabled). $this->get_kabupaten_select($values, $disabled) . $this->get_kecamatan_select($values , $disabled).
            $this->get_desa_select($values , $disabled);
        $hasil .="</div></div>";
        
        $hasil .= Form::hidden($this->get_signal_name()    , 0 , array('id' => $this->get_signal_name() ) );
        $hasil .= Form::hidden($this->get_store_url_name() , $go_where );
        $hasil .= Form::hidden('id' , $values ['id']  );
		$hasil .= '<hr><div class="form-group"><div class="col-sm-offset-10 col-lg-2">';
		$hasil .= Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-lg' ) );
		$hasil .= '</div></div>';
        $hasil .= Form::close();
        return $hasil;
    }
    /**
     *  return array
    */
    protected function get_all_name_input(){
        $array = array(
            'id'                            =>  ''  ,
            $this->get_first_name_name()    =>  ''  ,
            $this->get_second_name_name()   =>  ''  ,
            $this->get_tempat_lahir_name()  =>  ''  ,
            $this->get_password_name()      =>  ''  ,
            $this->get_password_over_name() =>  ''  ,
            $this->get_email_name()         =>  ''  ,
            $this->get_day_name()           =>  ''  ,
            $this->get_mnt_name()           =>  ''  ,
            $this->get_year_name()          =>  ''  ,
            $this->get_status_select_name() =>  ''  ,
            $this->get_group_name()         =>  ''  ,
            $this->get_propinsi_name()      =>  ''  ,
            $this->get_kabupaten_name()     =>  ''  ,
            $this->get_kecamatan_name()     =>  ''  ,
            $this->get_desa_name()          =>  ''  ,
            $this->get_gender_name()  =>  ''  ,
            $this->get_store_url_name()     =>  ''
        );
        return $array;
    }
   /**
     *  return array 
     *  useful for edit and delele view
     *  it related with changing select and edit
    */
    protected function set_values_to_inputs($model = 'empty'){
        $array = $this->get_all_name_input();
        if($model == 'selected'):
            $items = Input::all();
            foreach( $array as $key => $val){
                $array [$key] = Input::get($key);
            }
        elseif( is_object($model)):
            $phpdate = strtotime( $model->lahir );
            $array [$this->get_first_name_name()] = $model->first_name;
            $array [$this->get_second_name_name()] = $model->second_name;
            $array [$this->get_email_name()]        = $model->email;
            $array [$this->get_day_name()]          = Date('d' , $phpdate);
            $array [$this->get_mnt_name()]          = Date('m' , $phpdate);
            $array [$this->get_year_name()]          = Date('Y' , $phpdate);
            $array [$this->get_tempat_lahir_name()]  = $model->tempat->nama;
            $array [$this->get_gender_name()]        = $model->jenis;
            $array [$this->get_status_select_name()] = $model->status;
            $array [$this->get_group_name()]        = $model->admindgroup->nama;
            $array [$this->get_propinsi_name()]       = $model->desa->kecamatan->kabupaten->propinsi->nama;
            $array [$this->get_kabupaten_name()]       = $model->desa->kecamatan->kabupaten->nama ;
            $array [$this->get_kecamatan_name()]       = $model->desa->kecamatan->nama ;
            $array [$this->get_desa_name()]       = $model->desa->nama;
            //echo $this->get_status($model->status);
        endif;
        return $array;
	}
    /**
     *  set and get rules for input
     *  return array
    */
    protected function setting_and_get_rules(){
        $array = $this->get_all_name_input();
        foreach($array as $key => $val):
            $array [$key] = 'required'; 
        endforeach;
        $array [$this->get_day_name()]  = 'required|numeric';
        $array [$this->get_mnt_name()]  = 'required|numeric';
        $array [$this->get_year_name()] = 'required|numeric';
        $array ['id']                   = ''; 
        return $array;
    }
}


/**
 *  main class of this file
*/
class Admin_sarung_user_cud extends Admin_sarung_user_cud_input {
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
        //parent::set_default_value();
        $this->set_view('sarung/admin/index');
        $this->set_min_power( 1000 );
		$this->set_title('User register');
		$this->set_body_attribute( " class='admin admin_sarung_body' " );
        $this->set_table_name('admind');        
        //! input
        $this->set_first_name_name('first_name');
        $this->set_second_name_name('second_name');
        $this->set_email_name('email_name');
        $this->set_password_name('password_one');
        $this->set_password_over_name('password_two');
        $this->set_day_name('day');
        $this->set_mnt_name('mnt');
        $this->set_year_name('year');
        $this->set_tempat_lahir_name('tempat_lahir');
        $this->set_group_name('group_name');
        $this->set_signal_name('signal_name');
        $this->set_gender_name('ahmad_sakip');
        $this->set_status_select_name('status_select');
        
        $this->set_propinsi_name('propinsi');
        $this->set_kabupaten_name('kabupaten');
        $this->set_kecamatan_name('kecamatan');
        $this->set_desa_name('desa');
        
        $this->set_store_url_name('store_url');
        //! input rules
   		$rules = $this->setting_and_get_rules();        
        //! it should be on last 
        $this->set_inputs_rules($rules);
        $this->set_special_js();
    }
    /**
	 *	@override
      *  sequence : @get_rules() , @Sarung_db_about()
      *  return  getEventedit()
    **/
    public function postEventedit(){
		$chose = $this->get_value( $this->get_signal_name() );
		if($chose == 1 ){
    		$values = $this->set_values_to_inputs( 'selected' );
			return $this->on_changing_select($values);
		}
        else{
            return parent::postEventedit();
        }
    }
    /**
	 *	@override
     *  After_Submit , We overrid because we have select which will change according to other result
     *  return on_changing_select or postEventadd
    */
	public function postEventadd(){
        $data = Input::all();
		$chose = $this->get_value( $this->get_signal_name() );
		if($chose == 1 ){
    		$values = $this->set_values_to_inputs( 'selected' );
			return $this->on_changing_select($values);
		}
        /*Cek if password doest match*/
        if( $this->get_value( $this->get_password_name()) == $this->get_value($this->get_password_over_name()) ){
    		return parent::postEventadd();            
        }
        else{
            $message = "<label class='label label-danger'>Password doesnt same</label";
            return parent::getEventadd($message);
        }
	}
    /**
     * @ovverride
     * return object
    **/
    protected function Sarung_db_about($data , $edit = false , $values = array()){
        $event = $this->get_model_obj();
        if( !$edit ){
            $event->id = $data ['id'] ;
        }
        else{
            $event = $event->find( $data ['id'] );
        }
        $desa = new Desa_Model() ;
        $kab = new Kabupaten_Model();
        $kab = $kab->get_first(
                                 'Indonesia' ,
                                 $data [$this->get_propinsi_name()]     ,
                                 $data [$this->get_kabupaten_name()]            
                               );
        
        $event->idgroup         =   AdmindGroup::get_first( $data [$this->get_group_name()] )->id;
        $event->idtempat        = $kab->id;
        $desa = $desa->get_first(
                                 'Indonesia' ,
                                 $data [$this->get_propinsi_name()]     ,
                                 $data [$this->get_kabupaten_name()]    ,
                                 $data [$this->get_kecamatan_name()]    ,
                                 $data [$this->get_desa_name()]
                                 );        
        $event->iddesa          = $desa->id;
        $event->lahir           = sprintf('%1$s-%2$s-%3$s',
                                    $data [$this->get_year_name()],
                                    $data [$this->get_mnt_name()],
                                    $data [$this->get_day_name()]);
       	$event->first_name      = $data [ $this->get_first_name_name() ]		;
   		$event->second_name     = $data [ $this->get_second_name_name() ]	;
        $event->jenis           =   $data [$this->get_gender_name()] ;
        $event->email           =   $data [$this->get_email_name()];
        $event->status          =   $this->get_status( $data [$this->get_status_select_name()] , 1);
        $event->password        =   Hash::make($data [$this->get_password_over_name()]);
        return $event;
    }
}
