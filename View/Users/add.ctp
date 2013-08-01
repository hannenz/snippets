<div class="users add">
	<h2>Registrieren</h2>
	<div class="row">
		<div class="large-6 columns">
			<p>Herzlich Willkommen bei <em>Blackboard</em>, dem <em>Digitalen Schwarzen Brett</em></p>
			<p>Um selbst Schnipsel ans Brett heften zu können, musst du dich registrieren. Fülle dazu einfach das Formular aus und schon kannst du loslegen. Am besten du holst dir dann auch gleich das <?php echo $this->Html->link('<i class="icon-bookmark"></i> Bookmarklet', array('controller' => 'pages', 'action' => 'display', 'get_bookmarklet'), array('escape' => false)); ?> damit du unterwegs noch schneller und einfacher deine Fundstücke anheften kannst.</p>
			<p>Bei Fragen oder Problemen wende dich bitte per E-Mail an <?php echo $this->Html->link('j.braun@agentur-halma.de', 'mailto:j.braun@agentur-halma.de'); ?>.
			</div>
		<div class="large-6 columns">
			<?php echo $this->Form->create('User', array('action' => 'add'));
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
					'label' => 'Per E-Mail benachrichtigen, wenn neue Schnipsel am Schwarzen Brett gepostet werden',
					'checked' => true
				));
				echo $this->Form->input('notify_daily', array(
					'label' => 'Ein mal am Tag per E-Mail über alle neue Schnipsel am schwarzen Brett benachrichtigt werden',
					'checked' => true
				));
				echo $this->Form->button('Registrieren', array('type' => 'submit', 'class' => 'secondary radius button'));
				echo $this->Form->end();
			?>
		</div>
	</div>
</div>