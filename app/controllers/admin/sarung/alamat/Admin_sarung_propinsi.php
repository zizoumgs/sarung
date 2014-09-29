<?php
/**
 *  order of Subclass  
 *  root->Admin_root->Admin_sarung->Admin_sarung_event->Admin_sarung_negara->this 
**/
class Admin_sarung_propinsi extends Admin_sarung_negara{
    private $var ; 
    public function __construct(){
        parent::__construct();
    }
	/**
	 *	return select html for kelas
	 */
	protected function get_negara_select($selected = ''){
		$session = new Negara_Model();
		$sessions = $session->orderBy('updated_at' , 'DESC')->get();
		$items = array( "All" => "All" );
		foreach($sessions as $val){
			$items [$val->id] = $val->nama;
		}
        $default = array( "class" => "selectpicker col-md-12" , "id" => "" , "name" => $this->get_negara_select_name() , 'selected' => $selected ,
                        'id' => $this->get_negara_select_name()
						  );
		return $this->get_select($items , $default);
	}
    protected function set_negara_select_name($var){ $this->var ['negara_selected']  = $var; }
    protected function get_negara_select_name(){ return $this->var ['negara_selected'] ;}
    protected function get_negara_select_selected() {return $this->get_value( $this->get_negara_select_name() ) ;}
    
    protected function set_propinsi_name($var){ $this->var ['propinsi']  = $var; }
    protected function get_propinsi_name(){ return $this->var ['propinsi'] ;}
    protected function get_propinsi_selected() {return $this->get_value( $this->get_propinsi_name() ) ;}
    /**
     *  automatic called by getEventdel() , getEventedit() , getEventa
     *  return  html div
    **/
    protected function get_form_cud( $go_where  , $values = array()  ,$disabled = "" , $method = 'post'){
        $this->use_select();
        $array = array(
					   $this->get_negara_name() 		=> '' ,
                       $this->get_propinsi_name() 		=> '' ,
                       $this->get_negara_select_name()  => ''
					);        
        $array = $this->make_one_two_array($array , $values);
   		$hasil  = Form::open(array('url' => $go_where, 'method' => $method , 'role' => 'form' ,'class' => 'form-horizontal')) ;
        $hasil .= $this->get_input_cud_group( 'Negara'   , $this->get_negara_select( $array [ $this->get_negara_select_name() ] ) ) ;
        $hasil .= $this->get_text_cud_group( 'Propinsi' , $array [ $this->get_propinsi_name()] , $this->get_propinsi_name()  , $disabled) ;
        
   		$hasil .= Form::hidden('id', $this->get_id() );
		$hasil .= '<div class="form-group"><div class="col-sm-offset-2 col-sm-10">';
		$hasil .= Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) );
		$hasil .= '</div></div>';
        $hasil .= Form::close();
        return $hasil;		
    }
    /**
     *  this is default view for this table
     *  return html table
    */
    public function getIndex(){
        $find_name = $this->get_name_for_text_selected();
        $href = sprintf('<a href="%1$s" class="btn btn-primary btn-xs" >Add</a>' , $this->get_url_this_add() );
        $this->set_text_on_top('Propinsi Table  '.$href);
        $row = "";
        $form = $this->get_form_filter( $this->get_url_this_view() );
        $events = $this->get_model_obj();
        $wheres = array();
        if( $find_name != ""){
            $wheres [] = array( $this->get_name_for_text() => $find_name );
            $events = $events->where('nama' , 'LIKE' , "%".$find_name."%");
        }
        $events = $events->orderBy('updated_at' , 'DESC')->paginate(15);
        foreach($events as $event){
            $row .= "<tr>";
                $row .= sprintf('<td>%1$s</td>' , $event->id);
                $row .= sprintf('<td>%1$s</td>' , $this->get_edit_delete_row( $event->id ));
                $row .= sprintf('<td>%1$s</td>' , $event->negara->nama);
                $row .= sprintf('<td>%1$s</td>' , $event->nama);
                $row .= sprintf('<td>%1$s</td>' , $event->updated_at);
                $row .= sprintf('<td>%1$s</td>' , $event->created_at);
            $row .= "</tr>";
        }
		$hasil = sprintf(
			'
			<h1 class="title">%1$s</h1>
			%2$s
            <div class="table_div">
    			<table class="table table-striped table-hover" >
    				<tr class ="header">
    					<th>Id</th>
                        <th>Edit/Delete</th>
                        <th>Negara</th>
    					<th>Propinsi</th>
    					<th>Updated_at</th>
    					<th>Created_at</th>
    				</tr>
    				%3$s				
    			</table>
            </div>%4$s',
			 	$this->get_text_on_top() ,
   				$form               ,
                $row                ,
			 	$this->get_pagination_link($events , $wheres) 
			);
        $this->set_content($hasil);
        return $this->index();        
    }
    /**
     *  return array 
     *  useful for edit and delele view
    */
    protected function set_values_to_inputs($model){
            return array(	$this->get_negara_select_name() =>  $model->negara->nama  ,
                            $this->get_propinsi_name()      =>  $model->nama
						 );
	}
     /**
     *  This is must be function you should make if you make subclass from this class 
     *  return  none
    **/
    protected function set_default_value(){
        $this->set_view('sarung/admin/index');
        $this->set_min_power( 10 );
		$this->set_title('Propinsi');
		$this->set_body_attribute( " class='admin admin_sarung_body' " );
        $this->set_name_for_text('Propinsi');
        $this->set_negara_select_name('negara_name');
        $this->set_propinsi_name('propinsi_name');
        $this->set_table_name('propinsi');
         //! for url
        $this->set_url_this_dele($this->get_url_admin_sarung()."/propinsi/eventdel" );
        $this->set_url_this_edit($this->get_url_admin_sarung()."/propinsi/eventedit");
        $this->set_url_this_add ($this->get_url_admin_sarung()."/propinsi/eventadd" );
        $this->set_url_this_view($this->get_url_admin_sarung()."/propinsi");

        $this->set_model_obj(new Propinsi_Model() );
        
        $this->set_inputs_rules( array( $this->get_propinsi_name() => 'required' ));
    }
   /**
     * you should override  this .
     * will be called just before insert , edit
    **/
    protected function Sarung_db_about($data , $edit = false){
        $event = $this->get_model_obj();
        if( !$edit ){
            $event->id = $data ['id'] ;
        }
        else{
            $event = $event->find( $data ['id'] );
        }
        $selected_negara = $data [ $this->get_negara_select_name() ] ;
        $negara         =   new Negara_Model();
        $negara_id      =   $negara->get_id( $selected_negara );
       	$event->nama       = $data [ $this->get_propinsi_name() ]		;
        $event->idnegara   = $negara_id->id;
        return $event;        
    }	
}