<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>Snippets</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array(
			'foundation/stylesheets/foundation.min.css',
			'font-awesome.min.css',
			'app.css'
		));
		echo $this->Html->script(array(
				'http://code.jquery.com/jquery-1.10.2.min.js',
				'app.js'
			)
		);

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div class="busy-overlay"></div>
	<?php $userId = $this->Session->read('Auth.User.id');?>
	<div class="page row">
		<div class="xfixed">
			<nav class="top-bar">
				<ul>
					<li class="name">
						<a href="/"><i class="icon-cut"></i> Snippets</a>
					</li>
					<li class="toggle-topbar"><a href="#"></a></li>
				</ul>
				<section>
					<ul class="left">
						<li class="divider"></li>
						<?php if ($userId): ?>
							<li>
								<?php echo $this->Html->link('Meine Snippets', array('controller' => 'snippets', 'action' => 'index', 'user_id' => $userId)); ?>
							</li>
							<li>
								<?php echo $this->Html->link('<i class="icon-plus"></i> Neues Snippet', array('controller' => 'snippets', 'action' => 'add'), array('escape' => false));?>
							</li>
							<li>
								<?php echo $this->Html->link('<i class="icon-bookmark"></i> Bookmarklet', array('controller' => 'pages', 'action' => 'display', 'get_bookmarklet'), array('escape' => false)); ?>
							</li>
						<?php endif ?>
					</ul>
					<ul class="right">
						<li class="divider"></li>
						<?php if ($userId):?>
							<li class="has-dropdown">
								<?php echo $this->Html->link($this->Session->read('Auth.User.name'), '#'); ?>
								<ul class="dropdown">
									<li><?php echo $this->Html->link('Mein Profil', '#'); ?></li>
									<li><?php echo $this->Html->link('Abmelden', array('controller' => 'users', 'action' => 'logout'));?></li>
								</ul>
							</li>
						<?php else: ?>
							<li><?php echo $this->Html->link('Anmelden', array('controller' => 'users', 'action' => 'login')); ?></li>
						<?php endif ?>
					</ul>
				</section>
			</nav>
		</div>

		<header>
		</header>

		<div class="content">

			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<footer>
		</footer>
	</div>
	<?php #echo $this->element('sql_dump'); ?>
</body>
</html>
