
/*
	By Osvaldas Valutis, www.osvaldas.info
	Available for use under the MIT License
*/

;( function( $, window, document, undefined )
{
	'use strict';

	var cssTransitionSupport = function()
		{
			var s = document.body || document.documentElement, s = s.style;
			if( s.WebkitTransition == '' ) return '-webkit-';
			if( s.MozTransition == '' ) return '-moz-';
			if( s.OTransition == '' ) return '-o-';
			if( s.transition == '' ) return '';
			return false;
		},

		isCssTransitionSupport = cssTransitionSupport() === false ? false : true,

		cssTransitionTranslateX = function( element, positionX, speed )
		{
			var options = {}, prefix = cssTransitionSupport();
			options[ prefix + 'transform' ]	 = 'translateX(' + positionX + ')';
			options[ prefix + 'transition' ] = prefix + 'transform ' + speed + 's linear';
			element.css( options );
		},

		hasTouch	= ( 'ontouchstart' in window ),
		hasPointers = window.navigator.pointerEnabled || window.navigator.msPointerEnabled,
		wasTouched	= function( event )
		{
			if( hasTouch )
				return true;

			if( !hasPointers || typeof event === 'undefined' || typeof event.pointerType === 'undefined' )
				return false;

			if( typeof event.MSPOINTER_TYPE_MOUSE !== 'undefined' )
			{
				if( event.MSPOINTER_TYPE_MOUSE != event.pointerType )
					return true;
			}
			else
				if( event.pointerType != 'mouse' )
					return true;

			return false;
		};

	$.fn.imageLightbox = function( options )
	{
		var options	   = $.extend(
						 {
						 	selector:		'id="imagelightbox"',
						 	allowedTypes:	'png|jpg|jpeg|gif',
						 	animationSpeed:	250,
						 	preloadNext:	true,
						 	enableKeyboard:	true,
						 	quitOnEnd:		false,
						 	quitOnImgClick: false,
						 	quitOnDocClick: true,
						 	onStart:		false,
						 	onEnd:			false,
						 	onLoadStart:	false,
						 	onLoadEnd:		false
						 },
						 options ),

			targets		= $([]),
			target		= $(),
			image		= $(),
			imageWidth	= 0,
			imageHeight = 0,
			swipeDiff	= 0,
			inProgress	= false,

			isTargetValid = function( element )
			{
				return $( element ).prop( 'tagName' ).toLowerCase() == 'a' && ( new RegExp( '\.(' + options.allowedTypes + ')$', 'i' ) ).test( $( element ).attr( 'href' ) );
			},

			setImage = function()
			{
				if( !image.length ) return true;

				var screenWidth	 = $( window ).width() * 0.8,
					screenHeight = $( window ).height() * 0.9,
					tmpImage 	 = new Image();

				tmpImage.src	= image.attr( 'src' );
				tmpImage.onload = function()
				{
					imageWidth	 = tmpImage.width;
					imageHeight	 = tmpImage.height;

					if( imageWidth > screenWidth || imageHeight > screenHeight )
					{
						var ratio	 = imageWidth / imageHeight > screenWidth / screenHeight ? imageWidth / screenWidth : imageHeight / screenHeight;
						imageWidth	/= ratio;
						imageHeight	/= ratio;
					}

					image.css(
					{
						'width':  imageWidth + 'px',
						'height': imageHeight + 'px',
						'top':    ( $( window ).height() - imageHeight ) / 2 + 'px',
						'left':   ( $( window ).width() - imageWidth ) / 2 + 'px'
					});
				};
			},

			loadImage = function( direction )
			{
				if( inProgress ) return false;

				direction = typeof direction === 'undefined' ? false : direction == 'left' ? 1 : -1;

				if( image.length )
				{
					if( direction !== false && ( targets.length < 2 || ( options.quitOnEnd === true && ( ( direction === -1 && targets.index( target ) == 0 ) || ( direction === 1 && targets.index( target ) == targets.length - 1 ) ) ) ) )
					{
						quitLightbox();
						return false;
					}
					var params = { 'opacity': 0 };
					if( isCssTransitionSupport ) cssTransitionTranslateX( image, ( 100 * direction ) - swipeDiff + 'px', options.animationSpeed / 1000 );
					else params.left = parseInt( image.css( 'left' ) ) + 100 * direction + 'px';
					image.animate( params, options.animationSpeed, function(){ removeImage(); });
					swipeDiff = 0;
				}

				inProgress = true;
				if( options.onLoadStart !== false ) options.onLoadStart();

				setTimeout( function()
				{
					image = $( '<img ' + options.selector + ' />' )
					.attr( 'src', target.attr( 'href' ) )
					.load( function()
					{
						image.appendTo( 'body' );
						setImage();

						var params = { 'opacity': 1 };

						image.css( 'opacity', 0 );
						if( isCssTransitionSupport )
						{
							cssTransitionTranslateX( image, -100 * direction + 'px', 0 );
							setTimeout( function(){ cssTransitionTranslateX( image, 0 + 'px', options.animationSpeed / 1000 ) }, 50 );
						}
						else
						{
							var imagePosLeft = parseInt( image.css( 'left' ) );
							params.left = imagePosLeft + 'px';
							image.css( 'left', imagePosLeft - 100 * direction + 'px' );
						}

						image.animate( params, options.animationSpeed, function()
						{
							inProgress = false;
							if( options.onLoadEnd !== false ) options.onLoadEnd();
						});
						if( options.preloadNext )
						{
							var nextTarget = targets.eq( targets.index( target ) + 1 );
							if( !nextTarget.length ) nextTarget = targets.eq( 0 );
							$( '<img />' ).attr( 'src', nextTarget.attr( 'href' ) ).load();
						}
					})
					.error( function()
					{
						if( options.onLoadEnd !== false ) options.onLoadEnd();
					})

					var swipeStart	 = 0,
						swipeEnd	 = 0,
						imagePosLeft = 0;

					image.on( hasPointers ? 'pointerup MSPointerUp' : 'click', function( e )
					{
						e.preventDefault();
						if( options.quitOnImgClick )
						{
							quitLightbox();
							return false;
						}
						if( wasTouched( e.originalEvent ) ) return true;
					    var posX = ( e.pageX || e.originalEvent.pageX ) - e.target.offsetLeft;
						target = targets.eq( targets.index( target ) - ( imageWidth / 2 > posX ? 1 : -1 ) );
						if( !target.length ) target = targets.eq( imageWidth / 2 > posX ? targets.length : 0 );
						loadImage( imageWidth / 2 > posX ? 'left' : 'right' );
					})
					.on( 'touchstart pointerdown MSPointerDown', function( e )
					{
						if( !wasTouched( e.originalEvent ) || options.quitOnImgClick ) return true;
						if( isCssTransitionSupport ) imagePosLeft = parseInt( image.css( 'left' ) );
						swipeStart = e.originalEvent.pageX || e.originalEvent.touches[ 0 ].pageX;
					})
					.on( 'touchmove pointermove MSPointerMove', function( e )
					{
						if( !wasTouched( e.originalEvent ) || options.quitOnImgClick ) return true;
						e.preventDefault();
						swipeEnd = e.originalEvent.pageX || e.originalEvent.touches[ 0 ].pageX;
						swipeDiff = swipeStart - swipeEnd;
						if( isCssTransitionSupport ) cssTransitionTranslateX( image, -swipeDiff + 'px', 0 );
						else image.css( 'left', imagePosLeft - swipeDiff + 'px' );
					})
					.on( 'touchend touchcancel pointerup pointercancel MSPointerUp MSPointerCancel', function( e )
					{
						if( !wasTouched( e.originalEvent ) || options.quitOnImgClick ) return true;
						if( Math.abs( swipeDiff ) > 50 )
						{
							target = targets.eq( targets.index( target ) - ( swipeDiff < 0 ? 1 : -1 ) );
							if( !target.length ) target = targets.eq( swipeDiff < 0 ? targets.length : 0 );
							loadImage( swipeDiff > 0 ? 'right' : 'left' );	
						}
						else
						{
							if( isCssTransitionSupport ) cssTransitionTranslateX( image, 0 + 'px', options.animationSpeed / 1000 );
							else image.animate({ 'left': imagePosLeft + 'px' }, options.animationSpeed / 2 );
						}
					});

				}, options.animationSpeed + 100 );
			},

			removeImage = function()
			{
				if( !image.length ) return false;
				image.remove();
				image = $();
			},

			quitLightbox = function()
			{
				if( !image.length ) return false;
				image.animate({ 'opacity': 0 }, options.animationSpeed, function()
				{
					removeImage();
					inProgress = false;
					if( options.onEnd !== false ) options.onEnd();
				});
			};

		$( window ).on( 'resize', setImage );

		if( options.quitOnDocClick )
		{
			$( document ).on( hasTouch ? 'touchend' : 'click', function( e )
			{
				if( image.length && !$( e.target ).is( image ) ) quitLightbox();
			})
		}

		if( options.enableKeyboard )
		{
			$( document ).on( 'keyup', function( e )
			{
				if( !image.length ) return true;
				e.preventDefault();
				if( e.keyCode == 27 ) quitLightbox();
				if( e.keyCode == 37 || e.keyCode == 39 )
				{
					target = targets.eq( targets.index( target ) - ( e.keyCode == 37 ? 1 : -1 ) );
					if( !target.length ) target = targets.eq( e.keyCode == 37 ? targets.length : 0 );
					loadImage( e.keyCode == 37 ? 'left' : 'right' );
				}
			});
		}

		$( document ).on( 'click', this.selector, function( e )
		{
			if( !isTargetValid( this ) ) return true;
			e.preventDefault();
			if( inProgress ) return false;
			inProgress = false;
			if( options.onStart !== false ) options.onStart();
			target = $( this );
			loadImage();
		});

		this.each( function()
		{
			if( !isTargetValid( this ) ) return true;
			targets = targets.add( $( this ) );
		});

		this.switchImageLightbox = function( index )
		{
			var tmpTarget = targets.eq( index );
			if( tmpTarget.length )
			{
				var currentIndex = targets.index( target );
				target = tmpTarget;
				loadImage( index < currentIndex ? 'left' : 'right' );
			}
			return this;
		};

		this.quitImageLightbox = function()
		{
			quitLightbox();
			return this;
		};

		return this;
	};
})( jQuery, window, document );
(function($){
  $.fn.rowGrid = function( options ) {
    return this.each(function() {
      $this = $(this);
      if(options === 'appended') {
        options = $this.data('grid-options');
        var $lastRow = $this.children('.' + options.lastRowClass);
        var items = $lastRow.nextAll(options.itemSelector).add($lastRow);
        layout(this, options, items);
      } else {
        options = $.extend( {}, $.fn.rowGrid.defaults, options );
        $this.data('grid-options', options);
        layout(this, options);
        
        if(options.resize) {
          $(window).on('resize.rowGrid', {container: this}, function(event) {
            layout(event.data.container, options);
          });
        }
      }
    });
  };
  
  $.fn.rowGrid.defaults = {
    minMargin: null,
    maxMargin: null,
    resize: true,
    lastRowClass: 'last-row',
    firstItemClass: null
  };
 
  function layout(container, options, items) {
    var rowWidth = 0,
        rowElems = [],
        items = jQuery.makeArray(items || container.querySelectorAll(options.itemSelector)),
        itemsSize = items.length;
    // read
    var containerWidth = container.clientWidth-parseFloat($(container).css('padding-left'))-parseFloat($(container).css('padding-right'));
    var itemAttrs = [];
    var theImage;
    for(var i = 0; i < itemsSize; ++i) {
      theImage = items[i].getElementsByTagName('img')[0];
      if (!theImage) {
        items.splice(i, 1);
        --i;
        --itemsSize;
        continue;
      }
      // get width and height via attribute or js value
      itemAttrs[i] = {
        width: parseInt(theImage.getAttribute('width')) || theImage.offsetWidth,
        height: parseInt(theImage.getAttribute('height')) || theImage.offsetHeight
      };
    }
    itemsSize = items.length;

    // write
    for(var index = 0; index < itemsSize; ++index) {
      if (items[index].classList) {
        items[index].classList.remove(options.firstItemClass, options.lastRowClass);
      }
      else {
        // IE <10
        items[index].className = items[index].className.replace(new RegExp('(^|\\b)' + options.firstItemClass + '|' + options.lastRowClass + '(\\b|$)', 'gi'), ' ');
      }

      rowWidth += itemAttrs[index].width;
      rowElems.push(items[index]);
      
      // check if it is the last element
      if(index === itemsSize - 1) {
        for(var rowElemIndex = 0; rowElemIndex<rowElems.length; rowElemIndex++) {
          // if first element in row
          if(rowElemIndex === 0) {
            rowElems[rowElemIndex].className += ' ' + options.lastRowClass;
          }
          rowElems[rowElemIndex].style.cssText = 'margin-right:' + ((rowElemIndex < rowElems.length - 1)?options.minMargin+'px' : 0);
        }
      }      
      
      // check whether width of row is too high
      if(rowWidth + options.maxMargin * (rowElems.length - 1) > containerWidth) {
        var diff = rowWidth + options.maxMargin * (rowElems.length - 1) - containerWidth;
        var nrOfElems = rowElems.length;
        // change margin
        var maxSave = (options.maxMargin - options.minMargin) * (nrOfElems - 1);
        if(maxSave < diff) {
          var rowMargin = options.minMargin;
          diff -= (options.maxMargin - options.minMargin) * (nrOfElems - 1);
        } else {
          var rowMargin = options.maxMargin - diff / (nrOfElems - 1);
          diff = 0;
        }
        var rowElem,
          widthDiff = 0;
        for(var rowElemIndex = 0; rowElemIndex<rowElems.length; rowElemIndex++) {
          rowElem = rowElems[rowElemIndex];
          var rowElemWidth = itemAttrs[index+parseInt(rowElemIndex)-rowElems.length+1].width;
          var newWidth = rowElemWidth - (rowElemWidth / rowWidth) * diff;
          var newHeight = Math.round(itemAttrs[index+parseInt(rowElemIndex)-rowElems.length+1].height * (newWidth / rowElemWidth));
          if (widthDiff + 1 - newWidth % 1 >= 0.5 ) {
            widthDiff -= newWidth % 1;
            newWidth = Math.floor(newWidth);
          } else {
            widthDiff += 1 - newWidth % 1;
            newWidth = Math.ceil(newWidth);
          }
          rowElem.style.cssText =
              'width: ' + newWidth + 'px;' +
              'height: ' + newHeight + 'px;' +
              'margin-right: ' + ((rowElemIndex < rowElems.length - 1)?rowMargin : 0) + 'px';
          if(rowElemIndex === 0) {
            rowElem.className += ' ' + options.firstItemClass;
          }
        }
        rowElems = [],
          rowWidth = 0;
      }
    }
  }
})(jQuery);
/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 */
( function() {
	var container, button, menu;

	container = document.getElementById( 'site-navigation' );
	if ( ! container )
		return;

	button = container.getElementsByTagName( 'h1' )[0];
	if ( 'undefined' === typeof button )
		return;

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	if ( -1 === menu.className.indexOf( 'nav-menu' ) )
		menu.className += ' nav-menu';

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) )
			container.className = container.className.replace( ' toggled', '' );
		else
			container.className += ' toggled';
	};
} )();

( function() {
	var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
		is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
		is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

	if ( ( is_webkit || is_opera || is_ie ) && 'undefined' !== typeof( document.getElementById ) ) {
		var eventMethod = ( window.addEventListener ) ? 'addEventListener' : 'attachEvent';
		window[ eventMethod ]( 'hashchange', function() {
			var element = document.getElementById( location.hash.substring( 1 ) );

			if ( element ) {
				if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) )
					element.tabIndex = -1;

				element.focus();
			}
		}, false );
	}
})();

//========================
//  rowGrid.js
//========================
jQuery(document).ready(function($){
	jQuery(".gallery-full").rowGrid({itemSelector: ".gallery-item", minMargin: 20, maxMargin: 20, firstItemClass: "gallery-first-item"});
});

//========================
//  imagelightbox.js
//========================
jQuery( function( $ )
{
		// ACTIVITY INDICATOR

	var activityIndicatorOn = function()
		{
			$( '<div id="imagelightbox-loading"><div></div></div>' ).appendTo( 'body' );
		},
		activityIndicatorOff = function()
		{
			$( '#imagelightbox-loading' ).remove();
		},


		// OVERLAY

		overlayOn = function()
		{
			$( '<div id="imagelightbox-overlay"></div>' ).appendTo( 'body' );
		},
		overlayOff = function()
		{
			$( '#imagelightbox-overlay' ).remove();
		},


		// CLOSE BUTTON

		closeButtonOn = function( instance )
		{
			$( '<button type="button" id="imagelightbox-close" title="Close"></button>' ).appendTo( 'body' ).on( 'click touchend', function(){ $( this ).remove(); instance.quitImageLightbox(); return false; });
		},
		closeButtonOff = function()
		{
			$( '#imagelightbox-close' ).remove();
		},


		// CAPTION

		captionOn = function()
		{
			var description = $( 'a[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"] img' ).attr( 'alt' );
			if( description.length > 0 )
				$( '<div id="imagelightbox-caption">' + description + '</div>' ).appendTo( 'body' );
		},
		captionOff = function()
		{
			$( '#imagelightbox-caption' ).remove();
		},


		// NAVIGATION

		navigationOn = function( instance, selector )
		{
			var images = $( selector );
			if( images.length )
			{
				var nav = $( '<div id="imagelightbox-nav"></div>' );
				for( var i = 0; i < images.length; i++ )
					nav.append( '<button type="button"></button>' );

				nav.appendTo( 'body' );
				nav.on( 'click touchend', function(){ return false; });

				var navItems = nav.find( 'button' );
				navItems.on( 'click touchend', function()
				{
					var $this = $( this );
					if( images.eq( $this.index() ).attr( 'href' ) != $( '#imagelightbox' ).attr( 'src' ) )
						instance.switchImageLightbox( $this.index() );

					navItems.removeClass( 'active' );
					navItems.eq( $this.index() ).addClass( 'active' );

					return false;
				})
				.on( 'touchend', function(){ return false; });
			}
		},
		navigationUpdate = function( selector )
		{
			var items = $( '#imagelightbox-nav button' );
			items.removeClass( 'active' );
			items.eq( $( selector ).filter( '[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"]' ).index( selector ) ).addClass( 'active' );
		},
		navigationOff = function()
		{
			$( '#imagelightbox-nav' ).remove();
		},


		// ARROWS

		arrowsOn = function( instance, selector )
		{
			var $arrows = $( '<button type="button" class="imagelightbox-arrow imagelightbox-arrow-left"></button><button type="button" class="imagelightbox-arrow imagelightbox-arrow-right"></button>' );

			$arrows.appendTo( 'body' );

			$arrows.on( 'click touchend', function( e )
			{
				e.preventDefault();

				var $this	= $( this ),
					$target	= $( selector + '[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"]' ),
					index	= $target.index( selector );

				if( $this.hasClass( 'imagelightbox-arrow-left' ) )
				{
					index = index - 1;
					if( !$( selector ).eq( index ).length )
						index = $( selector ).length;
				}
				else
				{
					index = index + 1;
					if( !$( selector ).eq( index ).length )
						index = 0;
				}

				instance.switchImageLightbox( index );
				return false;
			});
		},
		arrowsOff = function()
		{
			$( '.imagelightbox-arrow' ).remove();
		};

/*
	//	WITH ACTIVITY INDICATION

	$( 'a[data-imagelightbox="a"]' ).imageLightbox(
	{
		onLoadStart:	function() { activityIndicatorOn(); },
		onLoadEnd:		function() { activityIndicatorOff(); },
		onEnd:			function() { activityIndicatorOff(); }
	});


	//	WITH OVERLAY & ACTIVITY INDICATION

	$( 'a[data-imagelightbox="b"]' ).imageLightbox(
	{
		onStart:	function() { overlayOn(); },
		onEnd:		function() { overlayOff(); activityIndicatorOff(); },
		onLoadStart: function() { activityIndicatorOn(); },
		onLoadEnd:	function() { activityIndicatorOff(); }
	});


	//	WITH "CLOSE" BUTTON & ACTIVITY INDICATION

	var instanceC = $( 'a[data-imagelightbox="c"]' ).imageLightbox(
	{
		quitOnDocClick:	false,
		onStart:		function() { closeButtonOn( instanceC ); },
		onEnd:			function() { closeButtonOff(); activityIndicatorOff(); },
		onLoadStart:	function() { activityIndicatorOn(); },
		onLoadEnd:		function() { activityIndicatorOff(); }
	});


	//	WITH CAPTION & ACTIVITY INDICATION

	$( 'a[data-imagelightbox="d"]' ).imageLightbox(
	{
		onLoadStart:	function() { captionOff(); activityIndicatorOn(); },
		onLoadEnd:		function() { captionOn(); activityIndicatorOff(); },
		onEnd:			function() { captionOff(); activityIndicatorOff(); }
	});


	//	WITH ARROWS & ACTIVITY INDICATION

	var selectorG = 'a[data-imagelightbox="g"]';
	var instanceG = $( selectorG ).imageLightbox(
	{
		onStart:		function(){ arrowsOn( instanceG, selectorG ); },
		onEnd:			function(){ arrowsOff(); activityIndicatorOff(); },
		onLoadStart:	function(){ activityIndicatorOn(); },
		onLoadEnd:		function(){ $( '.imagelightbox-arrow' ).css( 'display', 'block' ); activityIndicatorOff(); }
	});


	//	WITH NAVIGATION & ACTIVITY INDICATION

	var selectorE = 'a[data-imagelightbox="e"]';
	var instanceE = $( selectorE ).imageLightbox(
	{
		onStart:		function() { navigationOn( instanceE, selectorE ); },
		onEnd:			function() { navigationOff(); activityIndicatorOff(); },
		onLoadStart:	function() { activityIndicatorOn(); },
		onLoadEnd:		function() { navigationUpdate( selectorE ); activityIndicatorOff(); }
	});
*/

	//	ALL COMBINED

	var selectorF = 'a[data-imagelightbox="f"]';
	var instanceF = $( selectorF ).imageLightbox(
	{
		onStart:		function() { overlayOn(); closeButtonOn( instanceF ); arrowsOn( instanceF, selectorF ); },
		onEnd:			function() { overlayOff(); captionOff(); closeButtonOff(); arrowsOff(); activityIndicatorOff(); },
		onLoadStart:	function() { captionOff(); activityIndicatorOn(); },
		onLoadEnd:		function() { captionOn(); activityIndicatorOff(); $( '.imagelightbox-arrow' ).css( 'display', 'block' ); }
	});
});