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
	<title><?php echo $title_for_layout; ?></title>

	<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array(
			'normalize.css',
			'font-awesome.min.css',
			'app.css',
		));
		echo $this->Html->script(array(
				'vendor/custom.modernizr.js',
		));
		echo $this->Html->script(array(
				'foundation/foundation.js',
				'foundation/foundation.topbar.js',
				'app.js'
			),
			array('block' => 'bottomscripts')
		);
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>

</head>
<body>
	<?php $userId = $this->Session->read('Auth.User.id');?>
	<div class="busy-overlay"></div>
	<div class="contain-to-grid sticky">
		<nav class="top-bar" data-options="is_hover:true; sticky:true">
			<ul class="title-area">
				<li class="name">
					<a href="/"><i class="icon-cut"></i>Blackboard</a>
				</li>
				<li class="toggle-topbar menu-icon"><a href="#"><span>Menü</span></a></li>
			</ul>
			<section class="top-bar-section">
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
					<li><?php echo $this->Html->link('About', array('controller' => 'pages', 'action' => 'display', 'about'));?></li>
					<?php if ($userId):?>
						<li class="has-dropdown">
							<?php echo $this->Html->link($activeUser['User']['name'], '#'); ?>
							<ul class="dropdown">
								<li><?php echo $this->Html->link('<i class="icon-user"></i> Mein Profil', array('controller' => 'users', 'action' => 'edit', $userId), array('escape' => false)); ?></li>
								<li><?php echo $this->Html->link('<i class="icon-power-off"></i> Abmelden', array('controller' => 'users', 'action' => 'logout'), array('escape' => false));?></li>
							</ul>
						</li>
					<?php else: ?>
						<li><?php echo $this->Html->link('Registrieren', array('controller' => 'users', 'action' => 'add')); ?></li>
						<li><?php echo $this->Html->link('Anmelden', array('controller' => 'users', 'action' => 'login')); ?></li>
					<?php endif ?>
				</ul>
			</section>
		</nav>
	</div>
	<div class="row">
		<div class="twelve columns">

			<div class="page">
				<div class="row">
					<div class="large-9 columns">
						<div class="content">
							<?php echo $this->Session->flash(); ?>
							<?php echo $this->fetch('content'); ?>
						</div>
					</div>
					<div class="large-3 columns sidebar">
						<?php if (!empty($tagcloudTags)):?>
						<aside>
							<h4>Tags</h4>
							 <?php echo $this->Tagcloud->word_cloud($tagcloudTags);?>
						</aside>
						<?php endif ?>
						<aside>
							<h4>Suche</h4>
							<form action="/snippets/index" method="post">
								<div class="row collapse">
									<div class="large-9 small-8 columns">
										<input type="search" name="data[Snippet][query]" />
									</div>
									<div class="large-3 small-4 columns">
										<button type="submit" class="prefix secondary button">Suche</button>
									</div>
								</div>
							</form>
						</aside>

							</form>
						<?php if ($userId && count($activeUser['Favorite']) > 0):?>
							<aside>
								<h4>Meine Favoriten</h4>
								<ul class="favorites">
								<?php foreach ($activeUser['Favorite'] as $fav):?>
									<li>
										<div class="row">
											<div class="large-3 small-3 columns">
												<?php echo $this->Html->image($fav['image']); ?>
											</div>
											<div class="large-9 small-9 columns">
												<?php echo $this->Html->link($fav['title'], array('controller' => 'snippets', 'action' => 'view', $fav['id'])); ?>
											</div>
										</div>
									</li>
								<?php endforeach ?>
								</ul>
							</aside>
						<?php endif ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<footer class="main-footer">
		<div class="row">
			<div class="large-12 columns">
				Blackboard &middot; &copy; 2012&thinsp;&ndash;&thinsp;2013 <?php echo $this->Html->link('Agentur Halma', 'http://agentur-halma.de'); ?> &middot; Built with CakePHP Version <?php echo Configure::version(); ?>
			</div>
		</div>
	</footer>
	<script>
	  document.write('<script src=/js/vendor/'
	    + ('__proto__' in {} ? 'zepto' : 'jquery')
	    + '.js><\/script>');
	</script>
	<?php
	echo $this->fetch('bottomscripts');
	?>
</body>
</html>
