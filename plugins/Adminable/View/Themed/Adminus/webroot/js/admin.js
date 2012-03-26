//= require "jquery-1.7.1.min"
//= require "jquery.maskedinput-1.3"
//= require "jquery.maskMoney"
//= require "jquery.tipsy"
//= require "jquery.jgrowl"
//= require "bootstrap.min"
//= require "jeip"
//= require "app.form"

jQuery( function($) {
	jQuery('a').tipsy({
		gravity: 's'
	});
	setTimeout( function() {
		jQuery('.flash').html('');
	}, 15000);
});