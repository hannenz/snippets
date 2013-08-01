Hallo <?php echo $comment['Snippet']['User']['name']; ?>.

<?php echo $comment['User']['name']; ?> hat deinen Schnipsel [<?php echo $comment['Snippet']['title']; ?>](http://<?php echo env('SERVER_NAME'); ?>/snippets/view/<?php echo $comment['Snippet']['id']; ?>) kommentiert:

<?php echo nl2br($comment['Comment']['body']); ?>

