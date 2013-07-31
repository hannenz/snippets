<div class="users login">
	<div class="row">
		<h2>Blackboard Login</h2>
		<div class="large-6 columns">
			<?php
			echo $this->Session->flash('auth');
			echo $this->Form->create('User', array('action' => 'login'));
			echo $this->Form->input('email', array(
				'label' => 'E-Mail Adresse'
			));
			echo $this->Form->input('password', array(
				'label' => 'Passwort'
			));
			echo $this->Form->input('rememberme', array(
				'type' => 'checkbox',
				'label' => 'An mich erinnern'
			));
			echo $this->Form->button('Anmelden', array(
				'type' => 'submit',
				'class' => 'secondary radius button'
			));
			echo $this->Form->end();
			?>
		</div>
	</div>
</div>