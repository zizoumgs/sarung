<?php
/**
*   this will control every url about uang
**/
class uang extends root {    
    /*Important*/
    private $name_division , $name_division_sub , $pagenation; 
    protected function get_name_division(){ return $this->name_division ; }
    protected function get_name_division_sub(){ return $this->name_division_sub ; }
    public function index( $param = array() ){
        $data = array(
            'js'    => $this->get_js() ,
            'footer'    => $this->get_footer() ,
            'header'    => $this->get_header(),
            'css'       => $this->get_css(),
            'title'   => $this->get_title(),
            'content' => $this->get_table()     ,
            'side'  => $this->get_side()
                        )    ;
        return View::make('uang/index' , $data);
    }
    protected function get_side(){
        return "";
    }
    //! override this if you want 
    protected function get_default_query(){return "";}
    protected function get_header(){
        return '
            <header class="header_container">
                <div class="container">
                    <div class="navbar navbar-default" role="navigation">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="#">Fatihul Ulum</a>
                        </div>
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                <li><a href="'.$this->base_url().'/income">Income</a></li>
                                <li><a href="'.$this->base_url().'/outcome">Outcome</a></li>
                                <li><a href="'.$this->base_url().'/subdivisi">Sub Divisi</a></li>
                                <!-- <li><a href="/contact">Contact</a></li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </header>';

    }
    protected function get_footer(){
        $hasil = sprintf('
            <footer>
                <h3>Fatihul Ulum </h3>
            </footer>
            '
            );
        return $hasil;
    }
    protected function get_additional_js(){
        return "";
    }
    protected function get_select_divisi( $array = array() ){
        $default = array( "class" => "selectpicker" , "id" => "" , "name" => 'divisi');
        foreach ( $default as $key => $value) {
            if( array_key_exists($key , $array)){
                $default [$key] = $array [$key] ;
            }
        }
        $this->name_division = $default ['name'] ; 
        $default ['selected'] = $this->get_selected_division();
        $posts = DB::select(DB::raw('
            select divi.id as id , divi.nama as nama_div
            from divisi divi 
            order by nama_div')
        );
        $items = array("All");
        foreach ($posts as $post ) {
            $items [$post->id] = $post->nama_div ; 
        }
        return $this->get_select( $items , $default) ;
    }

    protected function get_select_divisi_sub( $array = array() ){
        $default = array( "class" => "selectpicker" , "id" => "" , "name" => 'divisi_sub');
        foreach ( $default as $key => $value) {
            if( array_key_exists($key , $array)){
                $default [$key] = $array [$key] ;
            }
        }
        $this->name_division_sub = $default ['name'] ; 
        //! for selected item
        $default ['selected'] = $this->get_selected_division_sub();
        $posts = DB::select(DB::raw('
            select divis.id as id , divis.nama as nama_div 
            from divisisub divis 
            group by nama_div
            order by divis.id DESC')
        );
        $items = array( '' => "All");
        foreach ($posts as $post ) {
            $items [$post->id] = $post->nama_div ; 
        }
        return $this->get_select( $items , $default) ;
    }
    protected function get_selected_division(){        return Input::get( $this->name_division );    }
    protected function get_selected_division_sub(){    return Input::get( $this->name_division_sub );  }
    protected function get_current_page(){    
        $page = Input::get( 'page') ; 
        if( $page > 0)
            return (Input::get( 'page')-1)* $this->get_total_jump();  
        return 0;  
    }
}