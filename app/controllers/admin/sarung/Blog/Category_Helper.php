<?php
class Category_Helper extends Root_Helper{
    
   	public static function get_term_obj($obj , $id ){
        
		$category_name  = Input::get( "category_name" );
		$slug_name      = Input::get( "slug_name" );
        $obj->id        = $id;
		$obj->name	    =	$category_name			;
		$obj->slug   	= 	$slug_name;
		return $obj;
	}
    
    public function get_taxonomy_obj( $obj , $id_term , $taxonomy = "Category"){
		$description  = Input::get( "description_name" );
        
        $obj->taxonomy = $taxonomy;
        $obj->description = $description;
        $obj->term_id = $id_term;
        $obj->parent      = self::get_parent_term();
        return $obj;
    }
    
    public static function get_parent_term(){
        $parent      = Input::get( "parent_name" );
        if( $parent == "-"){
            return 0 ;
        }
        return $parent;
    }
}