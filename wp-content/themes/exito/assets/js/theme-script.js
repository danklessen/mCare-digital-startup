window.jQuery = window.$ = jQuery;

//	Header Height
function exitoHeaderHeight() {
    "use strict";
	
	var headerWrapH = jQuery('header.header-top .header_wrap').height();
	jQuery('#page-wrap > header.header-top').css('padding-bottom', headerWrapH + 'px');
	
	var headerH = jQuery('header.header-top').height();
	jQuery('#pagetitle .container').css('padding-top', headerH + headerWrapH + 'px');
	
	jQuery('body.pagetitle_hide #breadcrumbs').css('margin-top', headerH + headerWrapH + 'px');
	if ( !jQuery('#default_page .contentarea .vc_row:first div').hasClass('rev_slider_wrapper') ) {
		jQuery('body.pagetitle_hide.breadcrumbs_hide #page-content').css('margin-top', headerH + headerWrapH + 'px');
	} else {
		if ( ( !jQuery('body').hasClass('header_bgcolor') || jQuery('body').hasClass('header_opacity') ) || jQuery(window).width() < 769 ) {
			jQuery('body #page-content').css('padding-top', '0px');
		} else {
			jQuery('body.pagetitle_hide.breadcrumbs_hide #page-content').css('padding-top', headerH + headerWrapH + 'px');
		}
		jQuery('body').addClass('slider_first_row');
	}
	
}

//	Blog Posts Metro Style size
function exitoBlogMetroHeight() {
	if (jQuery('#blog_list.metro').size() > 0) {
		jQuery('#blog_list.metro article.post').each(function(){
			var postW = jQuery(this).find('.post-content-wrapper').width();
			if (jQuery(this).hasClass('sizing_width2')) {
				if (jQuery('.sizing_width2').hasClass('pl0')) {
					jQuery(this).find('.post-content-wrapper').css('height', postW / 2 + 'px');
				} else {
					jQuery(this).find('.post-content-wrapper').css('height', postW / 2 - 15 + 'px');
				}
			} else if (jQuery(this).hasClass('sizing_height2')) {
				if (jQuery('.sizing_height2').hasClass('pl0')) {
					jQuery(this).find('.post-content-wrapper').css('height', postW * 2 + 'px');
				} else {
					jQuery(this).find('.post-content-wrapper').css('height', postW * 2 + 30 + 'px');
				}
			} else {
				jQuery(this).find('.post-content-wrapper').css('height', postW + 'px');
			}
		});
	}
}

//	Sidebar Height
function exitoSidebarHeight() {
    "use strict";
	
	if( jQuery('#blog_sidebar').length && jQuery(window).width() > 1025 ) {
		var BlogSidebarContentH = jQuery('#blog_sidebar').parent().parent().height();
		jQuery('#blog_sidebar').css('min-height', BlogSidebarContentH + 'px');
		
		if ( jQuery('.cstheme_sidebar_border').hasClass('left_border') ) {
			var PageContentH = jQuery('.cstheme_sidebar_border').prev().height();
		} else {
			var PageContentH = jQuery('.cstheme_sidebar_border').next().height();
		}
		var PageSidebarH = jQuery('.cstheme_sidebar_border').height();
		
		if ( PageContentH > PageSidebarH ) {
			jQuery('.cstheme_sidebar_border > div').css('min-height', PageContentH + 'px');
		} else {
			jQuery('.cstheme_sidebar_border > div').css('min-height', PageSidebarH + 'px');
		}
	}
}

// Subscribe Form
function exito_subscribe_form() {
	"use strict";
	
	jQuery('.wpb_column .mc4wp-form').each(function() {
		var mc4wp_wrap = jQuery(this).find('.mc4wp-form'),
			mc4wp_email = jQuery(this).find('.mc4wp_email_wrap'),
			mc4wp_submit = jQuery(this).find('.mc4wp_submit_wrap');
		
		mc4wp_email.css({'width': jQuery(this).width() - mc4wp_submit.width() - 30 + 'px'});
	});
}

//	Post Likes
function exito_PostLikes() {
    "use strict";
	
	jQuery('.exito_add_like').live("click", function () {
        var post_likes_this = jQuery(this);
        jQuery.post(exito_ajaxurl, {
            action: 'add_like_post',
            post_id: jQuery(this).attr('data-postid')
        }, function (response) {
            jQuery.cookie('like' + post_likes_this.attr('data-postid'), 'true', {expires: 7, path: '/'});
            post_likes_this.addClass('already_liked').removeClass('exito_add_like');
            post_likes_this.find("span").text(response);
        });
    });
}

//	Header Sticky
function exito_headerSticky() {
	"use strict";
	
	if ( jQuery('body').hasClass('admin-bar') ) {
		var headerWrapH = jQuery('header.header-top .header_wrap').height() - 32;
	} else {
		var headerWrapH = jQuery('header.header-top .header_wrap').height();
	}
	if ( ( jQuery(window).scrollTop() > jQuery('header').height() + headerWrapH ) && ( jQuery(window).width() > 767 ) && ( !jQuery('body').hasClass('error404') ) ) {
		jQuery('body').addClass('header-fixed');
		jQuery('header.header-top .header_wrap').css({'top': ' -' + headerWrapH + 'px', 'bottom': 'auto'});
	} else {
		jQuery('body').removeClass('header-fixed');
		jQuery('header.header-top .header_wrap').css({'bottom': '0', 'top': 'auto'});
	}
}

//	Video Iframe Size
function exito_video_size() {
	"use strict";
	
	jQuery('.post-video, .portfolio_video, .cstheme_video_iframe, .single-post-content').each(function(){
		jQuery(this).find('iframe').css({'height': jQuery(this).width()*9/16 + 'px'});
	});
}


//	Blog Top Image min height
function exito_blogTopImageMinH() {
	"use strict";
	
	if (jQuery('#blog_list.grid_top_img').size() > 0) {
		var PostMinH = jQuery('#blog_list.grid_top_img').find('.post.format-image').height();
		jQuery('#blog_list.grid_top_img').find('.format-quote .post-quote, .format-link .post-link').css({'height': PostMinH + 'px'});
	}

}

//	Blog Post BG Image Style
function exito_blog_bgimg_size() {
	"use strict";
	
	if (jQuery('#blog_list.grid_bg_img').size() > 0) {
		jQuery('#blog_list.grid_bg_img').each(function(){
			jQuery(this).find('article.post > div').css({'height': jQuery(this).find('article.post > div').width()*0.77 + 'px'});
		});
	}
}

//	Blog Post Card Style min height
function exito_blog_card_minheight() {
	"use strict";
	
	var post_height = jQuery('#blog_list.grid_card article.post.format-image').height();
	jQuery('#blog_list.grid_card article.post.format-quote .post-quote, #blog_list.grid_card article.post.format-link .post-link').css({'min-height': post_height + 'px'});
}

//	Portfolio Items ODD
function exito_portfolio_odd() {
	"use strict";
	
	jQuery('#portfolio_list.chess article:odd').find('.col-md-6:first').addClass('pull-right');
	jQuery('#portfolio_list.chess article').each(function(){
		var portfolio_chess_img_h = jQuery(this).find('.portfolio_format_content img').height(),
			portfolio_chess_txt_h = jQuery(this).find('.portfolio_descr_wrap').height(),
			portfolio_chess_txt_padtop = ( portfolio_chess_img_h - portfolio_chess_txt_h ) / 2;
		
		jQuery(this).find('.portfolio_descr_wrap').css({'padding-top': portfolio_chess_txt_padtop + 'px', 'padding-bottom': portfolio_chess_txt_padtop + 'px'});
	});
}

//	Page 404 height
function exito_page404_h() {
	"use strict";
	
	var windowH = jQuery(window).height();
	var headerWrapH = jQuery('.header_wrap').height() - 70;
	var error404_containerH = windowH - headerWrapH;
	var error404_container_inH = jQuery('#error404_container .container').height();
	
	jQuery('#error404_container').css({'min-height': error404_containerH + 'px'});
	jQuery('#error404_container .container').css({'padding-top': (error404_containerH - error404_container_inH) / 2 + 'px'});
}

//	Coming Soon Page
function exito_coming_soon_h() {
	"use strict";
	
	var windowH = jQuery(window).height();
	var coming_container_H = jQuery('.coming_soon_wrapper .container').height();
	
	jQuery('.coming_soon_wrapper').css({'min-height': windowH + 'px'});
	jQuery('.coming_soon_wrapper .container').css({'padding-top': (windowH - coming_container_H) / 2 + 'px'});
}

//	Slick Carousel Arrows
function exito_slickSliderAr() {
	"use strict";
	
	var windowW = jQuery(window).width();
	var containerW = jQuery(".ult-carousel-wrapper").width();
	var leftPart = (windowW - containerW) / 2 - 50;
	jQuery(".slick-prev").css("left", -leftPart);
	jQuery(".slick-next").css("right", -leftPart);
}

function exito_setup_menu() {
	"use strict";
	
	var menu_wrap = jQuery('.menu_creative_block .menu-primary-menu-container-wrap');
	if (menu_wrap.height() > jQuery(window).height()) {} else {
		menu_wrap.css('top', '60%');
	}
}

//	Single Post Fullscreen
function exito_singlepost_fullscreen() {
	"use strict";
	
	var windowH = jQuery(window).height();
	
	jQuery('#pagetitle.pagetitle_fullscreen').css({'min-height': windowH + 'px'});
}

//	Fixed Footer
function exito_footerFixed(){
	"use strict";
	
	if( jQuery('body').hasClass('footer_fixed') && !jQuery('body').hasClass('error404') && jQuery(window).width() > 1279 && jQuery(window).outerHeight(true) > jQuery('footer').outerHeight(true) ){
		jQuery('#page-content').css('margin-bottom', jQuery('footer').outerHeight(true));
		jQuery('footer').addClass('fixed');
	}

}

//	Post Format Gallery
function exito_post_gallery_carousel() {
	jQuery('.post_format_content .post-slider.owl-carousel').owlCarousel({
		items: 1,
		margin: 0,
		dots: true,
		nav: true,
		navText: [
			"<i class='fa fa-angle-left'></i>",
			"<i class='fa fa-angle-right'></i>"
		],
		loop: true,
		autoplay: true,
		autoplaySpeed: 1000,
		autoplayTimeout: 5000,
		navSpeed: 1000,
		autoplayHoverPause: true,
		thumbs: false
	});
}

//	Header Left Menu Function
function exito_LeftMenuFunc() {
	jQuery('header.header-left .header_left_top').css('min-height', jQuery(window).height() - jQuery('header.header-left .header_left_bottom').height() - 110);
}

jQuery(document).ready(function($) {
	"use strict";
	
	//	Preloader
	jQuery("#loader .bar").animate({
		width : '100%'
	}, 1500, function(){
		jQuery("#loader").fadeOut(500);
	});
	
	//	Empty href
	jQuery('.nav-menu a:not([href])').addClass('nohref');

	exitoHeaderHeight();
	
	//	Header Search focus
	if (jQuery('header .header_search_icon').size() > 0) {
		var header_search_button = $('.header_search_icon');
		var header_search_form = $('.form_search_block');
		header_search_button.unbind('click').on('click touchend', function() {
			header_search_form.fadeToggle(250, function() {
				if (header_search_form.is(':visible')) {
					header_search_button.addClass('active');
				} else {
					header_search_button.removeClass('active');
				}
			});
			$('.form_search_block input.search-field').focus();
			return false;
		});
	}
	
	//	Header Creative Menu
	if (jQuery('header .menu_creative_btn').size() > 0) {
		var menu_creative_btn = $('.menu_creative_btn');
		var menu_creative_block = $('.menu_creative_block');
		menu_creative_block.hide();
		menu_creative_btn.unbind('click').on('click touchend', function() {
			menu_creative_block.fadeToggle(250, function() {
				if (menu_creative_block.is(':visible')) {
					menu_creative_btn.parent().addClass('active');
				} else {
					menu_creative_btn.parent().removeClass('active');
				}
			});
			return false;
		});
	}
	
	//	Creative Menu Func
	if (jQuery('.menu_creative_block').size() > 0) {
		jQuery('.menu-item-has-children').children('a').on('click', function(event) {
			event.preventDefault();
			jQuery(this).next('ul').slideToggle(300);
			setTimeout("exito_setup_menu()", 330);
		});
	}
	
	//	Header left Menu
	if (jQuery('header.header-left').size() > 0) {
		jQuery('.menu-item-has-children').children('a').on('click', function(event) {
			event.preventDefault();
			jQuery(this).next('ul').slideToggle(300, function() {
				jQuery(this).parent().toggleClass('menu_open', $(this).is(':visible'));
			});
		});
	}
	
	//	Sidebar Border
	if (jQuery('aside.widget').size() > 0) {
		jQuery('aside.widget').closest('.vc_column_container').addClass('cstheme_sidebar_border');
		if(jQuery('.cstheme_sidebar_border').next('.vc_column_container').length > 0) {
			jQuery('.cstheme_sidebar_border').addClass('right_border');
		} else {
			jQuery('.cstheme_sidebar_border').addClass('left_border');
		}
	}
	
	//	Widget Recent Posts
	if (jQuery(".recent_posts_list.carousel").size() > 0) {
		jQuery(".recent_posts_list.carousel").owlCarousel({
			margin: 0,
			nav: false,
			loop: true,
			autoplay: true,
			autoplaySpeed: 1000,
			autoplayTimeout: 5000,
			navSpeed: 1000,
			autoplayHoverPause: true,
			items: 1,
			thumbs: false
		});
	}
	
	//	List widgets
	jQuery('.widget_archive ul li, .widget_categories ul li').each(function(){
		var str = jQuery(this).html();
		str = str.replace('(', '<span class="val">- ');
		str = str.replace(')', '</span>');

		jQuery(this).html(str);
	});
	
	jQuery('.widget_archive ul li li, .widget_categories ul li li').each(function(){
		var str = jQuery(this).html();
		str = str.replace('(', '<span class="val">- ');
		str = str.replace(')', '</span>');

		jQuery(this).html(str);
	});
	
	jQuery('.widget_archive ul li li li, .widget_categories ul li li li').each(function(){
		var str = jQuery(this).html();
		str = str.replace('(', '<span class="val">- ');
		str = str.replace(')', '</span>');

		jQuery(this).html(str);
	});
	
	//	Price Element
	if (jQuery('.ult_pricing_table').size() > 0) {
		var rex = new RegExp("([0-9]+)", "gm");

		$(".ult_pricing_table .ult_price_figure").each(function(){
			var $this = $(this);
			var content = $this.html();
			$this.html(content.replace(rex, '<span class="cstheme_price_figure">$1</span>'));
			var price_volue = jQuery(this).find('span.cstheme_price_figure').detach();
			jQuery(this).wrapInner('<span class="cstheme_price_value"></span>');
			if (jQuery(this).parent().find('.ult_price_term').html()) {
				jQuery(price_volue).appendTo(this);
			} else {
				jQuery(price_volue).prependTo(this);
			}
		});
		
		jQuery('.ult_pricing_table_wrap.ult_design_5').each(function(){
			if (jQuery(this).hasClass('ult_featured')) {
				jQuery(this).removeClass('ult_featured');
				jQuery(this).parent().parent().addClass('ult_price_item_featured');
			}
		});
	}
	
	
	//	Team Element
	if (jQuery('.ult-team-member-wrap').size() > 0) {
		jQuery('.ult-team-member-wrap.ult-style-1').each(function(){
			jQuery(this).find('.ult-team-member-name').before('<span class="member-name-divider"></span>');
			
			var team_socials = jQuery(this).find('.ult-social-buttons').detach();
			jQuery(this).find('.ult-team-member-image-overlay').after(team_socials);
		});
		
		jQuery('.ult-team-member-wrap.ult-style-2').each(function(){
			var team_style = jQuery(this).attr('style');
			var team_style2 = jQuery(this).find('.ult-team-member-image').attr('style');
			jQuery(this).find('.ult-team-member-image img').after('<span class="csteam_overlay" style="' + team_style2 + '' + team_style + ';"></span>');
		});
		
		jQuery('.ult-team-member-wrap.ult-style-3').each(function(){
			var team_style = jQuery(this).find('.ult-team-member-image').attr('style');
			jQuery(this).attr('style', team_style);
			
			var team_descr = jQuery(this).find('.ult-team-member-description').detach();
			jQuery(this).find('.ult-team-member-name').after(team_descr);
			
			var team_position = jQuery(this).find('.ult-team-member-position').detach();
			jQuery(this).find('.ult-team-member-name').before(team_position);
		});
	}
	
	
	//	Mobile Menu Function
	if (jQuery('#header_mobile_wrap').size() > 0) {
		jQuery('.mobile_menu_btn').on('click', function () {
			jQuery('#header_mobile_wrap .menu-primary-menu-container-wrap').slideToggle();
		});
		
		jQuery('#header_mobile_wrap ul.sub-menu').hide();
		jQuery('#header_mobile_wrap .menu-item-has-children').children('a').on('click', function(event) {
			event.preventDefault();
			jQuery(this).toggleClass('submenu_open');
			jQuery(this).next('ul').slideToggle(300);
		});
	}
	
	jQuery('h3#reply-title').each(function(){
		var divider_active = jQuery('.divider_active').html();
		jQuery(this).after('<div class="divider_active">' + divider_active + '</div>');
	});
	
	//	Contact Form 6 focus
	if (jQuery('.cstheme_contactform_type6').size() > 0) {
		jQuery('.cstheme_contactform_type6 span').each(function(){
			jQuery('.wpcf7-form-control').blur(function() {
				jQuery('.wpcf7-form-control').parent().removeClass("focus");
			}).focus(function() {
				jQuery(this).parent().addClass("focus")
			});
		});
	}
	
	//	Contact Form 5 focus
	if (jQuery('.cstheme_contactform_type5').size() > 0) {
		jQuery('.cstheme_contactform_type5 span').each(function(){
			jQuery('.wpcf7-form-control').blur(function() {
				jQuery('.wpcf7-form-control').parent().removeClass("focus");
			}).focus(function() {
				jQuery(this).parent().addClass("focus")
			});
		});
	}
	
	//	Contact Form 9 focus
	if (jQuery('.cstheme_contactform_type9').size() > 0) {
		jQuery('.cstheme_contactform_type9 span').each(function(){
			jQuery('.wpcf7-form-control').blur(function() {
				jQuery('.wpcf7-form-control').parent().removeClass("focus");
			}).focus(function() {
				jQuery(this).parent().addClass("focus")
			});
		});
	}
	
	//	Contact Form 10 focus
	if (jQuery('.cstheme_contactform_type10').size() > 0) {
		jQuery('.cstheme_contactform_type10 span').each(function(){
			jQuery('.wpcf7-form-control').blur(function() {
				jQuery('.wpcf7-form-control').parent().removeClass("focus");
			}).focus(function() {
				jQuery(this).parent().addClass("focus")
			});
		});
	}
	
	//	MailChimp focus
	if (jQuery('.mc4wp-form-fields').size() > 0) {
		jQuery('.mc4wp-form-fields .mc4wp_email_wrap').each(function(){
			jQuery('input').blur(function() {
				jQuery('input').parent().removeClass("focus");
			}).focus(function() {
				jQuery(this).parent().addClass("focus")
			});
		});
	}
	
	//	if no Related Posts
	if( jQuery('#related_posts_list .item').length < 1 ) {
		jQuery('#related_posts_list').hide();
	}
	
	exito_subscribe_form();
	
});


jQuery(window).load(function(){
	"use strict";
	
	//	Video Iframe Size
	exito_video_size();
	
	//	Evatheme Preloader
	setTimeout(function () {
		jQuery('.evatheme_preloader').fadeOut();
	}, 1000);
	
	setTimeout(function () {
		exitoSidebarHeight();
	}, 2000);
	
	if (jQuery("#portfolio_list.carousel").size() > 0) {
		jQuery("#portfolio_list").each(function(){
			jQuery(this).find(".owl-prev").empty().append("<i class='fa fa-angle-left'></i>");
			jQuery(this).find(".owl-next").empty().append("<i class='fa fa-angle-right'></i>");
		});
	}
	
	
	//	VC Gallery Img Alt
	if (jQuery(".wpb_image_grid_uls").size() > 0) {
		jQuery(".wpb_image_grid_uls li").each(function(){
			var gal_alt = jQuery(this).find('img').attr('alt');
			jQuery(this).find('.wpb_gallery_img_alt').append(gal_alt);
		});
	}
	
	if (jQuery('header.header-left').size() > 0) {
		exito_LeftMenuFunc();
	}
	
	//	Blog Posts Metro Style size
	if (jQuery('#blog_list.metro').size() > 0) {
		exitoBlogMetroHeight();
	}
	
	//	Related Posts Carousel
	if (jQuery("#related_posts_list").size() > 0) {
		jQuery('#related_posts_list .owl-carousel').owlCarousel({
			margin: 30,
			dots: false,
			nav: false,
			autoplay: true,
			autoplaySpeed: 1000,
			autoplayTimeout: 3000,
			navSpeed: 1000,
			autoplayHoverPause: true,
			responsive: {
				0: {items: 1},
				481: {items: 2},
				769: {items: 2},
				1025: {items: 3}
			}
		});
	}
	
	exito_page404_h();
	
	exito_coming_soon_h();
	
	exito_portfolio_odd();
	
	exito_blog_card_minheight();
	
	exito_slickSliderAr();
	
	exito_singlepost_fullscreen();
	
	exito_footerFixed();
	
	exito_blogTopImageMinH();
	
	//	Post Likes
	exito_PostLikes();
	
});

jQuery(window).resize(function(){
	"use strict";
	
	//Topbar Sticky
	exito_headerSticky();
	
	if (jQuery('header.header-left').size() > 0) {
		exito_LeftMenuFunc();
	}
	
	//	Blog Posts Metro Style size
	if (jQuery('#blog_list.metro').size() > 0) {
		exitoBlogMetroHeight();
	}
	
	//	Video Iframe Size
	exito_video_size();
	
	exito_post_gallery_carousel();
	
	exito_page404_h();
	
	exito_coming_soon_h();
	
	exitoHeaderHeight();
	
	exitoSidebarHeight();
	
	exito_subscribe_form();
	
	exito_portfolio_odd();
	
	exito_blog_bgimg_size();
	
	exito_blog_card_minheight();
	
	exito_slickSliderAr();
	
	exito_singlepost_fullscreen();
	
	exito_footerFixed();
	
	exito_blogTopImageMinH();
	
});

jQuery(window).scroll(function(){
	"use strict";
	
	//	Topbar Sticky
	exito_headerSticky();

	
	//	if Footer fixed and site boxed
	if (jQuery('body.boxed footer.fixed').size() > 0) {
		if( jQuery(window).scrollTop() + jQuery(window).height() > jQuery(document).height() - 10) {
			jQuery('footer.fixed').addClass('active');
		} else {
			jQuery('footer.fixed').removeClass('active');
		}
	}
});