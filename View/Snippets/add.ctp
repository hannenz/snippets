<div class="snippets form">
<?php echo $this->Form->create('Snippet', array('action' => 'add', 'type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('Add Snippet'); ?></legend>
	<?php
		echo $this->Form->input('user_id', array(
			'type' => 'hidden',
			'value' => $this->Session->read('Auth.User.id')
		));
		echo $this->Form->input('title');
		echo $this->Form->input('description');
		echo $this->Form->input('url');
		echo $this->Form->input('Tag');
		echo $this->Form->input('tags', array('type' => 'text'));
		echo $this->Form->input('image_upload', array('type' => 'file'));
		echo $this->Form->input('attachment_upload', array('type' => 'file'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Snippets'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tags'), array('controller' => 'tags', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tag'), array('controller' => 'tags', 'action' => 'add')); ?> </li>
	</ul>
</div>
