/**
 * Created by yakov on 23.10.16.
 */
;
(function($) {
	$.fn.accordion = function(options) {
		var opts = $.extend({}, $.fn.accordion.defaults, options);
		var accordion_header = $(this);
		accordion_header.each(function() {
			$(this).on('click', function() {
				if ($(this).hasClass(opts['header_active_class'])) return 0;
				var parent_id = $(this).attr(opts['data_parent_attr']);
				var current_level_header = [];
				accordion_header.each(function() {
					if ($(this).attr(opts['data_parent_attr']) === parent_id) {
						current_level_header.push($(this));
					}
				});
				$.each(current_level_header, function() {
					var section_id = $(this).attr('href');
					var section = $(section_id);
					$(section).hide(opts['animation_speed']);
					$(this).removeClass(opts['header_active_class'] + ' ' + opts['header_active_main_class'] + ' ' + opts['header_active_sub_class']);
				});
				var section_id = $(this).attr('href');
				$(section_id).show(opts['animation_speed']);
				if ($(this).hasClass(opts['header_sub_class'])) $(this).addClass(opts['header_active_class'] + ' ' + opts['header_active_sub_class']);
				else $(this).addClass(opts['header_active_class'] + ' ' + opts['header_active_main_class']);
			});
		});
		// Open some tabs
		$('.' + opts['content_open_class']).prev().each(function() {
			$(this).triggerHandler('click');
		});
		$(this).each(function() {
			$(this).on('click', function() {
				return false;
			});
		});
	};
	$.fn.accordion.defaults = {
		header_sub_class: 'tab__header_sub',
		header_active_class: 'tab__header_active',
		header_active_main_class: 'tab__header_active_main',
		header_active_sub_class: 'tab__header_active_sub',
		content_open_class: 'tab__content_in',
		data_parent_attr: 'data-parent',
		animation_speed: 'fast',
	};
})(jQuery);