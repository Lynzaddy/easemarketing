const filter = {
	init: function () {
		this.filterbar();
	},

	filterbar: function () {
		const filterBar = jQuery('.filter-bar');

		if (!filterBar.length) {
			return false;
		}

		const viewAll = filterBar.find('.view-all');
		viewAll.click(function () {
			jQuery('.view-all').addClass('active');
			filterItem.removeClass('active');
			filterItem.closest('.dropdown').removeClass('active');

			var toggle_button = filterBar.find('.dropdown-toggle');
			toggle_button.each(function () {
				jQuery(this).text($(this).data('value'));
			});
		});

		const filterItem = filterBar.find('.dropdown-item');
		filterItem.click(function () {
			viewAll.removeClass('active');
			const $this = $(this);
			$this.toggleClass('active');
			$this.siblings().removeClass('active');
			$this.closest('.dropdown').addClass('active');
			var parent_button = $this.parents('.filter-dropdown').find('button');
			var default_label = parent_button.data('value');
			jQuery('.dropdown-menu').removeClass('show');
			jQuery('.filter-dropdown').removeClass('show');
			if ($this.text().includes("View All") || !$this.parent().find('.active').length) {
				parent_button.text(default_label);
				parent_button.parent().removeClass('active');
			} else {
				parent_button.text($this.text());
			}
		});
	},
};

(function () {
	filter.init();
})();
