<?php
$userId = $this->Session->read('Auth.User.id');
$domain = env('HTTP_HOST');
?>
<?php if ($userId):?>
	<div>
		<h4>Bookmarklet</h4>
		<p>Um auf deinen Reisen, immer eine Schnipselschere dabei zu haben und interessante Links sofort schnipseln zu können, gibt es ein Bookmarklet. Dieses nistet sich einfach in deinen Lesezeichen ein und mit einem Klick darauf kannst du umgehend die aktuelle Seite schnipseln</p>
		<p>
			Diesen Button in deine Lesezeichen-Symbolleiste ziehen 
			<a class="primary radius button" href="javascript:domain='<?php echo $domain; ?>'; (function(){document.body.appendChild(document.createElement('script')).src='http://<?php echo $domain; ?>/js/savesnippet.bookmarklet.js';})();">Schnipsel</a>
			<br>
			<small>Oder das Linkziel des Buttons als Lesezeichen ablegen</small>
		</p>

	</div>
<?php endif ?>
