<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<?php echo $this->Persona->meta() ?>
	<title><?php echo $title_for_layout; ?></title>
	<?php echo $this->Html->css('cake.generic');?>
</head>
<body>
	<div id="content">
		<?php echo $this->Session->flash(); ?>

		<div class="persona-controls">
			<button id="persona-sign-in">Sign-in</button>
			<button id="persona-sign-out">Sign-out</button>
		</div>

		<div class="persona-identity">
			<?php echo debug($this->Session->read('Persona.identity')) ?>
		</div>

		<?php echo $this->fetch('content'); ?>

	</div>

<!-- Include the Persona scripts -->
<?php echo $this->Persona->script() ?>
<?php echo $this->Html->script('/persona/js/persona') ?>
<script>
// Initialize the Persona
Persona.init(
	"<?php echo Router::url(array('controller' => 'users', 'action' => 'sign_in')) ?>",
	"<?php echo Router::url(array('controller' => 'users', 'action' => 'sign_out')) ?>",
	"<?php echo $this->Session->read('Persona.identity.email') ?>"
);

// Attach click to sign-in button
var signinLink = document.getElementById('persona-sign-in');
if (signinLink) {
	signinLink.onclick = function() {
		navigator.id.request();
	};
}

// Attach click to sign-out button
var signoutLink = document.getElementById('persona-sign-out');
if (signoutLink) {
	signoutLink.onclick = function() {
		navigator.id.logout();
	};
}
</script>

</body>
</html>
