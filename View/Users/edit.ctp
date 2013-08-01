<div class="users form">
	<div class="row">
		<div class="large-6">
			<h2>Profil bearbeiten</h2>
			<?php echo $this->Form->create('User', array('action' => 'edit'));
				echo $this->Form->input('id');
				echo $this->Form->input('name', array(
					'label' => 'Name',
					'error' => 'Bitte gib deinen Namen ein'
				));
				echo $this->Form->input('email', array(
					'label' => 'E-Mail Adresse',
					'error' => array(
						'valid' => 'Bitte gib eine gültige E-Mail-Adresse ein',
						'notEmpty' => 'Bitte gib deine E-Mail Adresse ein',
						'unique' => 'Jemand hat sich bereits mit dieser E-Mail Adresse registriert'
					),
					''
				));
				echo $this->Form->input('password', array(
					'label' => 'Passwort (mind. 6 Zeichen)',
					'error' => array(
						'notEmpty' => 'Bitte gib ein Passwort ein',
						'valid' => 'Das Passwort muss aus mindestens sechs Zeichen bestehen',
						'match' => 'Die eingegebenen Passwörter stimmen nicht überein'
					),
					'value' => '',
					'autocomplete' => 'off'
				));
				echo $this->Form->input('password_confirm', array(
					'type' => 'password',
					'label' => 'Passwort wiederholen',
					'error' => array(
						'match' => 'Die eingegebenen Passwörter stimmen nicht überein'
					),
					'value' => ''
				));
				echo $this->Form->input('notify_on_new_snippet', array(
					'label' => 'Per E-Mail benachrichtigen, wenn neue Schnipsel am Schwarzen Brett gepostet werden'
				));
				echo $this->Form->input('notify_daily', array(
					'label' => 'Ein mal am Tag per E-Mail über alle neue Schnipsel am schwarzen Brett benachrichtigt werden'
				));
				echo $this->Form->input('notify_on_comments', array(
					'label' => 'Über neue Kommentare zu meinen Schnipseln per E-Mail informieren'
				));
				echo $this->Form->button('Speichern', array('type' => 'submit', 'class' => 'secondary radius button'));
				echo $this->Form->end();
			?>
		</div>
	</div>
</div>