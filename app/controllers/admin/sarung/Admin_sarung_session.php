<?php
class Admin_sarung_session extends Admin_sarung_event{
    private $input;
   
    public function __construct(){
        parent::__construct();
    }
   
    protected function set_session_name($val)   {  $this->input ['session_name'] = $val; }
    protected function get_session_name()       {  return $this->input ['session_name'] ; }
    protected function get_session_selected ()  {  return Input::get( $this->get_session_name() ) ;}
    
    protected function set_alias_name($val)     { $this->input ['alias_name'] = $val; }
    protected function get_alias_name()         { return $this->input['alias_name'];}
    protected function get_alis_selected ()     { return Input::get( $this->get_alias_name());}

    protected function set_perkiraan_santri_name($val)  { $this->input ['perkiraan_santri'] = $val ;}
    protected function get_perkiraan_santri_name()      { return $this->input ['perkiraan_santri'];}
    protected function get_perkiraan_santri_selected () { return Input::get( $this->get_perkiraan_santri_name() );}
    
    protected function set_awal_name($val)      { $this->input ['awal_name'] = $val ;}
    protected function get_awal_name()          { return $this->input['awal_name'];}
    protected function get_awal_selected ()     { return Input::get ( $this->get_awal_name()) ; }
    
    protected function set_akhir_name($val)     { $this->input ['akhir_name'] = $val ; }
    protected function get_akhir_name()         { return $this->input ['akhir_name'] ;}
    protected function get_akhir_selected ()    { return Input::get( $this->get_akhir_name() ) ;}
    
    protected function get_form_cud( $go_where  , $values = array()  ,$disabled = "" , $method = 'post'){
        $array = array(
                       $this->get_session_name () => '' ,
                       $this->get_alias_name    () => '' ,
                       $this->get_perkiraan_santri_name() => '2' ,
                       $this->get_awal_name()   =>  '' ,
                       $this->get_akhir_name()  =>  ''
                       );
        $array = $this->make_one_two_array($array , $values);
		$this->set_input_date( ".".$this->get_akhir_name() , true);
		$this->set_input_date( ".".$this->get_awal_name()  , false);
        $perkiraan_santri = sprintf('<input type="number" name="%1$s" class="%1$s form-control" min="1" max="3" Value="%2$s" %3$s  >',
                                    $this->get_perkiraan_santri_name()              , 
                                    $array [ $this->get_perkiraan_santri_name()]    ,
                                    $disabled );
        
        $array = $this->make_one_two_array($array , $values);
        $params = array('label' , 'value');
   		$hasil  = Form::open(array('url' => $go_where, 'method' => $method , 'role' => 'form' ,'class' => 'form-horizontal')) ;
        $hasil .= $this->get_text_cud_group( 'Session'     , $array [ $this->get_session_name()]   , $this->get_session_name()    , $disabled) ;
        $hasil .= $this->get_text_cud_group( 'Short_Name'  , $array [ $this->get_alias_name()]     , $this->get_alias_name()      , $disabled) ;
        $hasil .= $this->get_input_cud_group( 'Perkiraan Santri'  , $perkiraan_santri) ;
        $hasil .= $this->get_text_cud_group( 'Awal'        , $array [ $this->get_awal_name()]     , $this->get_awal_name()      , $disabled) ;
        $hasil .= $this->get_text_cud_group( 'Akhir'  , $array [ $this->get_akhir_name()]     , $this->get_akhir_name()      , $disabled) ;
        
        
   		$hasil .= Form::hidden('id', $this->get_id() );
		$hasil .= '<div class="form-group"><div class="col-sm-offset-2 col-sm-10">';
		$hasil .= Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) );
		$hasil .= '</div></div>';
        $hasil .= Form::close();
        return $hasil;
    }

    /*You should call this on contructor ,and you should make this*/
    protected function set_default_value(){
        $this->set_view('sarung/admin/index');
        $this->set_min_power( 1000 );
		$this->set_title('Session');
		$this->set_body_attribute( " class='admin admin_sarung_body' " );
        $this->set_name_for_text('kalender');
        $this->set_table_name('session');
        
        $this->set_perkiraan_santri_name( 'perkiraan_santri' );
        $this->set_session_name ( 'session_name');
        $this->set_alias_name   ( 'alias_name');
        $this->set_awal_name    ( 'awal_name');
        $this->set_akhir_name   ( 'akhir_name' );
    }


    public function getIndex(){
        $find_name = $this->get_name_for_text_selected();
        $href = sprintf('<a href="%1$s" class="btn btn-primary btn-xs" >Add</a>' , $this->get_url_this_add() );        
        $this->set_text_on_top('Session Table  '.$href);
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



    public function postEventadd(){
        $data = Input::all();
   		$rules = $this->get_rules( true);
    	$validator = Validator::make($data, $rules);
		if ($validator->fails())    {
			$messages = $validator->messages();
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages->all() ));
			return $this->getEventadd( $message );
		}
        else{
            $id             =   $this->get_id_from_save_id ( $this->get_table_name() ,$this->get_max_id() );
            $data ['id']    =   $id ;
            $event = $this->Sarung_db_about($data  );
			$messages = array("Gagal Memasukkan ");
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages ));
			$bool = false ;
            $saveId = $this->del_item_from_save_id( $this->get_table_name() , $id );
			DB::transaction(function()use ($event , $saveId , &$bool , $id){
				$event->save();
                if($saveId)
           			$saveId->delete();		
				$bool = true;				
			});
			if($bool){
				$messages = array(" Sukses Menambah");
				$message = sprintf('<span class="label label-info">%1$s</span>' ,
							   $this->make_message( $messages ));
			}
			return $this->getEventadd($message);            
        }        
    }



    public function postEventedit(){
		$data = Input::all() ;
        $id = Input::get('id');
		$rules = $this->get_rules(true);
    	$validator = Validator::make($data, $rules);
		if ($validator->fails())    {
			$messages = $validator->messages();
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages->all() ));
			return $this->getEventedit( $message );
		}
        else{
            $event = $this->Sarung_db_about( $data , true  );
			$messages = array("Gagal Mengedit ");
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages ));
			$bool = false ; 
			DB::transaction(function()use ($event , &$bool , $id){
				$event->save();
				$bool = true;				
			});
			if($bool){
				$messages = array(" Sukses Mengedit");
				$message = sprintf('<span class="label label-info">%1$s</span>' ,
							   $this->make_message( $messages ));
			}
			return $this->getEventedit( $id , $message);
        }
    }



    protected function get_rules($with_id = false){
        $array = array(
            $this->get_session_name ()  => 'required' ,
            $this->get_alias_name   ()  => 'required' ,
            $this->get_perkiraan_santri_name() => "required|numeric" ,
            $this->get_awal_name()      => 'required' ,
            $this->get_akhir_name()     => 'required'
        ); 
        if($with_id)
            $array ['id'] = "required|numeric" ; 
        return $array;
    }



   /* this will be called just before insert , edit */
    protected function Sarung_db_about($data , $edit = false){
        $event = new Session_Model();
        if( !$edit ){
            $event->id = $data ['id'] ;
        }
        else{
            $event = $event->find( $data ['id'] );
        }
       	$event->nama            = $data [ $this->get_session_name() ]           ;
   		$event->alias           = $data [ $this->get_alias_name()   ]	        ;
        $event->perkiraansantri = $data [ $this->get_perkiraan_santri_name() ]  ;
        $event->awal            = $data [ $this->get_awal_name()    ]           ;
        $event->akhir           = $data [ $this->get_akhir_name()   ]           ;
        return $event;
    }


    protected function get_max_id(){ return Session_Model::max('id');}

    protected function set_values_to_inputs($model){
        return array(
                     $this->get_session_name()              =>  $model->nama            ,
                     $this->get_alias_name()                =>  $model->alias           ,
                     $this->get_perkiraan_santri_name()     =>  $model->perkiraansantri ,
                     $this->get_awal_name()                 =>  $model->awal            ,
                     $this->get_akhir_name()                =>  $model->akhir
        );
    }

    //! this will get table of database
    protected function get_model_obj(){        return new Session_Model();    }
    protected function get_url_this_view(){ return $this->get_url_admin_sarung()."/session" ;}
    protected function get_url_this_add(){ return $this->get_url_admin_sarung()."/session/eventadd" ;}
    protected function get_url_this_edit(){ return $this->get_url_admin_sarung()."/session/eventedit" ;}
    protected function get_url_this_dele(){ return $this->get_url_admin_sarung()."/session/eventdel" ;}
}