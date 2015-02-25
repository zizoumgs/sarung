<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="_token" content="{{ csrf_token() }}" />
	<title>
            @yield('title')
    </title>
    	<!-- CSS are placed here -->
	<link href=" {{ URL::to('/').'/asset/bootstrap/css/bootstrap.css' }}" rel="stylesheet" type="text/css"/>
	<link href=" {{ URL::to('/').'/asset/bootstrap/css/bootstrap-theme.css' }}" rel="stylesheet" type="text/css"/>
	<link href="{{ URL::to('/') }}/asset/css/fudc.css" rel="stylesheet" type="text/css"/>
						<style>
						@media (min-width: 768px) {
							ul.navbar-nav > li {
								padding-top:50px;
								padding-bottom:0px;
								position:relative;
								z-index:1000;
							}
						    ul li ul.child-menu{
								display: none;
								padding:0px;
								margin:0px;
								position:absolute;
							}
							ul li:hover > ul.child-menu{
								display: block; /* display the dropdown */
							}
							ul.child-menu li , ul.navbar-nav > li:hover a{
								color:white !important;
								/*background:#6b0c36 !important;*/
								background:#33BEF0 !important;
							}
							ul.child-menu li{
								list-style-type: none;
								background:white;
								padding:7px;
								width:150px;
							}
							ul.child-menu li a {
								color:black !important;
								display:block;
							}
						}
						.page-header {
							padding-bottom: 9px;
							margin: 40px 0 20px;
							border-bottom: 1px solid #eeeeee;
						}						
						.page-header {
							border: none !important;
							
						}
						footer{
							background:#F5F5F2;
						}
						</style>
</head>
