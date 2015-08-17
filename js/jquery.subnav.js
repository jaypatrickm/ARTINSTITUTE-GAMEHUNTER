// Sub Nav 
$(document).ready(function(){
	jQuery.noConflict();
jQuery('.subNav, .subNav2, .subNav3, .subNav4, .subNav5').hide();
jQuery('.subNavTextXbox, .subNavTextPs3, .subNavTextWii, .subNavText3DS, .subNavTextPSVita').hide();
		
		jQuery('#xbox360Nav').click( function(){	
			jQuery('#xbox360Nav a:link').css('color', '#699635');
			jQuery('#ps3Nav a:link').css('color', '');
			jQuery('#wiiNav a:link').css('color', '');
			jQuery('#dsNav a:link').css('color', '');
			jQuery('#psvitaNav a:link').css('color', '');
			jQuery('.subNav2').hide();
			jQuery('.subNav3').hide();
			jQuery('.subNav4').hide();
			jQuery('.subNav5').hide();
			jQuery('.subNav').slideDown();
			jQuery('.subNav').css('background-color', '#699635')});
		jQuery('#ps3Nav').click( function(){	
			jQuery('#ps3Nav a:link').css('color', '#354e96');
			jQuery('#xbox360Nav a:link').css('color', '');
			jQuery('#wiiNav a:link').css('color', '');
			jQuery('#dsNav a:link').css('color', '');
			jQuery('#psvitaNav a:link').css('color', '');
			jQuery('.subNav').hide();
			jQuery('.subNav3').hide();
			jQuery('.subNav4').hide();
			jQuery('.subNav5').hide();
			jQuery('.subNav2').slideDown();
			jQuery('.subNav2').css('background-color', '#354e96')});
		jQuery('#wiiNav').click( function(){
			jQuery('#wiiNav a:link').css('color', '#359096');
			jQuery('#ps3Nav a:link').css('color', '');
			jQuery('#xbox360Nav a:link').css('color', '');
			jQuery('#dsNav a:link').css('color', '');
			jQuery('#psvitaNav a:link').css('color', '');	
			jQuery('.subNav').hide();
			jQuery('.subNav2').hide();
			jQuery('.subNav4').hide();
			jQuery('.subNav5').hide();
			jQuery('.subNav3').slideDown();
			jQuery('.subNav3').css('background-color', '#359096')});
		jQuery('#dsNav').click( function(){	
			jQuery('#dsNav a:link').css('color', '#4c3596');
			jQuery('#ps3Nav a:link').css('color', '');
			jQuery('#wiiNav a:link').css('color', '');
			jQuery('#xbox360Nav a:link').css('color', '');
			jQuery('#psvitaNav a:link').css('color', '');
			jQuery('.subNav').hide();
			jQuery('.subNav2').hide();
			jQuery('.subNav3').hide();
			jQuery('.subNav5').hide();
			jQuery('.subNav4').slideDown();
			jQuery('.subNav4').css('background-color', '#4c3596')});
		jQuery('#psvitaNav').click( function(){	
			jQuery('#psvitaNav a:link').css('color', '#963535');
			jQuery('#ps3Nav a:link').css('color', '');
			jQuery('#wiiNav a:link').css('color', '');
			jQuery('#dsNav a:link').css('color', '');
			jQuery('#xbox360Nav a:link').css('color', '');
			jQuery('.subNav').hide();
			jQuery('.subNav2').hide();
			jQuery('.subNav3').hide();
			jQuery('.subNav4').hide();
			jQuery('.subNav5').slideDown();
			jQuery('.subNav5').css('background-color', '#963535')});
});