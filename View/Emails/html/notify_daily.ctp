Hallo <?php echo $user['User']['name']; ?>.

<p>Schau dir an, was es alles neues am Digitalen Schwarzen Brett gibt:</p>

<?php foreach ($snippets as $snippet): ?>
	<p><?php echo $this->Html->link($snippet['Snippet']['title'], 'http://'.$servername.'/snippets/view/'.$snippet['Snippet']['id']); ?></p>
<?php endforeach ?>

