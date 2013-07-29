<div class="snippets view">
	<div class="row">
		<div class="four columns">
			<?php if (!empty($snippet['Snippet']['image'])) echo $this->Html->image($snippet['Snippet']['image']); ?>
		</div>
		<div class="eight columns">
			<h3><?php echo $snippet['Snippet']['title']; ?></h3>
			<div class="snippet-description">
				<?php echo $snippet['Snippet']['description']; ?>
			</div>
			<div class="snippet-url">
				<?php echo $this->Html->link($snippet['Snippet']['url'], $snippet['Snippet']['url'], array('target' => '_blank'));?>
			</div>
			<div class="snippet-meta">
				<span class="snippet-meta-user"><?php echo $snippet['User']['name']; ?></span><br>
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
				<ul class="button-group">
					<li><?php echo $this->Html->link('<i class="icon-share"></i> Empfehlen', array('action' => 'recommend', $snippet['Snippet']['id']), array('class' => 'button', 'escape' => false));?></li>
					<li><?php echo $this->Html->link('<i class="icon-edit"></i> Bearbeiten', array('action' => 'edit', $snippet['Snippet']['id']), array('class' => 'button', 'escape' => false)); ?></li>
					<li><?php echo $this->Form->postLink('<i class="icon-remove"></i> Löschen', array('action' => 'delete', $snippet['Snippet']['id']), array('class' => 'button', 'escape' => false), 'Bist du sicher, dass du diesen Schnipsel löschen willst?'); ?></li>
				</ul>
			</div>
			<?php
			$user = $this->Session->read('Auth.User');
			$nComments = count($snippet['Comment']);
			?>
			<h4><?php echo $nComments; ?> Kommentare</h4>
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
				echo $this->Form->submit('Kommentar absenden', array('class' => 'primary button'));
				echo $this->Form->end();
			}
			else {
				echo "Melde dich bitte an, um dieses Snippet kommentieren zu können: ".$this->Html->link('Login', array('controller' => 'users', 'action' => 'login'));
			}
			?>
		</div>
	</div>
</div>