<h1><?php echo __('Reset - step 2'); ?></h1>

<?php if($found) { ?>
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
	
	<?php
	echo Form::open();
	echo '<p>'.__('New password:').' '.Form::password('password', $post['password']).'</p>';
	echo Form::hidden('username', $user->username);
	echo Form::hidden('token', $_GET['token']);
	echo Form::hidden('email', $_GET['email']);
	echo Form::submit(NULL, __('Set new password'));
	echo Form::close();
	?>
<?php } else { ?>
	Link inactive
<?php } ?>
