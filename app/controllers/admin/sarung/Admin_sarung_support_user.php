<?php
/**
 *	Specific needed for user/admind and santri
 *	parent admin_sarung_support
 *	childs are Admind_sarung_santri and Admind_sarung_user
*/
abstract class Admin_sarung_support_user extends Admin_sarung_support{
	protected function set_default_value(){
		parent::set_default_value();
        //! special
        $this->set_foto_folder($this->base_url()."/foto");
		$this->set_status_select_name('sta_fil');
        $this->set_name_filter_name('nam_fil');		
	}
	/**
     *  function usualy used for filtering result
     *  return only input html
    */
    protected function get_form_group($input , $name_label){
		return sprintf('<div class="form-group ">
        					   %1$s
					   </div>' , $input , $name_label);
	}
    /**
     *  return  html div which containt label and input
    **/
    protected function get_input_cud_group( $label , $input ){
        return sprintf('
        <div class="form-group form-group-sm">
            <label class="col-sm-2 control-label" >%1$s</label>
            <div class="col-sm-3">
                %2$s
            </div>
        </div>' , $label , $input);
    }
    /**
      *  return html which was used as place of add , edit , delete form
    **/
    protected function get_panel( $heading , $body , $footer=""){
        return sprintf('
            <div class="panel panel-primary">
                <div class="panel-heading">%1$s</div>
                <div class="panel-body">%2$s</div>
                <div class="panel-footer">%3$s</div>
            </div>', $heading , $body , $footer);
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
    protected function get_user_data($model , $col_array = array( "col-md-2" , "col-md-10 x-small-font" )){
		$file = sprintf('%1$s/%2$s/%3$s',$this->get_foto_folder() , $model->id, $model->foto);
        $foto  = sprintf('<img src="%1$s" class="small-img thumbnail">', $this->get_and_check_file($file) );
        //$foto  = sprintf('<img src="%1$s/%2$s/%3$s" class="small-img thumbnail">',$this->get_foto_folder() , $model->id, $model->foto );
        $jenis = sprintf('<span>%1$s</span>', $model->jenis);
        $email  = sprintf('<span><span class="glyphicon glyphicon-envelope"></span> Email: %1$s</span><br>', $model->email);
        $ttl    = sprintf('<span><span class="glyphicon glyphicon-info-sign"></span> TTL: %1$s %2$s</span>', $model->tempat->nama , $model->lahir);
        $alamat = sprintf('<span><span class="glyphicon glyphicon-map-marker"></span> Alamat:%1$s %2$s %3$s</span><br>' ,
                          $model->desa->kecamatan->kabupaten->nama ,
                          $model->desa->kecamatan->nama ,
                          $model->desa->nama);
        $nama = sprintf('<span><span class="glyphicon glyphicon-user"></span> Nama: %1$s %2$s</span><br>' , $model->first_name , $model->second_name);
        $nama = sprintf('<div class="row">
                        <div class="%6$s">%1$s</div>
                        <div class="%7$s">%2$s %3$s %4$s %5$s</div>
                        </div>' , $foto  , $nama, $email, $alamat , $ttl  ,
						$col_array [0] , $col_array[1]);
        return $nama;
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
     * this will filter admind which will be seen , admind with lower/same power can`t see higher power
     * Return obj
    */
    protected function set_filter_by_user($model_obj){
        return $model_obj->getlesserPowerid($this->get_user_power());
    }
    /**
     * this will filter view by name
     * Return obj
    */
    protected function set_filter_by_name($model_obj , & $wheres ){
		//@ remove end space
		$find = rtrim( $this->get_name_filter_selected()  );
		//@ remove first space
		$selected = ltrim($find);
        if( $selected != ""){
            $wheres [$this->get_name_filter_name()] = $selected;
            return $model_obj->whereRaw(" (first_name LIKE ? or second_name LIKE ? ) " ,
                                        array( "%".$selected."%" ,
                                              "%".$selected."%" )
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
    /**
     *  return  html text on top of ...
    **/
    protected function set_text_on_top($value){ $this->values ['text_on_top'] = $value; }
    /**
     *  return  none
    **/
    protected function get_text_on_top(){ return $this->values ['text_on_top']; }
    /* Below is name of select which contains status to filter*/
    protected function set_status_select_name($val){ $this->input ['status_select'] = $val ; }
    protected function get_status_select_name(){ return $this->input ['status_select'] ;}
    protected function get_status_select_selected(){ return $this->get_value( $this->get_status_select_name() ); }
    /* Below is name of filter input which will filter output by its name */
    protected function set_name_filter_name($val){ $this->input ['filter_name'] = $val ; }
    protected function get_name_filter_name(){ return $this->input ['filter_name'] ;}
    protected function get_name_filter_selected(){ return $this->get_value( $this->get_name_filter_name() ); }
}
