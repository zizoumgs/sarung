		<div class="navbar navbar-default navbar-default-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<div class="page-header ">
						<h1>Fatihul Ulum Manggisan</h1>
						<p class="lead bold-font"><span class="glyphicon glyphicon-flash"></span>Forgotten boarding school.</p>
					</div> 			
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="{{ root::get_url_home() }}">Home</a></li>
						<li>
                            <a href="{{ root::get_url_klasement() }}">Table</a>
                            <ul class="child-menu">
                                <li><a href="{{ root::get_url_score() }}">Score</a></li>
                                <li><a href="{{ root::get_url_klasement() }}">Klasement</a></li>
                            </ul>
                        </li>
						<li>
			                <a href="{{ root::get_url_uang() }}">Uang</a>
								<ul class="child-menu">
									<li>	<a href="{{ root::get_url_uang() }}/income">Income</a></li>
									<li>	<a href="{{ root::get_url_uang() }}/outcome">Outcome</a></li>
									<li>	<a href="{{ root::get_url_uang() }}">Total	</a></li>                    
								</ul>
						</li>
						<li><a href="#">Contact</a></li>
						@if ( ! Auth::check() )
							<li><a href="{{root::get_url_admind()}}">Login</a></li>
						@else
							@if( root::get_user_power() >= 10 )
								<li><a href="{{root::get_url_admind()}}" rel="no">Dashboard</a></li>
							@endif
							<li><a href="{{root::get_url_logout()}}">Logout</a></li>
						@endif
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>