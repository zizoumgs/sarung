<?php
/**
 *  order of Subclass  
 *  root->Admin_root->Admin_sarung->Admin_sarung_event->Admin_sarung_negara->Admin_sarung_propinsi->Admin_sarung_kabupaten->Admin_sarung_kecamatan->this 
**/
class Admin_sarung_desa extends Admin_sarung_kecamatan{
    private $var; 
    public function __construct(){
        parent::__construct();
    }
	/**
	 *	return select html for kelas
	 */
	protected function get_kecamatan_select($selected = ''){
		$session = new Kecamatan_Model();
        $choosen_negara = $this->get_negara_select_selected();
		$choosen_propinsi = $this->get_propinsi_select_selected();
        $choosen_kabupaten = $this->get_kabupaten_select_selected();
        if(     $choosen_propinsi != "" && $choosen_propinsi != "All" && $choosen_negara != "" && $choosen_negara != "All"
                && $choosen_kabupaten != "" && $choosen_kabupaten != "All"
           ){
            $session = $session->get_kecamatans_of_kabupaten($choosen_negara , $choosen_propinsi , $choosen_kabupaten);
			
        }
		$sessions = $session->orderBy('updated_at' , 'DESC')->get();
		$items = array( "All" => "All" );
		foreach($sessions as $val){
			$items [$val->id] = $val->nama;
		}
        $default = array( "class" => "selectpicker col-md-12" , "id" => "" , "name" => $this->get_kecamatan_select_name() , 'selected' => $selected , );
		return $this->get_select($items , $default);
	}
    protected function set_kecamatan_select_name($var){ $this->var ['kecamatan_selected']  = $var; }
    protected function get_kecamatan_select_name(){ return $this->var ['kecamatan_selected'] ;}
    protected function get_kecamatan_select_selected() {return $this->get_value( $this->get_kecamatan_select_name() ) ;}
    
    protected function set_desa_name($var){ $this->var ['desa']  = $var; }
    protected function get_desa_name(){ return $this->var ['desa'] ;}
    protected function get_desa_selected() {return $this->get_value( $this->get_desa_name()) ;}
    /**
     *  automatic called by getEventdel() , getEventedit() , getEventa
     *  return  html div
    **/
    protected function get_form_cud( $go_where  , $values = array()  ,$disabled = "" , $method = 'post'){
        $this->use_select();
        $array = $this->set_values_to_inputs();
        $array = $this->make_one_two_array($array , $values);
   		$hasil  = Form::open(array('url' => $go_where, 'method' => $method , 'role' => 'form' ,'class' => 'form-horizontal')) ;
        $hasil .= $this->get_input_cud_group( 'Negara'     , $this->get_negara_select  ( $array [ $this->get_negara_select_name()   ] ) ) ;
        $hasil .= $this->get_input_cud_group( 'Propinsi'   , $this->get_propinsi_select( $array [ $this->get_propinsi_select_name() ] ) ) ;
        $hasil .= $this->get_input_cud_group( 'Kabupaten'   , $this->get_kabupaten_select( $array [ $this->get_kabupaten_select_name() ] ) ) ;
        $hasil .= $this->get_input_cud_group( 'Kecamatan'   , $this->get_kecamatan_select( $array [ $this->get_kecamatan_select_name() ] ) ) ;
        $hasil .= $this->get_text_cud_group(  'Desa'  , $array [ $this->get_desa_name()] , $this->get_desa_name()  , $disabled) ;
        
   		$hasil .= Form::hidden('id', $this->get_id() );
        $hasil .= Form::hidden($this->get_signal_name(), 0  , array('id' => $this->get_signal_name() ) );
        $hasil .= Form::hidden($this->get_redirect_name(), $go_where);
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
        $this->set_text_on_top('Desa Table  '.$href);
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
                $row .= sprintf('<td  style="font-size:0.7em;">%1$s</td>' , $event->id);
                $row .= sprintf('<td>%1$s</td>' , $this->get_edit_delete_row( $event->id ));
                $row .= sprintf('<td style="font-size:0.7em;">%1$s</td>' , $event->kecamatan->kabupaten->propinsi->negara->nama);
                $row .= sprintf('<td style="font-size:0.7em;">%1$s</td>' , $event->kecamatan->kabupaten->propinsi->nama);
                $row .= sprintf('<td style="font-size:0.8em;">%1$s</td>' , $event->kecamatan->kabupaten->nama);
				$row .= sprintf('<td style="font-size:0.8em;">%1$s</td>' , $event->kecamatan->nama);
                $row .= sprintf('<td style="font-size:0.8em;">%1$s</td>' , $event->nama);
                $row .= sprintf('<td style="font-size:0.7em;">%1$s</td>' , $event->updated_at);
                $row .= sprintf('<td style="font-size:0.7em;">%1$s</td>' , $event->created_at);
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
                        <th>Kabupaten</th>
						<th>Kecamatan</th>
                        <th>Desa</th>
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
	 *	Set js 
	*/
	private function set_js_to_submit(){
        $this->set_signal_name('signal_name_kk');
		$js = sprintf('
		<script type="text/javascript">
			$(function() {
				$( "#%1$s"  ).change(function () {
					$("#%2$s").val("1");
					$("form").submit();
				});
				$( "#%3$s"  ).change(function () {
					$("#%2$s").val("1");
					$("form").submit();
				});
				$( "#%4$s"  ).change(function () {
					$("#%2$s").val("1");
					$("form").submit();
				});
			});
		</script>' ,
        $this->get_negara_select_name(),
		$this->get_signal_name() ,
		$this->get_propinsi_select_name() ,
        $this->get_kabupaten_select_name()
		);
		$this->set_js( $js );
	}
    /**
     *  return array 
     *  useful for edit and delele view
    */
    protected function set_values_to_inputs($model = 'empty'){
        if($model == 'empty' ):
            return  array(
                $this->get_negara_select_name()       => '' ,
                $this->get_propinsi_select_name()     => "" ,
				$this->get_kabupaten_select_name()    => "" ,
  				$this->get_kecamatan_select_name()				=> "" , 
				$this->get_desa_name()				=> ""
            );
        elseif($model == 'selected'):
    		return array(
                            $this->get_negara_select_name()     => Input::get( $this->get_negara_select_name()) 		,
                            $this->get_propinsi_select_name()   => $this->get_propinsi_select_selected() 	,
							$this->get_kabupaten_select_name()   => $this->get_kabupaten_select_selected() 	,
                            $this->get_kecamatan_select_name()   => $this->get_kecamatan_select_selected() 	,
                            $this->get_desa_name()   => $this->get_desa_selected() 		,
						);       
        endif;
            return array(	$this->get_negara_select_name() 		=>  $model->kecamatan->kabupaten->propinsi->negara->nama  ,
                            $this->get_propinsi_select_name()      	=>  $model->kecamatan->kabupaten->propinsi->nama   ,
							$this->get_kabupaten_select_name()      =>  $model->kecamatan->kabupaten->nama   ,
                            $this->get_kecamatan_select_name()      =>  $model->kecamatan->nama   ,
                            $this->get_desa_name()     		=>  $model->nama                    ,
						 );
	}
     /**
     *  This is must be function you should make if you make subclass from this class 
     *  return  none
    **/
    protected function set_default_value(){
        $this->set_view('sarung/admin/index');
        $this->set_min_power( 10 );
		$this->set_title('Desa');
		$this->set_body_attribute( " class='admin admin_sarung_body' " );
        $this->set_name_for_text('Desa');
        $this->set_table_name('desa');

        $this->set_negara_select_name('negara_name');
        $this->set_propinsi_select_name('propinsi_name');
        $this->set_kabupaten_select_name('kabupaten_name');
        $this->set_kecamatan_select_name('kecamatan_name');
		//$this->set_kabupaten_name('kabupaten_beh');
		$this->set_desa_name('desa');
        
         //! for url
        $this->set_url_this_dele($this->get_url_admin_sarung()."/desa/eventdel" );
        $this->set_url_this_edit($this->get_url_admin_sarung()."/desa/eventedit");
        $this->set_url_this_add ($this->get_url_admin_sarung()."/desa/eventadd" );
        $this->set_url_this_view($this->get_url_admin_sarung()."/desa");

        $this->set_model_obj(new Desa_Model() );
        
        $this->set_inputs_rules( array( $this->get_desa_name() => 'required' ));
        //! special
        $this->set_js_to_submit();
        $this->set_redirect_name('redirect_name');
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
        $selected_negara        = $data [ $this->get_negara_select_name() ] ;
        $selected_propinsi      = $data [ $this->get_propinsi_select_name() ] ;
		$selected_kabupaten     = $data [ $this->get_kabupaten_select_name() ] ;
        $selected_kecamatan     = $data [ $this->get_kecamatan_select_name() ] ;
        $obj                   	=   new Kecamatan_Model();
        $obj		            =   $obj->get_id( $selected_negara  , $selected_propinsi , $selected_kabupaten , $selected_kecamatan);
       	$event->nama            = $data [ $this->get_desa_name() ]		;
        $event->idkecamatan     = $obj->id;
        return $event;        
    }
}