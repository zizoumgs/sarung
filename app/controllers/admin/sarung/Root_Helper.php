<?php
class Root_Helper {
    
   	protected static function should_be_keep($text){
		if( $text  !== "All" && $text != "" )
			return true;
		return false;
	}
}