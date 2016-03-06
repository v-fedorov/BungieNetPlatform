$(document).ready(function() {
	hljs.initHighlightingOnLoad();
	$('a').each(function() {
		var link = $(this).attr('href');
		if (link && (link.indexOf('//') == 0 || link.indexOf('http') == 0)) {
			$(this).attr('target', '_blank');
		}
		if (link && link.indexOf('#') == 0 && $(this).parents('#content').length > 0) {
			$(this).addClass('no-page');
		}
	});

	$('pre code').each(function() {
		var $code = $(this).parent();
		if ($code.height() < 100) return;
		$code.addClass('collapse').addClass('collapsed');
		$code.append('<a href="#" class="expand-code">Expand <i class="fa fa-caret-down"></i></a>');
		$code.find('.expand-code').on('click', function(e) {
			e.preventDefault();
			$code.toggleClass('collapsed');
			$(this).html($code.is('.collapsed') ? 'Expand <i class="fa fa-caret-down"></i>' : 'Collapse <i class="fa fa-caret-up"></i>');
		});
	});

	$('table').sortableTable();

	var pushHeader = function(toc, header, depth) {
		if (depth > 1 && toc.length > 0) {
			pushHeader(toc[toc.length-1].children, header, depth-1);
		} else {
			toc.push({selector: $(header), children: []});
		}
	};
	var appendHeader = function($parent, toc) {
		var $toc = $('<ol></ol>');
		for (var i=0; i<toc.length; i++) {
			var header = toc[i];
			var $header = $('<li></li>');
			if (header.children.length > 0) {
				appendHeader($header, header.children);
			}
			$header.prepend('<a href="#' + header.selector.attr('name') + '">' + header.selector.text().trim() + '</a>');
			$toc.append($header);
		}
		$parent.prepend($toc);
	};

	var tableOfContents = [];
	$('#content .inner').first().find('h2, h3, h4, h5, h6').each(function() {
		$(this).attr('name', $(this).text().trim().replace(/ /g, '-').replace(/[^a-z0-9\-]+/ig, ''));
		switch($(this).prop('tagName').toLowerCase()) {
			case 'h2': pushHeader(tableOfContents, this, 1); break;
			case 'h3': pushHeader(tableOfContents, this, 2); break;
			case 'h4': pushHeader(tableOfContents, this, 3); break;
			case 'h5': pushHeader(tableOfContents, this, 4); break;
			case 'h6': pushHeader(tableOfContents, this, 5); break;
		}
	});
	//console.log(tableOfContents);
	if (tableOfContents.length > 1) {
		var $toc = $('<div id="table-of-contents" class="collapse toc"></div>');
		appendHeader($toc, tableOfContents);
		$toc.append('<hr/>');

		var $inner = $('#content .inner');
		$inner.prepend($toc);
		$inner.prepend('<h2>Contents <a href="#table-of-contents" data-toggle="collapse" title="Show / Hide" class="toggle-collpase collapsed"><span class="hide">Toggle</span></h2>');
	}
});

$.fn.sortableTable = function(options) {
	if (options == undefined) options = {};
	return this.each(function() {
		var target = $(this);
		target.data($.extend({format: 'string', sort: 'asc', ignoreCase: true}, options));

		target.find('thead tr').first().children().each(function(index) {
			var targetHead = $(this);
			targetHead.data($.extend(targetHead.data(), {sortable: true, index: index, format: target.data('format')}));
			if (targetHead.data('sortable')) {
				var sort = target.data('sort') == 'desc' ? 'up' : 'down';
				var html = '<a href="#" class="sort-option">'
					+targetHead.text().trim()
					+' <i class="fa fa-'+(targetHead.is('.active') ? 'cart-'+sort : 'sort')+'"></i>'
					+'</a>';
				targetHead.html(html).find('a').on('click', function(e) {
					e.preventDefault();
					target.find('thead .sort-option').each(function() {
						if ($(this).parent().is(targetHead)) {
							sort = $(this).find('i').hasClass('fa-caret-down');
							target.find('tbody').append(target.find('tbody tr').sort(function(a, b) {
								var cella = $(a).children().removeClass('active').eq(targetHead.data('index')).addClass('active');
								var cellb = $(b).children().removeClass('active').eq(targetHead.data('index')).addClass('active');
								var dir = sort ? -1 : 1;
								//console.log(targetHead.data('format')+'\n'+cella.text()+'\n'+cellb.text());
								var test = 0;
								var testvala = cella.data('value') !== undefined ? ''+cella.data('value') : cella.text();
								var testvalb = cellb.data('value') !== undefined ? ''+cellb.data('value') : cellb.text();
								//console.log(testvala+' | '+testvalb);
								switch(targetHead.data('format')) {
									case 'number': test = parseFloat(testvala) - parseFloat(testvalb); break;
									case 'date':
										var datea = new Date(testvala);
										var dateb = new Date(testvalb);
										//console.log(datea);
										//console.log(dateb);
										//console.log('==');
										test = datea.getTime() - dateb.getTime();
										break;
									case 'string':default: test = testvala.localeCompare(testvalb); break;
								}
								return dir * test;
							}));

							$(this).parent().addClass('active');
							$(this).find('i').attr('class', 'fa fa-caret-'+(sort ? 'up' : 'down'));
						} else {
							$(this).parent().removeClass('active');
							$(this).find('i').attr('class', 'fa fa-sort');
						}
					});
				});
			}
		});
	});
};