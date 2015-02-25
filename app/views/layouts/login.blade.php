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
	        <!-- main content -->
            @yield('content')
		</div>
    </div>
</div>
</body>
</html>
