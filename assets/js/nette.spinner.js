/**
 * Nette Ajax extension adapted for bootstrap 4
 *
 * Requires
 * @link https://github.com/vojtech-dobes/nette.ajax.js
 */
(function($, undefined) {
	$.nette.ext('nette.spinner', {
		init: function () {
			this.spinner = this.createSpinner();
			this.spinner.appendTo('body');
		},
		start: function () {
			this.spinner.show(this.speed);
		},
		complete: function () {
			this.spinner.hide(this.speed);
		}
	}, {
		createSpinner: function () {
			return  spinner = $('<div>', {
				id: 'ajax-spinner',
				class: 'spinner-border text-primary',
				css: {
					top: '1%',
					left: '98%',
					position: 'absolute',
					display: 'none'
				}
			});
		},
		spinner: null,
		speed: undefined
	});
})(jQuery);
