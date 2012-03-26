/**
 * jGrowl 1.2.0
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 * Written by Stan Lemon <stanlemon@mac.com> 
 */
(function($) {
	
	$.jGrowl = function( m , o ) {
		// To maintain compatibility with older version that only supported one instance we'll create the base container.
		if ( $('#jGrowl').size() == 0 ) $('<div id="jGrowl"></div>').addClass($.jGrowl.defaults.position).appendTo('body');
		// Create a notification on the container.
		$('#jGrowl').jGrowl(m,o);
	};
	
	$.fn.jGrowl = function( m , o ) {
		if ( $.isFunction(this.each) ) {
			var args = arguments;
			return this.each(function() {
				var self = this;
				/** Create a jGrowl Instance on the Container if it does not exist **/
				if ( $(this).data('jGrowl.instance') == undefined ) {
					$(this).data('jGrowl.instance', new $.fn.jGrowl());
					$(this).data('jGrowl.instance').startup( this );
				}
				/** Optionally call jGrowl instance methods, or just raise a normal notification **/
				if ( $.isFunction($(this).data('jGrowl.instance')[m]) ) {
					$(this).data('jGrowl.instance')[m].apply( $(this).data('jGrowl.instance') , $.makeArray(args).slice(1) );
				} else {
					$(this).data('jGrowl.instance').create( m , o );
				}
			});
		};
	};

	$.extend( $.fn.jGrowl.prototype , {

		/** Default JGrowl Settings **/
		defaults: {
			pool: 			0,
			header: 		'',
			group: 			'',
			sticky: 		false,
			position: 		'top-right', // Is this still needed?
			glue: 			'after',
			theme: 			'default',
			corners: 		'10px',
			check: 			250,
			life: 			3000,
			speed: 			'normal',
			easing: 		'swing',
			closer: 		true,
			closeTemplate: '&times;',
			closerTemplate: '<div>[ fechar todos ]</div>',
			log: 			function(e,m,o) {},
			beforeOpen: 	function(e,m,o) {},
			open: 			function(e,m,o) {},
			beforeClose: 	function(e,m,o) {},
			close: 			function(e,m,o) {},
			animateOpen: 	{
				opacity: 	'show'
			},
			animateClose: 	{
				opacity: 	'hide'
			}
		},
		
		notifications: [],		
		element: 	null,
		interval:   null,
		
		/** Create a Notification **/
		create: 	function( message , o ) {
			var o = $.extend({}, this.defaults, o);
			this.notifications[ this.notifications.length ] = { message: message , options: o };			
			o.log.apply( this.element , [this.element,message,o] );
		},
		
		render: 		function( notification ) {
			var self = this;
			var message = notification.message;
			var o = notification.options;

			var notification = $('<div class="jGrowl-notification' + ((o.group != undefined && o.group != '') ? ' ' + o.group : '') + '"><div class="close">' + o.closeTemplate + '</div><div class="header">' + o.header + '</div><div class="message">' + message + '</div></div>')
				.data("jGrowl", o).addClass(o.theme).children('div.close').bind("click.jGrowl", function() {
					$(this).parent().trigger('jGrowl.close');
				}).parent();
				
			( o.glue == 'after' ) ? $('div.jGrowl-notification:last', this.element).after(notification) : $('div.jGrowl-notification:first', this.element).before(notification);

			/** Notification Actions **/
			$(notification).bind("mouseover.jGrowl", function() {
				$(this).data("jGrowl").pause = true;
			}).bind("mouseout.jGrowl", function() {
				$(this).data("jGrowl").pause = false;
			}).bind('jGrowl.beforeOpen', function() {
				o.beforeOpen.apply( self.element , [self.element,message,o] );
			}).bind('jGrowl.open', function() {
				o.open.apply( self.element , [self.element,message,o] );
			}).bind('jGrowl.beforeClose', function() {
				o.beforeClose.apply( self.element , [self.element,message,o] );
			}).bind('jGrowl.close', function() {
				$(this).trigger('jGrowl.beforeClose').animate(o.animateClose, o.speed, o.easing, function() {
					$(this).remove();
					o.close.apply( self.element , [self.element,message,o] );
				});
			}).trigger('jGrowl.beforeOpen').animate(o.animateOpen, o.speed, o.easing, function() {
				$(this).data("jGrowl").created = new Date();
			}).trigger('jGrowl.open');
		
			/** Optional Corners Plugin **/
			if ( $.fn.corner != undefined ) $(notification).corner( o.corners );

			/** Add a Global Closer if more than one notification exists **/
			if ( $('div.jGrowl-notification:parent', this.element).size() > 1 && $('div.jGrowl-closer', this.element).size() == 0 && this.defaults.closer != false ) {
				$(this.defaults.closerTemplate).addClass('jGrowl-closer').addClass(this.defaults.theme).appendTo(this.element).animate(this.defaults.animateOpen, this.defaults.speed, this.defaults.easing).bind("click.jGrowl", function() {
					$(this).siblings().children('div.close').trigger("click.jGrowl");

					if ( $.isFunction( self.defaults.closer ) ) self.defaults.closer.apply( $(this).parent()[0] , [$(this).parent()[0]] );
				});
			};
		},

		/** Update the jGrowl Container, removing old jGrowl notifications **/
		update:	 function() {
			$(this.element).find('div.jGrowl-notification:parent').each( function() {
				if ( $(this).data("jGrowl") != undefined && $(this).data("jGrowl").created != undefined && ($(this).data("jGrowl").created.getTime() + $(this).data("jGrowl").life)  < (new Date()).getTime() && $(this).data("jGrowl").sticky != true && 
					 ($(this).data("jGrowl").pause == undefined || $(this).data("jGrowl").pause != true) ) {
					$(this).trigger('jGrowl.close');
				}
			});

			if ( this.notifications.length > 0 && (this.defaults.pool == 0 || $(this.element).find('div.jGrowl-notification:parent').size() < this.defaults.pool) ) {
				this.render( this.notifications.shift() );
			}

			if ( $(this.element).find('div.jGrowl-notification:parent').size() < 2 ) {
				$(this.element).find('div.jGrowl-closer').animate(this.defaults.animateClose, this.defaults.speed, this.defaults.easing, function() {
					$(this).remove();
				});
			};
		},

		/** Setup the jGrowl Notification Container **/
		startup:	function(e) {
			this.element = $(e).addClass('jGrowl').append('<div class="jGrowl-notification"></div>');
			this.interval = setInterval( function() { 
				jQuery(e).data('jGrowl.instance').update(); 
			}, this.defaults.check);
			
			if ($.browser.msie && parseInt($.browser.version) < 7 && !window["XMLHttpRequest"]) $(this.element).addClass('ie6');
		},

		/** Shutdown jGrowl, removing it and clearing the interval **/
		shutdown:   function() {
			$(this.element).removeClass('jGrowl').find('div.jGrowl-notification').remove();
			clearInterval( this.interval );
		}
	});
	
	/** Reference the Defaults Object for compatibility with older versions of jGrowl **/
	$.jGrowl.defaults = $.fn.jGrowl.prototype.defaults;

})(jQuery);