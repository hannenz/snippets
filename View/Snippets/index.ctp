<div class="snippets index">
	<?php if (!empty($filters)):?>
	<ul class="active-filters">
		<?php foreach ($filters as $filter){
			echo $this->Html->tag('li', 
				$this->Html->tag('span', $filter, array('class' => 'secondary label'))
			);
		}
		?>
	</ul>
	<?php endif ?>
	<ul class="snippets-list block-grid four-up">
		<?php foreach ($snippets as $snippet): ?>
			<li>
				<div class="snippet">
					<div class="snippet-img-wrap">
						<?php
						if (!empty($snippet['Snippet']['image'])){
							echo $this->Html->image($snippet['Snippet']['image'], array('url' => array('action' => 'view', $snippet['Snippet']['id'])));;
						}
						?>
					</div>
					<h4><?php echo $this->Html->link($this->Text->truncate(($snippet['Snippet']['title']), 24), array('controller' => 'snippets', 'action' => 'view', $snippet['Snippet']['id'])) ; ?></h4>

					<div class="snippet-meta">
						<span class="snippet-meta-user"><?php echo $this->Html->link($snippet['User']['name'], array('controller' => 'snippets', 'action' => 'index', 'user_id' => $snippet['User']['id'])); ?></span><br>
						<span class="snippet-meta-date"><?php echo $this->Time->niceShort($snippet['Snippet']['created']); ?></span><br>
						<span class="snippet-meta-n-comments"><?php echo count($snippet['Comment']); ?> Kommentare</span>
						<br>
						<div class="snippet-meta-tags">
							<?php foreach ($snippet['Tag'] as $tag){
								echo $this->Html->link($tag['name'], array('controller' => 'snippets', 'action' => 'index', 'tag_id' => $tag['id']), array('class' => 'secondary tiny label snippet-meta-tag'));
								echo " ";
							}
							?>
						</div>

					</div>
				</div>
			</li>
		<?php endforeach ?>

	</ul>
	<?php echo $this->Paginator->next('Weitere Snippets', array('class' => 'paginator-next secondary button')); ?>
</div>
