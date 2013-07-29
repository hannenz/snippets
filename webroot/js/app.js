$(function(){

	var $body = $('body');

	$('.paginator-next a').bind('click', _onPaginatorNextClicked);

	function _onPaginatorNextClicked(event){

		event.preventDefault();

		var url = $(this).attr('href');
		$body.addClass('busy');
		$.get(url, function(result){
			var $result = $(result);
			var $newSnippets = $result.find('.snippets-list').children();
			$('.snippets-list').append($newSnippets);
			$body.removeClass('busy');

			$('.paginator-next a').replaceWith($result.find('.paginator-next a'));
			$('.paginator-next a').bind('click', _onPaginatorNextClicked);
		});

		return false;
	}

});