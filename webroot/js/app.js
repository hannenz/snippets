$.zepto.scrollTop = function (pixels) {
    this[0].scrollTop = pixels;
};

$(function(){

	$(document).foundation();

	var $body = $('body');

	$('.more-snippets a').live('click', _onPaginatorNextClicked);
	$snippetsList = $('.snippets-list');

	function _onPaginatorNextClicked(event){

		event.preventDefault();

		var url = $(this).attr('href');
		$body.addClass('busy');
		$.get(url, function(result){

			var $result = $(result);

			$('.more-snippets').replaceWith($result.find('.snippets-list > li'));

			var y = $(window).scrollTop();
			console.log(y);
			$body[0].scrollTopy = y + 150;

			$body.removeClass('busy');




		});

		return false;
	}

	$('#js-snippet-link').bind('click', function(event){
		var id = $(this).attr('data-snippet-id');
		$.get('/snippets/increment_visits/' + id, function(response){

			var json = $.parseJSON(response);
			$('#js-visits').html(json['visits']);
			$('#js-score').html(json['score']);
		});

	});
});
