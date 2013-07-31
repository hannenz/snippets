Hallo,

<p><?php echo $sender['User']['name']; ?> denkt, Du solltest Dir unbedingt folgenden Schipsel ansehen:</p>

<p><?php echo $this->Html->link($snippet['Snippet']['title'], 'http://'.$_SERVER['SERVER_NAME'].'/snippets/view/'.$snippet['Snippet']['id']); ?></p>

<p><?php echo $sender['User']['name']; ?> sagt:</p>

<p><?php echo nl2br($comment); ?></p>

