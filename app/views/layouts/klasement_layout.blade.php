<!doctype html>
<html lang="en">
<head>
        @include('includes.head_main')
        @yield('additional_css')
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
	<script type="text/javascript" src="{{ URL::to('/').'/asset/js/jquery-1.11.min.js' }}" ></script>
    <script type="text/javascript" src="{{ URL::to('/').'/asset/js/jquery-ui.js' }}" ></script>
    <script type="text/javascript" src="{{ URL::to('/').'/asset/bootstrap/js/bootstrap.js' }}" ></script>
	<script type="text/javascript" src="{{ URL::to('/').'/asset/js/sarung.js' }}" ></script>
    @yield('additional_js')
</body>
</html>
