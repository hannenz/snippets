Hallo <?php echo $comment['Snippet']['User']['name']; ?>.

<p><?php echo $comment['User']['name']; ?> hat deinen Schnipsel "<?php echo $this->Html->link($comment['Snippet']['title'], 'http://'.env('SERVER_NAME').'/snippets/view/'.$comment['Snippet']['id']); ?> kommentiert:</p>

<p><?php echo nl2br($comment['Comment']['body']); ?></p>

