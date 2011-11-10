<h1><?php echo __('Reset'); ?></h1>

<?php if(!isset($sent)) { ?>
	<?php if ($errors) { ?>
		<p class="message">Some errors were encountered, please check the details you entered.</p>
		<p>
		<ul class="errors">
		<?php foreach ($errors as $message): ?>
			<li><?php echo $message ?></li>
		<?php endforeach ?>
		</ul>
		</p>
	<?php } ?>
	<div class="block">
	   <h1><?php echo __('Forgot password or username'); ?></h1>
	   <div class="content">
	      <p><?php echo __('Please send me a link to reset my password.'); ?></p>
	<?php
	echo Form::open();
	echo '<p>'.__('Your email address:').' '.Form::input('email', $post['email']).'</p>';
	?>
	<?php
	echo Form::submit(NULL, __('Reset password'));
	echo Form::close();
	?>
	   </div>
	</div>
<?php } else { ?>
	Check your email
<?php } ?>
