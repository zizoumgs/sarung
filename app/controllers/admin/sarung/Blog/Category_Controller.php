<?php
class Category_Controller extends admin{
    public function __construct()
    {
    	parent::__construct(1);
		admin::init_helper(new Category_Helper);    
    }
	private static function get_db_name(){	return Config::get('database.default'); }
    public function anyIndex(){
        $array = array();
        $array ['items'] = Taxonomy_Model::get();
		return View::make('sarung.admin.blog.term.index' , $array);
    }
	public function getDelete( $id ){
        $array = array();
        $array ['items'] = Taxonomy_Model::get();
		$array ["id"] = $id;
		if( $id > 0){
			$model = Taxonomy_Model::find($id);
			$array ["description_name"] = $model->description;
			$array ["parent_name"]		= $model->parent;
			$array ["category_name"]	= $model->term->name;
			$array ["slug_name"]		= $model->term->slug ;
		}
		else{
			$array ["description_name"] = "Error , Id is Null";
			$array ["parent_name"]		= "Error , Id is Null";
			$array ["category_name"]	= "Error , Id is Null";
			$array ["slug_name"]		= "Error , Id is Null";			
		}
		return View::make('sarung.admin.blog.term.delete' , $array);		
	}
	
    public function postDelete(){
		$id = Input::get('id');
	    if($this->delete_to_db( $id  )){
	        return Redirect::to( root::get_url_admin_blog_category() )
				->with('message',  "Berhasil menghapus ke database");
		}
        else{
			return Redirect::to( root::get_url_admin_blog_category('delete/'.$id) )
				->with('message',  admin::get_error_message() );
		}
    }
	
	private function delete_to_db( $id_taxonomy ){
		$term_id = self::get_term_id( $id_taxonomy );
		$del_objects  [] =  self::get_term_object($term_id) ;
		$del_objects  [] =  Taxonomy_Model::find( $id_taxonomy );
		$save_objects [] = admin::get_saveid_obj( self::get_deleted_table_name() , $term_id ) ;
		return admin::multi_purpose_db( self::get_db_name() , $save_objects , $del_objects );
    }
	
	public function getAdd(){
        $array = array();
        $array ['items'] = Taxonomy_Model::get();

		return View::make('sarung.admin.blog.term.add' , $array);		
	}

	public function getEdit( $id ){
        $array = array();
        $array ['items'] = Taxonomy_Model::get();
		$array ["id"] = $id;
		if( $id > 0){
			$model = Taxonomy_Model::find($id);
			$array ["description_name"] = $model->description;
			$array ["parent_name"]		= $model->parent;
			$array ["category_name"]	= $model->term->name;
			$array ["slug_name"]		= $model->term->slug ;
		}
		else{
			$array ["description_name"] = "Error , Id is Null";
			$array ["parent_name"]		= "Error , Id is Null";
			$array ["category_name"]	= "Error , Id is Null";
			$array ["slug_name"]		= "Error , Id is Null";			
		}
		return View::make('sarung.admin.blog.term.edit' , $array);		
	}
	public function postEdit(){
		$id = Input::get('id');
	    if($this->edit_to_db( $id  )){
	        return Redirect::to( root::get_url_admin_blog_category() )
				->with('message',  "Berhasil merubah ke database");
		}
        else{
			return Redirect::to( root::get_url_admin_blog_category('edit/'.$id) )
				->with('message',  admin::get_error_message() );
		}		
	}
    public function postAdd(){
	    if($this->insert_to_db()){
	        return Redirect::to( root::get_url_admin_blog_category() )
				->with('message',  "Berhasil memasukkan ke database");
		}
        else{
			return Redirect::to( root::get_url_admin_blog_category("add") )
				->with('message',  admin::get_error_message() );
		}
    }
	
	

	private function get_term_id($id_taxonomy){
		return Taxonomy_Model::find($id_taxonomy)->term_id;
	}
	private function get_term_object( $term_id){
		$term_obj = Term_Model::find( $term_id );
		return admin::get_helper()->get_term_obj( $term_obj , $term_id );
	}
	private function get_taxanomy_object( $id_taxanomy , $term_id){
		$taxonomy_obj = Taxonomy_Model::find( $id_taxanomy );
		return admin::get_helper()->get_taxonomy_obj( $taxonomy_obj , $term_id);
	}
	
	private function edit_to_db( $id ){
		$term_id = self::get_term_id($id);
		$save_objects [] =  self::get_term_object($term_id) ;
		$save_objects [] =  self::get_taxanomy_object( $id , $term_id) ;		
		$del_objects  = array() ;
		
		return admin::multi_purpose_db( self::get_db_name() , $save_objects , $del_objects);		
	}
    private function insert_to_db(){
        $id_term 	  = 	admin::get_id( self::get_deleted_table_name() , Term_Model::max('id') );
		$save_objects = array();
		$save_objects [] = admin::get_helper()->get_term_obj( new Term_Model() , $id_term );
		$save_objects [] = admin::get_helper()->get_taxonomy_obj( new Taxonomy_Model() , $id_term);
		
		$del_objects  = array(SaveId::nameNid( self::get_deleted_table_name() , $id_term ));
		
		return admin::multi_purpose_db( self::get_db_name() , $save_objects , $del_objects );
    }
	
	private static function get_deleted_table_name(){
		return "blo_terms";
	}
}
