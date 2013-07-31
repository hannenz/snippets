<div class="snippets form">
	<?php echo $this->Form->create('Snippet'); ?>
	<div class="row">
		<div class="three columns">
			<?php echo $this->Html->image($this->request->data['Snippet']['image']); ?>
		</div>
		<div class="six columns">
			<?php
			echo $this->Form->input('id');
			echo $this->Form->input('user_id', array(
				'type' => 'hidden'
			));
			echo $this->Form->input('title', array(
				'label' => 'Titel'
			));
			echo $this->Form->input('description', array(
				'label' => 'Beschreibung'
			));
			echo $this->Form->input('url', array(
				'label' => 'URL'
			));
			?>
		</div>
		<div class="three columns">
			<?php
			echo $this->Form->input('Tag', array(
				'label' => 'Tags (aus bestehenden Tags auswählen)'
			));
			echo $this->Form->input('tags', array(
				'type' => 'text',
				'label' => 'Oder neue Tags eingeben (mehrere durch Leerzeichen getrennt)'
			));
			?>
			<button class="button" type="submit">Speichern</button>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
</div>