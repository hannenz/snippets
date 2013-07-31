Hallo <?php echo $user['User']['name']; ?>.

<p>Es gibt Neuigkeiten am schwarzen Brett:</p>

<p><?php echo $this->Html->link($snippet['Snippet']['title'], 'http://'.$_SERVER['SERVER_NAME'].'/snippets/view/'.$snippet['Snippet']['id']); ?></p>

