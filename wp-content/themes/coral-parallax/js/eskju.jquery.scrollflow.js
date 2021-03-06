/* global paramsForPara */
/*
 * jQuery ScrollFlow plugin
 *
 * Copyright (c) 2015 Christian Witte
 * licensed under MIT license.
 *
 * https://github.com/eskju/eskju-jquery-scrollflow
 *
 * Version: 1.0.0
 * 
 * Licensed under MIT license.
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software 
 * and associated documentation files (the "Software"), to deal in the Software without restriction, 
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, 
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, 
 * subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all copies or substantial 
 * portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT 
 * LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. 
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE 
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
(function($) {
	(function(a){(jQuery.browser=jQuery.browser||{}).mobile=/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od|ad)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|nexus|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))})(navigator.userAgent||navigator.vendor||window.opera);
	$( document ).ready( function()
	{
		var clientWidth = $(window).width();
		if ( jQuery.browser.mobile == false && 1300 < clientWidth ) {
			new ScrollFlow();
		} else {
			return;
		}
	});

	$.fn.ScrollFlow = function( options )
	{
		new ScrollFlow( options );
	}
	
	ScrollFlow = function( options )
	{
		this.init( options );
	}
	
	$.extend( ScrollFlow.prototype,
	{
		init : function( options )
		{
			this.options = $.extend(
			{
				useMobileTimeouts: true, // not supported yet
				mobileTimeout: 100, // not supported yet
				durationOnLoad: 500,
				durationOnResize: 250,
				durationOnScroll: paramsForPara.duration
			}, options );
			
			this.lastScrollTop = 0;
			this.bindScroll();
			this.bindResize();
			this.update( this.options.durationOnLoad );
		},
		
		bindScroll : function()
		{
			var $this = this;
			
			$( window ).scroll( function()
			{
			 	$this.update();
			});

			$( window ).bind( "gesturechange", function()
			{
			 	$this.update();
			});
		},
		
		bindResize: function()
		{
			var $this = this;
			
			$( window ).resize( function()
			{
			 	$this.update( $this.options.durationOnResize );
			});
		},
		
		update: function( forcedDuration )
		{
			var $this = this;
			
			winHeight = $( window ).height();
			scrollTop = $( window ).scrollTop();
			
			$( ".scrollflow" ).each( function( key, obj )
			{
				objOffset = $( obj ).offset();
				objOffsetTop = parseInt( objOffset.top );
				
				// request object settings
				effectDuration = $this.options.durationOnScroll;
				effectDuration = typeof( forcedDuration ) != "undefined" ? forcedDuration : effectDuration;
				effectiveFromPercentage = ( !isNaN( parseInt( $( obj ).attr( "data-scrollflow-start" ) / 100 ) ) ? parseInt( $( obj ).attr( "data-scrollflow-start" ) ) / 100 : -0.25 );
				scrollDistancePercentage = ( !isNaN( parseInt( $( obj ).attr( "data-scrollflow-distance" ) / 100 ) ) ? parseInt( $( obj ).attr( "data-scrollflow-distance" ) ) / 100 : 0.5 );
				effectiveFrom = objOffsetTop - winHeight * ( 1 - effectiveFromPercentage );
				effectiveTo = objOffsetTop - winHeight * ( 1 - scrollDistancePercentage );
				// end object settings
				
				parallaxScale = 0.8;
				parallaxOpacity = 0;
				parallaxOffset = -100;
				factor = 0;
				
				if( scrollTop > effectiveFrom )
				{
					factor = ( scrollTop - effectiveFrom ) / ( effectiveTo - effectiveFrom );
					factor = ( factor > 1 ? 1 : factor );
				}
				
				options = {
					opacity: 1,
					scale: 1,
					translateX: 0,
					translateY: 0
				};
		
				if( $( obj ).hasClass( "-opacity" ) )
				{
					options.opacity = 0 + factor;
				}
				
				if( $( obj ).hasClass( "-pop" ) )
				{
					options.scale = 0.5 + factor * 0.5;
				}
				
				if( $( obj ).hasClass( "-slide-left" ) )
				{
					options.translateX = ( -100 + factor * 100 ) * -1;
				}
				
				if( $( obj ).hasClass( "-slide-right" ) )
				{
					options.translateX = ( -100 + factor * 100 );
				}
				
				if( $( obj ).hasClass( "-slide-top" ) )
				{
					options.translateY = ( -100 + factor * 100 ) * -1;
				}
				
				if( $( obj ).hasClass( "-slide-bottom" ) )
				{
					options.translateY = ( -100 + factor * 100 );
				}
				
				$( obj ).css({
					webkitFilter: "opacity(" + options.opacity + ")",
					mozFilter: "opacity(" + options.opacity + ")",
					oFilter: "opacity(" + options.opacity + ")",
					msFilter: "opacity(" + options.opacity + ")",
					filter: "opacity(" + options.opacity + ")",
					
					webkitTransform: "translate3d( " + parseInt( options.translateX ) + "px, " + parseInt( options.translateY ) + "px, 0px ) scale(" + options.scale + ")",
					mozTransform: "translate3d( " + parseInt( options.translateX ) + "px, " + parseInt( options.translateY ) + "px, 0px ) scale(" + options.scale + ")",
					oTransform: "translate3d( " + parseInt( options.translateX ) + "px, " + parseInt( options.translateY ) + "px, 0px ) scale(" + options.scale + ")",
					msTransform: "translate3d( " + parseInt( options.translateX ) + "px, " + parseInt( options.translateY ) + "px, 0px ) scale(" + options.scale + ")",
					transform: "translate3d( " + parseInt( options.translateX ) + "px, " + parseInt( options.translateY ) + "px, 0px ) scale(" + options.scale + ")",
					
					transition: "all " + effectDuration + "ms ease-out"
				});
			});
			
			return;
		}
	});
})(jQuery);	