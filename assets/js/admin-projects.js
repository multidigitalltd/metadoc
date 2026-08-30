/**
 * מטאדוק — בורר התמונות במסך עריכת פרויקט נדל"ן.
 * נטען רק במסכי העריכה של סוג התוכן md_project.
 */
(function ($) {
	'use strict';

	$(document).on('click', '.md-pr-pick', function (e) {
		e.preventDefault();
		var button = $(this);
		var wrap = button.closest('.md-pr-media');
		var frame = wp.media({
			title: button.data('title'),
			button: { text: button.data('choose') },
			multiple: false,
			library: { type: 'image' }
		});

		frame.on('select', function () {
			var img = frame.state().get('selection').first().toJSON();
			var src = (img.sizes && img.sizes.medium) ? img.sizes.medium.url : img.url;
			wrap.find('input[type=hidden]').val(img.id);
			wrap.find('.md-pr-thumb').html(
				$('<img>', { src: src, alt: '', css: { maxWidth: '180px', height: 'auto', display: 'block' } })
			);
			wrap.find('.md-pr-clear').show();
		});

		frame.open();
	});

	$(document).on('click', '.md-pr-clear', function (e) {
		e.preventDefault();
		var wrap = $(this).closest('.md-pr-media');
		wrap.find('input[type=hidden]').val('');
		wrap.find('.md-pr-thumb').empty();
		$(this).hide();
	});
})(jQuery);
