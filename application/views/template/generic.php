<!DOCTYPE HTML>
<html lang="<?php echo substr(I18n::$lang, 0, 2); ?>"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta name="description" content="A short phrase that describes the content of the page" />
<meta name="keywords" content="list of words, separated by, comma" />
<meta name="abstract" content="Short description of page" />
<link rel="shortcut icon" type="image/x-icon" href="<?php echo URL::base(); ?>favicon.ico">
<link rel="apple-touch-icon" href="<?php echo URL::base(); ?>touch-icon-iphone.png" />
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo URL::base(); ?>touch-icon-ipad.png" />
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo URL::base(); ?>touch-icon-iphone4.png" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<title><?php echo $title ?></title>
<?php foreach ($styles as $file => $type) echo HTML::style($file, array('media' => $type)), PHP_EOL ?>
<?php foreach ($scripts as $file) echo HTML::script($file), PHP_EOL ?>
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js">IE7_PNG_SUFFIX=".png";</script>
<![endif]-->
</head>
<body>
<div id="content">
<div id="header">
<?php include Kohana::find_file('views', 'header'); ?>
</div>
<?php echo $content ?>
</div>
<?php echo View::factory('profiler/stats') ?>
</body>
</html>