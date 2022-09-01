if (jQuery('.hero-treatment-1').length) {

function create_custom_dropdowns() {
	jQuery('select').each(function (i, select) {
		if (!jQuery(this).next().hasClass('dropdown')) {
			jQuery(this).after('<div class="dropdown ' + (jQuery(this).attr('class') || '') + '" tabindex="0"><span class="current"></span><div class="banner_dropdown_list list"><ul></ul></div></div>');
			var dropdown = jQuery(this).next();
			var options = jQuery(select).find('option');
			var selected = jQuery(this).find('option:selected');
			dropdown.find('.current').html(selected.data('display-text') || selected.text());
			options.each(function (j, o) {
				var display = jQuery(o).data('display-text') || '';
				var url = jQuery(o).data('url') || '';
				dropdown.find('ul').append('<li class="option ' + (jQuery(o).is(':selected') ? 'selected' : '') + '" data-value="' + jQuery(o).val() + '" data-display-text="' + display + '" data-url="' + url + '">' + jQuery(o).text() + '</li>');
			});
		}
	});

}

// Event listeners

// Open/close
jQuery(document).on('click', '.dropdown', function (event) {
	jQuery('.dropdown').not(jQuery(this)).removeClass('open');
	jQuery(this).toggleClass('open');
	jQuery('body').toggleClass('hero-1-dropdown-open');
	if (jQuery(this).hasClass('open')) {
		jQuery(this).find('.option').attr('tabindex', 0);
		jQuery(this).find('.selected').focus();
	} else {
		jQuery(this).find('.option').removeAttr('tabindex');
		jQuery(this).focus();
	}
});

// Close when clicking outside
jQuery(document).on('click', function (event) {
	if (jQuery(event.target).closest('.dropdown').length === 0) {
		jQuery('.dropdown').removeClass('open');
		jQuery('body').removeClass('hero-1-dropdown-open');
		jQuery('.dropdown .option').removeAttr('tabindex');
	}
	event.stopPropagation();
});
// Option click
jQuery(document).on('click', '.dropdown .option', function (event) {
	jQuery(this).closest('.list').find('.selected').removeClass('selected');
	jQuery(this).addClass('selected');
	var text = jQuery(this).data('display-text') || jQuery(this).text();
	var url = jQuery(this).data('url');
	console.log(url);
	jQuery(this).closest('.dropdown').find('.current').text(text);
	jQuery(this).closest('.dropdown').prev('select').val(jQuery(this).data('value')).trigger('change');
	jQuery('.banner_dropdown').removeClass('active');
	jQuery('.banner_dropdown').addClass('active');

	jQuery('.current').append('.');

});

// Keyboard events
jQuery(document).on('keydown', '.dropdown', function (event) {
	var focused_option = jQuery(jQuery(this).find('.list .option:focus')[0] || jQuery(this).find('.list .option.selected')[0]);
	// Space or Enter
	if (event.keyCode == 32 || event.keyCode == 13) {
		if (jQuery(this).hasClass('open')) {
			focused_option.trigger('click');
		} else {
			jQuery(this).trigger('click');
		}
		return false;
		// Down
	} else if (event.keyCode == 40) {
		if (!jQuery(this).hasClass('open')) {
			jQuery(this).trigger('click');
		} else {
			focused_option.next().focus();
		}
		return false;
		// Up
	} else if (event.keyCode == 38) {
		if (!jQuery(this).hasClass('open')) {
			jQuery(this).trigger('click');
		} else {
			var focused_option = jQuery(jQuery(this).find('.list .option:focus')[0] || jQuery(this).find('.list .option.selected')[0]);
			focused_option.prev().focus();
		}
		return false;
		// Esc
	} else if (event.keyCode == 27) {
		if (jQuery(this).hasClass('open')) {
			jQuery(this).trigger('click');
		}
		return false;
	}
});

jQuery(document).ready(function () {
	create_custom_dropdowns();
	jQuery('.check-it-out-button a[role]').on('click', () => {
		const url = jQuery('.banner_dropdown .option.selected').data('url');
		if(url) {
			window.location.href = url;
		}
	});
	jQuery('.banner_dropdown').removeClass('active');
	jQuery('.current').append('.');
});

jQuery(document).ready(function () {
	jQuery(".broker-section .elementor-widget-container p").matchHeight();
});

}