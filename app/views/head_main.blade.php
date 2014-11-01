<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="_token" content="{{ csrf_token() }}" />
	<title>
    	@section('title')
        	{{ $title }}
        @show
    </title>
    	<!-- CSS are placed here -->
    		{{ $css }}
</head>
