/**
 * Created by yakov on 23.10.16.
 */
;
(function($) {
	var accordion_id = '#accordion';
	var header_class = 'tab__header';
	var header_sub_class = 'tab__header_sub';
	var header_active_class = 'tab__header_active';
	var header_active_main_class = 'tab__header_active_main';
	var header_active_sub_class = 'tab__header_active_sub';
	var content_open_class = 'tab__content_in';
	var data_parent_attr = 'data-parent';
	var animation_speed = 'fast';
	var accordion_header = $(accordion_id.concat(' .', header_class));
	accordion_header.each(function() {
		$(this).on('click', function() {
			if ($(this).hasClass(header_active_class)) return 0;
			var parent_id = $(this).attr(data_parent_attr);
			var current_level_header = [];
			accordion_header.each(function() {
				if ($(this).attr(data_parent_attr) === parent_id) {
					current_level_header.push($(this));
				}
			});
			$.each(current_level_header, function() {
				var section_id = $(this).attr('href');
				var section = $(section_id);
				$(section).hide(animation_speed);
				$(this).removeClass(header_active_class + ' ' + header_active_main_class + ' ' + header_active_sub_class);
			});
			var section_id = $(this).attr('href');
			$(section_id).show(animation_speed);
			if ($(this).hasClass(header_sub_class)) $(this).addClass(header_active_class.concat(' ', header_active_sub_class));
			else $(this).addClass(header_active_class.concat(' ', header_active_main_class));
		});
	});
	// Open some tabs
	$(accordion_id.concat(' .', content_open_class)).prev().each(function() {
		$(this).triggerHandler('click');
	});
	$(accordion_id.concat(' .', header_class)).each(function() {
		$(this).on('click', function() {
			return false;
		});
	});
})(jQuery);
