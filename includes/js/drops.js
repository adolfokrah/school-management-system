var main = function() {

	//The search for dropdown
	$('#searchFor > span, #searchFor > i').click(function() {
		$('#searchDrop').toggle('300ms');
	});
	// End of dropdown toggle

	$('#searchDrop > li').click(function() {
		$('#searchDrop').toggle('300ms');
	});
	// Hide dropdown after a list item is selected

	var placeShown = false;
	var thingShown = false;

	$('#place').click(function(){
		if ((placeShown===false) && (thingShown===false)) {
			$('#sHint').addClass('hidden');
			$('#placeEx').removeClass('hidden');
		}
		if ((placeShown===false) && (thingShown===true)) {
			$('#thingEx').addClass('hidden');
			$('#placeEx').removeClass('hidden');
			$('#thing').removeClass('active');
		}
		$('#place').addClass('active');
		placeShown = true;
		thingShown = false;
	});
	// end of PLACE click event

	$('#thing').click(function() {
		if ((thingShown===false) && (placeShown===false)) {
			$('#sHint').addClass('hidden');
			$('#thingEx').removeClass('hidden');
		}
		if ((thingShown===false) && (placeShown===true)) {
			$('#placeEx').addClass('hidden');
			$('#thingEx').removeClass('hidden');
			$('#place').removeClass('active');
		}
		$('#thing').addClass('active');
		thingShown = true;
		placeShown = false;
	});

	// ======================================================================================================================
	//						The Sidebar

	var sidebar = $('aside');
	var overlay = $('.overlay');
	var sbVisible = false;
	var mqWideMatch = window.matchMedia('screen and (min-width: 993px)');
	var mqNarrowMatch = window.matchMedia('screen and (max-width: 992px)');

	$('#menu-btn').click(function() {
		sidebar.animate({left: '0px'}, "300ms");
		overlay.removeClass('hidden');
		sbVisible = true;
	});//Show sidebar and overlay on menu-btn click
	$('.nav-close').click(function() {
		sidebar.animate({left: '-250px'}, "300ms");
		overlay.addClass('hidden');
		sbVisible = false;
	});//hide sidebar and overlay on close-btn click
	overlay.click(function() {
		sidebar.animate({left: '-250px'}, "300ms");
		overlay.addClass('hidden');
		sbVisible = false;
	});//hide sidebar and overlay on overlay click

	$(window).resize(function() {
		if ((mqWideMatch.matches) && (sbVisible===false)) {
			sidebar.animate({left: '0px'}, "300ms");
			overlay.addClass('hidden');
			sbVisible = false;
		}
		else if ((mqWideMatch.matches) && (sbVisible)) {
			sidebar.animate({left: '0px'}, "300ms");
			overlay.addClass('hidden');
			sbVisible = true;
		}
		else if ((mqNarrowMatch.matches) && (sbVisible)) {
			overlay.removeClass('hidden');
			sbVisible = true;
		}
		else if ((mqNarrowMatch.matches) && (sbVisible===false)) {
			sidebar.animate({left: '-250px'}, "300ms");
			overlay.addClass('hidden');
			sbVisible = false;
		}
	});

	//==================================================================================================			    	The Footer Accordions
	var mqPhone = window.matchMedia('screen and (max-width: 500px)');

	$('#accOne, #onedown, #oneup').click(function() {
		if (mqPhone.matches) {
			$('#accOne-content').toggle('100ms');
			$('#onedown').toggle('100ms');
			$('#oneup').toggle('100ms');
			$('body').animate({
				scrollTop: 10000
			});
		}
	});	// The downloads Accordions
	$('#accTwo, #twodown, #twoup').click(function() {
		if (mqPhone.matches) {
			$('#accTwo-content').toggle('100ms');
			$('#twodown').toggle('100ms');
			$('#twoup').toggle('100ms');
			$('body').animate({
				scrollTop: 10000
			});
		}
	});	// The info accordion 1
	$('#accThree, #threedown, #threeup').click(function() {
		if (mqPhone.matches) {
			$('#accThree-content').toggle('100ms');
			$('#threedown').toggle('100ms');
			$('#threeup').toggle('100ms');
			$('body').animate({
				scrollTop: 10000
			});
		}
	}); // The info accordion 2

	// Restoring to default on resize
	$(window).resize(function() {
		if (mqPhone.matches===false) {
			$('#accTwo-content, #accOne-content, #accThree-content').show('100ms');
			$('#onedown, #oneup, #twodown, #twoup, #threeup, #threedown').hide('50ms');
		}
		else if (mqPhone.matches) {
			$('#accTwo-content, #accOne-content, #accThree-content').hide('50ms');
			$('#onedown, #twodown, #threedown').show('50ms');
			$('#oneup, #twoup, #threeup').hide('50ms');
		}
	});
	

/*=============================================================== The Mobile Money Interface =============================================================== */
	
	$('#regSubmit').click(function() {
		$('#paymentInt').toggle('300ms');
	});
	$('#paymentSend').click(function() {
		$('.loading').show();
	});
	
	$('#commitChanges').click(function() {
		$('#paymentInt').toggle('300ms');
	});
	
	
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip();
	});
	$('.hinter').click(function(){
		$('.clove').toggle('300ms');
		$('#normal').animate({
			marginTop: '-7px'
		}, '200ms');
	});
	
	
	/* =================================
	Tab Scroll 
	================================== */
	
	var tbsXsmall = window.matchMedia('screen and (max-width: 767px)');
	
	$('.nav-pills>li>a').click(function(){
		if(tbsXsmall.matches){
			$('body').animate({
				scrollTop: 730
			});
		}
		else {
			$('body').animate({
				scrollTop: 255
			});
		}
	});	
	
	// The Edit tab toggle 			
	$('.item-edit').click(function(){
		$('#rmvd').removeClass('active');
		$('#rcvd').addClass('active');
	});
	
};


$(document).ready(main);









