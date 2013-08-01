<div class="snippets form">
	<h2>Neuen Schnipsel ans Brett posten</h2>
	<?php echo $this->Form->create('Snippet', array('action' => 'add', 'type' => 'file')); ?>
	<div class="row">
		<div class="three columns">
			<?php
			if (!empty($this->request->data['FromRemote']['image'])){
				echo $this->Html->image($this->request->data['FromRemote']['image']);
			}
			else if (!empty($this->request->data['FromRemote'])) {
				echo $this->Html->para(null, $this->Html->tag('em', '[ Kein Bild ]'));
			}
			?>
		</div>
		<div class="six columns">
				<?php
					echo $this->Form->input('title', array(
						'label' => 'Titel',
						'value' => !empty($this->request->data['FromRemote']['title']) ? $this->request->data['FromRemote']['title'] : ''
					));
					echo $this->Form->input('description', array(
						'label' => 'Beschreibung'
					));
					echo $this->Form->input('url', array(
						'label' => 'URL (Linkadresse)',
						'type' => 'text',
						'value' => !empty($this->request->data['FromRemote']['url']) ? $this->request->data['FromRemote']['url'] : ''
					));
				?>
		</div>
		<div class="three columns">
				<?php
					if (!empty($this->request->data['FromRemote']['image'])){
						echo $this->Form->input('image', array(
							'type' => 'hidden',
							'value' => $this->request->data['FromRemote']['image']
						));
						echo $this->Form->input('fetch_remote', array(
							'type' => 'hidden',
							'value' => 1
						));
					}
					else {
						echo $this->Form->input('image_upload', array('type' => 'file'));
						echo $this->Form->input('attachment_upload', array('type' => 'file'));
					}
					echo $this->Form->input('Tag', array(
						'label' => 'Aus vorhandenden Tags auswählen (Mehrfachauswahl mit gedrückter STRG-Taste möglich)'
					));
					echo $this->Form->input('tags', array(
						'type' => 'text',
						'label' => 'oder neue(n) Tag(s) eingeben (mehrere Tags mit Leerzeichen trennen)'
					));
				?>
				<button class="secondary radius button" type="submit">Schnipseln</button>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
</div>
