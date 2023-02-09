/* Description: Custom JS file */
(function($) {
    "use strict"; 
    
    // jQuery for page scrolling feature - requires jQuery Easing plugin
    $(function() {
        $(document).on('click', 'a.page-scroll', function(event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top
            }, 600, 'easeInOutExpo');
            event.preventDefault();
        });
    });

    /* Countdown Timer - The Final Countdown */
    $('#clock').countdown(register_end_date) /* change here your "countdown to" date */
    .on('update.countdown', function(event) {
        var format = `<span class="counter-number">%D<br><span class="timer-text">${langs.countTimeDays}</span></span><span class="counter-number">%H<br><span class="timer-text">${langs.countTimeHours}</span></span><span class="counter-number">%M<br><span class="timer-text">${langs.countTimeMinutes}</span></span><span class="counter-number">%S<br><span class="timer-text">${langs.countTimeSeconds}</span></span>`;
        $(this).html(event.strftime(format));
    })
    .on('finish.countdown', function(event) {
    $(this).html(langs.eventExpired)
        .parent().addClass('disabled');
    });


})(jQuery);