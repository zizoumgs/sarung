<!doctype html>
<html>
	@include('uang.includes.head')
<body>
	{{ $header }}
<div class="container">
	<div id="main" class="row">
		<article class='col-md-9'>
			@section('content')
	       		<h2>{{ $content }}</h2>
	       	@show
		</article>
		<aside class='col-md-3'>
			{{ $side }}
		</aside>	
	</div>
	{{ $footer }}
</div>
	{{ $js }}
</body>
</html>