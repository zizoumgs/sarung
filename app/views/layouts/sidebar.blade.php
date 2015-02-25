<!doctype html>
<html lang="en">
<head>
        @include('includes.head_main')
</head>
<body>
    <header>
        @include('includes.header_main')
    </header>

<div class="container">
    <div class="row">
		<div id="main" >
	        @yield('title_post')
	        <!-- main content -->
	        <div id="content" class="col-md-9">
	            @yield('content')
	        </div>
	        <!-- sidebar content -->
	        <div id="sidebar" class="col-md-3">
				@yield('sidebar')
	        </div>
		</div>
    </div>
</div>
    <footer>
		<div class="container" >	
			<p class="navbar-text">Copyright 2014 <a href="http://www.manggisan.com/" class="navbar-link">
			fatihul ulum manggisan</a> | all rights reserved | powered by
			<a href="http://http://laravel.com/" target="_blank">Laravel</a></p>
		</div>
	</footer>

</body>
</html>
