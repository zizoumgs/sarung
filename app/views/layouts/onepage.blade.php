<!doctype html>
<html lang="en">
<head>
	@include('includes.google')
    @include('includes.head_main')
</head>
<body>
    <header>
        @include('includes.header_main')
    </header>
	<div class="container">
	    <div class="row">
			<div id="main" >
		        <!-- main content -->
	            @yield('content')			
			</div>
	    </div>
	</div>
	<div class="clear_10"></div>
	@include('includes.footer')
</body>
</html>
