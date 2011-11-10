<h1><?php echo __('Dashboard'); ?></h1>
<?php if(Session::instance()->get_once('success_pwd')) { echo "<p><span id=\"success\">Success</span></p>"; } ?>