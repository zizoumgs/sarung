<?php

class Uang_controller extends Controller{
	public function getIndex(){
		$wheres = array ();
		$cat = Input::get('divisi');
	    $obj = new Income_Model();
		if($cat){
			$wheres  ['cat'] =  $cat ;
			$divisi = Divisi::where('nama','=',$cat)->first();
			$obj = $obj->where('iddivisi','=', $divisi->id );
		}
        $posts = $obj->orderby("tanggal","DESC")->paginate( 15 );
		return View::make('new_uang.income', array('posts' => $posts , 'wheres' => $wheres ));
	}
	public function getIncome(){	return $this->getIndex() ;}

	public function getOutcome(){
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
        $posts = $obj->orderby("tanggal","DESC")->paginate( 15 );
		return View::make('new_uang.outcome', array('posts' => $posts , 'wheres' => $wheres ));
	}
	
}