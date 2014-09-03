<?php
/**
*	All model should follow this class
*	@var means variabel which will be filled
*
**/
abstract class Root_model {
	private $alias_name  = array();
	private $order = "";
	private $final_query = "";// Good for debug \
	protected $limit = array( 'to' => 0 , 'from' => 15 );
	protected $pagenation  = "";
	private $wheres = array( array() ); /* Two dimenational Array */
	/* @var is  $final_query*/
	protected function set_final_query($val){		return $final_query = $val;	}
    protected function set_pagenation( $query , $where ){
        $posts = DB::select(DB::raw( $query ) , $where );
        $this->pagenation = Paginator::make($posts, count($posts),  $this->limit ['from'] );
        /*
			$pagination->getCurrentPage
			$pagination->getLastPage
			$pagination->getPerPage
			$pagination->getTotal
			$pagination->getFrom
			$pagination->getTo
			$pagination->count
        */
    }
    public  function get_pagenation_link( $array = array() ){
        if( count( $array) > 0  )
            return $this->pagenation->appends( $array )->links();
        return $this->pagenation->links ( );
    }    
    public function get_pagenation(){    	return $this->pagenation;    }
	/* Make sure everything is correct since after this you cant change anythings ,
		And pagenation automatic availabel aftet this function has ran .
		this function is most important part in this class 
	*/
	public function get_model(){
		// setting default query
		$query = $this->get_base_query();
		// setting default query along with its where 
		$where_val = array();
		foreach ($this->wheres as $where ) {
			if( isset( $where ['text'] )){
				 $query .= " ". $where ['text'] . " "  ; // Space is to keep safe 
				$where_val [] = $where ['val'] ;
			}
		}
		// setting order
		$query .= " " . $this->get_order() . " "; 
		//! setting page nation 
		$this->set_pagenation( $query , $where_val);
		// setting limit
		$query .= sprintf( ' limit  %1$s , %2$s ' , $this->limit ['to'] , $this->limit ['from']) ; 
		$this->set_final_query( $query );
		$posts = DB::select(DB::raw( $query ) 	 , $where_val ) ; 
		return $posts;
	}
	/* @var is  $order which is string */
	public function set_order($val){		$this->order = $val; 	}	
	/* @var is  $order which is string */
	public function get_order(){		return $this->order ; 	}
	/* @var is  $final_query , you can use this for debugging*/
	public function get_final_query(){		return $this->final_query;	}
	/* @var is  $limit which is array */	
	public function set_limit( $to , $from ){
		$this->limit ['to'] 	= $to ; 
		 $this->limit ['from'] 	= $from ; 
	}
	/* @var is  $limit which is array */	
	public function get_limit(){		return $this->limit;	}
	/* @var is  $alias_name which is array */
	public function set_alias( $array) {
		if( is_array($array)){
			$this->alias_name = array();
			foreach ($array as $key => $value) {
				$this->alias_name [] = $value ;
			}
		}
		else{
			echo "set alias should be array";			
		}
	}
	/* 	@var is  $alias_name which is array */	
	public function get_alias_names(){		return $this->alias_name;	}
	/* 
		You want fo show particular data ? . @var is  $wheres which is array 
		$where = array( array ( 'text' => , 'val' => '') 
	*/
	public function set_wheres( $additional ){
		$this->wheres = $additional ; 
	}
	public function get_wheres(){ 		return $this->wheres;	}


	abstract protected function get_base_query();
}
