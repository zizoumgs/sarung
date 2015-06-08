<?php

class Uang_controller extends Controller{
	private $month_my = "";
	public function getIndex(){
		$wheres = array ();
	    $obj = new Income_Model();
		$cat = Input::get('cat');
		if($cat != "" ){
			$wheres  ['cat'] =  $cat ;
			$category = Divisisub_Model::where('nama','=',$cat)->first();
			if( $category)
				$obj = $obj->where('idsubdivisi','=', $category->id );
			else
				$obj = $obj->where('idsubdivisi','=', 0 );
		}
		$obj = $this->getSpecificDate($obj); 
        $posts = $obj->orderby("tanggal","DESC")->paginate( 15 );		
		return View::make('new_uang.income', array('posts' => $posts , 'wheres' => $wheres ));
	}
	
	public function getIncome($month = "" ){
		$this->month_my = $month;			
		return $this->getIndex() ;
	}
	
	private function getSpecificDate( $obj ){
		if( $this->month_my != "" ){
			
			$year = FUNC\get_date_from_string( $this->month_my."-01" ,"Y");
			$month = FUNC\get_date_from_string( $this->month_my."-01" ,"m");
			$raw = sprintf('YEAR(tanggal) = %1$s and MONTH(tanggal) = %2$s' , $year , $month);
			$obj = $obj->whereRaw( $raw );
			return $obj;
		}
		return $obj ;
	}
	
	public function getOutcome( $month = "" ){
		$this->month_my = $month;			

		$wheres = array ();
		$obj = new Outcome_Model();
		$cat = Input::get('cat');
		if($cat != "" ){
			$wheres  ['cat'] =  $cat ;
			$category = Divisisub_Model::where('nama','=',$cat)->first();
			if( $category)
				$obj = $obj->where('idsubdivisi','=', $category->id );
			else
				$obj = $obj->where('idsubdivisi','=', 0 );
		}
		$obj = $this->getSpecificDate($obj); 

        $posts = $obj->orderby("tanggal","DESC")->paginate( 15 );
		return View::make('new_uang.outcome', array('posts' => $posts , 'wheres' => $wheres ));
	}
	
}