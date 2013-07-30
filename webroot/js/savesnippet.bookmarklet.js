(function(){

	// the minimum version of jQuery we want
	var v = "1.3.2";

	// check prior inclusion and version
	if (window.jQuery === undefined || window.jQuery.fn.jquery < v) {
		var done = false;
		var script = document.createElement("script");
		script.src = "http://ajax.googleapis.com/ajax/libs/jquery/" + v + "/jquery.min.js";
		script.onload = script.onreadystatechange = function(){
			if (!done && (!this.readyState || this.readyState == "loaded" || this.readyState == "complete")) {
				done = true;
				initMyBookmarklet();
			}
		};
		document.getElementsByTagName("head")[0].appendChild(script);
	} else {
		initSnippetsBookmarklet();
	}
	
	function initSnippetsBookmarklet() {
		(window.snippetsBookmarklet = function() {

			$('head').append('<link rel="stylesheet" type="text/css" href="http://'+domain+'/css/bookmarklet.css">');

			var $body = $('body');
			var $selector = $('<div id="snippets-bookmarklet-image-select" />');
			var $selectorHeading = $('<h4>Wähle ein Bild für diesen Schnipsel</h4>');
			var $selectorText = $('<p>Oder drücke &ldquo;Escape&rdquo; um abzubrechen</p>');

			$selector
				.append($selectorHeading)
				.append($selectorText)
			;

			var images = $body.find('img');
			images.each(function(i, el){
				var image = new Image();
				image.src = $(el).attr('src');

				image.onload = function(){

					if (image.height > 50 && image.width > 50){

						var $image = $(image);

						$.data($image, 'origWidth', image.width);
						$.data($image, 'origHeight', image.height);
						$image
						.addClass('snippets-bookmarklet-image')
						.appendTo($selector)
						.bind('click', _onImageSelected);
					}
				}
			});

			$selector.prependTo($body);

			$(document).bind('keyup', function(event){
				if (event.keyCode == 27){
					$selector.remove();
					$('#snippets-iframe').remove();
				}
			});

			function _onImageSelected(event){
				$selector.remove();
				var imageURL = $(this).attr('src');
				if (!imageURL.match(/^http/)){
					imageURL = window.location.href + imageURL;
				}
				var windowURL = 'http://' + domain + '/snippets/add?url=' + encodeURIComponent(window.location.href) + '&image=' + encodeURIComponent(imageURL) + '&title=' + encodeURI(document.title);

				window.open(windowURL, "Snippets", "width=400,height=700,scrollbars=yes");

			}
		})();
	}

})();
