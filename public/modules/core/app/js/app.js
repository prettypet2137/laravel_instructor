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
    
    var preseOpt = {
        tourID: "anyTourID",
        tourTitle: "instructorsdash",
        baseurl: "https://instructorsdash.com",
        overlayClickable: false,
        lang: {
          modalIntroType: "Instructorsdash.com"
        },
        intro: {
          enable: true,
          title: "Welcome to Instructors Dash.",
          content: "We have created a step by step tour to help you set up your account while also teaching you how to navigate through the features and functions of the site. Let's get started, at any time you can exit the tour and restart by launching “Tour” from the top of the dashboard.."
        },
        steps: [{
          before: function () {
            $("[data-target='account-setting']").click();
          },
          title: "Account Setting",
          content: "Click on the top right to access the drop down menu where you can access your account settings.",
          target: "[data-target='account-setting'] + .dropdown-menu",
          event: ["click", ".dropdown-item:nth-child(1)"]
        }, {
          loc: "/accountsettings",
          title: "",
          content: "Enter your company name here that you would like to display on your site.",
          target: "[name='company']"
        }, {
          loc: "/accountsettings",
          title: "",
          content: "You can update your password at any time from your settings. Always be sure when updating any settings your password boxes are blank if you are not trying to change the password.",
          target: ".change-password-content"
        }, {
          loc: "/accountsettings",
          title: "",
          content: "Let's set up how your customer pays you, select the payment settings tab.",
          target: "[href='#tab_payment_setting']",
          event: "click"
        }, {
          loc: "/accountsettings",
          title: "",
          content: "This is where you enter your payment gateway settings. You can select between Paypal or Stripe. For instructions on how to obtain the information required to set up, please select from the links displayed. If you need assistance please contact us through the support tab to assist you in configuring your settings, we charge a one time setup fee.",
        }, {
          loc: "/accountsettings",
          title: "",
          content: "Select “About Us” from the menu and let's configure what your customers will see about your company.",
          target: "[href='#tab_about_us']",
          event: "click"
        }, {
          loc: "/accountsettings",
          title: "",
          content: "Enter the info about your company info that you want displayed on your calendar page.",
          target: "#tab_about_us .card-body"
        }, {
          loc: "/accountsettings",
          title: "",
          content: "Now click “save settings” to ensure your updates are saved.",
          target: ".card-footer",
        }, {
          title: "",
          content: "Select “Event Categories from the side menu to continue.",
          target: ".event-category-navlink",
          event: "click"
        }, {
          loc: "/categories",
          title: "",
          content: "We are now going to set up the categories for your event, you must have at least one category setup. Example; Beginners, Intermediate, Advanced",
          target: ".add_category_btn",
          event: "click"
        }, {
          delayBefore: 500,
          loc: "/categories",
          title: "",
          content: "Enter your category name, if there's a space between words add a - between words. Example; Yoga-Class, Pistol-Class, Surfing-Event, MotorCross-Event",
          target: ".modal.create_category_modal .modal-content",
          event: ["submit", "form"]
        }, {
          loc: "/categories",
          content: "With each category created you will be provided a dedicated iframe code that can be used to insert that specific category calendar into your existing website. For example you want to only display the calendar event dates displayed for your “Intermediate-Event” category, you would copy the code for that category and insert it as a course code on your web page. If you need assistance please contact us through the support tab to assist you in configuring your settings, we charge a one time setup fee.",
          target: "#category_table > tbody"
        }, {
          loc: "/categories",
          content: "Select “My Events” from the side menu and let's create your first event.",
          target: "a.nav-link[data-target='#collapseEvents']",
          event: "click"
        }, {
          loc: "/categories",
          content: "Now select “Create Event”",
          target: "[data-target='#createModal']",
          event: "click"
        }, {
          loc: "/categories",
          delayBefore: 500,
          content: "You will first select the category your event will be listed under. After selecting your category, enter the name of your event. Example; “Fight Night Intermediate Class”",
          target: "#createModal .modal-content",
          event: ["submit", "#createForm"],
        }, {
          before: function() {
              console.log("AAA");
          },
          delayBefore: 2000,
          content: "Select an image for your event that will be displayed.",
          target: "#basic_content [name='image']"
        }, {
          content: "You can update your event name at any time from here. Enter a short description here. Make sure your description is short. Example; “Tuesday night blank beginners course.”",
          target: "#basic_content > .row:nth-child(2)"
        }, {
          content: "This is the maximum number of guests that can attend your course/event. For unlimited enter -1 or you can specify an amount. Example; 20",
          target: "#basic_content .row:nth-child(3) > .col-md-3:nth-child(1) .form-group"
        }, {
          content: "The “Register End Date” is the last date a user can register for the course/event on your calendar. The date/time must be prior to the “Start Date” of your event. You will then select the “Start Date” and “End Date” of your course/event. Be sure to set the correct time. Example 2022-12-19 14:36:13 represents Dec 19,2022 @ 2:36pm.",
          target: "#basic_content .row:nth-child(3) > .col-md-9 .row"
        }, {
          content: "If you would like your event to recur automatically select the box. Then select  the “Day” you want your event to recur on, then set the frequency, repeat every 1 week or every 2 weeks, etc. You will then select the “End Date” when you do not want your course/event to recur any further. PLEASE NOTE when you enable this feature your future events will be automatically added and displayed to your calendar.",
          target: "#basic_content .row:nth-child(4)"
        }, {
          content: "Are you offering this event online or offline, if you select offline you will need to enter a physical address for the event below.",
          target: "#basic_content .row:nth-child(5) > .col-md-3"
        }, {
          content: "Do you want this event to be displayed on your calendar? Example; If this is a private event not to be displayed on your calendar. If “No” is selected the event will NOT display on your calendar. If you do not see an event listed on your calendar, always check this option first what it is set at.",
          target: "#basic_content .row:nth-child(5) > .col-md-6:nth-child(2)"
        }, {
          content: "Enter the full complete address of the event here, including city state zip, this will be displayed as a map on your events page.",
          target: ".col-md-12.address-wrapper"
        }, {
          content: "Enter the full complete description of your course/event here. This will display to your customer the details of your course/event.",
          target: "#basic_content > .row:nth-child(5) > .col-md-12:last-child"
        }, {
          content: "Select the “Advance” tab from the top menu.",
          target: ".nav-tabs #tab_advance_content",
          event: "click"
        }, {
          delayBefore: 500,
          content: "You can use the default slug or If you would like to create a custom “slug” for your event link you may do so here. Be sure that you enter a dash between words. Example; south-event-show",
          target: "#advance_content > .row > .col-md-12:nth-child(1)"
        }, {
          content: "If you would like to collect specific information from your customer when they register, you can create custom fields here. Example; “How did you hear about us?” or “Referred By” etc. You can then select if this is a required field for your customer to fill out or optional. Below this field you will see where you can select the currency, default is USA.",
          target: "#advance_content > .row > .col-md-12:nth-child(2)"
        }, {
          content: "Terms & Conditions is a required field. Here you will enter the Terms & Conditions of your course/event. Your customer will be required to check a box acknowledging they agree to your Terms & Conditions of the course/event before they can continue registering.",
          target: "#advance_content > .row > .col-md-12:nth-child(4)"
        }, {
          content: "From the top menu tab select “Email & Notify”",
          target: "#tab_email_and_notify",
          event: "click"
        }, {
          delayBefore: 500,
          content: "The system by default has already labeled your “Registration Confirmation” email. You may edit the “Sender name” “Email Subject” and “Sender Email” from here. We DO NOT recommend you edit the “Body Message” of the email.",
          target: "#email_and_notify > .row:first-child"
        }, {
          content: "From the top menu select “Custom Domain” tab.",
          target: "#tab_domains",
          event: "click"
        }, {
          delayBefore: 500,
          content: "You can see your event by clicking on the “Public Event Link” If you want to provide someone a direct link to your specific event, this is the link to provide. You can also click on “Preview Button” at any time to preview your event listing page.",
          target: "#nav-domains .public-event-link"
        }, {
          content: "The system allows you to assign a custom domain or subdomain to your event. If you are not familiar with setting up this feature, we do offer a one time setup fee.",
          target: "#nav-domains .row > .col-md-8:nth-child(1)"
        }, {
          content: "Select the “SEO & Social” tab from the top menu. ",
          target: "#tab_seo_config",
          event: "click"
        }, {
          delayBefore: 500,
          content: "The system allows you to set up SEO for your event page, you can add a favicon for your event. This will display on the browser tab like the gmail icon.",
          target: "#seo_config [name='favicon']"
        }, {
          content: "Next you can enter the Title, Description and keywords for your event. This is optional and you do not have to enter this information to create your event.",
          target: "#seo_config .seo-content"
        }, {
          content: "Select “Theme Design tab from the top menu.",
          target: "#tab_theme_design",
          event: "click"
        }, {
          delayBefore: 500,
          content: "With the upgraded plan you can customize the theme of your event page.",
          target: "#theme_design > .row"
        }, {
          before: function () {
            $("#theme_design [name='theme']").click();
          },
          content: "You can select pre-designed themes for your event page.",
          target: "#theme_design .col-md-5 > .form-group"
        }, {
          content: "You can select the desired color and select an image to be used as the background.",
          target: "#theme_design .color-section"
        }, {
          content: "The system allows you to enter custom header and footer code, if you are not familiar with this we suggest leaving it blank.",
          target: "#theme_design .custom-header-and-footer"
        }, {
          content: "Once you have completed all your settings, click save at the bottom left.",
          target: "#form_create .card-footer button[type='submit']"
        }, {
          content: "Your event is now created. Lets now learn how to add an upsell option to your event. This will be displayed when your customer goes to checkout for your event.",
          target: ".upsell-link",
          event: "click"
        }, {
          loc: "/upsell",
          content: "Select “Add New” to create an upsell option.",
          target: ".add-upsell-btn",
          event: "click"
        }, {
          loc: "/upsell/create",
          content: "Select an image to be used for your upsell option. Example; you want to offer a meal ticket with your event, you can add the image displaying a meal ticket or of a meal item. You will then enter the Title of the upsell item. Example; “Last Chance to Add a Discounted Meal Ticket” then you will specify the price. Then the complete full description of your upsell item.",
          target: ".form"
        }, {
          loc: "/upsell/create",
          content: "You may add multiple price options, where you can specify in the description what the different price options include. Example; $5 | Meal for one, $10 | Meal for two, $20 | Meal for Four",
          target: ".form .form-price-group"
        }, {
          loc: "/upsell/create",
          content: "Remember to click save to update your changes.",
          target: ".form .form-actions > button"
        }, {
          delayBefore: 500,
          loc: "/upsell",
          content: "You can repeat this step and create multiple upsell options. Now that an upsell option has been created, let's learn how to add it to an event.",
          target: "#upsell_table"
        }, {
          content: "Select “My Events” from the side menu",
          target: "a[data-target='#collapseEvents']",
          event: "click"
        }, {
          content: "Then select “All Events”",
          target: ".all-events-link",
          event: "click"
        }, {
          delayBefore: 0,
          before: function () {
            $("#event_table tbody tr:nth-child(1) .dropdown-toggle").trigger("click");
          },
          loc: "/events",
          content: "Go to your event you want to add the upsell option to and click the “Actions Menu” from this menu select “Event Edit”",
          target: "table .dropdown-menu > a.dropdown-item:nth-child(1)",
          event: "click"
        }, {
          content: "Now from the event menu tabs select “Upsell”",
          target: "#tab_upsell",
          event: "click"
        }, {
          content: "From the menu select the upsell item you want to add to the event, select then click “Add” You will see the upsell option now added to the event.",
          target: "#upsell .input-group"
        }, {
          content: "Once you have finished adding the upsell items, remember to click “Save” on the bottom right to save your changes.",
          target: "#form_create .card-footer button"
        }, {
          content: "You can repeat this step as many times as you want adding different upsell options. At checkout the system will go through each option that you have added, providing your customer the option to add it to their checkout.",
          target: ""
        }, {
          before: function () {
            $("#event_table tbody tr:nth-child(1) .dropdown-toggle").trigger("click");
          },
          loc: "/events",
          content: "Let's take a look at your specific event page that you have now created.",
          target: "table .dropdown-menu > a.dropdown-item:nth-child(7)",
          event: "click"
        }, {
          content: "You can see the Ticket options you have created displayed on your event page.",
          target: "#description > .container"
        }, {
          content: "Here is where your ticket options you added are displayed on your event page.",
          target: ".form-group-ticket"
        }, {
          content: "Lets learn about the multi-guest option built into the system, select the drop down menu for quantity",
          target: "#student_cnt"
        }, {
          content: "Select the option for quantity “2” from the drop down menu",
          target: "#student_cnt"
        }, {
          content: "The system will now display the fields for the quantity of attendee selected. The",
          target: "#student_cnt"
        }, {
          content: "The system will now display the fields for the quantity of attendee selected. The customer will now enter the information for each additional attendee.",
          target: ".sub_students"
        }, {
          content: "Once the customer enters the registration information, if you have an upsell option added to the event, it will then display as they continue the checkout process.",
          target: ""
        }, {
          loc: "/events",
          before: function () {
            $("a.nav-link[data-target='#collapseEvent']").click();
          },
          content: "From the side menu bar, select “My Events” then “All Events”",
          target: ".all-events-link",
          event: "click"
        }, {
          loc: "/events",
          content: "This is the link to your main calendar page listing your events. If you would like to insert the calendar into an existing website, you can use the “iframe” tool. Click on the “Iframe code copier” button.",
          target: ".iframe-done-container",
          event: ["click", ".iframe-done-container a.btn"]
        }, {
          delayBefore: 500,
          loc: "/events",
          content: "Click the “Copy” button to copy the iFrame code to paste into your existing website. If you need assistance please contact us through the support tab to assist you in configuring your settings, we charge a one time setup fee.",
          target: ".main-code > div:nth-child(1)"
        }, {
          loc: "/events",
          content: "The Calendar Landing Page can be used if you do not have an existing website. This is also the page you would insert directly on to your existing website.",
          target: ""
        }, {
          loc: "/events",
          content: "The About Us section can be added/removed. If you are going to use the iFrame to insert into your existing website, we recommend you hide both About & Questions.",
          target: ""
        }, {
          loc: "/events",
          content: "The Questions form would also be hidden from the page if unchecked.",
          target: ""
        }, {
          loc: "/events",
          content: "You can select to add/remove the “About Us” or “Questions Form’ from your events calendar page by unchecking the boxes. If you are going to insert into an existing website, it is recommended to uncheck both options.",
          target: ".main-code > div.form-group"
        }, {
          loc: "/events",
          content: "You can see both options are now hidden.",
          target: ""
        }, {
          before: function () {
            $(".modal").modal("hide");
          },
          loc: "/events",
          content: "From the side menu select “Reports”",
          target: ".report-link",
          event: "click"
        }, {
            loc: "/reports",
            content: "You can view your monthly sales reports here.",
            target: ".report-row"
        }, {
            content: "From the side menu select “Comments”",
            target: ".comment-link"
        }, {
            delayBefore: 1000,
            loc: "/all-events/comment",
            content: "If a customer uses the “Question” form displayed on your calendar, the info will be displayed here.",
            target: ".comments-container"
        }, {
            before: function() {
                $("a[data-target='##collapseEventGuests']").click();
            },
            content: "From the side menu select “Guest” then “All Guest”",
            target: ".all-guests-link",
            event: "click"
        }, {
            delayBefore: 1000,
            content: "This tab will allow you to manage all registered guests. This is where you can transfer a guest registration, view order details, mark a guest as paid or mark them as joined the event.",
            target: "#users-table"
        }, {
            loc: "/guests",
            content: "Select the tab icon next to a guest registration.",
            target: "#users-table tbody tr:nth-child(1) > td:nth-child(1)",
            event: "click"
        }, {
            loc: "/guests",
            delayBefore: 1000,
            content: "If multiple guests have been registered under the specific guest, the other guest details will then be displayed.",
            target: "#users-table tbody tr:nth-child(1), #users-table tbody tr:nth-child(1) + tr"
        }, {
            loc: "/guests",
            before: function() {
            $("#users-table tbody tr:nth-child(1) > td:nth-child(1)").click();  
            },
            content: "Under the Ticket column you can view what type of ticket the customer purchased.",
            target: "#users-table tbody tr td:nth-child(4)"
        }, {
            loc: "/guests",
            content: "If acustomer registers but does not complete payment, the system will display as “Unpaid”. The system will send the customer a follow up text asking them to complete their registration. By clicking on the “Unpaid” option you can update the system to “Paid” after receiving the payment manually.",
            target: "#users-table tbody tr td:nth-child(5)"
        }, {
            loc: "/guests",
            content: "By clicking on “Registered” you can update attendance to “Joined”",
            target: "#users-table tbody tr td:nth-child(7)"
        }, {
            loc: "/guests",
            content: "The “Registered” column displays the date and time of the registration.",
            target: "#users-table tbody tr td:nth-child(8)"
        }, {
            loc: "/guests",
            content: "Select the “Detail” option",
            target: "#users-table tbody tr:nth-child(1) a.btn-detail",
            event: "click"
        }, {
            loc: "/guests",
            delayBefore: 1500,
            content: "You can view the registration details from this window, including what upsell option was selected.",
            target: "#modalDetail .modal-content"
        }, {
            loc: "/guests",
            content: "By selecting the “Confirmation Ticket” button, you will resend the customer with their Ticket information.",
            target: "#modalDetail .confirm_ticket_btn"
        }, {
            loc: "/guests",
            content: "The QR code is text to the registered guest. The Admin of the event can use their phone and scan the QR code, while the admin is logged in to InstructorsDash from a browser. Once scanned the attendees registration will be updated to “Joined”",
            target: "#modalDetail .data-qr-code"
        }, {
            loc: "/guests",
            before: function() {
                $("#modalDetail").modal("hide")
            },
            content: "Click on “Transfer”",
            target: "#users-table tbody tr:nth-child(1) a.btn-transfer",
            event: "click"
        }, {
            loc: "/guests",
            delayBefore: 1000,
            content: "You can transfer an attendee’s registration from one event to another by selecting transfer. The system will send the customer a text with their updated event details.",
            target: "#modalTransfer .modal-content"
        }, {
            loc: "/guests",
            before: function() {
                $("#modalTransfer").modal("hide");
            },
            content: "You can search for a specific customer by a specific event or all events.",
            target: "#users-table_filter"
        }, {
            loc: "/guests",
            content: "Select “Email” listed below the “Guest” side menu.",
            target: "#accordionSidebar .nav-item.active",
            event: "click"
        }, {
            loc: "/guests/email",
            content: "The system provides you the ability to email your guest a message."
        }, {
            loc: "/guests/email",
            content: "You can select specifically which event attendees you want to send the message to.",
            target: ".guest-emails-filter"
        }, {
            content: "Select “Email” from the side menu.",
            target: ".nav-link[data-target='#collapseEmail']",
            event: "click"
        }, {
            content: "Now select “Email Templates”",
            target: ".email-templates-link",
            event: "click"
        }, {
            loc: "/email/templates",
            content: "The system will automatically send an email for each action.",
            target: ".col-3 > .card"
        }, {
            loc: "/email/templates",
            content: "You can select each action and update the “Subject” of each action.",
            target: "input[name='subject']"
        }, {
            loc: "/email/templates",
            content: "It is not recommended to update the “Message” portion, however the system provides you the option.",
            target: "form .form-group:nth-child(2)"
        }, {
            before: function() {
              $(".nav-link[data-target='#collapseSms']").click();  
            },
            content: "From the side menu select “SMS Templates” that can be found under the “SMS” menu option.",
            target: ".sms-templates-link",
            event: "click"
        }, {
            loc: "/sms/templates",
            content: "The system is designed to keep connection with your customer via sms. The registered customer will receive a text every year on their birthday with a custom message. This marketing tool will keep your customers referring to you for years to come.",
            target: ""
        }, {
            delayBefore: 1000,
            loc: "/sms/templates",
            content: "You can enable or disable this feature at any time. To take full advantage of the system, keep sms enabled.",
            target: ".sms-switch"
        }, {
            loc: "/sms/templates",
            content: "Once enabled, Click on Recharge to add funds to your sms balance. The system will suspend messages if the Balance is $0",
            target: ".card .input-group",
            event: ["click", "#recharge-btn"]
        }, {
            delayBefore: 1000,
            loc: "/sms/templates",
            content: "You can select a predefined amount to recharge your sms balance.",
            target: "#sms-checkout-modal .modal-content"
        }, {
            before: function() {
                $("#sms-checkout-modal").modal("hide")
            },
            loc: "/sms/templates",
            content: "The subject line of the sms message is for your reference. The customer does not see this.",
            target: ".form-group input[name='subject']"
        }, {
            loc: "/sms/templates",
            content: "You can customize the message. Keep the message below 150 characters.",
            target: ".form-group textarea[name='description']"
        }, {
            loc: "/sms/templates",
            content: "The guest will receive a text message with a confirmation of the event, reminder of the upcoming event, reminder day of the event, follow up after the event, etc.",
            target: ".col-3 .card"
        }, {
            content: "Select “My Billing” from the side menu",
            target: ".my-billing-link",
            event: "click"
        }, {
            loc: "/billing",
            content: "You can upgrade/downgrade your package at any time from billing.",
            target: ".billing-container"
        }, {
            content: "Select “Feature Request” from the top menu",
            target: "a[data-target='#new_feature_modal']",
            event: "click"
        }, {
            delayBefore: 500,
            content: "At any time you can use this form to request support. If there is a feature that the system does not have that you would like to be developed, submit your request here.",
            target: "#new_feature_modal .modal-content"
        }, {
            content: "Select “Help” from the side menu.",
            target: ".help-link",
            event: "click"
        }],
      };
      iGuider("button", preseOpt, 'auto auto 40px 80px');
     
})(jQuery); // End of use strict
