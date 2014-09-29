<?php
/**
 *  Class wali will handle everything about wali 
*/
class Admin_sarung_wali extends Admin_sarung_session{
    public function __construct(){
        parent::__construct();
    }
    /**
     *  priority 1 
     *  return none
     *  set up everything
    **/
    protected function set_default_value(){
        $this->set_view('sarung/admin/index');
        $this->set_min_power( 1000 );
		$this->set_title('Wali');
		$this->set_body_attribute( " class='admin admin_sarung_body' " );
        $this->set_name_for_text('wali_filter');
        $this->set_table_name('wali');
    }
    /**
     *  priority 1 
     *  Default view for this class
     *  return @index()
    */
    public function getIndex(){
        $find_name = $this->get_name_for_text_selected();
        $href = sprintf('<a href="%1$s" class="btn btn-primary btn-xs" >Add</a>' , $this->get_url_this_add() );        
        $this->set_text_on_top('Wali Table  '.$href);
        $row = "";
        $form = $this->get_form_filter( $this->get_url_this_view() );
        $session = new Session_Model();
        $wheres = array();
        if( $find_name != ""){
            $wheres [] = array( $this->get_name_for_text() => $find_name );
            $session = $session->where('nama' , 'LIKE' , "%".$find_name."%");
        }
        $sessions = $session->orderBy('updated_at','DESC')->paginate(15);
        foreach($sessions as $event){
            $row .= "<tr>";
                $row .= sprintf('<td>%1$s</td>' , $event->id);
                $row .= sprintf('<td>%1$s</td>' , $this->get_edit_delete_row( $event->id ));
                $row .= sprintf('<td>%1$s</td>' , $event->nama);
                $row .= sprintf('<td>%1$s</td>' , $event->awal);
                $row .= sprintf('<td>%1$s</td>' , $event->akhir);
                $row .= sprintf('<td>%1$s</td>' , $event->perkiraansantri);
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
    					<th>Awal</th>
                        <th>Akhir</th>
                        <th>Perkiraan digit santri</th>
    					<th>Updated_at</th>
    					<th>Created_at</th>
    				</tr>
    				%3$s				
    			</table>
            </div>%4$s',
			 	$this->get_text_on_top() ,
   				$form               ,
                $row                ,
                //$events->appends( array() )->links()
			 	$this->get_pagination_link($sessions , $wheres) 
			);
        $this->set_content($hasil);
        return $this->index();
    }    
}