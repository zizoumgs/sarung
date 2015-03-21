<!doctype html>
<html lang="en">
<head>	
		<meta name="csrf-token" content="{{ csrf_token() }}" />
        <link href="{{ URL::to('/') }}/asset/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    	<link href="{{ URL::to('/') }}/asset/bootstrap/css/bootstrap-theme.css" rel="stylesheet" type="text/css"/>
		<!-- additional css -->
		<link href="{{ URL::to('/') }}/asset/css/admin.css" rel="stylesheet" type="text/css"/>
        <title>
            @yield('title')
        </title>
        @yield('additional_css')
</head>
<body>
    <header>
        <nav class="navbar navbar-inverse top-header" role="navigation">
            <div class="container-fluid">
	            <div class="navbar-header">
	                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
	                    <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Sarung | <small>Admin Sarung</small> </a>
                </div>
                <div class="collapse navbar-collapse">
	                <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="%4$s" rel="nofollow">Visit Site</a></li>
                        <li><a href="%5$s" rel="nofollow">Back up Database</a></li>
                        <li><a href="#" rel="nofollow">{{ admin::get_user_power() }} | {{ admin::get_user_name_group() }} </a></li>
		                <li><a href="{{ root::get_url_logout() }}" rel="nofollow"><span class="glyphicon glyphicon-log-in"> </span> Log out</a></li>
                    </ul>
                </div>
			</div>
		</nav>
    </header>
<div class="container-fluid">
    <div class="row">
		<aside class='col-md-2 admin_side'>
			@include('layouts.admin_sidebar')
        </aside>
		<article class='col-md-10'>
	        <!-- main content -->
            @yield('content')
		</article>
    </div>
</div>
	<script type="text/javascript" src="{{ URL::to('/').'/asset/js/jquery-1.11.min.js'}}">
	</script>
    <script type="text/javascript" src="{{ URL::to('/').'/asset/js/jquery-ui.js'}}">
	</script>
    <script type="text/javascript" src="{{ URL::to('/').'/asset/bootstrap/js/bootstrap.js'}}">
	</script>
	<script type="text/javascript" src="{{ URL::to('/').'/asset/js/sarung.js'}}">
	</script>
    @yield('additional_js')
</body>
</html>
