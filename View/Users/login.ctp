<div class="users login">
	<div class="row">
		<div class="six columns centered">
			<?php
			echo $this->Session->flash('auth');
			echo $this->Form->create('User', array('action' => 'login'));
			echo $this->Form->input('email', array(
				'label' => 'E-Mail Adresse'
			));
			echo $this->Form->input('password', array(
				'label' => 'Passwort'
			));
			echo $this->Form->button('Anmelden', array(
				'type' => 'submit',
				'class' => 'button'
			));
			echo $this->Form->end();
			?>
		</div>
	</div>
</div>