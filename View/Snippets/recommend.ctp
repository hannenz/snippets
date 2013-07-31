<div class="snippets recommend">
	<?php
	echo $this->Form->create('Snippet', array('action' => 'recommend'));
	echo $this->Form->input('snippet_id', array(
		'type' => 'hidden'
	));
	echo $this->Form->input('emails', array(
		'type' => 'select',
		'multiple' => true,
		'label' => 'Empfänger',
		'options' => $users
	));
	echo $this->Form->input('text', array(
		'label' => 'Text',
		'type' => 'textarea'
	));
	echo $this->Form->button('Empfehlung senden', array('class' => 'button'));
	echo $this->Form->end();
	?>
</div>