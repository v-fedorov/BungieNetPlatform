$(document).ready(function() {
	hljs.initHighlightingOnLoad();
	$('a').each(function() {
		var link = $(this).attr('href');
		if (link && (link.indexOf('//') == 0 || link.indexOf('http') == 0)) {
			$(this).attr('target', '_blank');
		}
	});
});