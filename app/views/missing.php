<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Laravel PHP Framework</title>
	<style>
		@import url(//fonts.googleapis.com/css?family=Lato:700);

		body {
			margin:0;
			font-family:'Lato', sans-serif;
			text-align:center;
			color: #999;
		}

		.welcome {
			width: 300px;
			height: 200px;
			position: absolute;
			left: 50%;
			top: 50%;
			margin-left: -150px;
			margin-top: -100px;
		}

		a, a:visited {
			text-decoration:none;
		}

		h1 {
			font-size: 32px;
			margin: 16px 0 0 0;
		}
        img{
            width:256px ; height:256px;
        }
	</style>
</head>
<body>
	<div class="welcome">
		<a href="http://laravel.com" title="Fatihul Ulum"><img src="<?php echo URL::to('/')?>/asset/images/fatihulUlum1.gif"
                        alt="Fatihul Ulum Manggisan"></a>
		<p>You try to find something that we dont have</p>
        
	</div>
</body>
</html>