"use strict";const app={init:function(){this.generalAction(),this.testimonialsSlider(),this.custombreadcrumb(),this.setupSearchButton(),this.activeSubmenuLink(),this.setupPopupForm(),this.marketplaceDropdown(),this.setupHeader()},setupHeader(){jQuery(".global-header .icon-down-arrow1.elementskit-submenu-indicator").on("click",(function(){const e=jQuery(this).parent().parent();jQuery(".dropdown-open").each((function(){const t=jQuery(this);t.is(e)||(t.removeClass("dropdown-open"),t.find(".elementskit-dropdown-open").removeClass("elementskit-dropdown-open"))}))})),jQuery(".book_demo_responsive").on("click",(function(){elementorProFrontend.modules.popup.showPopup({id:12082})}))},marketplaceDropdown(){jQuery(".dropdown .filter-button-new").on("click",(function(e){jQuery(".dropdown.filter-dropdown").removeClass("show"),jQuery(".dropdown-menu").removeClass("show"),e.stopPropagation()}))},setupPopupForm(){jQuery(document).on("elementor/popup/show",(e,t)=>{12082===t&&MktoForms2.loadForm("//hr.ease.com","627-PLV-209",1125)})},setupSearchButton:function(){jQuery(".search-modal-button").on("click",(function(){jQuery(".ekit_navsearch-button.ekit-modal-popup").click()})),jQuery(".ekit-modal-popup h2.elementor-heading-title a").on("click",(function(){console.log("focus"),jQuery('form.ekit-search-group input[type="search"]').focus(),jQuery('form.ekit-search-group input[type="search"]').click(),jQuery('form.ekit-search-group input[type="search"]').attr("required","required"),jQuery('form.ekit-search-group input[type="search"]').addClass("aaaaa")}))},testimonialsSlider:function(){jQuery(".testimonials-slider").slick({slidesToShow:3,slidesToScroll:1,centerMode:!0,arrows:!0,dots:!1,infinite:!0})},custombreadcrumb:function(){var e=window.location.href,t=window.location.pathname.split("/")[1],a=document.location.origin+"/"+t+"/";jQuery(".breadcrumb_item a").each((function(){this.href===e&&jQuery(this).addClass("active"),this.href===a&&jQuery(this).addClass("active")}))},activeSubmenuLink:function(){var e=window.location.href,t=window.location.hostname,a=window.location.protocol,i=window.location.pathname.split("/")[1],o=document.location.origin+"/"+i+"/";jQuery(".global-header .elementor-icon-list-item .ekit_badge_left").each((function(){this.href===e&&(jQuery(this).addClass("active"),jQuery(this).parents(".elementskit-dropdown-has").addClass("active")),this.href===o&&(jQuery(this).addClass("active"),jQuery(this).parents(".elementskit-dropdown-has").addClass("active"))})),jQuery(".global-header .elementskit-megamenu-panel .elementor-heading-title a").each((function(){console.log(a+"//"+t+"/partners/"),this.href===e&&(jQuery(this).addClass("active"),jQuery(this).parents(".elementskit-dropdown-has").addClass("active")),this.href===o&&(jQuery(this).addClass("active"),jQuery(this).parents(".elementskit-dropdown-has").addClass("active"))})),jQuery(".global-header .elementskit-megamenu-panel .ekit-heading a").each((function(){this.href===e&&(jQuery(this).addClass("active"),jQuery(this).parents(".elementskit-dropdown-has").addClass("active")),this.href===o&&(jQuery(this).addClass("active"),jQuery(this).parents(".elementskit-dropdown-has").addClass("active"))})),jQuery(document).ready((function(){e==a+"//"+t+"/partners/"&&jQuery(".resource-nav").removeClass("active")}))},generalAction:function(){jQuery(".tabs-nav .headshot-slide:first-child").addClass("active"),jQuery(".tabs-nav .dot-slide:first-child").addClass("active"),jQuery(".tab-content").hide(),jQuery(".tab-content:first").show(),jQuery(".tabs-nav .headshot-slide, .tabs-nav .dot-slide").click((function(){jQuery(".tabs-nav .headshot-slide").removeClass("active"),jQuery(".tabs-nav .dot-slide").removeClass("active");var e=jQuery(this).children("a").attr("href");jQuery("a[href="+e+"]").parents(".headshot-slide,.dot-slide").addClass("active"),jQuery(".tab-content").hide();var t=jQuery(this).find("a").attr("href");return jQuery(t).fadeIn(),!1}));var e=jQuery(".tabs-nav .dot-slide");setInterval((function(){var t=e.filter(".active");(t.index()<e.length-1?t.next():e.first()).click()}),1e4),jQuery(document).ready((function(){jQuery(".broker-section .elementor-widget-container p").matchHeight()})),jQuery(document).ready((function(){jQuery(".pricing-description").matchHeight()}))}};app.init();