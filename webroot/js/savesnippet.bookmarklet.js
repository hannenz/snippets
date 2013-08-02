/**
 * savesnippet.bookmarklet.js
 *
 * Implements code that is loaded and executed when clicking on the bookmarklet.
 * Loads jQuery and a stylesheet, then searches for all images on the page and
 * if found some presents the user with a selection dialog.
 * Then calls the normal applications snippets/add action in a new window (with
 * some special parameters passed to distinguish it from the "normal" add action)
 *
 * @author Johannes Braun <j.braun@agentur-halma.de>
 * @package snippets
*/
console.log('BOOKmarkLET');
(function(){

	// the minimum version of jQuery we want
	var v = "1.3.2";

	// check prior inclusion and version
	if (window.jQuery === undefined || window.jQuery.fn.jquery < v) {
		console.log('No jquery, trying to load it...');
		var done = false;
		var script = document.createElement("script");
		script.src = 'http://ajax.googleapis.com/ajax/libs/jquery/' + v + '/jquery.min.js';
		script.onload = script.onreadystatechange = function(){
			console.log('script has been loaded');
			if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) {
				done = true;
				console.log('No initializing bookmarklet main code');
				initSnippetsBookmarklet();
			}
		};
		document.getElementsByTagName('head')[0].appendChild(script);
	}
	else {
		initSnippetsBookmarklet();
	}
	
	function initSnippetsBookmarklet() {
		console.log('..');
		(window.snippetsBookmarklet = function() {
			console.log('...');


			/* Since we jump directly into a completly alien environment, we don't know what other scripts
			   are there... */
			var $ = jQuery.noConflict();

			// Check if we haVE already a running instance (Selector element poresent in DOM?)
			if ($('#snippets-bookmarklet-image-select').length > 0){
				alert ('Es läuft bereits eine Instanz des Bookmarklets auf dieser Seite. Vielleicht solltest du die Seite neu laden (F5)');
				return;
			}
			$('head').append('<link rel="stylesheet" type="text/css" href="http://'+domain+'/css/bookmarklet.css">');

			var $body = $('body');


			/* We can't load markup due t osame origin policy */
			var $selector = $('<div id="snippets-bookmarklet-image-select" />');
			var $selectorHeading = $('<h4>W&auml;hle ein Bild f&uuml;r diesen Schnipsel</h4>');
			var $noImageLink = $('<p><a href="#">Oder hier klicken um ohne Bild fortzufahren</a></p>');
			var $selectorText = $('<p>Oder dr&uuml;cke &ldquo;Escape&rdquo; um abzubrechen</p>');

			$selector
				.append($selectorHeading)
				.append($noImageLink)
				.append($selectorText)
			;
			var images = getallBgimages();
			var $images = $body.find('img');

			$images.each(function(i, el){
				var $el = $(el);
				images.push($el[0].src);
			});

			var n = images.length;
			var count = 0;

			$(images).each(function(i, el){

				var image = new Image();
				image.src = el

				image.onload = function(){

					if (image.height > 50 && image.width > 50){

						var $image = $(image);
						$image
							.addClass('snippets-bookmarklet-image')
							.appendTo($selector)
							.bind('click', _onImageSelected)
						;
						count++;
					}
					console.log(n);
					if (--n == 0){
						// Has the last image been loaded? Then show selector
						console.log('Showing selector');
						_showSelector();
					}
				}
				// Handle error and abort as well to keep the counter updated
				image.onerror = image.onabort = function(){
					if (--n == 0){
						_showSelector();
					}
				}
			});

			// Show selector after 5 seconds regardless if all images have been loaded
			setTimeout(_showSelector, 5000);

			function _showSelector(){
				// No images found? Proceed...
				if (count == 0){
					_onNoImageSelected();
					return;
				}
				$noImageLink.bind('click', _onNoImageSelected);
				$selector.prependTo($body);

				$(document).bind('keyup', function(event){
					if (event.keyCode == 27){
						$selector.remove();
						$('#snippets-iframe').remove();
					}
				});
			}

			function _onImageSelected(event){
				$selector.remove();
				var imageURL = $(this).attr('src');
				if (!imageURL.match(/^http/)){
					imageURL = window.location.href + imageURL;
				}
				var windowURL = 'http://' + domain + '/snippets/add?url=' + encodeURIComponent(window.location.href) + '&image=' + encodeURIComponent(imageURL) + '&title=' + encodeURI(document.title);

				window.open(windowURL, 'Blackboard - neuer Schnipsel', 'width=480,height=880,scrollbars=yes,resizable=yes,toolbar=no,titlebar=no,location=no');
			}

			function _onNoImageSelected(event){
				$selector.remove();
				var windowURL = 'http://' + domain + '/snippets/add?url=' + encodeURIComponent(window.location.href) + '&title=' + encodeURI(document.title);
				window.open(windowURL, 'Blackboard - neuer Schnipsel', 'width=480,height=880,scrollbars=yes,resizable=yes,toolbar=no,titlebar=no,location=no');
			}
		})();
	}
})();


function getallBgimages(){
	var url, B= [], A= document.getElementsByTagName('*');
	A= B.slice.call(A, 0, A.length);
	while(A.length){
		url= deepCss(A.shift(),'background-image');
		if(url) url=/url\(['"]?([^")]+)/.exec(url) || [];
		url= url[1];
		if(url && B.indexOf(url)== -1) B[B.length]= url;
	}
	return B;
}

function deepCss(who, css){
	if(!who || !who.style) return '';
	var sty= css.replace(/\-([a-z])/g, function(a, b){
		return b.toUpperCase();
	});
	if(who.currentStyle){
		return who.style[sty] || who.currentStyle[sty] || '';
	}
	var dv= document.defaultView || window;
	return who.style[sty] || 
	dv.getComputedStyle(who,"").getPropertyValue(css) || '';
}

Array.prototype.indexOf = Array.prototype.indexOf || 
	function(what, index){
		index= index || 0;
		var L= this.length;
		while(index< L){
			if(this[index]=== what) return index;
			++index;
		}
		return -1;
	}
