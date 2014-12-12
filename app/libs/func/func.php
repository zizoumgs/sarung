<?php
/**
*/
namespace FUNC;
// example
function get($classname)
{
    $a = __NAMESPACE__ . '\\' . $classname;
    return new $a;
}
function get_pagenation_link( $pagenation , $array = array() ){
	if(!$pagenation)
		return;
	if( count( $array) > 0  )
		return $pagenation->appends( $array )->links();
    return $pagenation->links ( );
}
/**
 *	value and text is differect
 *	return html select 
*/	
function get_select_by_key ( $items  , $array = array() , $disabled = ""){
	$attribute_select ="" ;
	foreach($array as $key => $val){
		if( $key != "selected")
			if($key != "disabled"){
				$attribute_select .= sprintf( ' %1$s = "%2$s" ' , $key , $val );
			}
	}
	$select = sprintf('<select %1$s %2$s>' , $attribute_select , $disabled);
    foreach ( $items as $key => $value) {
	   	$selected = "";
       	if($key == $array ['selected']){
       		$selected = ' selected="selected" ' ;
       	}
        $select .= sprintf('<option value="%1$s" %3$s >%2$s</option>',$key,$value , $selected );
    }
	$select .= "</select>";
    return $select;
}
/**
 *	value and text is same
 *	return html select 
*/	
function get_select( $items  , $array = array() , $disabled = ""){
	$attribute_select ="" ;
	foreach($array as $key => $val){
		if( $key != "selected")
			if($key != "disabled"){
				$attribute_select .= sprintf( ' %1$s = "%2$s" ' , $key , $val );
			}
	}
	$select = sprintf('<select %1$s %2$s>' , $attribute_select , $disabled);
    foreach ( $items as $key => $value) {
       	$selected = "";
       	if($value == $array ['selected']){
       		$selected = ' selected ' ;
       	}
        $select .= sprintf('<option value="%2$s" %3$s >%2$s</option>',$key,$value , $selected );
    }
    $select .= "</select>";
    return $select;
}
/**
 *  get session
 *  return select
*/
function get_session_select( $attributes = array() , $additional_item = array()){
	$default = array( "class" => "selectpicker",
                         "name" => '' ,
                         'id'   => '' , 
                         'selected' => '',
						 'data-size' => '5',
						 );
	//! transfer to default array
	foreach( $attributes as $key => $val){
		$default [$key] = $val ;
	}			
    $hasil = array();
	//@ additioanl item
    foreach($additional_item as $item){
	    $hasil [] = $item ;
    }
    //@
    $sessions = new \Session_Model();
	$sessions = $sessions->orderby('nama' , 'DESC')->get();
    foreach($sessions as $item){
	    $hasil [] = $item->nama ;
    }
    return get_select( $hasil , $default);
}

/**
 *  get pelajaran
 *  return select
**/
function get_pelajaran_select( $attributes ,   $additional_item = array()){
	$default = array(
		"class" => "selectpicker"	,
		"name" => ''				,
        'id'   => '' 				, 
        'selected' => ''			,
		 'data-size' => '5',
	 );
	//! transfer to default array
	foreach( $attributes as $key => $val){
		$default [$key] = $val ;
	}			
    $hasil = array();
	//@ additioanl item
    foreach($additional_item as $item){            $hasil [] = $item ;        }		
    //@
    $sessions = new \Ujian_Model();
    foreach($sessions->get_names_of_pelajaran() as $item){
		$hasil [] = $item->name ;
    }
    return get_select( $hasil , $default);		
}
/**
 *  get pelajaran
 *  return select
**/
function get_event_ujian_select( $attributes , $additional_item = array() ){
        $default = array( "class" => "selectpicker",
                         "name" => '',
                         'id'   => '' , 
                         'selected' => '',
						 'data-size' => '5',						 
						 );
		//! transfer to default array
	foreach( $attributes as $key => $val){
		$default [$key] = $val ;
	}			
    $hasil = array();
	//@ additioanl item
    foreach($additional_item as $item){
	    $hasil [] = $item ;
    }
    //@
    $sessions = new \Ujian_Model();
    foreach($sessions->get_names_of_ujian() as $item){
	    $hasil [] = $item->name ;
    }
    return get_select( $hasil , $default);		
}
/**
 *  get kelas
 *  return select
**/
function get_kelas_select( $attributes , $additional_item = array()){
    $default = array( "class" => "selectpicker",
        "name" => '',
        'id'   => '' , 
        'selected' => '',
		 'data-size' => '5',
	);
	//! transfer to default array
	foreach( $attributes as $key => $val){
		$default [$key] = $val ;
	}
	
    $hasil = array();
	//@ additioanl item
    foreach($additional_item as $item){            $hasil [] = $item ;        }		
    //@    
    $sessions = \Kelas_Model::orderby('nama' , 'ASC')->get();
    foreach($sessions as $item){
    	$hasil [] = $item->nama ;
    }		
	return get_select( $hasil , $default);		
}
/**
 *  get kelas
 *  return select
**/
function get_pelanggaran_name_select( $attributes , $additional_item = array()){
        $default = array( "class" => "selectpicker",
                         "name" => '',
                         'id'   => '' , 
                         'selected' => '',
						 'data-size' => '5',
						 );
	//! transfer to default array
	foreach( $attributes as $key => $val){
		$default [$key] = $val ;
	}
	//@ get from database
    $hasil = array();
	//@ additioanl item
    foreach($additional_item as $item){            $hasil [] = $item ;        }
    //@
    $sessions = \Larangan_Nama_Model::orderby('nama' , 'ASC')->get();
    foreach($sessions as $item){
	    $hasil [] = $item->nama ;
    }
	return get_select( $hasil , $default);		
}
/**
 *  get jenis pelanggaran
 *  return select
*/
function get_jenis_pelanggaran_select( $attributes = array() , $additional_item = array() ){
	$default = array( "class" => "selectpicker",
                         "name" => '' ,
                         'id'   => '' , 
                         'selected' => '',
						 'data-size' => '5',
						 );
	//! transfer to default array
	foreach( $attributes as $key => $val){
		$default [$key] = $val ;
	}			
    $hasil = array();
	//@ additioanl item
    foreach($additional_item as $item){            $hasil [] = $item ;        }
    //@
    $sessions = array("B","M","R");
    foreach($sessions as $item){
	    $hasil [] = $item ;
    }
    return get_select( $hasil , $default);
}

/**
 *	get pagination label 
 *	return label and total count or empty if failur happened
*/
function get_pagination_label( $obj , $text = ' Show %1$s of %2$s '  ){
	if($obj){
		return sprintf($text  , $obj->getFrom() , $obj->count());
	}
	return "";
}
/**
 *	get pagination label 
 *	return label and total count or empty if failur happened
*/
function get_pagination_label_two( $obj , $text = ' Show %1$s of %2$s '  ){
	if($obj){
		return sprintf($text  , $obj->getFrom() , $obj->getTotal());
	}
	return "";
}

/**
 *	form group for horizontal form
 *	return html 
*/
function get_group_for_hor_form($label , $input){
	$result = sprintf('
		<div class="form-group">
			<label for="%1$s" class="col-sm-2 control-label">%1$s</label>
			<div class="col-sm-10">					
				%2$s
			</div>
		</div>' , $label , $input);
	return $result;
}
/**
 *  function usualy used for filtering result
 *  return only input html
*/
function get_form_group($input){
	return sprintf('<div class="form-group ">
		   %1$s
   </div>' , $input );
}
/**
 *	add fake get
 *	remember this is global variabel
*/
function add_fake_get($key , $val){
	$_GET[$key] = $val;
}
function add_fake_post($key , $val){
	$_POST[$key] = $val;
}

/**
 *  convert string to time
 *  return time
*/
function get_time_from_string($string){
	$time = strtotime($string);//"2013-09-01";
    return $time; 
}    
/**
 *  convert string to date
 *  return date
 */
function get_date_from_string($string , $format = "Y-m-d"){
    $time = strtotime($string);//"2013-09-01";
    $date = date($format,$time);
	return $date ; 
}
 /**
  *  @  (dtime , string , string )
  *  add month to date
  *  return date
*/
function add_month_to_date( $time , $months = "+1", $format = " Y-m-d "){
	//$date = mktime(0, 0, 0, date("n") + $months, 1);
    $parameter = sprintf('%1$s months',$months);
    return date($format, strtotime($parameter, $time));
}
//@ escape from single quote
function get_escape($val){
	//@ or you can use : addalash
	return htmlentities(str_replace("'","\'",$val));
}	
//@ will make title for this application 
function make_title($text){
	return sprintf('<h1>%1$s</h1>',$text);
}


