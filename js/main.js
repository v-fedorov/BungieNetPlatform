$(document).ready(function() {
	hljs.initHighlightingOnLoad();
	$('a').each(function() {
		var link = $(this).attr('href');
		if (link && (link.indexOf('//') == 0 || link.indexOf('http') == 0)) {
			$(this).attr('target', '_blank');
		}
	});

	$('table').sortableTable();
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