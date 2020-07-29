/**
 * Created by yakov on 24.10.16.
 */
;
(function($) {
	$.fn.episode_accordion = function(options) {
		var opts = $.extend({}, $.fn.episode_accordion.defaults, options);
		var accordion_header = $(this);
		accordion_header.each(function() {
			$(this).on('click', function() {
				var section_id = $(this).attr('data-content');
				$(section_id).toggle(opts['animation_speed']);
				$(this).toggleClass(opts['header_active_class']);
			});
		});
		// Open some tabs
		$(this).triggerHandler('click');
		$(this).each(function() {
			$(this).on('click', function() {
				return false;
			});
		});
	};
	$.fn.episode_accordion.defaults = {
		header_active_class: 'season__title_active',
		animation_speed: 'fast',
	};
})(jQuery);