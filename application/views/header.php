<header>
	<h1><?php echo Request::current()->uri() != "/" ? HTML::anchor('', __('KOHANA 3.2 EXAMPLE')) : __('KOHANA 3.2 EXAMPLE'); ?></h1>
	
	<ul id="menu">
		<li><?php echo Request::current()->uri() != "about" ? HTML::anchor('about', __('ABOUT')) : __('ABOUT'); ?></li>
		<li><?php echo Request::current()->uri() != "faq" ? HTML::anchor('faq', __('FAQ')) : __('FAQ'); ?></li>
	</ul>
	
	<ul id="log">
	<?php if(isset($loged)) { ?>
			<li><?php echo Request::current()->uri() != "dashboard" ? HTML::anchor('dashboard', Auth::instance()->get_user()->username) : Auth::instance()->get_user()->username; ?> <?php echo HTML::anchor('dashboard/logout', __('Logout')); ?></li>
	<?php } else { ?>
			<li><?php echo Request::current()->uri() != "account/login" ? HTML::anchor('account/login', __('Login')) : __('Login'); ?></li><li><?php echo Request::current()->uri() != "account/create" ? HTML::anchor('account/create', __('Create an account')) : __('Create an account'); ?></li>
	<?php } ?>
	</ul>
	
	<ul id="lang">
	<?php foreach(Kohana::$config->load('ko32example.language') as $lg) { ?>
		<li><?php echo HTML::anchor('home/language/' . $lg, __($lg)); ?></li>
	<?php } ?>
	</ul>

</header>