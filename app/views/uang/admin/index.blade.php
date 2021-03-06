<!doctype html>
<html>
	@include('uang.includes.head')
<body {{ $body_attr }}>
	{{ $header }}
<div class="container-fluid">
	<div id="wrap" class="row">
		<div id="main" class="clear-top">
			<aside class='col-md-2 admin_side'>
				{{ $side }}
			</aside>
			<article class='col-md-10 main-article'>
				@section('content')
			   		{{ $content }}
			   	@show
			</article>
		</div>
	</div>
	<footer class="footer">
		{{ $footer }}
	</footer>
</div>
	{{ $js }}
</body>
</html>
