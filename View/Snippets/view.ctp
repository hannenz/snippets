<div class="snippets view">
	<div class="row">
		<div class="large-4 columns">
			<?php if (!empty($snippet['Snippet']['image'])) echo $this->Html->image($snippet['Snippet']['image']); ?>
		</div>
		<div class="large-8 columns">
			<h3><?php echo $snippet['Snippet']['title']; ?></h3>
			<div class="snippet-description">
				<?php echo $snippet['Snippet']['description']; ?>
			</div>
			<div class="snippet-url">
				<?php echo $this->Html->link($snippet['Snippet']['url'], $snippet['Snippet']['url'], array('target' => '_blank'));?>
			</div>
			<div class="snippet-meta">
				<?php if (!empty($snippet['Snippet']['attachment'])):?>
					<div class="snippet-meta-attachment">
						Anhang: <?php echo $this->Html->link(basename($snippet['Snippet']['attachment']), $snippet['Snippet']['attachment']); ?>
					</div><br>
				<?php endif ; ?>
				Von <span class="snippet-meta-user"><?php echo $this->Html->link($snippet['User']['name'], array('action' => 'index', 'user_id' => $snippet['User']['id'])); ?></span> am 
				<span class="snippet-meta-date"><?php echo $this->Time->nice($snippet['Snippet']['created']);?></span><br>
				<div class="snippet-meta-tags">
					<?php
					foreach ($snippet['Tag'] as $tag){
						echo $this->Html->link($tag['name'], array('action' => 'index', 'tag_id' => $tag['id']), array('class' => 'secondary label'));
						echo " ";
					}
					?>
				</div>
			</div>
			<div class="snippet-actions">
				<ul class="radius button-group">
					<li><?php echo $this->Html->link('<i class="icon-share"></i> Empfehlen', array('action' => 'recommend', $snippet['Snippet']['id']), array('class' => 'secondary button', 'escape' => false));?></li>
					<?php if ($activeUser['User']['id'] == $snippet['Snippet']['user_id']):?>
						<li><?php echo $this->Html->link('<i class="icon-edit"></i> Bearbeiten', array('action' => 'edit', $snippet['Snippet']['id']), array('class' => 'secondary button', 'escape' => false)); ?></li>
						<li><?php echo $this->Form->postLink('<i class="icon-remove"></i> Löschen', array('action' => 'delete', $snippet['Snippet']['id']), array('class' => 'secondary button', 'escape' => false), 'Bist du sicher, dass du diesen Schnipsel löschen willst?'); ?></li>
					<?php endif ?>
					<?php if (!in_array($snippet['Snippet']['id'], Set::extract('/Favorite/id', $activeUser))): ?>
						<li><?php echo $this->Html->link('<i class="icon-star"></i> Favorisieren', array('action' => 'starr', $snippet['Snippet']['id']), array('class' => 'secondary button', 'escape' => false)); ?></li>
					<?php else: ?>
						<li><?php echo $this->Html->link('<i class="icon-star"></i> Entfavorisieren', array('action' => 'unstarr', $snippet['Snippet']['id']), array('class' => 'secondary button', 'escape' => false)); ?></li>
					<?php endif ?>
				</ul>
			</div>
			<?php echo $this->Html->link('<i class="icon-caret-left"></i> Zurück', array('action' => 'index'), array('class' => 'secondary radius button', 'escape' => false)); ?>
			<?php
			$user = $this->Session->read('Auth.User');
			$nComments = count($snippet['Comment']);
			?>
			<h4><?php echo ($nComments == 0) ? 'Noch keine' : $nComments; ?> Kommentare</h4>
			<?php if ($nComments > 0):?>
				<section class="snippet-comments">
					<?php foreach ($snippet['Comment'] as $comment):?>
						<hr>
						<article>
							<?php echo nl2br(h($comment['body'])); ?>
							<footer>
								<span class="comment-meta-user"><?php echo $comment['User']['name']; ?></span> am <span class="comment-meta-date"><?php echo $comment['created']; ?></span>
							</footer>
						</article>
					<?php endforeach ?>
				</section>
			<?php endif ?>
			<hr>
			<?php
			if ($user['id'] > 0){
				echo $this->Html->tag('h5', 'Kommentier diesen Schnippsel');
				echo $this->Form->create('Comment', array('action' => 'add'));
				echo $this->Form->input('snippet_id', array('type' => 'hidden', 'value' => $snippet['Snippet']['id']));
				echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));
				echo $this->Form->input('body');
				echo $this->Form->submit('Kommentar absenden', array('class' => 'secondary radius button'));
				echo $this->Form->end();
			}
			else {
				echo "Melde dich bitte an, um dieses Snippet kommentieren zu können: ".$this->Html->link('Login', array('controller' => 'users', 'action' => 'login'));
			}
			?>
		</div>
	</div>
</div>