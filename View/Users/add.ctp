<div class="users add">
	<?php
	echo $this->Form->create('User', array('action' => 'add'));
	echo $this->Form->input('email');
	echo $this->Form->input('password');
	echo $this->Form->input('password_confirm', array(
		'type' => 'password',
		'label' => 'Passwort bestätigen'
	));
	echo $this->Form->end('Speichern');
	?>
</div>
