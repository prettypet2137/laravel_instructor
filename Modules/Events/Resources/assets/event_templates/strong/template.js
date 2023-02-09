
(function($) {
    "use strict"; 
	
	/* Countdown Timer */
	$('.clock').countdown(register_end_date)
	.on('update.countdown', function(event) {
		var format = `<span class="counter-number">%D<br><span class="timer-text">${langs.countTimeDays}</span></span><span class="separator">:</span><span class="counter-number">%H<br><span class="timer-text">${langs.countTimeHours}</span></span><span class="separator">:</span><span class="counter-number">%M<br><span class="timer-text">${langs.countTimeMinutes}</span></span><span class="separator">:</span><span class="counter-number">%S<br><span class="timer-text">${langs.countTimeSeconds}</span></span>`;
		$(this).html(event.strftime(format));
	})
	.on('finish.countdown', function(event) {
	$(this).html(langs.eventExpired)
		.parent().addClass('disabled');
	});

	/* Initialize Form Popup  */
	$('.popup-with-move-anim-form').magnificPopup({
		type: 'inline',
		fixedContentPos: false,
		fixedBgPos: true,
		overflowY: 'auto',
		closeBtnInside: true,
		preloader: false,
		
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-slide-bottom'
	});
	
	
})(jQuery);