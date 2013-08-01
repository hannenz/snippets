<div class="row">
	<div class="large-3 small-3 columns">
		<?php if (!empty($_snippet['image'])) echo $this->Html->image($_snippet['image']); ?>
	</div>
	<div class="large-9 small-9 columns">
		<?php echo $this->Html->link($_snippet['title'], array('controller' => 'snippets', 'action' => 'view', $_snippet['id'])); ?>
	</div>
</div>
