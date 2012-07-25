jQuery(function($) {
	jQuery(':input')
		.filter('.phone').mask('(99) 9999-9999', {placeholder: ' '}).end()
		.filter('.zip,.cep,.zipcode').mask('99999-999', {placeholder: ' '}).end()
		.filter('.date').mask('99/99/9999', {placeholder: ' '}).end()
		.filter('.datetime').mask('99/99/9999 99:99', {placeholder: ' '}).end()
		.filter('.cpf').mask('999.999.999-99', {placeholder: ' '}).end()
		.filter('.cnpj').mask('99.999.999/9999-99', {placeholder: ' '}).end()
		.filter('.year').mask('9999', {placeholder: ' '}).end()
		.filter('.uf').mask('aa', {placeholder: ' '}).end()
		.filter('.rg').mask('99.999.999-*', {placeholder: ' '}).end()
		.filter('.money').maskMoney({showSymbol:false, thousands:'.', decimal:',', symbolStay: true}).end()
		.filter('.date-my').mask('99/9999', {placeholder: ' '});
		
	jQuery.each(jQuery('.error-message'), function(i,v) {
		error = jQuery(v);
		error.closest('.control-group').addClass('error');
		error.parent().find('.help-block').text(jQuery(this).text());
		error.empty();
	});
});