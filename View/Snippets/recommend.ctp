<div class="snippets recommend">
	<h2>Diesen Schnipsel weiterempfehlen</h2>
	<h3>&ldquo;<?php echo $snippet['Snippet']['title']; ?>&rdquo;</h3>
	<div class="row">
		<div class="large-4 columns">
			<?php echo $this->Html->image($snippet['Snippet']['image'], array('class' => 'thumb')); ?>
		</div>
		<div class="large-8 columns">
			<?php
			echo $this->Form->create('Snippet', array('action' => 'recommend'));
			echo $this->Form->input('id', array(
				'type' => 'hidden',
				'value' => $snippet['Snippet']['id']
			));
			echo $this->Form->input('emails', array(
				'type' => 'select',
				'multiple' => true,
				'label' => 'Empfänger',
				'options' => $users
			));
			echo $this->Form->input('comment', array(
				'label' => 'Kommentar',
				'type' => 'textarea'
			));
			echo $this->Form->button('<i class="icon-envelope"></i> Empfehlung senden', array('class' => 'secondary radius button'));
			echo $this->Form->end();
			?>
		</div>
	</div>
</div>