<h1><?php echo __('Create an account'); ?></h1>

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

<?php echo Form::open(NULL, array('id' => 'create', 'autocomplete' => 'off')); ?>
<fieldset>
	<dl>
		<dt>
			
		<?php echo Form::label('email', 'Email') ?></dt>
		<dd>
			
		<?php echo Form::input('email', $post['email'], array('id' => 'focus')) ?></dd>
		<dt>
			
		<?php echo Form::label('username', 'Username') ?></dt>
		<dd>
			
		<?php echo Form::input('username', $post['username'], array('id' => 'username', 'MAXLENGTH' => 12)) ?></dd>
		<div id="status"></div>
		<dt>
			
		<?php echo Form::label('password', 'Password') ?></dt>
		<dd>
			
		<?php echo Form::password('password', $post['password'], array('id' => 'password')) ?></dd>
	</dl>
	<input type="submit" name="Create">
</fieldset>

<?php echo Form::close(); ?>

<script>
var keyinterval;
var available = 0;

function checkavailability() {
	clearInterval(keyinterval);
	$("#status").html('<img align="absmiddle" src="<?php echo URL::base(); ?>assets/images/account/loader.gif" /> Checking availability...');
	$.ajax({
		type: "POST",
		url: "checkusername",
		data: "username=" + $("#username").val(),
		cache: false,
		async: true,
		dataType: "json",
		success: function(resultArray, textStatus, XMLHttpRequest)
		{
			if(resultArray['available']) {
				available = 1;
				$("#status").show();
				$("#status").html('<img align="absmiddle" src="<?php echo URL::base(); ?>assets/images/account/accepted.png" /> Available!');
			} else {
				available = 0;
				$("#status").show();
				$("#status").html('<img align="absmiddle" src="<?php echo URL::base(); ?>assets/images/account/notaccepted.png" /> Not available...');
			}
		},
		error: function(request, textStatus, errorThrown)
		{
			alert('error');
		}
	});
}

$(document).ready(function () {

	// focus email
	$("#focus").focus();

	// validation
	$('#username').alphanumeric();
	
	// disable submit on submit
	$('form').submit(function(){
	    $('input[type=submit]', this).attr('disabled', 'disabled');
	});
	
	// check user availability
	$('#username').keyup(function() {
		var usr = $("#username").val();
		var pwd = $("#password").val();

		if(usr.length >= 1 && usr == pwd) {
			clearInterval(keyinterval);
			$("#status").show();
			$("#status").html('<img align="absmiddle" src="<?php echo URL::base(); ?>assets/images/account/notaccepted.png" /> Username cannot be the same as password');
		} else {
			if(usr.length >= 3) {
					clearInterval(keyinterval);
					keyinterval = setInterval( "checkavailability()", 1000);
			} else {
				$("#status").hide();
			}
		}
	});

	$("#username").change(function() {
		var usr = $("#username").val();
		if(usr.length < 3) {
			$("#status").show();
			$("#status").html('The username should have at least 3 characters.');
		} else if(available) {
			$("#status").hide();
		}
	});


	$('#password').keyup(function() {
		var usr = $("#username").val();
		var pwd = $("#password").val();

		if(usr == pwd) {
			$("#status").show();
			$(".password_strength").html('<img align="absmiddle" src="<?php echo URL::base(); ?>assets/images/account/notaccepted.png" /> Password cannot be the same as username');
		}
	});
	
	$('#password').password_strength({'texts' : {
		1 : 'Too weak',
		2 : 'Weak password',
		3 : 'Normal strength',
		4 : 'Strong password',
		5 : 'Very strong password'
		},
	});
	
});
</script>