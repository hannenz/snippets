<div class="snippets form">
	<h2>Schnipsel bearbeiten</h2>
	<?php echo $this->Form->create('Snippet', array('type' => 'file')); ?>
	<div class="row">
		<div class="large-3 columns">
			<?php
			if (!empty($this->request->data['Snippet']['image'])){
				echo $this->Html->image($this->request->data['Snippet']['image']);
				echo $this->Html->link('<i class="icon-remove"></i> Bild entfernen', array('action' => 'remove_file', $this->request->data['Snippet']['id'], 'image'), array('class' => 'small button', 'escape' => false));
			}
			else {
				echo $this->Html->tag('label', 'Bild hochladen');
				echo $this->Form->input('image_upload', array('type' => 'file'));
			}
			?>
		</div>
		<div class="large-6 columns">
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
			if (!empty($this->request->data['Snippet']['attachment'])){
				echo $this->Html->para(null, basename($this->request->data['Snippet']['attachment']));
				echo $this->Html->link('<i class="icon-remove"></i> Anhang entfernen', array('action' => 'remove_file', $this->request->data['Snippet']['id'], 'attachment'), array('class' => 'small button', 'escape' => false));
			}
			else {
				echo $this->Html->tag('label', 'Anhang hochladen');
				echo $this->Form->input('attachment_upload', array('type' => 'file'));			}
			?>
		</div>
		<div class="large-3 columns">
			<?php
			echo $this->Form->input('Tag', array(
				'label' => 'Tags (aus bestehenden Tags auswählen)'
			));
			echo $this->Form->input('tags', array(
				'type' => 'text',
				'label' => 'Oder neue Tags eingeben (mehrere durch Leerzeichen getrennt)'
			));
			?>
			<button class="secondary radius button" type="submit">Speichern</button>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
</div>