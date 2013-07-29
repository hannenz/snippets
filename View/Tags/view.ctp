<div class="tags view">
<h2><?php  echo __('Tag'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($tag['Tag']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($tag['Tag']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Tag'), array('action' => 'edit', $tag['Tag']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Tag'), array('action' => 'delete', $tag['Tag']['id']), null, __('Are you sure you want to delete # %s?', $tag['Tag']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Tags'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tag'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Snippets'), array('controller' => 'snippets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Snippet'), array('controller' => 'snippets', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Snippets'); ?></h3>
	<?php if (!empty($tag['Snippet'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Url'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($tag['Snippet'] as $snippet): ?>
		<tr>
			<td><?php echo $snippet['id']; ?></td>
			<td><?php echo $snippet['created']; ?></td>
			<td><?php echo $snippet['modified']; ?></td>
			<td><?php echo $snippet['user_id']; ?></td>
			<td><?php echo $snippet['title']; ?></td>
			<td><?php echo $snippet['description']; ?></td>
			<td><?php echo $snippet['url']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'snippets', 'action' => 'view', $snippet['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'snippets', 'action' => 'edit', $snippet['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'snippets', 'action' => 'delete', $snippet['id']), null, __('Are you sure you want to delete # %s?', $snippet['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Snippet'), array('controller' => 'snippets', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
