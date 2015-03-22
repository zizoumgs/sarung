<?php
class Root_Helper {
    
   	protected static function should_be_keep($text){
		if( $text  !== "All" && $text != "" )
			return true;
		return false;
	}
	public static function get_table_info( $obj ){
		return sprintf('Show %1$s of %2$s', $obj->getFrom() , $obj->getTotal()) ;
	}
}