(function(){

	// the minimum version of jQuery we want
	var v = "1.9.0";

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
		initMyBookmarklet();
	}
	
	function initMyBookmarklet() {
		(window.myBookmarklet = function() {

			var $selector = $('<div style="width:100%;position:fixed;top:0;left:0;border-bottom:2px solid #ccc; padding:10px;z-index:32767;background:#fff" />');
			var $body = $('body');


			var images = $body.find('img');
			images.each(function(i, el){
				var image = new Image();
				image.src = $(el).attr('src');

				image.onload = function(){
					console.log(image.width + 'x' + image.height);

					if (image.height > 50 && image.width > 50){

						var $image = $(image);

						$.data($image, 'origWidth', image.width);
						$.data($image, 'origHeight', image.height);
						$image
						.css({
							'height': 100,
							'cursor': 'pointer',
							'outline': '1px dashed #ccc'
						})
						.appendTo($selector)
						.bind('click', function(event){

							$selector.remove();

							var imageUrl = $(this).attr('src');
							var title = window.prompt('Titel', document.title);
							var description = window.prompt('Beschreibung');
							var tags = window.prompt('Tags (durch Leerzeichen getrennte Liste)');

							var $form = $('<form />');
							$form.attr('action', 'http://' + domain + '/snippets/add');
							$form.attr('method', 'POST');
							$form.attr('target', 'post_to_iframe');
							var $inp1 = $('<input type="hidden" name="data[Snippet][title]" />');
							var $inp2 = $('<input type="hidden" name="data[Snippet][user_id]" />');
							var $inp3 = $('<input type="hidden" name="data[Snippet][url]" />');
							var $inp4 = $('<input type="hidden" name="data[Snippet][description]" />');
							var $inp5 = $('<input type="hidden" name="data[Snippet][tags]" />');
							// var $inp6 = $('<textarea type="hidden" name="data[Snippet][base64_image]" />');
							var $inp7 = $('<input type="hidden" name="data[Snippet][image]" />');
							var $inp8 = $('<input type="hidden" name="data[Snippet][fetch_remote]" value="1" />');
							$inp1.val(title).appendTo($form);
							$inp2.val(user_id).appendTo($form);
							$inp3.val(window.location.href).appendTo($form);
							$inp4.val(description).appendTo($form);
							$inp5.val(tags).appendTo($form);


							// console.log('------------------------------------');
							// console.log('Creating canvas with ' + $.data($image, 'origWidth') + 'x' + $.data($image, 'origHeight'));

							// var canvas = document.createElement("canvas");
							// canvas.width = $image.data('origWidth');
							// canvas.heigth = $image.data('origHeight');
							// var ctx = canvas.getContext("2d");
							// ctx.drawImage(image, 0, 0);
							// $body.replaceWith($(canvas));

							// var dataURL = canvas.toDataURL('image/png');

							// $inp6.val(dataURL).appendTo($form);

							if (!imageUrl.match(/^http/)){
								imageUrl = window.location.href + '/' + imageUrl;
							}

							$inp7.val(imageUrl).appendTo($form);
							$inp8.appendTo($form);

							var $iframe = $('<iframe />');
							$iframe.attr('name', 'post_to_iframe').css({ width : '100%', height : '140px' }).prependTo($('body'));

							$form.appendTo($('body')).submit();
						});
					}
				}
			});

			$selector.prependTo($body);
		})();
	}

})();