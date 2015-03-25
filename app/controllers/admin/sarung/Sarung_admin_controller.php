<?php
class Sarung_Admin_Controller extends admin{
    public function __construct(){
        parent::__construct(1);
    }
    public function getIndex(){
        return View::make("sarung.admin.index");
    }
}
