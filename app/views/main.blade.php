<!DOCTYPE html>
    @include('includes.head_main')
<body>
    {{ $header }}
 <div class="container">
	<div class="row">
		<div id="main">
				@section('content')
			   		{{ $content }}
			   	@show
		</div>
	</div>
	<!--
	<footer class="footer">
        <nav class="navbar navbar-default" role="navigation">
            <div class="container">
                <p class="navbar-text">Powered by Fatihul ulum </p>
            </div>
        </nav>        
		{{ $footer }}
	</footer>
	-->
</div>   
	{{ $js }}
</body>
</html>