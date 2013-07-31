<?php
$domain = env('HTTP_HOST');
?>
<div>
	<h4><i class="icon-bookmark"></i> Bookmarklet</h4>
	<p>Um auf deinen Reisen, immer eine Schnipselschere dabei zu haben und interessante Links sofort ans Digitale Schwarze Brett heften zu können, gibt es dieses Bookmarklet. Es nistet sich einfach in deinen Lesezeichen ein und mit einem Klick darauf kannst du umgehend die aktuelle Seite ans Schwarze Brett heften</p>
	<p>
		Diesen Button in deine Lesezeichen-Symbolleiste ziehen 
		<br>
		<a class="secondary large radius button" href="javascript:domain='<?php echo $domain; ?>'; (function(){document.body.appendChild(document.createElement('script')).src='http://<?php echo $domain; ?>/js/savesnippet.bookmarklet.js';})();"><i class="icon-cut"></i> Schnipsel</a>
		<br>
		<small>Oder das Linkziel des Buttons als Lesezeichen ablegen</small>
	</p>
	<p><?php echo $this->Html->image('dragbookmarklet.png'); ?></p>
</div>
