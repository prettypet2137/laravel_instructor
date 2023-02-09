(function($) {
  "use strict"; // Start of use strict

   // fix icon datetimepicker font-awesome 5
   $.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
      icons: {
          time: 'fas fa-clock',
          date: 'fas fa-calendar',
          up: 'fas fa-arrow-up',
          down: 'fas fa-arrow-down',
          previous: 'fas fa-chevron-left',
          next: 'fas fa-chevron-right',
          today: 'fas fa-calendar-check-o',
          clear: 'fas fa-trash',
          close: 'fas fa-times'
  }});
  $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
    $(".sidebar").toggleClass("toggled");
    if ($(".sidebar").hasClass("toggled")) {
      $('.sidebar .collapse').collapse('hide');
    };
  });
  
  if ($(window).width() < 768) {
      $(".sidebar").addClass("toggled");
  }


  $(document).on('scroll', function() {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 100) {
      $('.scroll-to-top').fadeIn();
    } else {
      $('.scroll-to-top').fadeOut();
    }
  });


  $(document).on('click', 'a.scroll-to-top', function(e) {
    var $anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    e.preventDefault();
  });
  
        function printErrorMsg(msg) {
            var mess = "";
            $.each(msg, function (key, value) {
                mess += '<li>' + value + '</li>';
            });
            return mess;
        }
      
      $(".btn_builder_template").on("click", function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#template_id_builder').val(id);

      });
      
      

      

      tinymce.init({
        plugins: 'link',
        selector: '#description_pages_website'
      });
      

    $("#mobile_device").on('click',function(){
        $('.website-append').addClass('mobile');
        $('.website-append').removeClass('labtop');
        $('.website-append').removeClass('tablet');
        $('#mobile_device').addClass('active');
        $('#labtop_device').removeClass('active');
        $('#tablet_device').removeClass('active');
      });

      $("#labtop_device").on('click',function(){
        $('.website-append').addClass('labtop');
        $('.website-append').removeClass('mobile');
        $('.website-append').removeClass('tablet');
        $('#mobile_device').removeClass('active');
        $('#labtop_device').addClass('active');
        $('#tablet_device').removeClass('active');
      });

      $("#tablet_device").on('click',function(){
        $('.website-append').addClass('tablet');
        $('.website-append').removeClass('labtop');
        $('.website-append').removeClass('mobile');
        $('#mobile_device').removeClass('active');
        $('#labtop_device').removeClass('active');
        $('#tablet_device').addClass('active');
      });
      
      $('#domain_type_select').on('change', function (e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;

        if (valueSelected) {
            // subdomain
            if (valueSelected == 0) {
              
              $("#input_custom_domain").attr('disabled','disabled');
              $("#input_sub_domain").removeAttr('disabled');
              $("#custom_domain_note").removeClass("d-none").addClass("d-none");
              $("#sub_domain_note").removeClass("d-none");
            }
            // custom_domain
            else if(valueSelected == 1){
              $("#input_sub_domain").attr('disabled','disabled');
              $("#input_custom_domain").removeAttr('disabled');
              $("#sub_domain_note").removeClass("d-none").addClass("d-none");
              $("#custom_domain_note").removeClass("d-none");
            }
        }
      });

      $('#type_form_submit').on('change', function (e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;

        if (valueSelected) {
            // subdomain
            if (valueSelected == 'thank_you_page') {
              $("#form_redirect_url").addClass("d-none");
            }
            // custom_domain
            else if(valueSelected == 'url'){
              $("#form_redirect_url").removeClass("d-none");
             
            }
        }
      });
      
      $('#type_payment_submit').on('change', function (e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;

        if (valueSelected) {
            // subdomain
            if (valueSelected == 'thank_you_page') {
              $("#form_redirect_url_payment").addClass("d-none");
            }
            // custom_domain
            else if(valueSelected == 'url'){
              $("#form_redirect_url_payment").removeClass("d-none");
             
            }
        }
      });



     $("#labtop_device").on('click',function(){
        $('.website-append').addClass('labtop');
        $('.website-append').removeClass('mobile');
        $('.website-append').removeClass('tablet');
        $('#mobile_device').removeClass('active');
        $('#labtop_device').addClass('active');
        $('#tablet_device').removeClass('active');
     });

    
     $('#datetimepicker1').datetimepicker({
                    format: 'YYYY-MM-DD hh:mm:ss'
    });
     
})(jQuery); // End of use strict
