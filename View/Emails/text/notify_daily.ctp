Hallo <?php echo $user['User']['name'];?>.

Schau dir an, was es alles neues am Digitalen Schwarzen Brett gibt:


<?php foreach ($snippets as $snippet): ?>

[<?php echo $snippet['Snippet']['title']; ?>](http://<?php echo $servername; ?>/snippets/view/<?php echo $snippet['Snippet']['id']; ?>)

<?php endforeach ?>

