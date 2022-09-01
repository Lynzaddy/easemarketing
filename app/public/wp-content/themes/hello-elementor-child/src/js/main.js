const app = {
  init: function () {
   this.generalAction();
   this.testimonialsSlider();
   this.custombreadcrumb();
   this.setupSearchButton();
   this.activeSubmenuLink();
   this.setupPopupForm();
   this.marketplaceDropdown();
   this.setupHeader();
  },
	setupHeader() {
		jQuery('.global-header .icon-down-arrow1.elementskit-submenu-indicator').on('click', function() {
			const parent = jQuery(this).parent().parent();
			const dropdowns = jQuery('.dropdown-open');
			dropdowns.each(function () {
				const self = jQuery(this);
				if(!self.is(parent)) {
					self.removeClass('dropdown-open');
					self.find('.elementskit-dropdown-open').removeClass('elementskit-dropdown-open');
				}
			});
		});

		jQuery('.book_demo_responsive').on('click', function() {
			elementorProFrontend.modules.popup.showPopup( { id: 12082 } )
		});
	},
	marketplaceDropdown() {
		jQuery('.dropdown .filter-button-new').on('click', function(event){
			jQuery(".dropdown.filter-dropdown").removeClass("show");
			jQuery(".dropdown-menu").removeClass("show");
			event.stopPropagation();
		});
  },
	
  setupPopupForm() {
		jQuery( document ).on( 'elementor/popup/show', (event,id) => {
			if( id === 12082 ) {
				MktoForms2.loadForm("//hr.ease.com", "627-PLV-209", 1125);
			}
		} );
  },
	
  setupSearchButton: function() {
	jQuery('.search-modal-button')
		.on('click', function() { 
			jQuery('.ekit_navsearch-button.ekit-modal-popup').click();
		});
		
	  jQuery('.ekit-modal-popup h2.elementor-heading-title a').on("click", function () { 
		  console.log('focus'); 
		  jQuery('form.ekit-search-group input[type="search"]').focus(); 
		  jQuery('form.ekit-search-group input[type="search"]').click(); 
		  jQuery('form.ekit-search-group input[type="search"]').attr('required', 'required'); 
		  jQuery('form.ekit-search-group input[type="search"]').addClass('aaaaa');		   
	  });		
		
  },
  testimonialsSlider: function() {
		jQuery('.testimonials-slider').slick({
			slidesToShow: 3,
			slidesToScroll: 1,
			centerMode: true,
			arrows: true,
			dots: false,
			//centerPadding: '20px',
			infinite: true,
			//speed: 500,
			//autoplaySpeed: 5000,
			//autoplay: true			
		});

  },

	 
  custombreadcrumb: function() {
		var path = window.location.href;
		var pathArray = window.location.pathname.split('/');
		var secondLevelLocation = pathArray[1];
		var secondLevelLocations = document.location.origin+'/'+secondLevelLocation+'/';

		jQuery('.breadcrumb_item a').each(function () {
			if (this.href === path ) { 
				jQuery(this).addClass('active');
			}
			if (this.href === secondLevelLocations ) { 
				jQuery(this).addClass('active');
			}
		});
	},

	activeSubmenuLink: function () {
		var path = window.location.href;
		var domain = window.location.hostname;
		var protocol = window.location.protocol;
		var pathArray = window.location.pathname.split('/');
		var secondLevelLocation = pathArray[1];
		var secondLevelLocations = document.location.origin + '/' + secondLevelLocation + '/';

		jQuery('.global-header .elementor-icon-list-item .ekit_badge_left').each(function () {

			if (this.href === path) {
				jQuery(this).addClass('active');
				jQuery(this).parents('.elementskit-dropdown-has').addClass('active');
			}
			if (this.href === secondLevelLocations) {
				jQuery(this).addClass('active');
				jQuery(this).parents('.elementskit-dropdown-has').addClass('active');
			}
		});

		jQuery('.global-header .elementskit-megamenu-panel .elementor-heading-title a').each(function () {

			console.log(protocol+ '//' + domain + '/partners/');
			if (this.href === path) {
				jQuery(this).addClass('active');
				jQuery(this).parents('.elementskit-dropdown-has').addClass('active');

			}
			if (this.href === secondLevelLocations) {
				jQuery(this).addClass('active');
				jQuery(this).parents('.elementskit-dropdown-has').addClass('active');
			}
		});

		jQuery('.global-header .elementskit-megamenu-panel .ekit-heading a').each(function () {

			if (this.href === path) {
				jQuery(this).addClass('active');
				jQuery(this).parents('.elementskit-dropdown-has').addClass('active');
			}
			if (this.href === secondLevelLocations) {
				jQuery(this).addClass('active');
				jQuery(this).parents('.elementskit-dropdown-has').addClass('active');
			}
		});

		jQuery(document).ready(function () {
			if (path == protocol+'//'+domain+'/partners/') {
				jQuery('.resource-nav').removeClass('active');
			}
		}); 


	},

  generalAction: function() {
	  jQuery('.tabs-nav .headshot-slide:first-child').addClass('active');
	  jQuery('.tabs-nav .dot-slide:first-child').addClass('active');
	  jQuery('.tab-content').hide();
	  jQuery('.tab-content:first').show();

	  jQuery('.tabs-nav .headshot-slide, .tabs-nav .dot-slide').click(function () {
		  jQuery('.tabs-nav .headshot-slide').removeClass('active');
		  jQuery('.tabs-nav .dot-slide').removeClass('active');
		  var href = jQuery(this).children('a').attr('href');
		  jQuery('a[href=' + href + ']').parents('.headshot-slide,.dot-slide').addClass('active');
		  jQuery('.tab-content').hide();
		  var activeTab = jQuery(this).find('a').attr('href');
		  jQuery(activeTab).fadeIn();
		  return false;
	  });  

	  var dots = jQuery('.tabs-nav .dot-slide');
	  setInterval(function () {
		  var ondots = dots.filter('.active');
		  var nextdots = ondots.index() < dots.length - 1 ? ondots.next() : dots.first();
		  nextdots.click();
	  }, 10000);


		jQuery( document ).ready(function() {
			jQuery(".broker-section .elementor-widget-container p").matchHeight();
		}); 

		jQuery( document ).ready(function() {
			jQuery(".pricing-description").matchHeight();
		}); 
  },


  

};

(function () {
  app.init();
})();


