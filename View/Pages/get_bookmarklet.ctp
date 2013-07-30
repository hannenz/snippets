<?php
$userId = $this->Session->read('Auth.User.id');
$domain = env('HTTP_HOST');
?>
<?php if ($userId):?>
	<div>
		Den nachfolgenden Link als Lesezeichen ablegen: 
		<a class="primary radius button" href="javascript:domain='<?php echo $domain; ?>'; (function(){document.body.appendChild(document.createElement('script')).src='http://<?php echo $domain; ?>/js/savesnippet.bookmarklet.js';})();">Save Snippet</a>
	</div>
<?php endif ?>
