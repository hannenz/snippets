<div class="snippets index">
	<div class="row">
		<div class="large-4 columns">
			<h4>Blackboard</h4>
		</div>
		<div class="large-8 columns">
			<?php if (!empty($filters)):?>
				<div class="active-filters">
				<span>Aktive Filter:</span>  
				<?php foreach ($filters as $filter){
					echo $this->Html->tag('span', $filter, array('class' => 'secondary label'));
				}
				?>
				</div>
			<?php endif ?>
		</div>
	</div>
	<ul class="snippets-list large-block-grid-3 small-block-grid-2">
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
					<h4><?php echo $this->Html->link($this->Text->truncate(($snippet['Snippet']['title']), 42, array('exact' => false)), array('controller' => 'snippets', 'action' => 'view', $snippet['Snippet']['id'])) ; ?></h4>

					<div class="snippet-meta">
						<?php if (!empty($snippet['Snippet']['attachment'])):?>
							<span class="snippet-meta-has-attachment">
								<?php echo $snippet['Snippet']['attachment']; ?>
							</span>
						<?php endif ; ?>
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
		<?php if ($this->Paginator->hasNext()):?>
			<li class="more-snippets">
				<div class="snippet">
					<?php
					echo $this->Paginator->next('Noch mehr Schnipsel anzeigen');
					?>
				</div>
			</li>
		<?php endif; ?>
	</ul>
</div>
