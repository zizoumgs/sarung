<!doctype html>
<html>
	@include('sarung.includes.head')
<body {{ $body_attr }}>
	@include('sarung.includes.header')
<div class="container">
	<div id="main" class="row">
		<article class='col-md-9'>
			@section('content')
	       		{{ $content }}
	       	@show
		</article>
		<aside class='col-md-3 widget'>
			{{ $side }}
		</aside>	
	</div>
	{{ $footer }}
</div>
	{{ $js }}
</body>
</html>