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
	@include('includes.footer')
</body>
</html>
