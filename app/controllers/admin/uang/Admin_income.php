<?php
class Admin_income extends Admin_uang{
    public function __construct(){
        parent::__construct();
   		$this->set_title('Admin Uang-Income Fatihul Ulum');

    }
    protected function get_content(){
        return "You are on Admin Income";
    }
}