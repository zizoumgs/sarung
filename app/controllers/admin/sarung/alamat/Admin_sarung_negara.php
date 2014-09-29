<?php
/**
 *  order of Subclass  
 *  root->Admin_root->Admin_sarung->Admin_sarung_event->this 
**/
class Admin_sarung_negara extends Admin_sarung_event{
    private $var ;
    public function __construct(){
        parent::__construct();
    }
    protected function set_negara_name($var){ $this->var ['negara']  = $var; }
    protected function get_negara_name(){ return $this->var ['negara'] ;}
    protected function get_negara_selected() {return $this->get_value( $this->var ['negara'] ) ;}
    /**
     *  automatic called by getEventdel() , getEventedit() , getEventa
     *  return  html div
    **/
    protected function get_form_cud( $go_where  , $values = array()  ,$disabled = "" , $method = 'post'){
        $array = array(
					   $this->get_negara_name() 		=> '' ,
					);
        $array = $this->make_one_two_array($array , $values);
        $params = array('label' , 'value');
   		$hasil  = Form::open(array('url' => $go_where, 'method' => $method , 'role' => 'form' ,'class' => 'form-horizontal')) ;
        $hasil .= $this->get_text_cud_group( 'Negara'  , $array [ $this->get_negara_name()]   , $this->get_negara_name()   , $disabled) ;
   		$hasil .= Form::hidden('id', $this->get_id() );
		$hasil .= '<div class="form-group"><div class="col-sm-offset-2 col-sm-10">';
		$hasil .= Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) );
		$hasil .= '</div></div>';
        $hasil .= Form::close();
        return $hasil;		
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
       	$event->nama       = $data [ $this->get_negara_name() ]		;
        return $event;        
    }	
    /**
     *  this is default view for this table
     *  return html table
    */
    public function getIndex(){
        $find_name = $this->get_name_for_text_selected();
        $href = sprintf('<a href="%1$s" class="btn btn-primary btn-xs" >Add</a>' , $this->get_url_this_add() );
        $this->set_text_on_top('Negara Table  '.$href);
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
    					<th>Name</th>
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
            return array(	$this->get_negara_name() =>  $model->nama  ,
						 );
	}
     /**
     *  This is must function you should make if you make subclass from this class 
     *  return  none
    **/
    protected function set_default_value(){
        $this->set_view('sarung/admin/index');
        $this->set_min_power( 10 );
		$this->set_title('Negara');
		$this->set_body_attribute( " class='admin admin_sarung_body' " );
        $this->set_name_for_text('Negara');
        $this->set_negara_name('negara_name');
        $this->set_table_name('negara');
        //! for url
        $this->set_url_this_dele($this->get_url_admin_sarung()."/negara/eventdel" );
        $this->set_url_this_edit($this->get_url_admin_sarung()."/negara/eventedit");
        $this->set_url_this_add ($this->get_url_admin_sarung()."/negara/eventadd" );
        $this->set_url_this_view($this->get_url_admin_sarung()."/negara");

        $this->set_model_obj(new Negara_Model() );
		$this->set_inputs_rules( array( $this->get_negara_name() => 'required') );
    }
}