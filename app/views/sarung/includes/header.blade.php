<div id="page" class="hfeed site">

<header id="masthead" class="site-header" role="banner">    
    <nav class="navbar navbar-inverse" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-right"> 
                    <li><a href="<?php echo URL::to('/')?>/uang">Uang</a> </li>
                    <li><a href="<?php echo URL::to('/')?>">Sarung</a> </li>
                    <li><a href="#Login">Contact</a></li>
                </ul>
            </div>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand auto-height" href="<?php echo URL::to('/') ?>">
                    <img src="<?php echo URL::to('/')?>/asset/images/cropped-logo1.png" class="header-image" 
                    height="84" width="84" alt="" />
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse ">
                <ul class="nav navbar-nav navbar-right follow">
                    <li><a href="#about"><img src='http://placehold.it/450x65'   /></a></li>
                    <li>
                        <div>
                            <a href="#services"><img src="<?php echo URL::to('/') ?>/asset/images/follow_on_twitter.jpg"   /></a>
                            <a href="#contact"><img src="<?php echo URL::to('/') ?>/asset/images/follow-on-fb.jpg"   /></a>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
    </nav>
    <nav class="navbar navbar-default menu_pos" role="navigation">
		<div class="container">
			<div class="left" ><img   src="<?php echo URL::to('/') ?>/asset/images/menu-bg-left.png"></div>
            <div class="menu-primary-container">
				<ul id="menu-primary" class="nav navbar-nav ">
					<li id="menu-item-124" class="">
						<a href="http://localhost/wordpress/">Home</a>
					</li>
					<li id="menu-item-6" class="menu-item ">
						<a href="<?php echo URL::to('/')?>/santri">Santri</a>
					</li>
					<li id="menu-item-20" class="menu-item ">
						<a href="http://localhost/wordpress/category/indonesia/">Indonesia</a>
					</li>
					<li id="menu-item-21" class="menu-item">
						<a href="http://localhost/wordpress/category/usa/">Usa</a>
					</li>
					<li id="menu-item-22" class="menu-item">
						<a href="http://localhost/wordpress/category/restaurants/japanese/">Japanese</a>
					</li>
				</ul>
			</div>
			<div class="right" ><img  src="<?php echo URL::to('/') ?>/asset/images/menu-bg-right.png"></div>
        </div>
    </nav>
	
	<!--
    <nav class="navbar navbar-default menu_pos" role="navigation">
        <div class="container">
            <div class="left" ><img   src="<?php //echo URL::to('/') ?>/images/menu-bg-left.png" ></div>
            <?php //wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav navbar-nav ','depth'           => 0  ) ); ?>
            <div class="right" ><img  src="<?php //echo get_template_directory_uri(); ?>/images/menu-bg-right.png" ></div>
        </div>
    </nav
	--> 
</header><!-- #masthead -->	
