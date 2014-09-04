<?php
class Admin_uang extends Admin_root{
    public function __construct(){
        parent::__construct();
		$this->set_title('Admin Uang Fatihul Ulum');
		$this->set_body_attribute( " class='admin admin_uang_body' " );
		$this->set_view ('uang/admin/index'); 
    }
	protected function get_content(){
		return "<h1>Welcome Admind Uang</h1>
		<p>Silahkan anda masukkan apa yang perlu dimasukkan!</p>";
	}
	protected function get_header(){
		$hasil = '
		<nav class="navbar navbar-inverse top-header" role="navigation">
            <div class="container-fluid">
	            <div class="navbar-header">
	                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
	                    <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Sarung | <small>Admin Uang</small> </a>
                </div>
                <div class="collapse navbar-collapse">
	                <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="%2$s" rel="nofollow" target="_blank">Visit Site</a></li>
                        <li><a href="#" rel="nofollow">Back up Database</a></li>
                        <li><a href="%1$s" rel="nofollow">Admind-Power</a></li>
		                <li><a href="logout" rel="nofollow">Log out</a></li>
                    </ul>
                </div>
			</div>
		</nav>		
		';
		return $hasil;
	}
	protected function get_side(){
        $list_menu = "";
        $list_menu .=  sprintf('<li><a href="%1$s" rel="nofollow" class="title"><span class="glyphicon glyphicon-dashboard"></span> %2$s</a></li>',
							   $this->get_admin_url(),"Dashboard"); 
        $list = array(
                        array('Outcome' 	,'<span class="glyphicon glyphicon-refresh"></span>'    , sprintf('%1$s/outcome' , $this->get_admin_url() )  ) ,
                        array('Income'  	,'<span class="glyphicon glyphicon-cutlery"></span>' , sprintf('%1$s/income'  	, $this->get_admin_url() ) ) ,
                        array('Subdivisi'	,'<span class="glyphicon glyphicon-expand"></span>'  , sprintf('%1$s/subdivisi' , $this->get_admin_url() ) ),
						array('User'		,'<span class="glyphicon glyphicon-user"></span>'  , sprintf('%1$s/subdivisi' , $this->get_admin_url() ) )
                      );
        foreach($list as $key => $val ){
           $list_menu .= sprintf('<li><a href="%1$s" rel="nofollow"> %2$s    %3$s</a></li>', $val [2] , $val [1] ,$val[0]) ;
        }
        $menu  = '
            <a id="element" href="#" tabindex="0" 
                data-toggle="popover" 
                data-trigger="focus"
                data-html="true"
                title="<span class=\'title_side_content\'>Dismissible popover</span>" 
                data-content="
                    <a class=\'inside_side_content\' href=\'#\'>Fudc</a>
                    <a class=\'inside_side_content\' href=\'#\'>Fudc</a>
                    <a class=\'inside_side_content\' href=\'#\'>Fudc</a>
                "
                >Dismissible popover</a>

        ';
        $list_menu .= sprintf('<li>%1$s</li>', $menu) ;
		$side = sprintf('
				<ul>%1$s</ul>
		',$list_menu);
		return $side;
		
		return '
	
		<ul>
			<li><a href="#">Outcome</a></li>
			<li><a href="#">Income</a></li>
			<li><a href="#">Subdivisi</a></li>
			<li><a href="#">Divisi</a></li>
		</ul>
		';
	}
	protected function get_additional_css(){
		return sprintf(
		'
		<!-- additional css -->
		<link href="%1$s" rel="stylesheet" type="text/css"/>
		',
		URL::to('/').'/asset/css/admin.css'
		);
	}
    protected function get_additional_js(){
		$js = sprintf('
			<!-- additional css -->
            <script>
	            $("#element").popover();
            </script>
			',
			$this->base_url()
			);
		return $js;
    }
	
	//! penting
	protected function get_admin_url(){		return sprintf('%1$s/admin_uang' , Url::to('/') ) ;	}
}

