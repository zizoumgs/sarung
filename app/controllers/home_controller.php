<?php
class Home_controller extends Controller {
    public function getIndex(){
		$url = 'http://www.google-analytics.com/collect?payload_data&z=123456';
		$my_ch = curl_init();
		curl_setopt($my_ch, CURLOPT_URL,$url);
		curl_setopt($my_ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($my_ch, CURLOPT_TIMEOUT,        5);
		$r = curl_exec($my_ch);
		curl_close($my_ch);
	
		$map = "";
		return View::make('main' , array('cu' => $map ) );
    }
}