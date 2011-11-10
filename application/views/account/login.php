<h1><?php echo __('Login'); ?></h1>
<?php if ($errors || $loginerrors) { ?>
	<p class="message">Some errors were encountered, please check the details you entered.</p>
	<p>
	<ul class="errors">
	<?php foreach ($errors as $message): ?>
	    <li><?php echo $message ?></li>
	<?php endforeach ?>
	<?php if(isset($loginerrors) && empty($errors)) { echo $loginerrors; } ?>
	</ul>
	</p>
<?php } else { ?>
<p>Please enter your login information below:</p>
<?php } ?>

<?php echo Form::open(); ?>
<dl>
    <dt><?php echo Form::label('username', 'Username or email') ?></dt>
    <dd><?php echo Form::input('username', $post['username']) ?></dd>
 
    <dt><?php echo Form::label('password', 'Password') ?></dt>
    <dd><?php echo Form::password('password') ?></dd>
    
    <dt><?php echo Form::label('remember', 'Remember my info') ?></dt>
    <dd><?php echo Form::checkbox('remember', NULL, ! empty($post['remember'])) ?></dd>
</dl>
<p><?php echo Form::submit(NULL, 'Login'); ?></p>
<?php echo Form::close(); ?>
<p><?php echo HTML::anchor('account/reset', 'Lost my log in information'); ?></p>
<p><?php echo HTML::anchor('account/create', 'Don\'t have an account?'); ?></p>
<p><?php echo HTML::anchor('account/help', 'Help'); ?></p>