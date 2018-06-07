/* global paramsForJs */
/**
 * Theme functions file.
 *
 * Contains handler for navigation.
 */

( function( $ ) {
// header height
if ( 1 == paramsForJs.isheader ) {
	$( document ).ready( function() {
		var clientHeight = $(window).height();
		$('#headerwrap').css('height', clientHeight);		
	});
}
// Sidr
	$(document).ready(function() {
		if ($('#menu-button').css("display") == "none" ){
			$.sidr('close', 'sidr');
			$('#sidr').css('display','block');
			$('#sidr').css('transition','');
			$('#sidr').removeClass("sidr right");
		} else {
			$('#menu-button').sidr({
				side: 'right',
				speed: 200
			});
			$('#sidr').css('display','block');				
		}
		$(window).resize(function () {
			if ($('#menu-button').css("display") == "none" ){
				$.sidr('close', 'sidr');
				$('#sidr').css('display','block');
				$('#sidr').css('transition','');
				$('#sidr').removeClass("sidr right");
			} else {
				$('#menu-button').sidr({
					side: 'right',
					speed: 200
				});
				$('#sidr').css('display','block');				
			}
		});
	});
// smartmenu	
	$( document ).ready( function() {
		$('#main-menu').smartmenus({
			subMenusSubOffsetX: 1,
			subMenusSubOffsetY: -6,
			markCurrentItem: true,
			markCurrentTree: false
		});
	});

// fit logo text width
	$( document ).ready( function() {
		var resizer = function () {
			var presettitlefontSize = paramsForJs.titlefontsize;
			var presettaglinefontSize = paramsForJs.taglinefontsize;
			var titleWidth = $('.site-title span').width();
			var taglineWidth = $('.site-description span').width();
			var containerWidth = $('.site-branding').width();	
			var newtitlefontSize = Math.min( containerWidth / titleWidth * presettitlefontSize, presettitlefontSize);
			var newtaglinefontSize = Math.min( containerWidth / taglineWidth * presettaglinefontSize, presettaglinefontSize);
			if (titleWidth > containerWidth) {
				$('.site-title').animate({ fontSize: newtitlefontSize }, 200);
			}
			if (taglineWidth > containerWidth) {
				$('.site-description').animate({ fontSize: newtaglinefontSize }, 200);
			}
		};
		// Call once to set.
//		resizer();
		// Call on resize. Opera debounces their resize by default.
//		$(window).on('resize orientationchange', resizer);		
	});

// padding-bottom of #contentwrap depending on the #footerwrap height, to put the footer to the bottom
	$( document ).ready( function() {
		var contentpadding = function () {
			var footerHeight = $('#footerwrap').innerHeight();
			$('#contentwrap').css("padding-bottom", footerHeight);
		};
		// Call once to set.
		contentpadding();

		// Call on resize. Opera debounces their resize by default.
		$(window).on('resize orientationchange', contentpadding);
	});
} )( jQuery );