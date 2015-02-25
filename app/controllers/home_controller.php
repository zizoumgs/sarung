
<?php
class Home_controller extends Controller {
    public function getIndex(){
		return View::make('main');        
    }
}