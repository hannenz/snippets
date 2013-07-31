Hallo <?php echo $user['User']['name']; ?>.

Es gibt Neuigkeiten am Schwarzen Brett:

[<?php echo $snippet['Snippet']['title']; ?>](http://<?php echo $_SERVER['SERVER_NAME']; ?>/snippets/view/<?php echo $snippet['Snippet']['id']; ?>)

