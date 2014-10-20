<!doctype html>
<html>
	@include('uang.includes.head')
<body {{ $body_attr }}>
	{{ $header }}
<div class="container">
	<div id="main" class="row">
		<article class='col-md-12'>
			@section('content')
	       		{{ $content }}
	       	@show
		</article>
	</div>
	{{ $footer }}
</div>
	{{ $js }}
</body>
</html>