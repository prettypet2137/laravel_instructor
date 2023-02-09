/*
 * jQuery iGuider v 5.5
 *
 * Copyright 2017, Linnik Yura | LI MASS CODE | http://masscode.ru
 *
 * Last Update 08/03/2022
 */
var iGuider;
(function ($) {
    "use strict";
    var methods = {
        init: function (options) {
            var p = {
                tourID:'anyTourID',							//This string allows you to save data with a unique name about tour progress. 
															//It can be used to save information on the progress of the tour for several users. 
															//Or save the progress of each tour separately
                tourTitle:'Tour Title Default',				//Tour title
				tourSubtitle:'Tour Subtitle Default',
                startStep:1,								//Step from which the tour begins
				
                overlayClickable:true,						//This parameter enables or disables the click event for overlying layer
				overlayColor:'#000',						//Global color values of the overlay layer.
				overlayOpacity:0.5,							//Global opacity values of the overlay layer.
				
                pagination:true,							//Shows the total number of steps and the current step number
                registerMissingElements:true,				//Shows an absent element in tour map and find this element in DOM.
                textDirection:'ltr',						//Global text direction. (ltr, rtl)
				
				shape:0,									//Global shape of highlighting. 0 - rectangle (default), 1 - circle, 2 - rounded rectangle
				shapeBorderRadius:5,						//Global corner radius of rounded rectangle shape. Only when "shape" value is "2"
				
				width:320,									//Global width of the message block
				
				bgColor:false,								//Global background color of the message block
				titleColor:false,							//Global title color of the message block
				
				modalContentColor:false,					//Global content color of the message block
				modalTypeColor:false,						//Global modal type color of the message block
				
				paginationColor:false,						//Global pagination color of the message block
				timerColor:false,							//Global timer color of the message block
				
				btnColor:false,								//Global buttons color
				btnHoverColor:false,						//Global buttons hover color

				spacing:10,									//Global indent highlighting around the element
				baseurl:false,								//The initial portion of the URL that is common to all steps.
															//Required if you specify a relative URL in the LOC parameter value.
				loc:false,									//Global relative/absolute path to the page for steps for which the LOC parameter is not specified
				timer:false,								//Global time after which an automatic switching to the next step
				timerType:'line',							//Global timer shape type: 'line' or 'circle'
				keyboard:true,								//Tour control by keyboard buttons. Left - the previous step, right - the next step, Esc - close tour.
				keyboardEvent:false,						//This parameter sets the permission to trigger custom events.

                intro:{										//Default intro settings
                    enable:true,							//If set to true, before the tour you will see the introductory slide, which will offer to see a tour. 
					
					title:'Welcome to the interactive tour',												//Title of introduction dialog
					content:'This tour will tell you about the main site functionalities',					//Content of introduction dialog
					
                    cover:'',								//Path to the cover of intro
                    overlayColor:false,						//For intro, you can specify the different color values of the overlay layer.
                    overlayOpacity:false,					//For intro, you can specify the different opacity values of the overlay layer.
					width:false,							//Width of the intro message block
					
					bgColor:false,							//Background color of the intro message block
					titleColor:false,						//Title color of the intro message block
					
					modalContentColor:false,				//Content color of the intro message block
					modalTypeColor:false,					//Modal type color of the intro message block
					
					btnColor:false,							//Buttons color of the intro message block
					btnHoverColor:false						//Buttons Hover color of the intro message block
                },
                
                continue:{									//Default the continue message settings
                    enable:true,							//This parameter add the ability to continue the unfinished tour.    
					
					title:'Continue the unfinished tour?',											//Title of continue dialog
                    content:'Click "Continue" to start with step on which finished last time.',		//Content of continue dialog
					
                    cover:'',								//Path to the cover of continue message    
                    overlayColor:false,						//For continue message, you can specify the different color values of the overlay layer.
                    overlayOpacity:false,					//For continue message, you can specify the different opacity values of the overlay layer.
					width:false,							//Width of the continue message block
					
					bgColor:false,							//Background color of the continue message block
					titleColor:false,						//Title color of the continue message block
					
					modalContentColor:false,				//Content color of the continue message block
					modalTypeColor:false,					//Modal type color of the continue message block
					
					btnColor:false,							//Buttons color of the continue message block
					btnHoverColor:false						//Buttons Hover color of the continue message block
                },

                tourMap: {									//Default Tour Checklist settings
                    enable:true,							//This parameter add the ability view list of steps.
                    position:'right',						//Checklist Position 
                    clickable:true,							//Specifies the clickability of links in the checklist of steps: true - clickable, false - disabled, or 'ready' - clickable only completed steps and current
                    open:false,								//Specifies to show or hide the Checklist at the start of the tour 
					
					bgColor:false,							//Background color of the Checklist
					titleColor:false,						//Title color of the Checklist
					
					btnColor:false,							//Buttons color of the checklist block
					btnHoverColor:false,					//Buttons hover color of the checklist block
					
					itemColor:false,						//Item color of the Checklist
					itemHoverColor:false,					//Item hover color of the Checklist
					itemActiveColor:false,					//Item Active color of the Checklist
					itemActiveBg:false,						//Item Active BG color of the Checklist
					itemNumColor:false,						//Item Number color of the Checklist
					
					checkColor:false,						//Check color of the Checklist
					checkReadyColor:false					//Check Ready color of the Checklist
                },
				
                steps:[{									//Default step settings
                    cover:'',								//Path to image file
                    title:'New Step Title',					//Name of step
                    content:'New Step Description',			//Description of step
                    position:'auto',						//Position of message
                    target:'uniqueName',					//Unique Name (<div data-target="uniqueName"></div>) 
															//of highlighted element or .className (<div class="className"></div>) or #idValue (<div id="idValue"></div>)
                    disable:false,							//Block access to element
                    overlayOpacity:0.5,						//For each step, you can specify the different opacity values of the overlay layer.
                    overlayColor:'#000',					//For each step, you can specify the different color values of the overlay layer in HEX .
                    spacing:10,								//Indent highlighting around the element, px
                    shape:0,								//Shape of highlighting (0 - rectangle, 1 - circle, 2 - rounded rectangle)
					shapeBorderRadius:5,					//The corner radius of rounded rectangle shape. Only when "shape" value is "2"
                    timer:false,							//The time after which an automatic switching to the next step
                    event:'next',							//An event that you need to do to go to the next step
					eventMessage:'Follow the required conditions to continue.',		//Message hint for steps with custom events
                    skip: false,							//Step can be skipped if you set parameter "skip" to true.
                    nextText:'Next',						//The text in the Next Button
                    prevText:'Prev',						//The text in the Prev Button
                    trigger:false,							//An event which is generated on the selected element, in the transition from step to step
                    stepID:'',								//Unique ID Name. This name is assigned to the "html" tag 
															//as "data-g-stepid" attribute (If not specified, the plugin generates it automatically in the form: "step-N")
					waitElementTime:0,						//The parameter "waitElementTime" sets the time (ms) to wait for an item to appear
                    loc:false,								//The path to the page on which the step should work
					ready:false,							//This parameter indicates whether the step was completed or not.
					width:320,								//Width of the message block
					autofocus:true,							//Automatically puts the cursor in the selected form element.
					
					bgColor:false,							//Background color of the message block
					titleColor:false,						//Title color of the message block
					
					modalContentColor:false,				//Content color of the message block
					
					paginationColor:false,					//Pagination color of the message block
					timerColor:false,						//Timer color of the message block
					
					btnColor:false,							//Buttons color of the message block
					btnHoverColor:false,					//Buttons Hover color of the message block
					
					keyboardEvent:false,					//This parameter sets the permission to simulate user events for step.

                    checkNext:{                             //Function in which you can carry out any verification by clicking on the "Next" button. 
                        func:function(){return true;},       ////If the function returns True, the step will be switched.
                        messageError:'Fulfill all conditions!'  //If the function returns "False", an error message will appear in the message window
                    },
                    checkPrev:{                             //Function in which you can carry out any verification by clicking on the "Prev" button. 
                        func:function(){return true;},
                        messageError:'Fulfill all conditions!'  
                    },
                    before:function(target){},					//Triggered before the start of step
                    during:function(target){},					//Triggered after the onset of step
                    after:function(target){},						//Triggered After completion of the step, but before proceeding to the next
                    delayBefore:0,							//The delay before the element search, ms
                    delayAfter:0							//The delay before the transition to the next step, ms
                }],
            
                lang: {										//Default language settings
                    cancelTitle: 'Cancel Tour',				//The title in the cancel tour button
                    cancelText: '×',						//The text in the cancel tour button
                    hideText: 'Hide Tour Map',				//The text in the hidden tour map button 
                    tourMapText:'≡',						//The text in the show tour button
                    tourMapTitle: 'Tour Map',				//Title of Tour map button
                    nextTextDefault:'Next',					//The text in the Next Button
                    prevTextDefault:'Prev',					//The text in the Prev Button
                    endText:'End Tour',						//The text in the End Tour Button

                    contDialogBtnBegin:'Start over',		//Text in the start button of continue dialog 
                    contDialogBtnContinue:'Continue',		//Text in the continue button of continue dialog 
                    
                    introDialogBtnStart:'Start',			//Text in the start button of introduction dialog
                    introDialogBtnCancel:'Cancel',			//Text in the cancel button of introduction dialog
                   
					modalIntroType:'Tour Intro',			//Type Name of intro dialog
					modalContinueType:'Unfinished Tour'		//Type Name of continue dialog
                },
                
                create: function(){},						//Triggered when the iGuider is created
				start: function(){},						//Triggered before first showing the step
				progress: function(data){},					//Triggered together with start any step
                end: function(){},							//Triggered when the tour ended, or was interrupted
                abort: function(){},						//Triggered when the tour aborted
                finish: function(){},						//Triggered when step sequence is over
				play: function(){},							//Triggered when the timer state switches to "play"
				pause: function(){},						//Triggered when the timer state switches to "pause"
                
                modalTemplate:								//Modal window template
                '<div class="gWidget">'+
					'<div class="gCover">[modal-cover]</div>'+
					'<div class="gAction">'+
						'<span class="gType">[modal-type]</span>'+
						'<span class="gBtn">[modal-map]</span>'+
						'<span class="gBtn">[modal-close]</span>'+
						'<div class="gTimer">[modal-timer]</div>'+
					'</div>'+
					'<div class="gScroll">'+
						'<div class="gHeader">[modal-header]</div>'+
						'<div class="gContent">[modal-body]</div>'+
					'</div>'+
					'<div class="gFooter">'+
						'<span class="gPage">'+
							'<span class="gPageVal">[step-value]</span>'+
							'<span class="gPageTotal">[step-total]</span>'+
						'</span>'+
						'<span class="gBtn">[modal-prev]</span>'+
						'<span class="gBtn">[modal-next]</span>'+
						'<span class="gBtn">[modal-cancel]</span>'+
						'<span class="gBtn">[modal-start]</span>'+
						'<span class="gBtn">[modal-begin-first]</span>'+
						'<span class="gBtn">[modal-begin-continue]</span>'+
					'</div>'+
				'</div>',
                
                mapTemplate:								//Tour Map template
                '<div class="g-map-pos">'+
					'<div class="gMapAction">'+
						'<span class="gBtn">[map-toggle]</span>'+
						'<span class="gBtn">[map-hide]</span>'+
					'</div>'+
					'<div class="gMapHeader">[map-header]</div>'+
					'<span class="gPage">'+
						'<span class="gPageVal">[step-value]</span>'+
						'<span class="gPageTotal">[step-total]</span>'+
					'</span>'+
					'<div class="gMapContent">[map-content]</div>'+
					'<div class="gMapBufer"></div>'+
				'</div>',
                
                debug: false								//Display of messages in the console
            };
            
            if(!$.iGuider){
                $.iGuider = {};
            }
			
			

			/*create method attr()*/
			(function(old) {
			  $.fn.attr = function() {
				if(arguments.length === 0) {
				  if(this.length === 0) {
					return null;
				  }
				  var obj = {};
				  $.each(this[0].attributes, function() {
					if(this.specified) {
					  obj[this.name] = this.value;
					}
				  });
				  return obj;
				}
				return old.apply(this, arguments);
			  };
			})($.fn.attr);

            if(!$.iGuider.opt){

				/*Set dinamic variables*/
                var requestID;
                var overlayCreateFlag = false;
                var savePar = [];
                var resizeID = function(){};
				var waitInterval = 500;      
                
                /**/
                /*save all options in base data object*/
                /**/        
                $.iGuider.opt = {};
                if (options) {

                    $.extend(p.lang, options.lang);
                    $.extend(p.intro, options.intro);
                    $.extend(p.continue, options.continue);
                    $.extend(p.tourMap, options.tourMap);
					$.extend(options.lang,p.lang);
                    $.extend(options.intro,p.intro);
                    $.extend(options.continue,p.continue);
                    $.extend(options.tourMap,p.tourMap);
					
					p.stepsDef = p.steps;
					if(options.steps && options.steps.length){
						p.steps = options.steps;
					}else{
						p.steps = false;
					}
					
					
					if(options.modalTemplate && $.trim(options.modalTemplate) != ''){
						p.modalTemplate = options.modalTemplate;
					}else{
						p.modalTemplate = false;
					}
					
					if(options.mapTemplate && $.trim(options.mapTemplate) != ''){
						p.mapTemplate = options.mapTemplate;
					}else{
						p.mapTemplate = false;
					}

					$.extend(p, options);
                }
                $.extend($.iGuider.opt, p);
				
				

                /*Fix Number Values*/
                $.iGuider.opt.startStep = parseFloat($.iGuider.opt.startStep);
				$.iGuider.opt.overlayOpacity = parseFloat($.iGuider.opt.overlayOpacity);
				$.iGuider.opt.intro.overlayOpacity = parseFloat($.iGuider.opt.intro.overlayOpacity);
				$.iGuider.opt.continue.overlayOpacity = parseFloat($.iGuider.opt.continue.overlayOpacity);
				
				var setIntroDefaultColor = function(){
					$.iGuider.opt.intro.overlayColor = $.iGuider.opt.overlayColor;	
					
				};
				var setContDefaultColor = function(){
					$.iGuider.opt.continue.overlayColor = $.iGuider.opt.overlayColor;	
				};
				var setIntroDefaultOpacity = function(){
					$.iGuider.opt.intro.overlayOpacity = $.iGuider.opt.overlayOpacity;	
				};
				var setContDefaultOpacity = function(){
					$.iGuider.opt.continue.overlayOpacity = $.iGuider.opt.overlayOpacity;	
				};

				if($.iGuider.opt.overlayColor){
					
					if(options.intro){
						if(!options.intro.overlayColor)	{
							setIntroDefaultColor();
						}
					}else{
						setIntroDefaultColor();	
					}
					if(options.continue){
						if(!options.continue.overlayColor)	{
							setContDefaultColor();
						}
					}else{
						setContDefaultColor();	
					}
				}
								
				if($.iGuider.opt.overlayOpacity > -1){
					if(options.intro){
						if(!options.intro.overlayOpacity && options.intro.overlayOpacity !== 0)	{
							setIntroDefaultOpacity();
						}
					}else{
						setIntroDefaultOpacity();	
					}
					if(options.continue){
						if(!options.continue.overlayOpacity && options.continue.overlayOpacity !== 0)	{
							setContDefaultOpacity();
						}
					}else{
						setContDefaultOpacity();	
					}
				}
				
                if($.iGuiderLang){
                    $.extend($.iGuider.opt.lang, $.iGuiderLang);
                }
                
                /**/
                /*creating object for addition vars*/
                /**/
                $.iGuider.v = {};
				
				$.iGuider.v.scrollDoc = $('html,body');
			   
                /**/
                /*Creating tour map block*/
                /**/        
				var mapTemplate = $.iGuider.opt.mapTemplate ? $($.iGuider.opt.mapTemplate) : $(mapTpl);
				
				$.iGuider.v.gMapPos = mapTemplate.addClass('g-map-pos-'+$.iGuider.opt.tourMap.position).appendTo('body');				
				
                $.iGuider.v.stepTimerId = function(){};
				$.iGuider.v.delayAfterId = function(){};
				$.iGuider.v.delayBeforeId = function(){};
				$.iGuider.v.duration = 300;
				
				$.iGuider.v.sTop = {};
				$.iGuider.v.sBot = {};
				$.iGuider.v.sLeft = {};
				$.iGuider.v.sRight = {};
				
				
                /*new*/
                window.requestAnimFrame = (function(){
                    return  window.requestAnimationFrame    || 
                    window.webkitRequestAnimationFrame        || 
                    window.mozRequestAnimationFrame            || 
                    window.oRequestAnimationFrame            || 
                    window.msRequestAnimationFrame            || 
                    function(callback, element){
                        window.setTimeout(callback, 1000 / 60);
                    };
                })();
                $.iGuider.v.easeOutQuad = function(currentIteration, startValue, changeInValue, totalIterations) {
                    return (parseFloat(-changeInValue * (currentIteration /= totalIterations) * (currentIteration - 2)) + parseFloat(startValue));
                };

                /*Detect old IE browser*/				
				var GetIEVersion = function() {
					var sAgent = window.navigator.userAgent;
					var Idx = sAgent.indexOf("MSIE");
					if (Idx > 0) {
						return parseInt(sAgent.substring(Idx+ 5, sAgent.indexOf(".", Idx)));
					}else{
						if (!!navigator.userAgent.match(/Trident\/7\./)){
							return 11;	
						}else{
							return 0; //It is not IE	
						}
					}
				};
				var ieFlag = GetIEVersion();
				if (ieFlag > 0){
					if(ieFlag >= 11){
						if(window.location.protocol == 'file:'){
							console.log('Some plugin functions "localStorage" is not available on local files (using the file: protocol) for this browser!');
							return false;
						}
					}else{
						console.log('The plugin \"iGuider\" does not support this version of the browser!');	
						return false;
					}
				}
				$.iGuider.v.debug = function(text){
					if($.iGuider.opt.debug){
						console.log(text);    
					}
				};

				/*This function create preloader*/
				var createPreloader = function(){
					$.iGuider.v.gLoader = $('<div class="g-loader"><div class="g-loader-b"></div><div class="g-loader-s"></div></div>');
					$.iGuider.v.gLoader.appendTo('body');
				};
				var showPreloader = function(){
					$.iGuider.v.createOverlayLayer();
					$('html').addClass('g-preloader');
				};
				var hidePreloader = function(){
					$('html').removeClass('g-preloader');
				};
				createPreloader();
				
				/*Create Circle Progress bar animation*/
				var RADIUS = 21;
				var CIRCUMFERENCE = 2 * Math.PI * RADIUS;
				$.iGuider.v.progressCircleTimer = function(value){
					var progress = value / 100;
					var dashoffset = CIRCUMFERENCE * (1 - progress);
					//console.log('progress:', value + '%', '|', 'offset:', dashoffset)
					$.iGuider.v.progressValue.style.strokeDashoffset = dashoffset;
				};

                $.iGuider.v.correctColor = function(myColor){
					
					
                    function RGBColor(color_string) {
                        this.ok = false;
                    
                        // strip any leading #
                        if (color_string.charAt(0) == '#') { // remove # if any
                            color_string = color_string.substr(1,6);
                        }
                    
                        color_string = color_string.replace(/ /g,'');
                        color_string = color_string.toLowerCase();
                    
                        // before getting into regexps, try simple matches
                        // and overwrite the input
                        var simple_colors = {
                            aliceblue: 'f0f8ff',
                            antiquewhite: 'faebd7',
                            aqua: '00ffff',
                            aquamarine: '7fffd4',
                            azure: 'f0ffff',
                            beige: 'f5f5dc',
                            bisque: 'ffe4c4',
                            black: '000000',
                            blanchedalmond: 'ffebcd',
                            blue: '0000ff',
                            blueviolet: '8a2be2',
                            brown: 'a52a2a',
                            burlywood: 'deb887',
                            cadetblue: '5f9ea0',
                            chartreuse: '7fff00',
                            chocolate: 'd2691e',
                            coral: 'ff7f50',
                            cornflowerblue: '6495ed',
                            cornsilk: 'fff8dc',
                            crimson: 'dc143c',
                            cyan: '00ffff',
                            darkblue: '00008b',
                            darkcyan: '008b8b',
                            darkgoldenrod: 'b8860b',
                            darkgray: 'a9a9a9',
                            darkgreen: '006400',
                            darkkhaki: 'bdb76b',
                            darkmagenta: '8b008b',
                            darkolivegreen: '556b2f',
                            darkorange: 'ff8c00',
                            darkorchid: '9932cc',
                            darkred: '8b0000',
                            darksalmon: 'e9967a',
                            darkseagreen: '8fbc8f',
                            darkslateblue: '483d8b',
                            darkslategray: '2f4f4f',
                            darkturquoise: '00ced1',
                            darkviolet: '9400d3',
                            deeppink: 'ff1493',
                            deepskyblue: '00bfff',
                            dimgray: '696969',
                            dodgerblue: '1e90ff',
                            feldspar: 'd19275',
                            firebrick: 'b22222',
                            floralwhite: 'fffaf0',
                            forestgreen: '228b22',
                            fuchsia: 'ff00ff',
                            gainsboro: 'dcdcdc',
                            ghostwhite: 'f8f8ff',
                            gold: 'ffd700',
                            goldenrod: 'daa520',
                            gray: '808080',
                            green: '008000',
                            greenyellow: 'adff2f',
                            honeydew: 'f0fff0',
                            hotpink: 'ff69b4',
                            indianred : 'cd5c5c',
                            indigo : '4b0082',
                            ivory: 'fffff0',
                            khaki: 'f0e68c',
                            lavender: 'e6e6fa',
                            lavenderblush: 'fff0f5',
                            lawngreen: '7cfc00',
                            lemonchiffon: 'fffacd',
                            lightblue: 'add8e6',
                            lightcoral: 'f08080',
                            lightcyan: 'e0ffff',
                            lightgoldenrodyellow: 'fafad2',
                            lightgrey: 'd3d3d3',
                            lightgreen: '90ee90',
                            lightpink: 'ffb6c1',
                            lightsalmon: 'ffa07a',
                            lightseagreen: '20b2aa',
                            lightskyblue: '87cefa',
                            lightslateblue: '8470ff',
                            lightslategray: '778899',
                            lightsteelblue: 'b0c4de',
                            lightyellow: 'ffffe0',
                            lime: '00ff00',
                            limegreen: '32cd32',
                            linen: 'faf0e6',
                            magenta: 'ff00ff',
                            maroon: '800000',
                            mediumaquamarine: '66cdaa',
                            mediumblue: '0000cd',
                            mediumorchid: 'ba55d3',
                            mediumpurple: '9370d8',
                            mediumseagreen: '3cb371',
                            mediumslateblue: '7b68ee',
                            mediumspringgreen: '00fa9a',
                            mediumturquoise: '48d1cc',
                            mediumvioletred: 'c71585',
                            midnightblue: '191970',
                            mintcream: 'f5fffa',
                            mistyrose: 'ffe4e1',
                            moccasin: 'ffe4b5',
                            navajowhite: 'ffdead',
                            navy: '000080',
                            oldlace: 'fdf5e6',
                            olive: '808000',
                            olivedrab: '6b8e23',
                            orange: 'ffa500',
                            orchid: 'da70d6',
                            palegoldenrod: 'eee8aa',
                            palegreen: '98fb98',
                            paleturquoise: 'afeeee',
                            palevioletred: 'd87093',
                            papayawhip: 'ffefd5',
                            peachpuff: 'ffdab9',
                            peru: 'cd853f',
                            pink: 'ffc0cb',
                            plum: 'dda0dd',
                            powderblue: 'b0e0e6',
                            purple: '800080',
                            red: 'ff0000',
                            rosybrown: 'bc8f8f',
                            royalblue: '4169e1',
                            saddlebrown: '8b4513',
                            salmon: 'fa8072',
                            sandybrown: 'f4a460',
                            seagreen: '2e8b57',
                            seashell: 'fff5ee',
                            sienna: 'a0522d',
                            silver: 'c0c0c0',
                            skyblue: '87ceeb',
                            slateblue: '6a5acd',
                            slategray: '708090',
                            snow: 'fffafa',
                            springgreen: '00ff7f',
                            steelblue: '4682b4',
                            tan: 'd2b48c',
                            teal: '008080',
                            thistle: 'd8bfd8',
                            tomato: 'ff6347',
                            turquoise: '40e0d0',
                            violet: 'ee82ee',
                            violetred: 'd02090',
                            wheat: 'f5deb3',
                            white: 'ffffff',
                            whitesmoke: 'f5f5f5',
                            yellow: 'ffff00',
                            yellowgreen: '9acd32'
                        };
                        for (var key in simple_colors) {
                            if (color_string == key) {
                                color_string = simple_colors[key];
                            }
                        }
                        // end of simple type-in colors
                    
                        // array of color definition objects
                        var color_defs = [
                            {
                                re: /^rgb\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3})\)$/,
                                example: ['rgb(123, 234, 45)', 'rgb(255,234,245)'],
                                process: function (bits){
                                    return [
                                        parseInt(bits[1]),
                                        parseInt(bits[2]),
                                        parseInt(bits[3])
                                    ];
                                }
                            },
                            {
                                re: /^(\w{2})(\w{2})(\w{2})$/,
                                example: ['#00ff00', '336699'],
                                process: function (bits){
                                    return [
                                        parseInt(bits[1], 16),
                                        parseInt(bits[2], 16),
                                        parseInt(bits[3], 16)
                                    ];
                                }
                            },
                            {
                                re: /^(\w{1})(\w{1})(\w{1})$/,
                                example: ['#fb0', 'f0f'],
                                process: function (bits){
                                    return [
                                        parseInt(bits[1] + bits[1], 16),
                                        parseInt(bits[2] + bits[2], 16),
                                        parseInt(bits[3] + bits[3], 16)
                                    ];
                                }
                            }
                        ];
                    
                        // search through the definitions to find a match
                        for (var i = 0; i < color_defs.length; i++) {
                            var re = color_defs[i].re;
                            var processor = color_defs[i].process;
                            var bits = re.exec(color_string);
                            if (bits) {
                                var channels = processor(bits);
                                this.r = channels[0];
                                this.g = channels[1];
                                this.b = channels[2];
                                this.ok = true;
                            }
                    
                        }
                    
                        // validate/cleanup values
                        this.r = (this.r < 0 || isNaN(this.r)) ? 0 : ((this.r > 255) ? 255 : this.r);
                        this.g = (this.g < 0 || isNaN(this.g)) ? 0 : ((this.g > 255) ? 255 : this.g);
                        this.b = (this.b < 0 || isNaN(this.b)) ? 0 : ((this.b > 255) ? 255 : this.b);
                    
                        // some getters
                        this.toRGB = function () {
                            return 'rgb(' + this.r + ', ' + this.g + ', ' + this.b + ')';
                        };
                        this.toHex = function () {
                            var r = this.r.toString(16);
                            var g = this.g.toString(16);
                            var b = this.b.toString(16);
                            if (r.length == 1) r = '0' + r;
                            if (g.length == 1) g = '0' + g;
                            if (b.length == 1) b = '0' + b;
                            return '#' + r + g + b;
                        };
                    }
					
					if(myColor.search('gradient') !== -1 || myColor.search('rgba') !== -1){
						return myColor;
					}else{
						var color = new RGBColor(myColor);
						if (color.ok) {
							return color.toHex();
						}  
					}
					
                      
                };

                /*Convert hex to rgba*/
                $.iGuider.v.hexToRGBA = function(hex, opacity) {
                    var c;
                    if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
                        c= hex.substring(1).split('');
                        if(c.length== 3){
                            c= [c[0], c[0], c[1], c[1], c[2], c[2]];
                        }
                        c= '0x'+c.join('');
                        return 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+','+opacity+')';
                    }
                };
                $.iGuider.v.hexToRGBCODE = function(hex) {
                    var c;
                    if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
                        c= hex.substring(1).split('');
                        if(c.length== 3){
                            c= [c[0], c[0], c[1], c[1], c[2], c[2]];
                        }
                        c= '0x'+c.join('');
                        return [(c>>16)&255, (c>>8)&255, c&255];
                    }
                };
                $.iGuider.v.clearSavePar = function(){
                    savePar = [];
                };
                
                /*create overlay*/
                $.iGuider.v.createOverlayLayer = function(){
					if($.iGuider.v.tCanvas.tColor && $.iGuider.v.tCanvas.tOpacity > -1){
						if(!overlayCreateFlag){
							overlayCreateFlag = true;
							$('html').addClass('g-show g-event');
							$.iGuider.v.ctx.fillStyle = $.iGuider.v.hexToRGBA($.iGuider.v.tCanvas.tColor,$.iGuider.v.tCanvas.tOpacity);
							$.iGuider.v.ctx.fillRect(0,0,$.iGuider.v.tCanvas.width,$.iGuider.v.tCanvas.height);
						}else{
							
							var hexCode = $.iGuider.v.hexToRGBCODE($.iGuider.v.tCanvas.tColor);
							$.iGuider.v.redrawOverlay(hexCode[0],hexCode[1],hexCode[2],$.iGuider.v.tCanvas.tOpacity);    
						}
					}
                };
                
                /*delete overlay*/
                $.iGuider.v.deleteOverlayLayer = function(){
                    if(overlayCreateFlag){
                        $('html').removeClass('g-show');
                        
                        $.iGuider.v.shapeRemove();
                        $('html').removeClass('g-event');
						overlayCreateFlag = false;
						$.iGuider.v.ctx.clearRect(0,0,$.iGuider.v.tCanvas.width,$.iGuider.v.tCanvas.height);
						$('.g-active').removeClass('g-active');
						$.iGuider.v.clearSavePar();
                    }
                };
                
                /*Redraw Overlay*/
                $.iGuider.v.redrawOverlay = function(r,g,b,a){
                    if(overlayCreateFlag){
                        $.iGuider.v.ctx.clearRect(0,0,$.iGuider.v.tCanvas.width,$.iGuider.v.tCanvas.height);
                        $.iGuider.v.ctx.fillStyle = 'rgba('+r+','+g+','+b+','+a+')';
                        $.iGuider.v.ctx.fillRect(0,0,$.iGuider.v.tCanvas.width,$.iGuider.v.tCanvas.height);
                    }
                };
				
				var addSuccess = function(stepItemLink){
					stepItemLink.addClass('g-step-success');
				};  
                
                /*Create Canvas*/
                $.iGuider.v.createCanvas = function(){
                    if(!$('#g-overlay-wrap').length){        
                        $.iGuider.v.tCanvas = document.createElement('canvas');
                        $($.iGuider.v.tCanvas).appendTo('body');
                        $.iGuider.v.tCanvas.id = 'g-overlay-wrap';
                    }else{
                        $.iGuider.v.tCanvas = document.getElementById('g-overlay-wrap');    
                    }
                    $.iGuider.v.ctx = $.iGuider.v.tCanvas.getContext('2d');
                };
                
                /*Set Canvas Size*/
                $.iGuider.v.setCanvasSize = function(){
                    $.iGuider.v.tCanvas.width = $(window).width();
                    $.iGuider.v.tCanvas.height = $(window).height();
                    $.iGuider.v.createOverlayLayer();
                };
                
				/*Remove All Rectangles*/
                $.iGuider.v.delRect = function(sLength){
                    if(overlayCreateFlag){
                        for(var i = 0; i < sLength; i++){
                            var index = i;
                            var delX = savePar[index].prevX;
                            var delY = savePar[index].prevY;
                            var delW = savePar[index].prevW;
                            var delH = savePar[index].prevH;
                            if($.iGuider.v.tCanvas.shape === 0){
                                $.iGuider.v.ctx.clearRect(delX,delY,delW,delH);    
                                $.iGuider.v.ctx.fillRect(delX,delY,delW,delH);    
                            }
                            if($.iGuider.v.tCanvas.shape == 1){
                                $.iGuider.v.redrawOverlay($.iGuider.v.tCanvas.saveColorR,$.iGuider.v.tCanvas.saveColorG,$.iGuider.v.tCanvas.saveColorB,$.iGuider.v.tCanvas.saveOpacity);
                            }
							if($.iGuider.v.tCanvas.shape == 2){
                                $.iGuider.v.redrawOverlay($.iGuider.v.tCanvas.saveColorR,$.iGuider.v.tCanvas.saveColorG,$.iGuider.v.tCanvas.saveColorB,$.iGuider.v.tCanvas.saveOpacity);
                            }
                            
                            if(i == (sLength - 1)){
                                savePar = [];
                            }
                        }
                        $.iGuider.v.shapeRemove();
                    }
                };
				
                /*Start Animate*/
                $.iGuider.v.start_animate = function(rectPar,lengthDef) {

                    if(overlayCreateFlag){
                        cancelAnimationFrame(requestID);
                        /*Set dinamic variables*/
                        var iteration = 0;
                        var durationFrame = $.iGuider.v.tCanvas.tDuration / 16.666;
                        var durationF = durationFrame+1;
                        var startOp = $.iGuider.v.tCanvas.saveOpacity*10;    /*opacity*/
                        var pathOp = $.iGuider.v.tCanvas.pathOpacity*10;    /*opacity*/
                        
                        /*Draw Rectangle*/
                        $.iGuider.v.tCanvas.draw = function(){
							var newColorR,newColorG,newColorB,newOpacity,newBR;
                            if($.iGuider.v.tCanvas.changeColor){
								if($.iGuider){
									newColorR = $.iGuider.v.easeOutQuad(iteration, $.iGuider.v.tCanvas.saveColorR, $.iGuider.v.tCanvas.pathColorR, durationF);  /*color*/
									newColorG = $.iGuider.v.easeOutQuad(iteration, $.iGuider.v.tCanvas.saveColorG, $.iGuider.v.tCanvas.pathColorG, durationF);  /*color*/
									newColorB = $.iGuider.v.easeOutQuad(iteration, $.iGuider.v.tCanvas.saveColorB, $.iGuider.v.tCanvas.pathColorB, durationF);  /*color*/    
									newOpacity = $.iGuider.v.easeOutQuad(iteration, startOp, pathOp, durationF) / 10;  /*opacity*/
									$.iGuider.v.redrawOverlay(newColorR,newColorG,newColorB,newOpacity);    
								}
                            }                            
                            if($.iGuider.v.tCanvas.saveShape == 1){
                                /*Remove Old Arc*/
                                if($.iGuider.v.tCanvas.changeColor){
                                    $.iGuider.v.redrawOverlay(newColorR,newColorG,newColorB,newOpacity);
                                }else{
                                    $.iGuider.v.redrawOverlay($.iGuider.v.tCanvas.saveColorR,$.iGuider.v.tCanvas.saveColorG,$.iGuider.v.tCanvas.saveColorB,$.iGuider.v.tCanvas.saveOpacity);
                                }
                            }
						
							if($.iGuider.v.tCanvas.saveShape == 2){
                                
                                if($.iGuider.v.tCanvas.changeColor){
                                    $.iGuider.v.redrawOverlay(newColorR,newColorG,newColorB,newOpacity);
                                }else{
                                    $.iGuider.v.redrawOverlay($.iGuider.v.tCanvas.saveColorR,$.iGuider.v.tCanvas.saveColorG,$.iGuider.v.tCanvas.saveColorB,$.iGuider.v.tCanvas.saveOpacity);
                                }
                            }
							
                            for(var i = 0; i < rectPar.length; i++){
                                /*Set dinamic variables*/
                                var index = i;    
                                if(!savePar[index]){
                                    savePar.push({});
                                }
                                var saveParItem = savePar[index];
                                var rectParItem = rectPar[index];
                                var prevX = saveParItem.prevX || rectParItem.x;
                                var prevY = saveParItem.prevY || rectParItem.y;
                                var prevW = saveParItem.prevW || rectParItem.width;
                                var prevH = saveParItem.prevH || rectParItem.height;
								var prevBR = saveParItem.prevBR || rectParItem.BR;
                                if($.iGuider.v.tCanvas.saveShape === 0){
                                    /*Remove Old Rect*/
                                    $.iGuider.v.ctx.clearRect(prevX,prevY,prevW,prevH);
                                    $.iGuider.v.ctx.fillRect(prevX,prevY,prevW,prevH);    
                                }
            
                                /*Get New Position*/
                                var newPosX = $.iGuider.v.easeOutQuad(iteration, rectParItem.saveX, rectParItem.pathX, durationF);
                                var newPosY = $.iGuider.v.easeOutQuad(iteration, rectParItem.saveY, rectParItem.pathY, durationF);
                                var newW = $.iGuider.v.easeOutQuad(iteration, rectParItem.saveW, rectParItem.pathW, durationF);
                                var newH = $.iGuider.v.easeOutQuad(iteration, rectParItem.saveH, rectParItem.pathH, durationF);
								var newBR = $.iGuider.v.easeOutQuad(iteration, rectParItem.saveBR, rectParItem.pathBR, durationF);

                                /*Draw New Rect*/
                                if($.iGuider.v.tCanvas.shape === 0){
                                    $.iGuider.v.ctx.clearRect(newPosX,newPosY,newW,newH);
                                }
                                
                                /*Draw New Arc*/
                                if($.iGuider.v.tCanvas.shape == 1){
                                    var arcLeft = (newPosX + newW/2).toFixed(0);
                                    var arcTop = (newPosY + newH/2).toFixed(0);
                                    var radius = (Math.sqrt(newW * newW + newH * newH)/2).toFixed(0);
                                    $.iGuider.v.ctx.globalCompositeOperation = 'destination-out';
                                    $.iGuider.v.ctx.beginPath();
                                    $.iGuider.v.ctx.arc(arcLeft,arcTop,radius,0,Math.PI*2);
                                    $.iGuider.v.ctx.closePath();
                                    $.iGuider.v.ctx.fillStyle = 'rgba(0,0,0,1)';
                                    $.iGuider.v.ctx.fill();
                                    $.iGuider.v.ctx.globalCompositeOperation = 'source-over';
                                }
								
								/*Draw New Round Rect*/
                                if($.iGuider.v.tCanvas.shape == 2){
                                    $.iGuider.v.ctx.globalCompositeOperation = 'destination-out';
									$.iGuider.v.ctx.fillStyle = 'rgba(0,0,0,1)';
	
                                    if (typeof newBR === 'undefined') {
										newBR = 5;
									}

									$.iGuider.v.ctx.beginPath();
									$.iGuider.v.ctx.moveTo(newPosX + newBR, newPosY);
									$.iGuider.v.ctx.lineTo(newPosX + newW - newBR, newPosY);
									$.iGuider.v.ctx.quadraticCurveTo(newPosX + newW, newPosY, newPosX + newW, newPosY + newBR);
									$.iGuider.v.ctx.lineTo(newPosX + newW, newPosY + newH - newBR);
									$.iGuider.v.ctx.quadraticCurveTo(newPosX + newW, newPosY + newH, newPosX + newW - newBR, newPosY + newH);
									$.iGuider.v.ctx.lineTo(newPosX + newBR, newPosY + newH);
									$.iGuider.v.ctx.quadraticCurveTo(newPosX, newPosY + newH, newPosX, newPosY + newH - newBR);
									$.iGuider.v.ctx.lineTo(newPosX, newPosY + newBR);
									$.iGuider.v.ctx.quadraticCurveTo(newPosX, newPosY, newPosX + newBR, newPosY);
									$.iGuider.v.ctx.closePath();
									$.iGuider.v.ctx.fill();

                                    $.iGuider.v.ctx.globalCompositeOperation = 'source-over';
                                }

                                saveParItem.prevX = newPosX;
                                saveParItem.prevY = newPosY;
                                saveParItem.prevW = newW;
                                saveParItem.prevH = newH;
                                saveParItem.saveX = rectParItem.x;
                                saveParItem.saveY = rectParItem.y;
                                saveParItem.saveW = rectParItem.width;
                                saveParItem.saveH = rectParItem.height;
								saveParItem.saveBR = rectParItem.BR;
                            }
                            
                            if (iteration < durationFrame) {
                                iteration ++;
                                requestID = requestAnimFrame($.iGuider.v.tCanvas.draw);
                            }else{
                                iteration = 0;
                                cancelAnimationFrame(requestID);
                                $.iGuider.v.tCanvas.saveColor = $.iGuider.v.tCanvas.color;       	 /*color*/
                                $.iGuider.v.tCanvas.saveColorR = $.iGuider.v.tCanvas.colorR;    	 /*color*/
                                $.iGuider.v.tCanvas.saveColorG = $.iGuider.v.tCanvas.colorG;   		 /*color*/
                                $.iGuider.v.tCanvas.saveColorB = $.iGuider.v.tCanvas.colorB;   		 /*color*/
                                $.iGuider.v.tCanvas.saveOpacity = $.iGuider.v.tCanvas.opacity;   	 /*color*/
                                $.iGuider.v.tCanvas.saveShape = $.iGuider.v.tCanvas.shape;        	 /*color*/

								
                                if(lengthDef){
                                    for(var j = 0; j < lengthDef; j++){
                                        savePar.pop();
                                    }    
                                }
                            }
                        };
                        
                        /*Start Draw Rect*/
                        $.iGuider.v.tCanvas.draw();
                    }
                };
                
                $.iGuider.v.shapeRemove = function(){
                    $('.g-shape').remove();    
                };
                
                $.iGuider.v.searchEl = function(collect){
                    $.iGuider.v.createOverlayLayer();
                    if(overlayCreateFlag){
                        var rectPar = [];
                        var color = $.iGuider.v.tCanvas.tColor;                /*color*/
                        var colorCode = $.iGuider.v.hexToRGBCODE(color);    /*color*/
                        var colorR = colorCode[0];                /*color*/
                        var colorG = colorCode[1];                /*color*/
                        var colorB = colorCode[2];                /*color*/
                        var opacity = $.iGuider.v.tCanvas.tOpacity;           /*opacity*/    
                        var shape = $.iGuider.v.tCanvas.shape;                /*shape*/
						
                        var saveColor = $.iGuider.v.tCanvas.saveColor || color;        /*color*/
                        var saveColorR = $.iGuider.v.tCanvas.saveColorR || colorR;                        /*color*/
                        var saveColorG = $.iGuider.v.tCanvas.saveColorG || colorG;                        /*color*/
                        var saveColorB = $.iGuider.v.tCanvas.saveColorB || colorB;                        /*color*/
                        var saveOpacity = $.iGuider.v.tCanvas.saveOpacity >= 0 ? $.iGuider.v.tCanvas.saveOpacity : opacity;    /*opacity*/
						
						
												
                        $.iGuider.v.tCanvas.colorR = colorR;     /*color*/
                        $.iGuider.v.tCanvas.colorG = colorG;     /*color*/
                        $.iGuider.v.tCanvas.colorB = colorB;     /*color*/
                        $.iGuider.v.tCanvas.saveColor = saveColor;        /*color*/
                        $.iGuider.v.tCanvas.saveColorR = saveColorR;    /*color*/
                        $.iGuider.v.tCanvas.saveColorG = saveColorG;    /*color*/
                        $.iGuider.v.tCanvas.saveColorB = saveColorB;    /*color*/
                        $.iGuider.v.tCanvas.saveShape = $.iGuider.v.tCanvas.saveShape || shape;    /*shape*/
						
                        $.iGuider.v.tCanvas.saveOpacity = saveOpacity;    /*opacity*/
                        $.iGuider.v.tCanvas.pathColorR = colorR - saveColorR;        /*color*/
                        $.iGuider.v.tCanvas.pathColorG = colorG - saveColorG;        /*color*/
                        $.iGuider.v.tCanvas.pathColorB = colorB - saveColorB;        /*color*/
                        $.iGuider.v.tCanvas.pathOpacity = opacity - saveOpacity;    /*opacity*/
						
						
						
                        if($.iGuider.v.tCanvas.saveColor != $.iGuider.v.tCanvas.color || $.iGuider.v.tCanvas.saveOpacity != $.iGuider.v.tCanvas.opacity){
                            $.iGuider.v.tCanvas.changeColor = true;
                        }else{
                            $.iGuider.v.tCanvas.changeColor = false;    
                        }
						
                        $.iGuider.v.shapeRemove();
						
                        collect.each(function(i){
                            var index = i;
                            var el = $(this);
                            var elW = el.outerWidth();
                            var elH = el.outerHeight();
                            var elLeft = (el.offset().left - $(window).scrollLeft()).toFixed(0);
                            var elTop = (el.offset().top - $(window).scrollTop()).toFixed(0);
                            var margin = $.iGuider.v.tCanvas.tMargin;
                            var width = elW + margin * 2;
                            var height = elH + margin * 2;
                            var x = elLeft - margin;
                            var y = elTop - margin;
							var maxBRSize = width > height ? height/2 : width/2;
							var shapeBorderRadius = $.iGuider.v.tCanvas.shapeBorderRadius;
							
							var shapeLeft = el.offset().left - margin;
                            var shapeTop = el.offset().top - margin;
                            var shapeW = width;
                            var shapeH = height;
                            var shapeBRadius = 0;
							
							if($.iGuider.v.tCanvas.shape == 2){
                                shapeBRadius = shapeBorderRadius > maxBRSize ? maxBRSize : shapeBorderRadius;
								shapeBorderRadius = shapeBRadius;
                            }
							
                            if(el.is('body')){
                                margin = 0;    
                                width = 0;    
                                height = 0;
                                x = $(window).width()/2;
                                y = $(window).height()/2;
                            }
            
                            if(!savePar[index]){
                                savePar.push({});
                            }
                
                            var saveX = savePar[index].saveX || x;
                            var saveY = savePar[index].saveY || y;
                            var saveW = savePar[index].saveW || width;
                            var saveH = savePar[index].saveH || height;
							
							var saveBR = savePar[index].saveBR || shapeBorderRadius;

                            rectPar.push({
                                width:width,
                                height:height,
                                x:x,
                                y:y,
								
								BR:shapeBorderRadius,
            
                                saveX:saveX,
                                saveY:saveY,
                                saveW:saveW,
                                saveH:saveH,
								
								saveBR:saveBR,
            
                                pathX:x - saveX,
                                pathY:y - saveY,
                                pathW:width - saveW,
                                pathH:height - saveH,
								
								pathBR:shapeBorderRadius - saveBR,
            
                                prevX:savePar[index].prevX || x,
                                prevY:savePar[index].prevY || y,
                                prevW:savePar[index].prevW || width,
                                prevH:savePar[index].prevH || height,
								
								prevBR:savePar[index].prevBR || shapeBorderRadius

                            });            
                            
                            if(i == (collect.length - 1)){
                                $.iGuider.v.setEmpty(savePar,rectPar);
                            }
                            
                            /*if $.iGuider.v.tCanvas.shape == 0*/
                           
                            
                            if($.iGuider.v.tCanvas.shape == 1){
								var radius = (Math.sqrt(shapeW * shapeW + shapeH * shapeH)/2);
                                shapeLeft = (shapeLeft - (radius - shapeW/2));
                                shapeTop = (shapeTop - (radius - shapeH/2));
                                shapeW = radius*2;
                                shapeH = radius*2;
                                shapeBRadius = '50%';
                            }
							
                            
							var fixedTop = (shapeTop - $(window).scrollTop());
							var fixedLeft = (shapeLeft - $(window).scrollLeft());
                            $('<div>')
                                .addClass('g-shape')
                                .css({left:fixedLeft, top:fixedTop, width:shapeW, height:shapeH, borderRadius:shapeBRadius})
                                .appendTo('body');
                        });
                        if(!collect.length){
                            $.iGuider.v.delRect(savePar.length);        
                        }
                    }
                };

                $.iGuider.v.fixStepNumVal = function(stepObj){
                	if(stepObj){
                		if(stepObj.overlayOpacity > -1){stepObj.overlayOpacity = parseFloat(stepObj.overlayOpacity);}
    					if(stepObj.spacing > -1){stepObj.spacing = parseFloat(stepObj.spacing);}
    					if(stepObj.shape > -1){stepObj.shape = parseFloat(stepObj.shape);}	
    					if(stepObj.shapeBorderRadius > -1){stepObj.shapeBorderRadius = parseFloat(stepObj.shapeBorderRadius);}
    					if(stepObj.waitElementTime > -1){stepObj.waitElementTime = parseFloat(stepObj.waitElementTime);}
                    }
                    return stepObj;
                };

				
                /*Set Addition Empty Objects*/
                $.iGuider.v.setEmpty = function(savePar,rectPar){
                    var sLength = savePar.length;
                    var rLength = rectPar.length;
                                    
                    if(sLength > rLength){
                        var saveIndex = (rLength-1);
                        var lengthDef = sLength - rLength;
                        var jsonItem = JSON.stringify(rectPar[saveIndex]);
                        var saveItem = JSON.parse(jsonItem);
                        for(var i = 0; i < sLength; i++){
                            var index = i;
                            if(index > (rLength - 1)){                        
                                rectPar[index] = saveItem;
                                rectPar[index].saveX = savePar[index].saveX;
                                rectPar[index].saveY = savePar[index].saveY;
                                rectPar[index].saveW = savePar[index].saveW;
                                rectPar[index].saveH = savePar[index].saveH;
            
                                rectPar[index].prevX = savePar[index].prevX;
                                rectPar[index].prevY = savePar[index].prevY;
                                rectPar[index].prevW = savePar[index].prevW;
                                rectPar[index].prevH = savePar[index].prevH;
                                
                                rectPar[index].pathX = rectPar[index].x - savePar[index].saveX;
                                rectPar[index].pathY = rectPar[index].y - savePar[index].saveY;
                                rectPar[index].pathW = rectPar[index].width - savePar[index].saveW;
                                rectPar[index].pathH = rectPar[index].height - savePar[index].saveH;
            
                                if(index == (sLength - 1)){
                                    $.iGuider.v.start_animate(rectPar,lengthDef);    
                                }                
                            }
                        }
                    }else{
                        if(rLength){
                            $.iGuider.v.start_animate(rectPar);    
                        }else{
                            $.iGuider.v.delRect(savePar.length);    
                        }
                    }
                };

                /*Set Canvas Def Options*/
                $.iGuider.v.setCanvasDefault = function(){
                    $.iGuider.v.tCanvas.def = {
                        tOpacity:$.iGuider.opt.overlayOpacity > -1 ? $.iGuider.opt.overlayOpacity : 0.5,
                        tColor:$.iGuider.opt.overlayColor || '#000',    
                        tMargin:parseFloat($.iGuider.opt.spacing) > -1 ? parseFloat($.iGuider.opt.spacing) : 10,
                        tDuration:300,
                        shape:parseFloat($.iGuider.opt.shape) > -1 ? parseFloat($.iGuider.opt.shape) : 0,
						shapeBorderRadius:parseFloat($.iGuider.opt.shapeBorderRadius) > -1 ? parseFloat($.iGuider.opt.shapeBorderRadius) : 5
                    };
                    $.iGuider.v.tCanvas.startOpt = {
                        tOpacity:1.1,
                        tColor:'#0000',    
                        tMargin:10,
                        tDuration:300,
                        shape:0,
						shapeBorderRadius:4
                    };
                    $.iGuider.v.tCanvas.tOpacity = $.iGuider.v.tCanvas.def.tOpacity;
                    $.iGuider.v.tCanvas.tColor = $.iGuider.v.tCanvas.def.tColor;
                    $.iGuider.v.tCanvas.tMargin = $.iGuider.v.tCanvas.def.tMargin;
                    $.iGuider.v.tCanvas.tDuration = $.iGuider.v.tCanvas.def.tDuration;
                    $.iGuider.v.tCanvas.shape = $.iGuider.v.tCanvas.def.shape;
					$.iGuider.v.tCanvas.shapeBorderRadius = $.iGuider.v.tCanvas.def.shapeBorderRadius;
                };
                
                $.iGuider.v.tIni = function(){
                    $.iGuider.v.createCanvas();
                    $.iGuider.v.setCanvasSize();
                    $.iGuider.v.setCanvasDefault();
                };

                $.iGuider.v.tIni();

                /**/
                /*Any Tour ID*/
                /**/
                $.iGuider.v.tourid = '';
                
                if($.iGuider.opt.tourTitle){
                    $.iGuider.v.tourid = $.iGuider.opt.tourTitle;
                    $.iGuider.v.gMapHeader = $('<div>')
                        .addClass('g-map-header')
                        .html($.iGuider.opt.tourTitle)
                        .appendTo($(':contains([map-header])',mapTemplate).last().empty());

                }
                
                $.iGuider.v.gMapContent = $('<div>')
                    .addClass('g-map-content')
                    .appendTo($(':contains([map-content])',mapTemplate).last().empty());

                /**/
                /*Step can be skipped if you set parameter "skip" to true.*/
                /**/
                var actualStepsCombine = [];
                var actualIndex = 0;
                
                var uid = 0;
                var stepReplace = function(hStepItem){
                    if(!hStepItem.loc){
						if($.iGuider.opt.baseurl){
							hStepItem.loc = $.iGuider.opt.loc || location.href.split($.iGuider.opt.baseurl)[1];
						}else{
							hStepItem.loc = $.iGuider.opt.loc || location.href;
						}
                    }

					if(typeof hStepItem.keyboardEvent == "undefined"){
						hStepItem.keyboardEvent = $.iGuider.opt.keyboardEvent;
					}

					/*Set Step Timer*/
					if(!parseFloat(hStepItem.timer)){
						if(hStepItem.timer === false || hStepItem.timer === 0 || hStepItem.timer === '0'){
							hStepItem.timer = false;
						}else{
							if(parseFloat($.iGuider.opt.timer) > 0){
								hStepItem.timer = $.iGuider.opt.timer;
							}else{
								hStepItem.timer = false;
							}
						}
					}

                    actualStepsCombine.push(hStepItem);

                    /**/
                    /*Creating step links*/
                    /**/
                    var hStepItemTitle = hStepItem.title ? hStepItem.title : '№'+(actualIndex+1);
                    var hindexStep = $('<div data-hindex="'+actualIndex+'" class="g-step-item" data-title="'+hStepItemTitle+'"><span class="g-step-item-text">'+hStepItemTitle+'</span></div>').appendTo($.iGuider.v.gMapContent);
                    if(hStepItem.ready){
						addSuccess(hindexStep); 
                    }
                    actualIndex++;
                };

                var escapeRe = function (value) {
                    return value.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&");
                };

				
				
				if($.iGuider.opt.steps && $.iGuider.opt.steps.length){
					for(var i = 0; i < $.iGuider.opt.steps.length; i++){
						var skip = $.iGuider.opt.steps[i].skip;
						if(!skip){
							var hStepItem = $.iGuider.opt.steps[i];
							if($.iGuider.opt.registerMissingElements || hStepItem.position == 'center'){
								stepReplace(hStepItem);
							}else{
								var targetElement;
								if($(hStepItem.target).length){
									targetElement = $(hStepItem.target);         
								}else{
									targetElement = $('[data-target ="'+hStepItem.target+'"]');
								}    
								if(targetElement.length){
									stepReplace(hStepItem);
								}
							}
						}
						$.iGuider.v.tourid = $.iGuider.v.tourid + $.iGuider.opt.steps[i].target;
					}
					$.iGuider.opt.steps = actualStepsCombine;
				}
                
				
                /**/
                /*Save Desktop Events $ Save Touch Events*/
                /**/
                var iOs = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
                $.iGuider.v.clickEvent = iOs ? 'touchend' : 'click';

                var touchMoving = false;
                if (iOs){  
                    document.ontouchmove = function(e){
                        touchMoving = true;
                    };
                    document.ontouchend = function(e){
                        setTimeout(function(){
                            touchMoving = false;
                        },100);
                    };
                } 
                var mousemoveEvent = 'mousemove.'+$.iGuider.hName;
                var mousedownEvent = 'mousedown.'+$.iGuider.hName;
                var mouseupEvent = 'mouseup.'+$.iGuider.hName;
                if('ontouchstart' in window){
                    mousemoveEvent = 'touchmove.'+$.iGuider.hName;
                    mousedownEvent = 'touchstart.'+$.iGuider.hName;
                    mouseupEvent = 'touchend.'+$.iGuider.hName;
                }    
                $.iGuider.v.mousemoveEvent = mousemoveEvent;
                $.iGuider.v.mouseupEvent = mouseupEvent;
                $.iGuider.v.mousedownEvent = mousedownEvent;
                
                /**/
                /*Detect Privacy Mode in Safari (iOS)*/
                /**/
                var iOS = !!navigator.platform && /iPad|iPhone|iPod/.test(navigator.platform);
				if(iOS){
					try { localStorage.test = 2; } catch (e) {
						alert('You are in Privacy Mode\nPlease deactivate Privacy Mode and then reload the page to view the Tour.');
						$.fn.iGuider('destroy');
						return false;
					}
				}
                
                /**/
                /*This function converts the parameters of the object to a string*/
                /**/
                var toStringObjIndex = 0;
                var typeDetect = function(per){
                    if(typeof per == 'function'){
                        //function
                        return typeof per;
                    }
                    if(typeof per == 'boolean'){
                        //boolean
                        return typeof per;
                    }
                    if(typeof per == 'string'){
                        //string
                        return typeof per;
                    }
                    if(typeof per == 'number'){
                        //number
                        return typeof per;
                    }
                    if(typeof per == 'object'){
                        if(Array.isArray(per)){
                            //Array
                            return 'array';
                        }else{
                            //Object
                            return 'object';
                        }
                    }
                };
                $.iGuider.v.toStringObj = function(obj){
                    var newIndex = toStringObjIndex++;
                    var objEnter = obj;
                    var tempObj = {};
                    tempObj[newIndex] = {};
                    
                    for (var i in objEnter) {
						if(objEnter.hasOwnProperty(i)){
							var key1 = i;
							var val = objEnter[key1];
							//function
							if(typeDetect(val) == 'function'){
								tempObj[newIndex][key1] = val.toString();
							}
							//array
							if(typeDetect(val) == 'array'){
								var valEach = val;
								for(var f = 0; f < valEach.length; f++){
									if(typeDetect(valEach[f]) == 'object'){
										var objMass = valEach[f];
										var val3 = $.iGuider.v.toStringObj(objMass);
										valEach[f] = val3;    
									}        
								}
								tempObj[newIndex][key1] = valEach;
							}
							//object
							if(typeDetect(val) == 'object'){
								var val2 = $.iGuider.v.toStringObj(val);    
								tempObj[newIndex][key1] = val2;
							}
							//string, number, boolean
							if(typeDetect(val) == 'string' || typeDetect(val) == 'number' || typeDetect(val) == 'boolean'){
								tempObj[newIndex][key1] = objEnter[key1];
							}
						}
                    }
                    return tempObj[newIndex];    
                };

				$.iGuider.v.coneHide = function(){
					$.iGuider.v.modalPos.addClass('cone-hide');
				};
				$.iGuider.v.coneShow = function(){
					$.iGuider.v.modalPos.removeClass('cone-hide');
				};
				
				$.iGuider.v.selectCallback = function(){
					
					if($.iGuider.opt.steps[$.iGuider.v.startIndex].autofocus !== false){
						$(':focus').blur();
						$.iGuider.v.targetEl.focus();
					}
					
					$.iGuider.v.messHide();
					$.iGuider.v.messEvHide();
				};

                $.iGuider.v.posCorrect = function(pos_0, pos_1, pos_2){
					
					if(!pos_0){
						pos_0 = $.iGuider.v.modalPos.attr('data-pos');
					} 
					if(!pos_1){
						pos_1 = $.iGuider.v.modalPos.attr('data-cone');
					} 
					if(!pos_2){
						pos_2 = $.iGuider.v.modalPos.attr('data-cont');
					} 
					
					var ww = $(window).width();
					
					var sizeW = $.iGuider.v.modalSize.outerWidth();
					if(sizeW > (ww - 20)){
						$.iGuider.v.modalSize.css({minWidth:(ww - 20)});
					}
					
					var corrected = false;
					
					$.iGuider.v.modalSize.css({marginTop:'', marginLeft:''});	
					$.iGuider.v.modalPos.css({marginLeft:''});	
					var sumW = ($.iGuider.v.modalSize.offset().left + $.iGuider.v.modalSize.width());
					var wh = $(window).height();
					var elOffsetTop = ($.iGuider.v.modalSize.offset().top - $(window).scrollTop());		
					var sumH = elOffsetTop + $.iGuider.v.modalSize.height();
					$.iGuider.v.coneShow();
					var corVal;

					$.iGuider.v.coneCheckHor = function(corVal){
						
						if(pos_0 == 'l' || pos_0 == 'r'){
							//hide cone
							$.iGuider.v.coneHide();
						}
						
						if(pos_0 == 't' || pos_0 == 'b'){
							if(pos_2 == 'r' && corVal > 0){
								//hide cone
								$.iGuider.v.coneHide();
							}
							
							
							if(pos_2 == 'l' && corVal < 0){
								//hide cone
								$.iGuider.v.coneHide();
							}
							
							if(pos_1 == 'c'){
								if(pos_2 == 'c'){
									if(corVal < 0){
										if((corVal-15) < -$.iGuider.v.modalSize.outerWidth()/2){
											//hide cone
											$.iGuider.v.coneHide();
										}
									}
									if(corVal > 0){
										if((corVal+15) > $.iGuider.v.modalSize.outerWidth()/2){
											//hide cone
											$.iGuider.v.coneHide();
										}
									}
								}
								if(pos_2 == 'r'){
									if(corVal < 0){
										if((corVal-15) < -$.iGuider.v.modalSize.outerWidth()){
											//hide cone
											$.iGuider.v.coneHide();
										}
									}
								}
								if(pos_2 == 'l'){
									if(corVal > 0){
										if((corVal+15) > $.iGuider.v.modalSize.outerWidth()){
											//hide cone
											$.iGuider.v.coneHide();
										}
									}
								}
								
							}
							
							if(pos_1 == 'r' || pos_1 == 'l'){
								if(pos_2 == 'r'){
									if(corVal < 0){
										if((corVal-15) < -$.iGuider.v.modalSize.outerWidth()){
											//hide cone
											$.iGuider.v.coneHide();
										}
									}
								}
								if(pos_2 == 'l'){
									if(corVal > 0){
										if((corVal+15) > $.iGuider.v.modalSize.outerWidth()){
											//hide cone
											$.iGuider.v.coneHide();
										}
									}
								}
								if(pos_2 == 'c'){
									if(corVal < 0){
										if((corVal-15) < -$.iGuider.v.modalSize.outerWidth()/2){
											//hide cone
											$.iGuider.v.coneHide();
										}
									}
									if(corVal > 0){
										if((corVal+15) > $.iGuider.v.modalSize.outerWidth()/2){
											//hide cone
											$.iGuider.v.coneHide();
										}
									}
								}
							}
						}
					};
					$.iGuider.v.coneCheckVert = function(corVal){	

						if(pos_0 == 't' || pos_0 == 'b'){
							//hide cone
							$.iGuider.v.coneHide();
						}
						
						if(pos_0 == 'l' || pos_0 == 'r'){
							if(pos_2 == 'b' && corVal > 0){
								//hide cone
								$.iGuider.v.coneHide();
							}
							if(pos_2 == 't' && corVal < 0){
								//hide cone
								$.iGuider.v.coneHide();
							}
							
							if(pos_1 == 'c'){
								if(pos_2 == 'c'){
									if(corVal < 0){
										if((corVal-15) < -$.iGuider.v.modalSize.outerHeight()/2){
											//hide cone
											$.iGuider.v.coneHide();
										}
									}
									if(corVal > 0){
										if((corVal+15) > $.iGuider.v.modalSize.outerHeight()/2){
											//hide cone
											$.iGuider.v.coneHide();
										}
									}
								}
								if(pos_2 == 'b'){
									if(corVal < 0){
										if((corVal-15) < -$.iGuider.v.modalSize.outerHeight()){
											//hide cone
											$.iGuider.v.coneHide();
										}
									}
								}
								if(pos_2 == 't'){
									if(corVal > 0){
										if((corVal+15) > $.iGuider.v.modalSize.outerHeight()){
											//hide cone
											$.iGuider.v.coneHide();
										}
									}
								}
								
							}
							
							if(pos_1 == 'b' || pos_1 == 't'){
								if(pos_2 == 'b'){
									if(corVal < 0){
										if((corVal-15) < -$.iGuider.v.modalSize.outerHeight()){
											//hide cone
											$.iGuider.v.coneHide();
										}
									}
								}
								if(pos_2 == 't'){
									if(corVal > 0){
										if((corVal+15) > $.iGuider.v.modalSize.outerHeight()){
											//hide cone
											$.iGuider.v.coneHide();
										}
									}
								}
								if(pos_2 == 'c'){
									if(corVal < 0){
										if((corVal-15) < -$.iGuider.v.modalSize.outerHeight()/2){
											//hide cone
											$.iGuider.v.coneHide();
										}
									}
									if(corVal > 0){
										if((corVal+15) > $.iGuider.v.modalSize.outerHeight()/2){
											//hide cone
											$.iGuider.v.coneHide();
										}
									}
								}
							}

						}

					};
					
					/*start correct*/
					/*for horizontal correct*/

					if(sumW > (ww - 10)){
						corrected = true;
						corVal = -((sumW - ww)+10);
						$.iGuider.v.modalSize.css({marginLeft:corVal});
						
						$.iGuider.v.coneCheckHor(corVal);
					}
					if($.iGuider.v.modalSize.offset().left < 10){
						corrected = true;
						corVal = -$.iGuider.v.modalSize.offset().left+10;
						$.iGuider.v.modalSize.css({marginLeft:corVal}); 			

						$.iGuider.v.coneCheckHor(corVal);
					}
					
					
					
					/*for vertical correct*/

					if(sumH > (wh - 10)){
						
						corrected = true;
						corVal = -((sumH - wh)+10);
						$.iGuider.v.modalSize.css({marginTop:corVal});
						
						$.iGuider.v.coneCheckVert(corVal);
						
					}
					if(elOffsetTop < 10){
						corrected = true;
						corVal = (elOffsetTop*-1+10);
						$.iGuider.v.modalSize.css({marginTop:corVal}); 
								
						$.iGuider.v.coneCheckVert(corVal);
						
					}
					/*end correct*/
					
					

					if(pos_0 == 'c' && pos_1 == 'c' && pos_2 == 'c'){
						$.iGuider.v.modalSize.css({marginLeft:''});	
                    }
					
					if(pos_2 !== 'c' && corrected){
						//hide cone
						//$.iGuider.v.coneHide();
					}
					
					if($.iGuider.v.modalSize.height() > wh - 20){
						//hide cone
						$.iGuider.v.coneHide();
					}

					if(corrected){
						$.iGuider.v.modalPos.addClass('g-pos-correct');
					}else{
						$.iGuider.v.modalPos.removeClass('g-pos-correct');
					}

                };
				
				$.iGuider.v.play = function(){
					if ($.iGuider.opt.play !== undefined) {
						try{
							var play_Func = new Function('return ' + $.iGuider.opt.play)();
							play_Func();
						}catch(e) {
							$.iGuider.v.debug(new Error().lineNumber+ ' The callback function specified is not correct.');
						}
					}
				};
				$.iGuider.v.pause = function(){
					if ($.iGuider.opt.pause !== undefined) {
						try{
							var pause_Func = new Function('return ' + $.iGuider.opt.pause)();
							pause_Func();
						}catch(e) {
							$.iGuider.v.debug(new Error().lineNumber+ ' The callback function specified is not correct.');
						}
					}
				};
                
				/*Callback functions*/
				$.iGuider.v.start = function(){
					localStorage.setItem('iGuider_event','start');
					if ($.iGuider.opt.start !== undefined) {
						try{
							var start_Func = new Function('return ' + $.iGuider.opt.start)();
							start_Func();
						}catch(e) {
							$.iGuider.v.debug(new Error().lineNumber+ ' The callback function specified is not correct.');
						}
					}				
				};
				$.iGuider.v.end = function(){
					localStorage.setItem('iGuider_event','end');
					//$.iGuider.v.progressFunc(0);
					if ($.iGuider.opt.end !== undefined) {
						try{
							var end_Func = new Function('return ' + $.iGuider.opt.end)();
							end_Func();
						}catch(e) {
							$.iGuider.v.debug(new Error().lineNumber+ ' The callback function specified is not correct.');
						}
					}
					
				};
				$.iGuider.v.abort = function(){
					localStorage.setItem('iGuider_event','abort');
					localStorage.setItem('iGuider_restored','0');
					localStorage.removeItem('iGuider_opt');
					localStorage.removeItem('iGuider_step');
					if ($.iGuider.opt.abort !== undefined) {
						try{
							var abort_Func = new Function('return ' + $.iGuider.opt.abort)();
							abort_Func();
						}catch(e) {
							$.iGuider.v.debug(new Error().lineNumber+ ' The callback function specified is not correct.');
						}
					} 

				};
				$.iGuider.v.finish = function(){
					localStorage.setItem('iGuider_event','finish');
					if ($.iGuider.opt.finish !== undefined) {
						try{
							var finish_Func = new Function('return ' + $.iGuider.opt.finish)();
							finish_Func(); 
						}catch(e) {
							$.iGuider.v.debug(new Error().lineNumber+ ' The callback function specified is not correct.');
						}
					}
					localStorage.removeItem('iGuider_step');
					localStorage.removeItem('iGuider_opt');
					
					localStorage.removeItem('iGuider_data-'+$.iGuider.opt.tourID);
					localStorage.removeItem('itour_options');
				};
				$.iGuider.v.create = function(){
					localStorage.setItem('iGuider_event','create');
					if ($.iGuider.opt.create !== undefined) {
						try{
							var create_Func = new Function('return ' + $.iGuider.opt.create)();
							create_Func();
						}catch(e) {
							$.iGuider.v.debug(new Error().lineNumber+ ' The callback function specified is not correct.');
						}
					}
					if(!$.iGuider.opt.steps){
						localStorage.setItem('iGuider_event','no_steps');
					}
				};
				
				$(document).on('keydown.iGuider',function(e){
					if($.iGuider){
						if(!$.iGuider.v.design){
							if($.iGuider.opt.keyboard){
								if(parseFloat(e.keyCode) == 27){
									$.iGuider.v.debug(new Error().lineNumber+ ' Click  Esc and Destroy'); 
									$.iGuider.v.end();                                            
									$.iGuider.v.abort();  
									$.fn.iGuider('destroy');
								}
								
								if(parseFloat(e.keyCode) == 39){
									$.iGuider.v.debug(new Error().lineNumber+ ' Click Keyboard Next');   
									iGuider('next');							
								}
								
								if(parseFloat(e.keyCode) == 37){
									$.iGuider.v.debug(new Error().lineNumber+ ' Click Keyboard Prev');    
									iGuider('prev');
								}
								
								if(parseFloat(e.keyCode) == 13){
									$.iGuider.v.debug(new Error().lineNumber+ ' Click Keyboard Enter');  
									if($('html').is('.g-modal-intro-show')){
										
										$.iGuider.v.debug(new Error().lineNumber+ ' Click Keyboard Start');
										
										$.iGuider.v.modalStart.addClass('active');
										$.iGuider.v.modalStart.trigger('click');
									}
									
									if($('html').is('.g-modal-continue-show')){
										
										$.iGuider.v.debug(new Error().lineNumber+ ' Click Keyboard Continue');
										
										$.iGuider.v.modalBeginContinue.addClass('active');
										$.iGuider.v.modalBeginContinue.trigger('click');
									}
									
								}
								
							}
						}
					}
                });
                
                /**/
                /*Overlay Elements Positioning*/
                /**/
                $.iGuider.v.overlayPos = function(targetEl){

					$.iGuider.v.debug(new Error().lineNumber+ ' Start overlayPos func'); 
                    if(targetEl && targetEl.length){
                        $.iGuider.v.modalData = [];
						var vw = $(window).width();
						var vh = $(window).height();
						var wst = $(window).scrollTop();
						var wsl = $(window).scrollLeft();
						var indent = 10;
                        targetEl.each(function(i){
                            var targetElItem = $(this);
                            var targetElWidth = Math.round(targetElItem.outerWidth());
                            var targetElHeight = Math.round(targetElItem.outerHeight());
                            var targetElTop = Math.round(targetElItem.offset().top);
                            var targetElLeft = Math.round(targetElItem.offset().left);

                            /**/
                            /*Specifies the data for the starting step*/
                            /**/
                            var targetOpt = $.iGuider.opt.steps[$.iGuider.v.startIndex];
                            var contentPos = $.trim(targetOpt.position).split('');
                            var top;
                            var left;
                            var blockTransLeft = '0';
                            var blockTransTop = '0';
                            var blockLeft;
                            var blockTop;

                            if($.iGuider.opt.steps){
                                if($.iGuider.opt.steps[$.iGuider.v.startIndex].disable){
                                    $('html').addClass('g-disable');
                                }else{
                                    $('html').removeClass('g-disable');
                                }
                                var setSpacing = $.iGuider.v.tCanvas.tMargin;     
								
								/*Set Width of Message Block*/
								var widthVal = '';
								var widthPar = $.iGuider.opt.steps[$.iGuider.v.startIndex].width || $.iGuider.opt.width;
								if(widthPar){
									widthVal = widthPar;
									widthVal = widthVal.toString();
									if(widthVal.search('%') != -1 || widthVal.search('vw') != -1){
										widthVal = widthVal.replace('%','vw');
									}else{
										widthVal = parseFloat(widthVal);
									}
								}
								$.iGuider.v.modalSize.css({minWidth:widthVal});
								
								/*Set Background of Message Block*/
								var bgColorPar = $.iGuider.opt.steps[$.iGuider.v.startIndex].bgColor || $.iGuider.opt.bgColor;
								if(bgColorPar){
									$.iGuider.v.modalTimerControll.css({background:bgColorPar});
									$.iGuider.v.modalSize.css({background:bgColorPar});
									$.iGuider.v.modalPos.css({color:bgColorPar});
									
								}else{
									$.iGuider.v.modalTimerControll.css({background:''});
									$.iGuider.v.modalSize.css({background:''});
									$.iGuider.v.modalPos.css({color:''});
								}
										
								/*Set Title Color of Message Block*/
								var titleColorPar = $.iGuider.opt.steps[$.iGuider.v.startIndex].titleColor || $.iGuider.opt.titleColor;
								if(titleColorPar){
									$.iGuider.v.modalHeader.css({color:titleColorPar});
								}else{
									$.iGuider.v.modalHeader.css({color:''});
								}
								
								
								/*Set Content Color of Message Block*/
								var modalContentColorPar = $.iGuider.opt.steps[$.iGuider.v.startIndex].modalContentColor || $.iGuider.opt.modalContentColor;
								if(modalContentColorPar){
									
									$.iGuider.v.modalBody.css({color:modalContentColorPar});
								}else{
									$.iGuider.v.modalBody.css({color:''});
								}
															
								/*Set Pagination Color of Message Block*/
								var paginationColorPar = $.iGuider.opt.steps[$.iGuider.v.startIndex].paginationColor || $.iGuider.opt.paginationColor;
								if(paginationColorPar){
									$('#paginationColorStyle').remove();
									$('<style id="paginationColorStyle">').html('.g-modal-pos .g-modal-step-value, .g-modal-pos .g-modal-step-total {color:'+paginationColorPar+'}').appendTo('html');
								}else{
									$('#paginationColorStyle').remove();
								}
								
								/*Set Timer of Message Block*/
								var timerColorPar = $.iGuider.opt.steps[$.iGuider.v.startIndex].timerColor || $.iGuider.opt.timerColor;
								
								if(timerColorPar){
									$('#timerColorStyle').remove();
									$('<style id="timerColorStyle">').html('.g-modal-timer-line .g-modal-timer { background: '+timerColorPar+'; } .g-progress__value { stroke: '+timerColorPar+'; }').appendTo('html');
								}else{
									$('#timerColorStyle').remove();
								}
								
								/*Set Buttons Color of Message Block*/
								var btnColorPar = $.iGuider.opt.steps[$.iGuider.v.startIndex].btnColor || $.iGuider.opt.btnColor;
								if(btnColorPar){
									$('#btnColorStyle').remove();
									$('<style id="btnColorStyle">').html('.g-modal-pos .gBtn {color:'+btnColorPar+'}').appendTo('html');
								}else{
									$('#btnColorStyle').remove();
								}
								
								/*Set Buttons Hover Color of Message Block*/
								var btnHoverColorPar = $.iGuider.opt.steps[$.iGuider.v.startIndex].btnHoverColor || $.iGuider.opt.btnHoverColor;
								if(btnHoverColorPar){
									$('#btnHoverColorStyle').remove();
									$('<style id="btnHoverColorStyle">').html('.g-modal-pos .gBtn:hover {color:'+btnHoverColorPar+'}').appendTo('html');
								}else{
									$('#btnHoverColorStyle').remove();
								}							
								
								
								/*Set Checklist Buttons Color*/
								var listBtnColorPar = $.iGuider.opt.tourMap.btnColor || $.iGuider.opt.btnColor;
								if(listBtnColorPar){
									$('#listBtnColorStyle').remove();
									$('<style id="listBtnColorStyle">').html('.g-map-pos .gBtn {color:'+listBtnColorPar+'}').appendTo('html');
								}else{
									$('#listBtnColorStyle').remove();
								}
								
								/*Set Checklist Buttons Hover Color*/
								var listBtnHoverColorPar = $.iGuider.opt.tourMap.btnHoverColor || $.iGuider.opt.btnHoverColor;
								if(listBtnHoverColorPar){
									$('#listBtnHoverColorStyle').remove();
									$('<style id="listBtnHoverColorStyle">').html('.g-map-pos .gBtn:hover {color:'+listBtnHoverColorPar+'}').appendTo('html');
								}else{
									$('#listBtnHoverColorStyle').remove();
								}
								
								
								/*Set Background of Checklist*/
								var listBgColorPar = $.iGuider.opt.tourMap.bgColor || $.iGuider.opt.bgColor;
								if(listBgColorPar){
									$.iGuider.v.gMapPos.css({background:listBgColorPar});
								}else{
									$.iGuider.v.gMapPos.css({background:''});
								}
										
								/*Set Title Color of Checklist*/
								var listTitleColorPar = $.iGuider.opt.tourMap.titleColor || $.iGuider.opt.titleColor;
								if(listTitleColorPar){
									$.iGuider.v.gMapHeader.css({color:listTitleColorPar});
								}else{
									$.iGuider.v.gMapHeader.css({color:''});
								}
								
								/*Set Step Item Number color of Checklist*/
								var itemNumColorPar = $.iGuider.opt.tourMap.itemNumColor;
								if(itemNumColorPar){
									$('#itemNumColorStyle').remove();
									$('<style id="itemNumColorStyle">').html('.g-step-item:before {color:'+itemNumColorPar+'}').appendTo('html');
								}else{
									$('#itemNumColorStyle').remove();
								}
								
								/*Set Step Item color of Checklist*/
								var itemColorPar = $.iGuider.opt.tourMap.itemColor;
								if(itemColorPar){
									$('#itemColorStyle').remove();
									$('<style id="itemColorStyle">').html('.g-step-item:not(.hCur):not(:hover) {color:'+itemColorPar+'}').appendTo('html');
								}else{
									$('#itemColorStyle').remove();
								}
								
								/*Set Step Item Hover color of Checklist*/
								var itemHoverColorPar = $.iGuider.opt.tourMap.itemHoverColor;
								if(itemHoverColorPar){
									$('#itemHoverColorStyle').remove();
									$('<style id="itemHoverColorStyle">').html('.g-step-item:not(.hCur):hover {color:'+itemHoverColorPar+'}').appendTo('html');
								}else{
									$('#itemHoverColorStyle').remove();
								}
								
								/*Set Step Item Active color of Checklist*/
								var itemActiveColorPar = $.iGuider.opt.tourMap.itemActiveColor;
								if(itemActiveColorPar){
									$('#itemActiveColorStyle').remove();
									$('<style id="itemActiveColorStyle">').html('.hCur .g-step-item-text {color:'+itemActiveColorPar+'}').appendTo('html');
								}else{
									$('#itemActiveColorStyle').remove();
								}
								
								/*Set Step Item Active BG color of Checklist*/
								var itemActiveBgPar = $.iGuider.opt.tourMap.itemActiveBg;
								if(itemActiveBgPar){
									$('#itemActiveBgStyle').remove();
									$('<style id="itemActiveBgStyle">').html('.g-step-item.hCur:before {background:'+itemActiveBgPar+'}').appendTo('html');
								}else{
									$('#itemActiveBgStyle').remove();
								}
								
								/*Set Check color of Checklist*/
								var checkColorPar = $.iGuider.opt.tourMap.checkColor;
								if(checkColorPar){
									$('#checkColorStyle').remove();
									$('<style id="checkColorStyle">').html('.g-step-item:after {border-color:'+checkColorPar+'}').appendTo('html');
								}else{
									$('#checkColorStyle').remove();
								}
								
								/*Set Check Ready color of Checklist*/
								var checkReadyColorPar = $.iGuider.opt.tourMap.checkReadyColor;
								if(checkReadyColorPar){
									$('#checkReadyColorStyle').remove();
									$('<style id="checkReadyColorStyle">').html('.g-step-item.g-step-success:after {border-color:'+checkReadyColorPar+'}').appendTo('html');
								}else{
									$('#checkReadyColorStyle').remove();
								}
								
								/*Set Pagination Color of Checklist Block*/
								var checkPaginationColorPar = $.iGuider.opt.tourMap.paginationColor || $.iGuider.opt.paginationColor;
								if(checkPaginationColorPar){
									$('#checkPaginationColorStyle').remove();
									$('<style id="checkPaginationColorStyle">').html('.g-map-pos .g-modal-step-value, .g-map-pos .g-modal-step-total {color:'+checkPaginationColorPar+'}').appendTo('html');
								}else{
									$('#checkPaginationColorStyle').remove();
								}

                                /**/
                                /*Positioning in center of the screen */
                                /**/
                                if($.iGuider.opt.steps[$.iGuider.v.startIndex].position == 'center' || !$.iGuider.opt.steps[$.iGuider.v.startIndex].target){
                                    contentPos = ['c','c','c'];
                                    left = '50%';
                                    top = '50%';
                                }else{

                                    /**/
                                    /*Automatic positioning of message */
                                    /**/
                                    if(contentPos.length != 3 || contentPos[0] != 't' && contentPos[0] != 'r' && contentPos[0] != 'b' && contentPos[0] != 'l'){
                                        $.iGuider.opt.steps[$.iGuider.v.startIndex].position = 'auto';
                                    }
                                    if($.iGuider.opt.steps[$.iGuider.v.startIndex].position == 'auto'){
										
										/*start auto positioning*/

										contentPos = [];
										$.iGuider.v.eTop = targetElTop - wst;
										$.iGuider.v.eLeft = targetElLeft - wsl;
										
										$.iGuider.v.mbw = $.iGuider.v.modalSize.outerWidth();
										$.iGuider.v.mbh = $.iGuider.v.modalSize.outerHeight();
										
										$.iGuider.v.sTop.h = $.iGuider.v.eTop - (indent + setSpacing);
										$.iGuider.v.sBot.h = vh - ($.iGuider.v.eTop + targetElHeight) - (indent + setSpacing);
										$.iGuider.v.sLeft.w = $.iGuider.v.eLeft - (indent + setSpacing);
										$.iGuider.v.sRight.w = vw - ($.iGuider.v.eLeft + targetElWidth) - (indent + setSpacing);
										
										
										
										$.iGuider.v.sMaxH = $.iGuider.v.sTop.h;
										$.iGuider.v.sMaxW = $.iGuider.v.sLeft.w;
										$.iGuider.v.sideTB = 't';
										$.iGuider.v.sideLR = 'l';
										
										
										
										if($.iGuider.v.sBot.h > $.iGuider.v.sTop.h){
											$.iGuider.v.sMaxH = $.iGuider.v.sBot.h
											$.iGuider.v.sideTB = 'b';
										}
										if($.iGuider.v.sRight.w > $.iGuider.v.sLeft.w){
											$.iGuider.v.sMaxW = $.iGuider.v.sRight.w
											$.iGuider.v.sideLR = 'r';
											
										}
										
										
										if($.iGuider.v.sMaxH > $.iGuider.v.mbh){
											// bottom, top
											contentPos[0] = $.iGuider.v.sideTB;
											contentPos[1] = $.iGuider.v.sideLR;
											contentPos[2] = $.iGuider.v.sideLR;
											
											if($.iGuider.v.sideTB == 't'){
												top = $.iGuider.v.eTop - (setSpacing + 15);
											}else{
												
												top = ($.iGuider.v.eTop + targetElHeight + setSpacing + 15);
											}
											
											if($.iGuider.v.sideLR == 'l'){
												left = $.iGuider.v.eLeft - (setSpacing);
											}else{
												left = ($.iGuider.v.eLeft + targetElWidth + setSpacing);
											}
											
										}else{
											if($.iGuider.v.sMaxW > $.iGuider.v.mbw){
												// right, left
												contentPos[0] = $.iGuider.v.sideLR;
												contentPos[1] = $.iGuider.v.sideTB;
												contentPos[2] = $.iGuider.v.sideTB;
												
												if($.iGuider.v.sideLR == 'l'){
													left = $.iGuider.v.eLeft - (setSpacing + 15);
												}else{
													left = ($.iGuider.v.eLeft + targetElWidth + setSpacing + 15);
												}
												
												if($.iGuider.v.sideTB == 't'){
													top = $.iGuider.v.eTop - (setSpacing);
												}else{
													top = ($.iGuider.v.eTop + targetElHeight + setSpacing);
												}
												
											}else{
												// bottom, top
												contentPos[0] = $.iGuider.v.sideTB;
												contentPos[1] = $.iGuider.v.sideLR;
												contentPos[2] = $.iGuider.v.sideLR;
												
												if($.iGuider.v.sideTB == 't'){
													top = $.iGuider.v.eTop - (setSpacing + 15);
												}else{
													
													top = ($.iGuider.v.eTop + targetElHeight + setSpacing + 15);
												}
												
												if($.iGuider.v.sideLR == 'l'){
													left = $.iGuider.v.eLeft - (setSpacing);
												}else{
													left = ($.iGuider.v.eLeft + targetElWidth + setSpacing);
												}
											}
										}
										/*end auto positioning*/
										
                                    }else{
        
                                        /**/
                                        /*Decoding of first symbol*/
                                        /**/
                                        if(contentPos[0] == 'r'){
                                            left = (targetElLeft + setSpacing + targetElWidth + 15) - $(window).scrollLeft();
                                            blockTransLeft = '0';
                                            blockLeft = '0';
                                        }
                                        if(contentPos[0] == 'l'){
                                            left = (targetElLeft - (setSpacing + 15)) - $(window).scrollLeft();
                                            blockTransLeft = '-100%';
                                            blockLeft = '0';
                                        }
                                        if(contentPos[0] == 'b'){
                                            top = ((targetElTop + setSpacing + targetElHeight) - $(window).scrollTop()) + 15;
                                            blockTransTop = '0';
                                            blockTop = '0';
                                        }
                                        if(contentPos[0] == 't'){
                                            top = ((targetElTop - (setSpacing + 15)) - $(window).scrollTop());
                                            blockTransTop = '-100%';
                                            blockTop = '0';
                                        }
        
                                        /**/
                                        /*Decoding of second symbol*/
                                        /**/
                                        if(contentPos[1] == 'c' && contentPos[0] == 'r' || contentPos[1] == 'c' && contentPos[0] == 'l'){
                                            top = (targetElTop + targetElHeight/2) - $(window).scrollTop();
                                        }
                                        if(contentPos[1] == 'b'){
                                            top = (targetElTop + targetElHeight + setSpacing) - $(window).scrollTop();
                                        }
                                        if(contentPos[1] == 't'){
                                            top = (targetElTop - setSpacing) - $(window).scrollTop();
                                        }
                                        if(contentPos[1] == 'c' && contentPos[0] == 'b' || contentPos[1] == 'c' && contentPos[0] == 't'){
                                            left = (targetElLeft + targetElWidth/2) - $(window).scrollLeft();
                                        }
                                        if(contentPos[1] == 'l'){
                                            left = (targetElLeft - setSpacing) - $(window).scrollLeft();
                                        }
                                        if(contentPos[1] == 'r'){
                                            left = (targetElLeft + targetElWidth + setSpacing) - $(window).scrollLeft();
                                        }
                                    }
                                
                                }

                                /**/
                                /*Set of the position code*/
                                /**/
                                if(i === 0){
									
                                    $.iGuider.v.modalPos.css({left:left,top:top}).attr({
                                        'data-pos':contentPos[0],
                                        'data-cone':contentPos[1],
                                        'data-cont':contentPos[2]
                                    });
									 $.iGuider.v.contentPos = contentPos;
                                }
                                
                                /*Show Message Window*/
                                $.iGuider.v.modalPosShow($.iGuider.v.tCanvas.tDuration);
								
								/**/
                                /*Position correction*/
                                /**/
                                $.iGuider.v.modalPos.stop(true).css({opacity:0}).show();
								$.iGuider.v.debug(new Error().lineNumber+ ' posCorrect func - 1');	

                                $.iGuider.v.posCorrect(contentPos[0],contentPos[1],contentPos[2]);
								
                                $.iGuider.v.modalData.push({
                                    left:left,
                                    top:top,
                                    'dataPos':contentPos[0],
                                    'dataCone':contentPos[1],
                                    'dataCont':contentPos[2]    
                                });
	
                            }else{
                                console.log('Parameter "steps" is undefined or empty');    
                            }    
                        });
                        $.iGuider.v.indexActive = 0;
                    }
                };

                $.iGuider.v.modalNextShow = function(){
					
                    $('html').addClass('g-modal-next-show');
                    $('html').removeClass('g-modal-next-hide');
                    $.iGuider.v.modalNext.html($.iGuider.opt.steps[$.iGuider.v.startIndex].nextText);
                };
                $.iGuider.v.modalNextHide = function(){
                    $('html').addClass('g-modal-next-hide');
                    $('html').removeClass('g-modal-next-show');
                };
                
                $.iGuider.v.modalPrevShow = function(){

                    $('html').addClass('g-modal-prev-show');
                    $('html').removeClass('g-modal-prev-hide');
                    $.iGuider.v.modalPrev.html($.iGuider.opt.steps[$.iGuider.v.startIndex].prevText);   

					
					
                };
                $.iGuider.v.modalPrevHide = function(){
                    $('html').addClass('g-modal-prev-hide');
                    $('html').removeClass('g-modal-prev-show');    
                };
				
				
				$.iGuider.v.modalStartShow = function(){
                    $('html').removeClass('g-modal-start-hide');
                };
                $.iGuider.v.modalStartHide = function(){
                    $('html').addClass('g-modal-start-hide');
 
                };
				
				$.iGuider.v.coverShow = function(){
                    $('html').addClass('g-modal-cover-show');
                    $('html').removeClass('g-modal-cover-hide');
                };
				$.iGuider.v.coverHide = function(){
                    $('html').addClass('g-modal-cover-hide');
                    $('html').removeClass('g-modal-cover-show');
                };
				
                
                $.iGuider.v.modalStepShow = function(){
                    $('html').addClass('g-modal-step-show');
                    $('html').removeClass('g-modal-step-hide');
                };
                $.iGuider.v.modalStepHide = function(){
                    $('html').removeClass('g-modal-step-show');
                    $('html').addClass('g-modal-step-hide');    
                };
				
				$.iGuider.v.modalContShow = function(){
                    $('html').addClass('g-modal-cont-show');
                    $('html').removeClass('g-modal-cont-hide');
                }; 
				$.iGuider.v.modalContHide = function(){
                    $('html').removeClass('g-modal-cont-show');
                    $('html').addClass('g-modal-cont-hide');
                }; 
				
				$.iGuider.v.modalTitleShow = function(){
                    $('html').addClass('g-modal-title-show');
                    $('html').removeClass('g-modal-title-hide');
                }; 
				$.iGuider.v.modalTitleHide = function(){
                    $('html').removeClass('g-modal-title-show');
                    $('html').addClass('g-modal-title-hide');
                }; 
                
                $.iGuider.v.modalIntroShow = function(){
                    $('html').addClass('g-modal-intro-show');
                    $('html').removeClass('g-modal-intro-hide');
                };
                $.iGuider.v.modalIntroHide = function(){
                    $('html').removeClass('g-modal-intro-show');
                    $('html').addClass('g-modal-intro-hide');    
                };
                
                $.iGuider.v.modalCloseHide = function(){
                    $('html').addClass('g-modal-close-hide');
                    $('html').removeClass('g-modal-close-show');    
                };
                $.iGuider.v.modalCloseShow = function(){
                    $('html').removeClass('g-modal-close-hide');
                    $('html').addClass('g-modal-close-show');    
                };
                
                $.iGuider.v.modalMapHide = function(){
                    $('html').addClass('g-modal-map-hide');
                    $('html').removeClass('g-modal-map-show');
                };
                $.iGuider.v.modalMapShow = function(){				
                    $('html').removeClass('g-modal-map-hide');
                    $('html').addClass('g-modal-map-show');    
                };
                
                $.iGuider.v.modalContinueShow = function(){
                    $('html').addClass('g-modal-continue-show');
                    $('html').removeClass('g-modal-continue-hide');
                };
                $.iGuider.v.modalContinueHide = function(){
                    $('html').removeClass('g-modal-continue-show');
                    $('html').addClass('g-modal-continue-hide');    
                };
                
                $.iGuider.v.timerShow = function(){
                    $('html').addClass('g-timer-show');
                    $('html').removeClass('g-timer-hide');
                };
                $.iGuider.v.timerHide = function(){
                    $('html').removeClass('g-timer-show');
                    $('html').addClass('g-timer-hide');    
                };
				


				$.iGuider.v.modalPosShowId = function(){};
				
                $.iGuider.v.modalPosShow = function(delay){
					$.iGuider.v.debug(new Error().lineNumber+ ' start modalPosShow func');
					clearTimeout($.iGuider.v.modalPosShowId);
                    $.iGuider.v.modalPos.stop(true).css({opacity:0}).show();
					$.iGuider.v.modalPosShowId = setTimeout(function(){
                        $.iGuider.v.modalPos.stop(true).animate({opacity:1},300,function(){
							if($.iGuider){
								$.iGuider.v.posCorrect();
							}
						});
                    },delay);    
                };
                
                $.iGuider.v.modalPosHide = function(duration){
					$.iGuider.v.debug(new Error().lineNumber+ ' start modalPosHide func');	
                    $.iGuider.v.modalPos.stop(true).animate({opacity:0},duration,function(){
                        $.iGuider.v.modalPos.hide();
                    });
                };

                /**/
                /*Creating message block*/
                /**/
                $.iGuider.v.modalPos = $('<div>').addClass('g-modal-pos').appendTo('body');
                $.iGuider.v.modalSize = $('<div>').addClass('g-modal-size').appendTo($.iGuider.v.modalPos);
				
				
                

				var modalTemplate = $.iGuider.opt.modalTemplate ? $($.iGuider.opt.modalTemplate) : $(modalTpl);
				modalTemplate.appendTo($.iGuider.v.modalSize);
				
                
                $.iGuider.v.modalStart = $(':contains([modal-start])',modalTemplate).last().empty()
                    .addClass('g-modal-start')
                    .html($.iGuider.opt.lang.introDialogBtnStart);
                    
                $.iGuider.v.modalCloseIntro = $(':contains([modal-cancel])',modalTemplate).last().empty()
                    .addClass('g-modal-close-intro g-modal-close')
                    .html($.iGuider.opt.lang.introDialogBtnCancel);
                
                $.iGuider.v.modalBeginFirst = $(':contains([modal-begin-first])',modalTemplate).last().empty()
                    .addClass('g-modal-begin-first')
                    .html($.iGuider.opt.lang.introDialogBtnStart);
                    
                $.iGuider.v.modalBeginContinue = $(':contains([modal-begin-continue])',modalTemplate).last().empty()
                    .addClass('g-modal-begin-continue')
                    .html($.iGuider.opt.lang.introDialogBtnCancel);
                
				
				if($.iGuider.opt.timerType == 'line'){
					$.iGuider.v.modalTimer = $('<div>').addClass('g-modal-timer')
						.appendTo($(':contains([modal-timer])',modalTemplate).last().empty());
					$('html').addClass('g-modal-timer-line');
				}
				if($.iGuider.opt.timerType == 'circle'){
					$.iGuider.v.modalTimer = $('<div>').addClass('g-modal-timer')
						.html('<svg class="g-progress" width="44" height="44" viewBox="0 0 44 44"><circle class="g-progress__meter" cx="22" cy="22" r="21" stroke-width="2" /><circle class="g-progress__value" cx="22" cy="22" r="21" stroke-width="2" /></svg>')
						.appendTo($(':contains([modal-timer])',modalTemplate).last().empty());
					$('html').addClass('g-modal-timer-circle');
					
					$.iGuider.v.progressValue = document.querySelector('.g-progress__value');
					$.iGuider.v.progressValue.style.strokeDasharray = CIRCUMFERENCE;
					$.iGuider.v.progressCircleTimer(0);
				}
				
				
				
				
				
				
				$.iGuider.v.modalTimerControll = $('<div>').addClass('g-timer-controll g-timer-pause gBtn').insertAfter($.iGuider.v.modalTimer);
				
                
                $.iGuider.v.modalImage = $('<div>').addClass('g-modal-cover').appendTo($(':contains([modal-cover])',modalTemplate).last().empty());

                $.iGuider.v.modalMap = $(':contains([modal-map])',modalTemplate).last().empty()
                    .addClass('g-modal-map')
                    .attr('title',$.iGuider.opt.lang.tourMapTitle)
                    .html($.iGuider.opt.lang.tourMapText);

                $.iGuider.v.tourMapDetect = function(){
                        if($.iGuider.opt.tourMap.enable === true || $.iGuider.opt.tourMap.enable === 'true'){
                            $.iGuider.v.modalMapShow();
                        }else{
                            $.iGuider.v.modalMapHide();
                        }
                };
                
                $.iGuider.v.tourMapDetect();
                
                $.iGuider.v.modalCloseTour = $(':contains([modal-close])',modalTemplate).last().empty()
                    .addClass('g-modal-close-tour g-modal-close')
                    .attr('title',$.iGuider.opt.lang.cancelTitle)
                    .html($.iGuider.opt.lang.cancelText);

				$.iGuider.v.modalType = $(':contains([modal-type])',modalTemplate).last().empty().addClass('g-modal-type');
                
                $.iGuider.v.modalCloseShow();

                $.iGuider.v.modalHeader = $('<div>').addClass('g-modal-header').appendTo($(':contains([modal-header])',modalTemplate).last().empty());
                $.iGuider.v.modalBody = $('<div>').addClass('g-modal-body').appendTo($(':contains([modal-body])',modalTemplate).last().empty());
                
                $.iGuider.v.modalPrev = $(':contains([modal-prev])',modalTemplate).last().empty()
                    .addClass('g-modal-prev')
                    .html($.iGuider.opt.lang.prevTextDefault);
                    
                $.iGuider.v.modalNext = $(':contains([modal-next])',modalTemplate).last().empty()
                    .addClass('g-modal-next')
                    .html($.iGuider.opt.lang.nextTextDefault);

				$.iGuider.v.modalStepValue = [];
				$.iGuider.v.modalStepTotal = [];
				var findByContentText = function(obj, parentEl, textVal){
					obj.push($(':contains("'+textVal+'")', parentEl).filter(function() {
						return $(this).text() == textVal;
					}).last().empty());
				};

				findByContentText($.iGuider.v.modalStepValue, modalTemplate, '[step-value]');
				findByContentText($.iGuider.v.modalStepValue, mapTemplate,'[step-value]');
				
				findByContentText($.iGuider.v.modalStepTotal, modalTemplate, '[step-total]');
				findByContentText($.iGuider.v.modalStepTotal, mapTemplate,'[step-total]');			
				
				

                if($.iGuider.opt.textDirection == "rtl"){
                    $.iGuider.v.modalSize.addClass('rtl');
					$.iGuider.v.gMapPos.addClass('rtl');
                }

                $($.iGuider.v.modalStepTotal).each(function(){
					$(this).addClass('g-modal-step-total').html($.iGuider.opt.steps.length);
				});
                
                /**/
                /*This function skip an absent element*/
                /**/
                var searchElement = function(mess){
                    if((parseFloat($.iGuider.v.startIndex) + 1) < $.iGuider.opt.steps.length){
                        if($.iGuider.opt.registerMissingElements){
                            $('[data-hindex="'+$.iGuider.v.startIndex+'"]').addClass('g-el-absent');
                        }
                        if($.iGuider.v.event === 'next'){
                            $.iGuider.v.startIndex++;
                        }else{
                            $.iGuider.v.startIndex--;    
                        }
                        if(!$.iGuider.v.event){
                            $.iGuider.v.event = 'next';
                        }
						$.iGuider.v.debug(new Error().lineNumber+ ' Run "hStep" func - 1');
                        hStep();    
                    }else{
                        console.log('Target is '+mess);
                        $.iGuider.v.debug(new Error().lineNumber+ ' Target is '+mess+' (HTML) and Destroy');
                        $.fn.iGuider('destroy');
                    }
                };

                /**/
                /*Creating the tour map buttons*/                    
                /**/
                $.iGuider.v.hClose = $(':contains([map-close])',mapTemplate).last().empty()
                    .addClass('g-map-close-tour g-modal-close')
                    .html($.iGuider.opt.lang.cancelTitle);
					
                $.iGuider.v.hHide = $(':contains([map-hide])',mapTemplate).last().empty()
                    .addClass('g-map-hide')
                    .html($.iGuider.opt.lang.hideText);
					
				$.iGuider.v.hToggle = $(':contains([map-toggle])',mapTemplate).last().empty()
                    .addClass('g-map-toggle');
                
                /**/
                /*Changing the content of message block*/
                /**/
                $.iGuider.opt.startStep = parseFloat($.iGuider.opt.startStep);
                if($.iGuider.opt.startStep < 1) {
                    $.iGuider.opt.startStep = 1;
                }
				$.iGuider.v.progressFunc = function(step){
					if ($.iGuider.opt.progress !== undefined) {
						try{
							var progress_Func = new Function('return ' + $.iGuider.opt.progress)();
							progress_Func({
								step: step,
								steps: $.iGuider.opt.steps.length
							});
						}catch(e) {
							$.iGuider.v.debug(new Error().lineNumber+ ' The callback function specified is not correct.');
						}
					}
					
				};
				$.iGuider.v.beforeFunc = function(){
					
					if ($.iGuider.opt.steps[$.iGuider.v.startIndex].before !== undefined) {
						try{
							var before_Func = new Function('return ' + $.iGuider.opt.steps[$.iGuider.v.startIndex].before)();
							before_Func($.iGuider.v.targetEl);
						}catch(e) {
							$.iGuider.v.debug(new Error().lineNumber+ ' The callback function specified is not correct.');
						}
					}
					
				};
				$.iGuider.v.after_beforeFunc = function(){
					$.iGuider.v.targetEl.addClass('iGuider-highlight');
					$.iGuider.v.progressFunc(iGuider('getStep'));
				};
				
				$.iGuider.v.duringFunc = function(){
					if ($.iGuider.opt.steps[$.iGuider.v.startIndex].during !== undefined) {
						try{
							var during_Func = new Function('return ' + $.iGuider.opt.steps[$.iGuider.v.startIndex].during)();
							during_Func($.iGuider.v.targetEl);
						}catch(e) {
							$.iGuider.v.debug(new Error().lineNumber+ ' The callback function specified is not correct.');
						}
					}
				};
				
                $.iGuider.v.afterFunc = function(){
                    if ($.iGuider.opt.steps[$.iGuider.v.startIndex].after !== undefined) {
						try{
							var after_Func = new Function('return ' + $.iGuider.opt.steps[$.iGuider.v.startIndex].after)();
							after_Func($.iGuider.v.targetEl);
						}catch(e) {
							$.iGuider.v.debug(new Error().lineNumber+ ' The callback function specified is not correct.');
						}
					}
                };
				$.iGuider.v.after_afterFunc = function(){
					$('.iGuider-highlight').removeClass('iGuider-highlight');
                };
				
				$.iGuider.v.messageErrorId = function(){};
				$.iGuider.v.messageEventId = function(){};
				$.iGuider.v.messHide = function(){
					var errorMessage = $('.gErrorMessage');
					errorMessage.stop(true).animate({opacity:0},function(){
						errorMessage.animate({height:0, padding:0},function(){
							errorMessage.remove();  
						});
					});
				};
				$.iGuider.v.messEvHide = function(){
					var eventMessage = $('.gEventMessage');
					eventMessage.stop(true).animate({opacity:0},function(){
						eventMessage.animate({height:0, padding:0},function(){
							eventMessage.remove();  
						});
					});
				};
				$.iGuider.v.messageErrorHide = function(){
					clearTimeout($.iGuider.v.messageErrorId);
					$.iGuider.v.messageErrorId = setTimeout(function(){
						$.iGuider.v.messHide();
					},3000);
				};
				$.iGuider.v.messageEventHide = function(){
					clearTimeout($.iGuider.v.messageEventId);
					$.iGuider.v.messageEventId = setTimeout(function(){
						$.iGuider.v.messEvHide();
					},3000);
				};
				
                var messageErrorNext = function(){
					clearTimeout($.iGuider.v.messageErrorId);
					
                    var mess = $.iGuider.opt.stepsDef[0].checkNext.messageError;
                    if($.iGuider.opt.steps[$.iGuider.v.startIndex].checkNext.messageError && $.trim($.iGuider.opt.steps[$.iGuider.v.startIndex].checkNext.messageError) !== ''){
                        mess = $.iGuider.opt.steps[$.iGuider.v.startIndex].checkNext.messageError;
                    }
                    var errorMessage = $('<div>').addClass('gErrorMessage').text(mess);
                    $('.gErrorMessage').remove();
                    $('.gFooter').after(errorMessage);
					
					$.iGuider.v.posCorrect();
					$.iGuider.v.messageErrorHide();
					
                };
				
				
				
                var messageErrorPrev = function(){
                    var mess = $.iGuider.opt.stepsDef[0].checkPrev.messageError;
                    if($.iGuider.opt.steps[$.iGuider.v.startIndex].checkPrev.messageError && $.trim($.iGuider.opt.steps[$.iGuider.v.startIndex].checkPrev.messageError) !== ''){
                        mess = $.iGuider.opt.steps[$.iGuider.v.startIndex].checkPrev.messageError;
                    }
                    var errorMessage = $('<div>').addClass('gErrorMessage').text(mess);
                    $('.gErrorMessage').remove();
                    $('.gFooter').after(errorMessage);
                    setTimeout(function(){
                        errorMessage.stop(true).animate({opacity:0},function(){
                            errorMessage.animate({height:0, padding:0},function(){
                                errorMessage.remove();  
                            });
                        });
                    },3000);
                };
                var checkNextFunc = function(targetElObj){
                    var result = true;
                    if($.iGuider.opt.steps[$.iGuider.v.startIndex].checkNext){
                        if ($.iGuider.opt.steps[$.iGuider.v.startIndex].checkNext.func !== undefined){
							try{
								var next_Func = new Function('return ' + $.iGuider.opt.steps[$.iGuider.v.startIndex].checkNext.func)();
								result = next_Func(targetElObj);
							}catch(e) {
								$.iGuider.v.debug(new Error().lineNumber+ ' The callback function specified is not correct.');
							}
                        }
                    }
                    return result;
                };
                var checkPrevFunc = function(targetElObj){
                    var result = true;
                    if($.iGuider.opt.steps[$.iGuider.v.startIndex].checkPrev){
                        if ($.iGuider.opt.steps[$.iGuider.v.startIndex].checkPrev.func !== undefined){
							try{
								var prev_Func = new Function('return ' + $.iGuider.opt.steps[$.iGuider.v.startIndex].checkPrev.func)();
								result = prev_Func(targetElObj);
							}catch(e) {
								$.iGuider.v.debug(new Error().lineNumber+ ' The callback function specified is not correct.');
							}
                        }
                    }
                    return result;
                };
				$.iGuider.v.stopTimer = function(){
					clearTimeout($.iGuider.v.stepTimerId);
					if($.iGuider.opt.timerType == 'line'){
						$.iGuider.v.modalTimer.stop(true).animate({width:0},300);
					}
					if($.iGuider.opt.timerType == 'circle'){
						$.iGuider.v.modalTimer.stop(true).animate({bottom:'0%'}, {
							duration:300,
							step: function(now,fx) {
								$.iGuider.v.progressCircleTimer(now);									
							}
						});
					}
					
				};
                $.iGuider.v.startTimer = function(time){
					clearTimeout($.iGuider.v.stepTimerId);
					if(time > 0){
						$.iGuider.v.timeSave = time;
						$.iGuider.v.timerShow();
						if($.iGuider.v.timerState == 'play'){
							$.iGuider.v.stepTimerId = setTimeout(function(){
								$.fn.iGuider('next',true);
							},time); 
							if($.iGuider.opt.timerType == 'line'){
								$.iGuider.v.modalTimer.stop(true).css({width:0}).show().animate({width:'100%'},time);
							}
							if($.iGuider.opt.timerType == 'circle'){
								$.iGuider.v.progressCircleTimer(0);
								$.iGuider.v.modalTimer.stop(true).css({bottom:'0%'}).show().animate({bottom:'100%'}, {
									duration:time,
									step: function(now,fx) {
										$.iGuider.v.progressCircleTimer(now);									
									}
								});
							}
						}
					}else{
						$.iGuider.v.timeSave = false;
						$.iGuider.v.timerHide();
					}    
                };
                $(document).on('mouseenter.iGuider mousemove.iGuider','.gWidget, .g-shape, .iGuider-highlight',function(){
					$('html').removeClass('g-timer-progress-show').addClass('g-timer-progress-hide');
                });
                $(document).on('mouseleave.iGuider','.gWidget, .g-shape, .iGuider-highlight',function(){
					$('html').removeClass('g-timer-progress-hide').addClass('g-timer-progress-show');
                });
				
				$.iGuider.v.changeDelayId = function(){};
                var hStep = function(){
					
					$.iGuider.v.tourMapDetect();
                    $.iGuider.v.modalIntroHide();
                    $.iGuider.v.modalContinueHide();
					
                    clearTimeout($.iGuider.v.stepTimerId);
					clearTimeout($.iGuider.v.changeDelayId);

                    var changeDelay = $.iGuider.v.tCanvas.tDuration;
                    if($.iGuider.goFlag){
                        changeDelay = 1;    
                        localStorage.removeItem('iGuider_go');
                        $.iGuider.goFlag = false;
                    }
					
					

                    /**/
                    /*Cleaning the content of message block*/
                    /**/
                    $.iGuider.v.modalPosHide(0);
                    $.iGuider.v.modalHeader.empty();
                    $.iGuider.v.modalBody.empty();

                    /**/
                    /*If listed steps in parameters*/
                    /**/
                    if($.iGuider.opt.steps){
						
						if(localStorage.getItem('iGuider_event') != 'start'){
							$.iGuider.v.start();
						}
						localStorage.setItem('iGuider_step',parseFloat($.iGuider.v.startIndex)+1);
						var targetOpt = $.iGuider.opt.steps[$.iGuider.v.startIndex];
                        targetOpt = $.iGuider.v.fixStepNumVal(targetOpt);

                        if(targetOpt){
							
							var targetElSelector;
							$.iGuider.v.debug(new Error().lineNumber+ ' targetOpt.target: '+targetOpt.target);    
							if(targetOpt.target){
								if (targetOpt.target.search(/<([^>]*)>/g) != -1){
									$.iGuider.v.debug(new Error().lineNumber+ ' The target is HTML code');    
									/*This is Full Tag*/	
									var newEl = $(targetOpt.target);
									var tagName = newEl[0].tagName;
									var attrMass = newEl.attr();
									var selectorMass = [];
									for (var key in attrMass) {
										if(attrMass[key].search('function') == -1){
											selectorMass.push('['+key+'*="'+attrMass[key]+'"]');
										}
									}
									targetElSelector = tagName+selectorMass.join('');								
								}else{	
									if($(targetOpt.target).length || targetOpt.target.search('\\.') != -1 || targetOpt.target.search('#') != -1 || targetOpt.target.search('\\[') != -1){
										targetElSelector = targetOpt.target;      
									    $.iGuider.v.debug(new Error().lineNumber+ ' The target is jQuery object');    
									}else{
									   $.iGuider.v.debug(new Error().lineNumber+ ' The selector is data-target attribute');    
										targetElSelector = '[data-target="'+targetOpt.target+'"]'; 
									}
								}
							}
							
							/**/
							/*If the specified element (purpose) for this step*/
							/**/
							if(targetOpt.position == 'center' || !targetOpt.target){
								targetElSelector = 'body';
							}
							$.iGuider.v.debug(new Error().lineNumber+ ' targetElSelector: '+targetElSelector);    
							targetOpt.waitElementTime = targetOpt.waitElementTime || 0;
							
							$.iGuider.v.targetElSave = $.iGuider.v.targetEl;
							
							$.iGuider.v.targetEl = $(targetElSelector);

							$.iGuider.v.beforeFunc();
                            

                            /**/
                            /*The delay before the element search*/
                            /**/
                            targetOpt.delayBefore = targetOpt.delayBefore || 0;
                            
							clearTimeout($.iGuider.v.delayBeforeId);
							$.iGuider.v.delayBeforeId = setTimeout(function(){   

								
                                var stepFunc = function(){
									$.iGuider.v.after_beforeFunc();
									var durationTime = $.iGuider.v.duration;
									$.iGuider.v.changeDelayId = setTimeout(function(){
										$.iGuider.v.selectCallback();
									},durationTime);

									if($.iGuider.v.targetEl.length){
										if($.iGuider.v.targetEl.is(':visible')){
											
											/**/
											/*Show the tour map block by default, if there is a flag*/
											/**/
											if($.iGuider.opt.tourMap.open === true  || $.iGuider.opt.tourMap.open === "true"){
												$('html').addClass('g-map-open');
											}
											
											var myFunc = function(){
												$('[data-hindex="'+$.iGuider.v.startIndex+'"]').removeClass('g-el-absent');
												$('[data-hindex="'+$.iGuider.v.startIndex+'"]').removeClass('hElHidden');
												
												/**/
												/*Transmits the step data to the overlay function*/
												/**/
												$('html').removeAttr('data-g-stepid');
												$('html').removeAttr('data-g-step');
												var stepNum = (parseFloat($.iGuider.v.startIndex) + 1);
												var stepID = 'step-'+stepNum;
												if(targetOpt.stepID){
													stepID = targetOpt.stepID;
												}
												$('html').attr('data-g-stepid',stepID);
												$('html').attr('data-g-step',stepNum);
												
												if(targetOpt.shape >= 0){
													$.iGuider.v.tCanvas.shape = targetOpt.shape;
												}else{
													$.iGuider.v.tCanvas.shape = $.iGuider.v.tCanvas.def.shape;
												}
												if($.iGuider.v.tCanvas.shape == 2){
													if(targetOpt.shapeBorderRadius >= 0){
														$.iGuider.v.tCanvas.shapeBorderRadius = targetOpt.shapeBorderRadius;
													}else{
														$.iGuider.v.tCanvas.shapeBorderRadius = $.iGuider.v.tCanvas.def.shapeBorderRadius;
													}
												}
												if(targetOpt.overlayColor){
													$.iGuider.v.tCanvas.tColor = $.iGuider.v.correctColor(targetOpt.overlayColor);
												}else{
													$.iGuider.v.tCanvas.tColor = $.iGuider.v.correctColor($.iGuider.v.tCanvas.def.tColor);
												}
												if(parseFloat(targetOpt.overlayOpacity) >= 0){
													$.iGuider.v.tCanvas.tOpacity = parseFloat(targetOpt.overlayOpacity);
												}else{
													$.iGuider.v.tCanvas.tOpacity = $.iGuider.v.tCanvas.def.tOpacity;
												}
												if(parseFloat(targetOpt.spacing) >= 0){
													$.iGuider.v.tCanvas.tMargin = parseFloat(targetOpt.spacing);
												}else{
													$.iGuider.v.tCanvas.tMargin = $.iGuider.v.tCanvas.def.tMargin;
												}
												
												
												$.iGuider.v.tCanvas.tDuration = $.iGuider.v.duration;
												
												$.iGuider.v.searchEl($.iGuider.v.targetEl);
	
												
												var targetOptTitle = targetOpt.title ? targetOpt.title : '№'+(parseFloat($.iGuider.v.startIndex)+1);
	
												/**/
												/*Insert new content*/
												/**/
												$.iGuider.v.modalImage.empty();
												if(targetOpt.cover && $.trim(targetOpt.cover) !== ''){
													var coverEl = $('<img>').hide()
													.attr('src',targetOpt.cover)
													.on('load',function(){
														coverEl.show();
													});
													coverEl.appendTo($.iGuider.v.modalImage);
													$.iGuider.v.coverShow();
												}else{
													$.iGuider.v.modalImage.empty(); 
													$.iGuider.v.coverHide();													
												}
												if(targetOpt.title){
													$.iGuider.v.modalTitleShow();
													$.iGuider.v.modalHeader.html(targetOptTitle);    
												}else{
													$.iGuider.v.modalHeader.html('');  
													$.iGuider.v.modalTitleHide();													
												}
												if($.trim(targetOpt.content) != ''){
													$.iGuider.v.modalContShow();
													$.iGuider.v.modalBody.html(targetOpt.content);
												}else{
													$.iGuider.v.modalContHide();
												}
												
												$.iGuider.v.overlayPos($.iGuider.v.targetEl);
												
												/**/
												/*Sets the text to the default buttons*/
												/**/
												if(!$.iGuider.opt.steps[$.iGuider.v.startIndex].prevText) {$.iGuider.opt.steps[$.iGuider.v.startIndex].prevText = $.iGuider.opt.lang.prevTextDefault;}
												if(!$.iGuider.opt.steps[$.iGuider.v.startIndex].nextText) {$.iGuider.opt.steps[$.iGuider.v.startIndex].nextText = (parseFloat($.iGuider.v.startIndex)+1) == $.iGuider.opt.steps.length ? $.iGuider.opt.lang.endText : $.iGuider.opt.lang.nextTextDefault;}
												
												/**/
												/*Insert step numbers*/
												/**/
												var stepValue = parseFloat($.iGuider.v.startIndex)+1;
												
												$($.iGuider.v.modalStepValue).each(function(){
													$(this).addClass('g-modal-step-value').html(stepValue);
												});
												
												if($.iGuider.opt.pagination){
													$.iGuider.v.modalStepShow();
													$.iGuider.v.modalIntroHide();
													$('.g-modal-type').hide().empty();
												}else{
													$.iGuider.v.modalStepHide();
												}
												
												/**/
												/*Save step numbers in localStorage*/
												/**/
												
												$.iGuider.v.iGuider_data = {};
												if(stepValue > 1){
													$.iGuider.v.iGuider_data = {
														tourId:$.iGuider.v.tourid,
														stepValue:stepValue,
														page:location.href
													};
												}else{
													$.iGuider.v.iGuider_data = {
														tourId:false,
														stepValue:stepValue,
														page:location.href
													};    
												}
												localStorage.setItem('iGuider_data-'+$.iGuider.opt.tourID,JSON.stringify($.iGuider.v.iGuider_data));
												localStorage.setItem('iGuider_step',stepValue);
												
												
												/**/
												/*Insert buttons*/
												/**/
												var prevIndex = parseFloat($.iGuider.v.startIndex)-1;
											
												if($.iGuider.opt.steps[prevIndex]){
													$.iGuider.v.modalPrevShow();
												}else{
													$.iGuider.v.modalPrevHide();
												}
												
												if($.iGuider.opt.steps[$.iGuider.v.startIndex]){
													if($.iGuider.opt.steps[$.iGuider.v.startIndex].ready){
														$.iGuider.v.modalNextShow();
													}
												}else{
													$.iGuider.v.modalNextHide();
												}
												
												if(!$.iGuider.opt.steps[$.iGuider.v.startIndex].event){
													$.iGuider.opt.steps[$.iGuider.v.startIndex].event = 'next';
												}
												
												$.iGuider.v.customEvent = false;
												$.iGuider.v.customTarget = false;
												
												if($.iGuider.opt.steps[$.iGuider.v.startIndex].event == 'next'){
													$.iGuider.v.modalNextShow();
												}else{
													$.iGuider.v.modalNextHide();

													if(typeof $.iGuider.opt.steps[$.iGuider.v.startIndex].event == 'object'){
														$.iGuider.v.customEvent = $.iGuider.opt.steps[$.iGuider.v.startIndex].event[0];
														$.iGuider.v.customTarget = $($.iGuider.opt.steps[$.iGuider.v.startIndex].event[1]);
													}
	
													if(typeof $.iGuider.opt.steps[$.iGuider.v.startIndex].event == 'string'){
														$.iGuider.v.customEvent = $.iGuider.opt.steps[$.iGuider.v.startIndex].event;
														$.iGuider.v.customTarget = $.iGuider.v.targetEl;
													}
													
													if($.iGuider.v.customEvent){
														if($.iGuider.v.customTarget){
															$.iGuider.v.customTarget.attr('data-uid','h-'+uid++);
															$.iGuider.v.customTargetSelector = '[data-uid="'+$.iGuider.v.customTarget.attr('data-uid')+'"]';
															if($.iGuider.v.customTargetSelector){
																
																if($.iGuider.opt.steps[$.iGuider.v.startIndex].checkNext){
																	if(checkNextFunc($($.iGuider.v.customTargetSelector)) === true){
																		$.iGuider.v.modalNextShow();
																		addSuccess($('[data-hindex="'+$.iGuider.v.startIndex+'"]')); 
																		targetOpt.ready = true;
    																	$.iGuider.opt.steps[$.iGuider.v.startIndex].ready = true;
																	}
																}
																$.iGuider.v.eventFlag = true;
																$(document).on($.iGuider.v.customEvent+'.iGuider',$.iGuider.v.customTargetSelector,function(e){

                                                                    if(checkNextFunc($($.iGuider.v.customTargetSelector)) === true){
																		
																		if($.iGuider.v.eventFlag == true){
																			$.iGuider.v.eventFlag = false;
																			$('.gErrorMessage').remove();

																			$(this).off(e);
																			targetOpt.ready = true;
																			$.iGuider.opt.steps[$.iGuider.v.startIndex].ready = true;
																			
																			/**/
																			/*Step is marked as completed (painted over)*/
																			/**/
																			addSuccess($('[data-hindex="'+$.iGuider.v.startIndex+'"]')); 
													
																			$.iGuider.v.afterFunc();
			
																			targetOpt.delayAfter = targetOpt.delayAfter || 0;
																			
																			
																			/*NEW*/
																			$.iGuider.v.nowLoc = location.href;
																			var targetLoc = $.iGuider.v.nowLoc;
																			$.iGuider.v.nextIndex = (parseFloat($.iGuider.v.startIndex) + 1);

																			/**/
																			/*Check presence of next step */
																			/**/
																			if($.iGuider.v.nextIndex < $.iGuider.opt.steps.length){
																				targetLoc = $.iGuider.opt.steps[$.iGuider.v.nextIndex].loc;
																			}
																			
																			
																			
																			var iGuider_opt = {
																				opt:$.iGuider.v.toStringObj($.iGuider.opt)
																			};									
																			localStorage.setItem('iGuider_opt',JSON.stringify(iGuider_opt));
																			localStorage.setItem('iGuider_step',parseFloat($.iGuider.v.startIndex)+2);																		
																			    
																			 

																			clearTimeout($.iGuider.v.delayAfterId);
																			$.iGuider.v.delayAfterId = setTimeout(function(){
																				
																				$.iGuider.v.after_afterFunc();
																				$.iGuider.v.eventFlag = true;
			
																				/*START PAST 2*/
																				$.iGuider.v.compareLoc2 = function(nowLoc){
																					if(nowLoc !== targetLoc){
																						/**/
																						/*Redirect 2*/
																						/**/
																						$.iGuider.v.debug(new Error().lineNumber+ ' Redirect 4');
																						if(!$.iGuider.opt.baseurl){
																							location.href = targetLoc;
																						}else{
																							location.href = $.iGuider.opt.baseurl + targetLoc;
																						}
																						
																					}else{                                
																						$.iGuider.v.startIndex++;
																						$.iGuider.v.debug(new Error().lineNumber+ ' Run "hStep" func - 2');    
																						hStep(); 
																					}	
																				};
																				
																				if(!$.iGuider.opt.baseurl){
																					/*only for absolute path URL*/
																					$.iGuider.v.compareLoc2($.iGuider.v.nowLoc);
																				}else{
																					/*only for relative path URL*/
																					var relativeNowLoc = $.iGuider.v.nowLoc.split($.iGuider.opt.baseurl)[1].split('#')[0];
																					$.iGuider.v.compareLoc2(relativeNowLoc);
																				}
																				/*END PAST*/

																			},targetOpt.delayAfter);
																		}
    																	return true; 
                                                                    }else{
                                                                        messageErrorNext();
                                                                        return false;
                                                                    }
																});    
															}else{
																console.log('Custom target don\'t have class and id attributes');
															}
														}else{
															console.log('Custom target is absent');
														}
													}else{
														console.log('Custom event is absent');
													}
												}
	
												/**/
												/*Highlighting the active step*/
												/**/
												var stepItemLink = $('[data-hindex]').removeClass('hCur').filter('[data-hindex="'+$.iGuider.v.startIndex+'"]').addClass('hCur');
												
												var mapContHeight = parseFloat($('.gMapContent').height());
												var stepLinkH = parseFloat(stepItemLink.outerHeight());
												var flat = Math.floor(mapContHeight/stepLinkH/2);
												$('.gMapContent').stop(true).animate({scrollTop:(stepItemLink.position().top + $('.gMapContent').scrollTop()) - stepLinkH*flat});
												
												if($.iGuider.opt.steps[$.iGuider.v.startIndex].trigger && $.iGuider.opt.steps[$.iGuider.v.startIndex].trigger !== false && $.iGuider.opt.steps[$.iGuider.v.startIndex].trigger != 'false'){
													$.iGuider.v.targetEl.trigger($.iGuider.opt.steps[$.iGuider.v.startIndex].trigger);
												}
												
												/**/
												/*During callback function*/
												/**/
												$.iGuider.v.duringFunc();
												$.iGuider.v.startTimer(parseFloat(targetOpt.timer));
												var iGuider_opt = {
													opt:$.iGuider.v.toStringObj($.iGuider.opt)
												};																	
												localStorage.setItem('iGuider_opt',JSON.stringify(iGuider_opt));
											};
											
											/**/
											/*Animation scroll to selected item*/
											/**/
											if(targetOpt.position == 'center' || !targetOpt.target){
												myFunc();
											}else{
												if($.iGuider.v.targetEl.offset().top < $(window).scrollTop()){
													$.iGuider.v.scrolling = true;
													
													$.iGuider.v.scrollDoc.animate({scrollTop:($.iGuider.v.targetEl.offset().top - $(window).height()/2)},changeDelay).promise().then(function(){
														$.iGuider.v.scrolling = false;
														myFunc();
													});
												}else{
													if(($.iGuider.v.targetEl.offset().top + $.iGuider.v.targetEl.outerHeight()) > ($(window).scrollTop() + $(window).height())){
														$.iGuider.v.scrolling = true;
														
														$.iGuider.v.scrollDoc.animate({scrollTop:($.iGuider.v.targetEl.offset().top - $(window).height()/2)},changeDelay).promise().then(function(){
															$.iGuider.v.scrolling = false;
															myFunc();
														});
													}else{
														myFunc();        
													}    
												}
											}
										}else{
											$.iGuider.v.debug(new Error().lineNumber+ ' Run "searchElement" func - 1');    
											searchElement('hidden');
										}
									}else{
										$.iGuider.v.debug(new Error().lineNumber+ ' Run "searchElement" func - 2');    
										searchElement('absent');
									}
								};
								
								/**/
								/*This function implements the check for the presence of the element and its waiting.*/
								/**/
								var waitTimeId = function(){};
								var waitIntervalId = function(){};
								var elementPresentCheck = function(){
									if($(targetElSelector).length){
                                        $.iGuider.v.debug(new Error().lineNumber+ ' $(\''+targetElSelector+'\') ' + 'is found!');
										var elVisible = 0;
										$(targetElSelector).each(function(){
											if($(this).is(':visible')){
												elVisible++;
											}
										})
										if(elVisible == $(targetElSelector).length){
											$.iGuider.v.debug(new Error().lineNumber+ ' $(\''+targetElSelector+'\') ' + 'is visible!');
											clearInterval(waitIntervalId);  
											clearTimeout(waitTimeId);
											hidePreloader();
											$.iGuider.v.debug(new Error().lineNumber+ ' Run "stepFunc" func - 1');    
											$.iGuider.v.targetEl = $(targetElSelector);
											stepFunc();
										}else{
											$.iGuider.v.debug(new Error().lineNumber+ ' $(\''+targetElSelector+'\') ' + 'is hidden');
										} 
									}else{
                                        $.iGuider.v.debug(new Error().lineNumber+ ' $(\''+targetElSelector+'\') ' + 'is absent on the page');
                                    }
								};

								if(targetOpt.waitElementTime > 0){

                                    $.iGuider.v.debug(new Error().lineNumber+ ' Waiting for item max: '+targetOpt.waitElementTime+'ms');
									showPreloader();
                                    $.iGuider.v.debug(new Error().lineNumber+ ' Start the timer');
									waitTimeId = setTimeout(function(){
										clearInterval(waitIntervalId);	
										clearTimeout(waitTimeId);
										hidePreloader();
                                        $.iGuider.v.debug(new Error().lineNumber+ ' Time is up');
										$.iGuider.v.debug(new Error().lineNumber+ ' Run "stepFunc" func - 2');    
										stepFunc();
									},targetOpt.waitElementTime);
									waitIntervalId = setInterval(function(){
										elementPresentCheck();
									},waitInterval);
									elementPresentCheck();	
								}else{
									$.iGuider.v.debug(new Error().lineNumber+ ' Run "stepFunc" func - 3');    
									stepFunc();
								}

                            },targetOpt.delayBefore);
                        }else{
                            $.iGuider.v.startIndex--;
							/**/
							/*Triggered when sequence is over*/
							/**/
							$.iGuider.v.debug(new Error().lineNumber+ ' Empty object of parameters for current step and Destroy');    
							$.iGuider.v.end();    
							$.iGuider.v.finish();
							$.fn.iGuider('destroy');
                        }
                    }else{
                        console.log('step data is missing');    
                    }
                };
				
                var startStep = function(){
					
                    
					
                    var delayTimeout = 0;
                    setTimeout(function(){

                        
                        
                        /**/
                        /*Correcting start index*/
                        /**/						
                        $.iGuider.v.startIndex = (parseFloat($.iGuider.opt.startStep) - 1) || 0 ;

						/**/
                        /*Start step function*/
                        /**/
                        $.iGuider.v.debug(new Error().lineNumber+ ' Run "hStep" func - 3');    
                        hStep();
                    },delayTimeout);
                };				
                
				/**/
				/*This function display continue modal window*/
				/**/
				$.iGuider.v.windowContinue = function(){
					clearTimeout($.iGuider.v.storageDetectId);
					$.iGuider.v.modalImage.empty();
					if($.trim($.iGuider.opt.continue.cover)){

						var coverEl = $('<img>').hide()
						.attr('src',$.iGuider.opt.continue.cover)
						.addClass('hTourCover')
						.on('load',function(){
							coverEl.show();
						});
						coverEl.appendTo($.iGuider.v.modalImage);
						$.iGuider.v.coverShow();
					}else{
						$.iGuider.v.modalImage.empty();	
						$.iGuider.v.coverHide();
					}
					
					if($.iGuider.opt.continue.title && $.iGuider.opt.continue.title != ''){
						$.iGuider.v.modalHeader.html($.iGuider.opt.continue.title);
						$.iGuider.v.modalTitleShow();
					}else{
						$.iGuider.v.modalTitleHide();
					}
					
					
					if($.iGuider.opt.continue.content && $.iGuider.opt.continue.content != ''){
						$.iGuider.v.modalBody.html($.iGuider.opt.continue.content);
						$.iGuider.v.modalContShow();
					}else{
						$.iGuider.v.modalContHide();
					}
					
					
					$.iGuider.v.modalBeginFirst.html($.iGuider.opt.lang.contDialogBtnBegin);
					$.iGuider.v.modalBeginContinue.html($.iGuider.opt.lang.contDialogBtnContinue);
					$.iGuider.v.modalPos.css({left:'50%',top:'50%'}).attr({
						'data-pos':'c',
						'data-cone':'c',
						'data-cont':'c'
					});
					
					
					/*Set Width of Message Block*/
					var widthVal = '';
					var widthPar = $.iGuider.opt.continue.width || $.iGuider.opt.width;
					if(widthPar){
						widthVal = widthPar;
						widthVal = widthVal.toString();
						if(widthVal.search('%') != -1 || widthVal.search('vw') != -1){
							widthVal = widthVal.replace('%','vw');
						}else{
							widthVal = parseFloat(widthVal);
						}
					}
					$.iGuider.v.modalSize.css({minWidth:widthVal});
					
					/*Set Background of Message Block*/
					var bgColorPar = $.iGuider.opt.continue.bgColor || $.iGuider.opt.bgColor;
					if(bgColorPar){
						
						$.iGuider.v.modalSize.css({background:bgColorPar});
					}else{
						$.iGuider.v.modalSize.css({background:''});
					}
					
					/*Set Title Color of Message Block*/
					var titleColorPar = $.iGuider.opt.continue.titleColor || $.iGuider.opt.titleColor;
					if(titleColorPar){
						
						$.iGuider.v.modalHeader.css({color:titleColorPar});
					}else{
						$.iGuider.v.modalHeader.css({color:''});
					}
					
					/*Set Content Color of Message Block*/
					var modalContentColorPar = $.iGuider.opt.continue.modalContentColor || $.iGuider.opt.modalContentColor;
					if(modalContentColorPar){
						
						$.iGuider.v.modalBody.css({color:modalContentColorPar});
					}else{
						$.iGuider.v.modalBody.css({color:''});
					}
					
					/*Set Modal Type Color of Message Block*/
					var modalTypeColorPar = $.iGuider.opt.continue.modalTypeColor || $.iGuider.opt.modalTypeColor;
					if(modalTypeColorPar){
						$.iGuider.v.modalType.css({color:modalTypeColorPar});
					}else{
						$.iGuider.v.modalType.css({color:''});
					}
					
					/*Set Buttons Color of Message Block*/
					var btnColorPar = $.iGuider.opt.continue.btnColor || $.iGuider.opt.btnColor;
					if(btnColorPar){
						$('#btnColorStyle').remove();
						$('<style id="btnColorStyle">').html('.g-modal-pos .gBtn {color:'+btnColorPar+'}').appendTo('html');
					}else{
						$('#btnColorStyle').remove();
					}
					
					/*Set Buttons Hover Color of Message Block*/
					var btnHoverColorPar = $.iGuider.opt.continue.btnHoverColor || $.iGuider.opt.btnHoverColor;
					if(btnHoverColorPar){
						$('#btnHoverColorStyle').remove();
						$('<style id="btnHoverColorStyle">').html('.g-modal-pos .gBtn:hover {color:'+btnHoverColorPar+'}').appendTo('html');
					}else{
						$('#btnHoverColorStyle').remove();
					}
					
					/**/
					/*Position correction*/
					/**/
					
					$.iGuider.v.debug(new Error().lineNumber+ ' posCorrect func - 2');							

					$.iGuider.v.posCorrect('c','c','c');
					$.iGuider.v.tCanvas.tColor = $.iGuider.v.correctColor($.iGuider.opt.continue.overlayColor);
					$.iGuider.v.tCanvas.tOpacity = $.iGuider.opt.continue.overlayOpacity;
					$.iGuider.v.tCanvas.saveColor = $.iGuider.v.tCanvas.tColor;
					$.iGuider.v.tCanvas.saveOpacity = $.iGuider.v.tCanvas.tOpacity;
					
					$.iGuider.v.createOverlayLayer();
					$.iGuider.v.modalPrevHide();
					$.iGuider.v.modalNextHide();
					
					
					$.iGuider.v.modalStepHide();
					$.iGuider.v.modalMapHide();
					$.iGuider.v.modalPosShow(0);
					$.iGuider.v.modalIntroHide();
					$.iGuider.v.modalContinueShow();
					$.iGuider.v.timerHide();
					
					$('.g-modal-type').html($.iGuider.opt.lang.modalContinueType).show();
					
					if($.iGuider.v.iGuider_data){
						$.iGuider.v.stepValue = $.iGuider.v.iGuider_data.stepValue;

						var pageLoc = $.iGuider.v.iGuider_data.page;
						if($.iGuider.v.nowLoc.search(escapeRe(pageLoc)) === -1 && pageLoc.search(escapeRe($.iGuider.v.nowLoc)) === -1 && $.iGuider.v.nowLoc !== pageLoc){
							$.iGuider.v.otherPage = $.iGuider.v.iGuider_data.page; 
						}else{
							$.iGuider.v.otherPage = false;     
						}
					}
				};
				
				
                /**/
                /*Detect unfinished tour*/
                /**/
				$.iGuider.v.storageDetectId = function(){};
                var storageDetect = function(){
					
                    var delayTimeout = 0;
                    if($.iGuider.v.modalPos.is(':visible')){
                        $.iGuider.v.modalPosHide(300);
                        delayTimeout = 300;    
                    }
                    if($.iGuider.goFlag){
                        delayTimeout = 1;    
                    }
                    $.iGuider.v.storageDetectId = setTimeout(function(){
                        
						$.iGuider.v.nowLoc = location.href;
						if(localStorage.getItem('iGuider_data-'+$.iGuider.opt.tourID)){                                 
							$.iGuider.v.iGuider_data = $.parseJSON(localStorage.getItem('iGuider_data-'+$.iGuider.opt.tourID));
							if($.iGuider.v.iGuider_data.tourId == $.iGuider.v.tourid){
								if($.iGuider.goFlag){
									$.iGuider.v.stepValue = $.iGuider.v.iGuider_data.stepValue;
									$.iGuider.opt.startStep = $.iGuider.v.stepValue; 										
									startStep();
								}else{
									if($.iGuider.opt.continue.enable && localStorage.getItem('iGuider_restored') != '1'){
										/*display modal window*/
										$.iGuider.v.windowContinue();
									}else{
										$.iGuider.v.debug(new Error().lineNumber+ ' continue.enable: ' + $.iGuider.opt.continue.enable); 
										$.iGuider.v.debug(new Error().lineNumber+ ' iGuider_restored: ' + localStorage.getItem('iGuider_restored'));													
										if(localStorage.getItem('iGuider_restored') != '1'){
											$.iGuider.v.startStepVal = $.iGuider.opt.startStep;
											$.iGuider.v.stepVal = $.iGuider.opt.steps[$.iGuider.v.startStepVal-1];
											$.iGuider.v.targetLocVal = $.iGuider.v.stepVal.loc;

											
											/*START PAST*/
											$.iGuider.v.compareLoc = function(nowLoc){
												if(nowLoc !== $.iGuider.v.targetLocVal){
													$.iGuider.v.debug(new Error().lineNumber+ ' $.iGuider.v.nowLoc: '+$.iGuider.v.nowLoc); 
													$.iGuider.v.debug(new Error().lineNumber+ ' $.iGuider.v.targetLocVal: '+$.iGuider.v.targetLocVal);													
													$.iGuider.v.iGuider_go = {
														opt:$.iGuider.v.toStringObj($.iGuider.opt)
													};
													localStorage.setItem('iGuider_go',JSON.stringify($.iGuider.v.iGuider_go));
						
													/**/
													/*Save step numbers in localStorage*/
													/**/
													$.iGuider.v.iGuider_data = {
														tourId:$.iGuider.v.tourid,
														stepValue:$.iGuider.opt.startStep
													};
													localStorage.setItem('iGuider_data-'+$.iGuider.opt.tourID,JSON.stringify($.iGuider.v.iGuider_data));

													/**/
													/*Redirect*/
													/**/
													$.iGuider.v.debug(new Error().lineNumber+ ' Redirect 8'); 
													if(!$.iGuider.opt.baseurl){
														location.href = $.iGuider.v.targetLocVal;
													}else{
														location.href = $.iGuider.opt.baseurl + $.iGuider.v.targetLocVal;
													}
												}else{                                
													startStep();
												}	
											};
											
											if(!$.iGuider.opt.baseurl){
												/*only for absolute path URL*/
												$.iGuider.v.compareLoc($.iGuider.v.nowLoc);
											}else{
												/*only for relative path URL*/
												var relativeNowLoc = $.iGuider.v.nowLoc.split($.iGuider.opt.baseurl)[1].split('#')[0];
												$.iGuider.v.compareLoc(relativeNowLoc);
											}
											/*END PAST*/
											
											
											
										}else{
											startStep();
										}
									}
								}
							}else{
								
								var targetLoc;
								if($.iGuider.opt.steps){
									if($.iGuider.opt.steps.length){
												
										targetLoc = $.iGuider.opt.steps[(parseFloat($.iGuider.opt.startStep) - 1)].loc || $.iGuider.v.nowLoc;
										$.iGuider.v.debug(new Error().lineNumber+ ' targetLoc: '+targetLoc);
										$.iGuider.v.debug(new Error().lineNumber+ ' $.iGuider.v.nowLoc: '+$.iGuider.v.nowLoc);										

										
										/*START PAST 4*/
										$.iGuider.v.compareLoc4 = function(nowLoc){
											if(nowLoc !== targetLoc){
												$.iGuider.v.iGuider_go = {
													opt:$.iGuider.v.toStringObj($.iGuider.opt)
												};
												localStorage.setItem('iGuider_go',JSON.stringify($.iGuider.v.iGuider_go));
					
												/**/
												/*Save step numbers in localStorage*/
												/**/
												$.iGuider.v.iGuider_data = {};
												if(localStorage.getItem('iGuider_data-'+$.iGuider.opt.tourID)){
													$.iGuider.v.iGuider_data = $.parseJSON(localStorage.getItem('iGuider_data-'+$.iGuider.opt.tourID));
												}
												$.extend($.iGuider.v.iGuider_data, {
													tourId:$.iGuider.v.tourid,
													stepValue:$.iGuider.opt.startStep
												});    
												localStorage.setItem('iGuider_data-'+$.iGuider.opt.tourID,JSON.stringify($.iGuider.v.iGuider_data));
												
												/**/
												/*Redirect 4*/
												/**/
												
												$.iGuider.v.debug(new Error().lineNumber+ ' Redirect 1');
												if(!$.iGuider.opt.baseurl){
													location.href = targetLoc;
												}else{
													location.href = $.iGuider.opt.baseurl + targetLoc;
												}
												
											}else{                                
												startStep();
											}	
										};
										
										if(!$.iGuider.opt.baseurl){
											/*only for absolute path URL*/
											$.iGuider.v.compareLoc4($.iGuider.v.nowLoc);
										}else{
											/*only for relative path URL*/
											var relativeNowLoc = $.iGuider.v.nowLoc.split($.iGuider.opt.baseurl)[1].split('#')[0];
											$.iGuider.v.compareLoc4(relativeNowLoc);
										}
										/*END PAST*/
										
										
									
									}else{
										$.iGuider.v.debug(new Error().lineNumber+ ' Steps array does not have abject items');  
									}
								}else{
									$.iGuider.v.debug(new Error().lineNumber+ ' Steps parameter is absent.'); 									
								}


							}
						}else{
							
							$.iGuider.v.startStepVal = $.iGuider.opt.startStep;
							$.iGuider.v.stepVal = $.iGuider.opt.steps[$.iGuider.v.startStepVal-1];
							$.iGuider.v.targetLocVal = $.iGuider.v.stepVal.loc;
		
							if($.iGuider.v.nowLoc.search(escapeRe($.iGuider.v.targetLocVal)) === -1 && $.iGuider.v.targetLocVal.search(escapeRe($.iGuider.v.nowLoc)) === -1 && $.iGuider.v.nowLoc !== $.iGuider.v.targetLocVal){

								$.iGuider.v.iGuider_go = {
									opt:$.iGuider.v.toStringObj($.iGuider.opt)
								};
								localStorage.setItem('iGuider_go',JSON.stringify($.iGuider.v.iGuider_go));
	
								/**/
								/*Save step numbers in localStorage*/
								/**/
								$.iGuider.v.iGuider_data = {
									tourId:$.iGuider.v.tourid,
									stepValue:$.iGuider.opt.startStep
								};
								localStorage.setItem('iGuider_data-'+$.iGuider.opt.tourID,JSON.stringify($.iGuider.v.iGuider_data));

								/**/
								/*Redirect*/
								/**/
								$.iGuider.v.debug(new Error().lineNumber+ ' Redirect 7');  

								if(!$.iGuider.opt.baseurl){
									location.href = $.iGuider.v.targetLocVal;
								}else{
									location.href = $.iGuider.opt.baseurl + $.iGuider.v.targetLocVal;
								}
								
								
							}else{
								startStep();
							}
						}
                        
                    },delayTimeout);
                };
                
                $(document).on('click','.g-modal-start',function(){
					if(!$.iGuider.v.design){
						storageDetect();
					}
                });
                
                $(document).on('click','.g-modal-begin-first',function(){
					if(!$.iGuider.v.design){
						/**/
						/*Set present and necessary location path*/
						/**/
						$.iGuider.v.nowLoc = location.href;
						var targetLoc = $.iGuider.v.nowLoc;
						$.iGuider.v.nextIndex = (parseFloat($.iGuider.opt.startStep) - 1);

						/**/
						/*Check presence of next step */
						/**/
						if($.iGuider.v.nextIndex < $.iGuider.opt.steps.length && $.iGuider.v.nextIndex >= 0){
							targetLoc = $.iGuider.opt.steps[$.iGuider.v.nextIndex].loc;
						}
						/**/
						/*compare the paths*/
						/**/

						
						/*START PAST 3*/
						$.iGuider.v.compareLoc3 = function(nowLoc){
							if(nowLoc !== targetLoc){
								/*If the paths are not the same:*/
								
								/**/
								/*create new options object for transfer to another page*/
								/**/
								
								$.iGuider.v.iGuider_go = {
									opt:$.iGuider.v.toStringObj($.iGuider.opt)
								};
								localStorage.setItem('iGuider_go',JSON.stringify($.iGuider.v.iGuider_go));
							
								/**/
								/*Save step numbers in localStorage*/
								/*Get iGuider_data object from localStorage*/
								/**/
								$.iGuider.v.iGuider_data = {};
								if(localStorage.getItem('iGuider_data-'+$.iGuider.opt.tourID)){
									$.iGuider.v.iGuider_data = $.parseJSON(localStorage.getItem('iGuider_data-'+$.iGuider.opt.tourID));
								}
								
								/**/
								/*Merge the getting object with the new values*/
								/**/
								$.extend($.iGuider.v.iGuider_data, {
									tourId:$.iGuider.v.tourid,
									stepValue:$.iGuider.opt.startStep
								});    
								
								/**/
								/*Save new data in localStorage*/
								/**/
								localStorage.setItem('iGuider_data-'+$.iGuider.opt.tourID,JSON.stringify($.iGuider.v.iGuider_data));

								/**/
								/*Redirect 3*/
								/**/
								$.iGuider.v.debug(new Error().lineNumber+ ' Redirect 2'); 
								if(!$.iGuider.opt.baseurl){
									location.href = targetLoc;
								}else{
									location.href = $.iGuider.opt.baseurl + targetLoc;
								}
								
							}else{                                
								startStep();    
							}	
						};
						
						if(!$.iGuider.opt.baseurl){
							/*only for absolute path URL*/
							$.iGuider.v.compareLoc3($.iGuider.v.nowLoc);
						}else{
							/*only for relative path URL*/
							var relativeNowLoc = $.iGuider.v.nowLoc.split($.iGuider.opt.baseurl)[1].split('#')[0];
							$.iGuider.v.compareLoc3(relativeNowLoc);
						}
						/*END PAST*/
						
						
						
					}
                });
                
                $(document).on('click','.g-modal-begin-continue',function(){
					if(!$.iGuider.v.design){
						$.iGuider.opt.startStep = $.iGuider.v.stepValue;					
						if($.iGuider.v.otherPage){ 
							$.iGuider.v.customTarget = $.iGuider.v.otherPage;
							
							/**/
							/*Add Redirect Flag*/
							/**/
							$.iGuider.v.iGuider_go = {
								opt:$.iGuider.v.toStringObj($.iGuider.opt)
							};
							localStorage.setItem('iGuider_go',JSON.stringify($.iGuider.v.iGuider_go));

							/**/
							/*Redirect*/
							/**/
							$.iGuider.v.debug(new Error().lineNumber+ ' Redirect 3');    
							location.href = $.iGuider.v.customTarget;    
						}else{
							
							/*Highlight all ready steps*/
							var targetIndex =  ($.iGuider.opt.startStep-1);
							for(var i = 0; i < $.iGuider.opt.steps.length; i ++){
								if(i < targetIndex){
									$.iGuider.opt.steps[i].ready = true;
									addSuccess($('[data-hindex="'+i+'"]')); 
								}else{
									break;
								}
							}
							
							startStep();
						}
					}
                });

                /**/
                /*Update position after window resize*/
                /**/
                var researchEl = function(){
					if(!$('html').is('.g-preloader')){
						/*Search previous element if new element is not ready*/
						var targetEl = $.iGuider.v.targetElSave;
						if($.iGuider.v.targetEl){
							if($.iGuider.v.targetEl.length && $.iGuider.v.targetEl.is(':visible')){
								targetEl = $.iGuider.v.targetEl;
							}
							if(targetEl){
								if(targetEl.length){
									var color = $.iGuider.v.tCanvas.tColor;
									var rgbCode = $.iGuider.v.hexToRGBCODE(color);
									$.iGuider.v.redrawOverlay(rgbCode[0],rgbCode[1],rgbCode[2],$.iGuider.v.tCanvas.tOpacity);
									$.iGuider.v.searchEl(targetEl);
								}
							}
						}
					}
                };
                $(window).on('resize.iGuider',function(){
                    if($.iGuider){
                        if(!$.iGuider.v.scrolling){
                            $.iGuider.v.overlayPos($.iGuider.v.targetEl);    
                            if(overlayCreateFlag){
                                clearTimeout(resizeID);
                                resizeID = setTimeout(function(){
                                    $.iGuider.v.setCanvasSize();
                                    researchEl();
                                },200);
                            }
                        }
                    }
                });
                $(window).on('scroll.iGuider',function(){
                    if($.iGuider){
                        if(!$.iGuider.v.scrolling){
                            $.iGuider.v.overlayPos($.iGuider.v.targetEl);    
                            if(overlayCreateFlag){
                                researchEl();
                            }
                        }
                    }
                });
                
                var brouserNotSupport = function(){
                    console.log('Your browser does not support multi-page');
                    $.iGuider.v.debug(new Error().lineNumber+ ' Old Browser and Destroy');    

                    $.fn.iGuider('destroy');
                };
                
                /**/
                /*This function call the next step*/
                /**/
                var nextActive = false;
                $.iGuider.v.nextStep = function(){
					$.iGuider.v.nextIndex = (parseFloat($.iGuider.v.startIndex) + 1);
                    if(nextActive === false && $($.iGuider.v.targetEl).length){
                        nextActive = true;
                        
                        /**/
                        /*Set present and necessary location path*/
                        /**/
                        $.iGuider.v.nowLoc = location.href;
                        var targetLoc = $.iGuider.v.nowLoc;
                        $.iGuider.v.nextIndex = (parseFloat($.iGuider.v.startIndex) + 1);

                        /**/
                        /*Check presence of next step */
                        /**/

                        if($.iGuider.v.nextIndex < $.iGuider.opt.steps.length){
                            targetLoc = $.iGuider.opt.steps[$.iGuider.v.nextIndex].loc;
                        }else{
							if($.iGuider.opt.baseurl){
								targetLoc = targetLoc.split($.iGuider.opt.baseurl)[1].split('#')[0];
							}
						}
						
                        
                        $.iGuider.v.targetEl.off($.iGuider.opt.steps[$.iGuider.v.startIndex].event+'.iGuider');
                        
                        if($.iGuider.v.customTargetSelector){
                            $($.iGuider.v.customTargetSelector).off($.iGuider.v.customEvent+'.iGuider');
                        }
                        
                        if($.iGuider.opt.steps[$.iGuider.v.startIndex].event == 'next'){
                            $.iGuider.opt.steps[$.iGuider.v.startIndex].ready = true;
							addSuccess($('[data-hindex="'+$.iGuider.v.startIndex+'"]'));
                        }
                        $.iGuider.v.afterFunc();
                        $.iGuider.opt.steps[$.iGuider.v.startIndex].delayAfter = $.iGuider.opt.steps[$.iGuider.v.startIndex].delayAfter || 0;
                        clearTimeout($.iGuider.v.delayAfterId);
						$.iGuider.v.delayAfterId = setTimeout(function(){
							$.iGuider.v.after_afterFunc();
							setTimeout(function(){
								nextActive = false;
							},500);
							
                            /**/
                            /*compare 1*/
                            /*START PAST 1*/

							$.iGuider.v.compareLoc1 = function(nowLoc){
								if(nowLoc !== targetLoc){
									/*If the paths are not the same:*/
									/**/
									/*create new options object for transfer to another page*/
									/**/
									
									$.iGuider.v.iGuider_go = {
										opt:$.iGuider.v.toStringObj($.iGuider.opt)
									};
									localStorage.setItem('iGuider_go',JSON.stringify($.iGuider.v.iGuider_go));

									/**/
									/*Save step numbers in localStorage*/
									/*Get iGuider_data object from localStorage*/
									/**/
								   $.iGuider.v.iGuider_data = {};
									if(localStorage.getItem('iGuider_data-'+$.iGuider.opt.tourID)){
										$.iGuider.v.iGuider_data = $.parseJSON(localStorage.getItem('iGuider_data-'+$.iGuider.opt.tourID));
									}
									
									/**/
									/*Merge the getting object with the new values*/
									/**/
									$.extend($.iGuider.v.iGuider_data, {
										tourId:$.iGuider.v.tourid,
										stepValue:(parseFloat($.iGuider.v.iGuider_data.stepValue) + 1)
									});    
									
									/**/
									/*Save new data in localStorage*/
									/**/
									localStorage.setItem('iGuider_data-'+$.iGuider.opt.tourID,JSON.stringify($.iGuider.v.iGuider_data));
		
									/**/
									/*Main Redirect 1*/
									/**/
									$.iGuider.v.debug(new Error().lineNumber+ ' Redirect 4');
									if(!$.iGuider.opt.baseurl){
										location.href = targetLoc;
									}else{
										
										console.log($.iGuider.opt.baseurl)
										console.log(targetLoc)
										
										location.href = $.iGuider.opt.baseurl + targetLoc;
									}
									
								}else{                                
									$.iGuider.v.startIndex++;
									$.iGuider.v.event = 'next';
									$.iGuider.v.debug(new Error().lineNumber+ ' Run "hStep" func - 4');    
									hStep();
								}	
							};
							
							if(!$.iGuider.opt.baseurl){
								/*only for absolute path URL*/
								$.iGuider.v.compareLoc1($.iGuider.v.nowLoc);
							}else{
								/*only for relative path URL*/
								var relativeNowLoc = $.iGuider.v.nowLoc.split($.iGuider.opt.baseurl)[1].split('#')[0];
								$.iGuider.v.compareLoc1(relativeNowLoc);
							}
							/*END PAST*/
							
							
							
							
                        },$.iGuider.opt.steps[$.iGuider.v.startIndex].delayAfter);
                        
                    }
                };
                
                $(document).on('click','.g-modal-next',function(){
					if(!$.iGuider.v.design){
						if(checkNextFunc($($.iGuider.v.targetEl)) === true){
							$('.gErrorMessage').remove();
							localStorage.setItem('iGuider_step',parseFloat($.iGuider.v.startIndex)+2);																								
							$.iGuider.v.nextStep();
						}else{
							messageErrorNext();
						}
					}
                });
                
                /**/
                /*This function call the prev step*/
                /**/
                var prevActive = false;
                $.iGuider.v.prevStep = function(){
					/**/
					/*Check presence of next step */
					/**/
					$.iGuider.v.nextIndex = (parseFloat($.iGuider.v.startIndex) - 1);
					if($.iGuider.v.nextIndex >= 0){
					
						if(prevActive === false && $($.iGuider.v.targetEl).length){
							prevActive = true;
							$.iGuider.v.targetEl.off($.iGuider.opt.steps[$.iGuider.v.startIndex].event+'.iGuider');
							if($.iGuider.v.customTargetSelector){
								$($.iGuider.v.customTargetSelector).off($.iGuider.v.customEvent+'.iGuider');
							}
							if($.iGuider.opt.steps[$.iGuider.v.startIndex].event == 'prev'){
								$.iGuider.opt.steps[$.iGuider.v.startIndex].ready = true;
								addSuccess($('[data-hindex="'+$.iGuider.v.startIndex+'"]'));
							}

							clearTimeout($.iGuider.v.delayAfterId);
							$.iGuider.v.afterFunc();
							$.iGuider.opt.steps[$.iGuider.v.startIndex].delayAfter = $.iGuider.opt.steps[$.iGuider.v.startIndex].delayAfter || 0;
							$.iGuider.v.delayAfterId = setTimeout(function(){
								$.iGuider.v.after_afterFunc();	

								/**/
								/*Set present and necessary location path*/
								/**/
								$.iGuider.v.nowLoc = location.href;
								var targetLoc = $.iGuider.opt.steps[$.iGuider.v.nextIndex].loc;

								/**/
								/*compare the paths*/
								/**/
																
								/*START PAST 5*/
								$.iGuider.v.compareLoc5 = function(nowLoc){
									if(nowLoc !== targetLoc){
										/*If the paths are not the same:*/
										/**/
										/*create new options object for transfer to another page*/
										/**/
										
										$.iGuider.v.iGuider_go = {
											opt:$.iGuider.v.toStringObj($.iGuider.opt)
										};
										
										localStorage.setItem('iGuider_go',JSON.stringify($.iGuider.v.iGuider_go));
									
										/**/
										/*Save step numbers in localStorage*/
										/*Get iGuider_data object from localStorage*/
										/**/
										$.iGuider.v.iGuider_data = {};
										if(localStorage.getItem('iGuider_data-'+$.iGuider.opt.tourID)){
											$.iGuider.v.iGuider_data = $.parseJSON(localStorage.getItem('iGuider_data-'+$.iGuider.opt.tourID));
										}
										
										/**/
										/*Merge the getting object with the new values*/
										/**/
										$.extend($.iGuider.v.iGuider_data, {
											tourId:$.iGuider.v.tourid,
											stepValue:(parseFloat($.iGuider.v.iGuider_data.stepValue) - 1)
										});    
										
										/**/
										/*Save new data in localStorage*/
										/**/
										localStorage.setItem('iGuider_data-'+$.iGuider.opt.tourID,JSON.stringify($.iGuider.v.iGuider_data));
			
										/**/
										/*Redirect 5*/
										/**/
										$.iGuider.v.debug(new Error().lineNumber+ ' Redirect 5'); 
										if(!$.iGuider.opt.baseurl){
											location.href = targetLoc;
										}else{
											location.href = $.iGuider.opt.baseurl + targetLoc;
										}
										
									}else{                                
										$.iGuider.v.startIndex--;    
										$.iGuider.v.event = 'prev';
										$.iGuider.v.debug(new Error().lineNumber+ ' Run "hStep" func - 5');    
										hStep();
									}	
								};
								
								if(!$.iGuider.opt.baseurl){
									/*only for absolute path URL*/
									$.iGuider.v.compareLoc5($.iGuider.v.nowLoc);
								}else{
									/*only for relative path URL*/
									var relativeNowLoc = $.iGuider.v.nowLoc.split($.iGuider.opt.baseurl)[1].split('#')[0];
									$.iGuider.v.compareLoc5(relativeNowLoc);
								}
								/*END PAST*/
								
								
							
							},$.iGuider.opt.steps[$.iGuider.v.startIndex].delayAfter);  
						
							setTimeout(function(){
								prevActive = false;
							},500);
						}
					}else{
						$.iGuider.v.debug(new Error().lineNumber+ ' No previous steps');
					}
                };
                $(document).on('click','.g-modal-prev',function(){
					if(!$.iGuider.v.design){
						if(checkPrevFunc($($.iGuider.v.targetEl)) === true){
							localStorage.setItem('iGuider_step',$.iGuider.v.startIndex);																			
							$.iGuider.v.prevStep();
						}else{
							messageErrorPrev(); 
						}
					}
                });
                
                /**/
                /*This function off tour*/
                /**/
                $(document).on('click','.g-modal-close',function(){
					if(!$.iGuider.v.design){
						$.iGuider.v.end();    
						$.iGuider.v.abort();
						$.iGuider.v.debug(new Error().lineNumber+ ' Click Close and Destroy');    
						$.fn.iGuider('destroy');
					}
                });
                
                /**/
                /*This function set active step*/
                /**/
				$.iGuider.v.setStep = function(stepLinkIndex){
					if(stepLinkIndex < $.iGuider.opt.steps.length){
						clearTimeout($.iGuider.v.storageDetectId);
						$.iGuider.v.nowLoc = location.href;
						
						var targetLoc = $.iGuider.opt.steps[stepLinkIndex].loc;
						
						if(!$.iGuider.v.startIndex && parseFloat($.iGuider.v.startIndex) != 0){
							$.iGuider.v.startIndex = 999;
						}							

						if(parseFloat($.iGuider.v.startIndex) !== parseFloat(stepLinkIndex)){
							
							$.iGuider.v.startIndex = stepLinkIndex;
							
							if($.iGuider.opt.steps[$.iGuider.v.startIndex].event == 'next' && !$.iGuider.opt.steps[$.iGuider.v.startIndex].checkNext){
								$.iGuider.opt.steps[$.iGuider.v.startIndex].ready = true;
								addSuccess($('[data-hindex="'+$.iGuider.v.startIndex+'"]'));
							}
							
							clearTimeout($.iGuider.v.delayAfterId);
							$.iGuider.v.afterFunc();
							$.iGuider.opt.steps[$.iGuider.v.startIndex].delayAfter = $.iGuider.opt.steps[$.iGuider.v.startIndex].delayAfter || 0;
							$.iGuider.v.delayAfterId = setTimeout(function(){

								$.iGuider.v.after_afterFunc();	
								
								

								
								/*START PAST 6*/
								$.iGuider.v.compareLoc6 = function(nowLoc){
									if(nowLoc !== targetLoc){
										$.iGuider.v.iGuider_go = {
											opt:$.iGuider.v.toStringObj($.iGuider.opt)
										};
										localStorage.setItem('iGuider_go',JSON.stringify($.iGuider.v.iGuider_go));

										/**/
										/*Save step numbers in localStorage*/
										/**/
										$.iGuider.v.iGuider_data = {};
										if(localStorage.getItem('iGuider_data-'+$.iGuider.opt.tourID)){
											$.iGuider.v.iGuider_data = $.parseJSON(localStorage.getItem('iGuider_data-'+$.iGuider.opt.tourID));
										}
										$.extend($.iGuider.v.iGuider_data, {
											tourId:$.iGuider.v.tourid,
											stepValue:(parseFloat(stepLinkIndex) + 1)
										});    
										localStorage.setItem('iGuider_data-'+$.iGuider.opt.tourID,JSON.stringify($.iGuider.v.iGuider_data));
										localStorage.setItem('iGuider_step',parseFloat(stepLinkIndex) + 1);																			

										/**/
										/*Redirect 6*/
										/**/
										$.iGuider.v.debug(new Error().lineNumber+ ' Redirect 6'); 
										if(!$.iGuider.opt.baseurl){
											location.href = targetLoc;
										}else{
											location.href = $.iGuider.opt.baseurl + targetLoc;
										}
										
									}else{                                
										localStorage.setItem('iGuider_step',parseFloat(stepLinkIndex) + 1);	
										if($.iGuider.v.targetEl){
											$.iGuider.v.targetEl.off($.iGuider.opt.steps[$.iGuider.v.startIndex].event+'.iGuider');
										}
										if($.iGuider.v.customTargetSelector){
											$($.iGuider.v.customTargetSelector).off($.iGuider.v.customEvent+'.iGuider');
										}
										$.iGuider.v.debug(new Error().lineNumber+ ' Run "hStep" func - 6');    
										hStep();
									}	
								};
								
								if(!$.iGuider.opt.baseurl){
									/*only for absolute path URL*/
									$.iGuider.v.compareLoc6($.iGuider.v.nowLoc);
								}else{
									/*only for relative path URL*/
									var relativeNowLoc = $.iGuider.v.nowLoc.split($.iGuider.opt.baseurl)[1].split('#')[0];
									$.iGuider.v.compareLoc6(relativeNowLoc);
								}
								/*END PAST*/
								
								
							},$.iGuider.opt.steps[$.iGuider.v.startIndex].delayAfter);   
						}
					}else{
						$.iGuider.v.debug(new Error().lineNumber+ ' Attention: Invalid step number');    
					}
				};
				
                if(!$.iGuider.opt.tourMap.clickable){
					$('html').addClass('g-map-no-clickable');                    
                }else{
                    if($.iGuider.opt.tourMap.clickable == true || $.iGuider.opt.tourMap.clickable == 'true'){
						$(document).on('click','[data-hindex]',function(){
							if(!$('html').is('.g-preloader')){
								var stepLink = $(this);
								var stepLinkIndex = stepLink.attr('data-hindex');
								$.iGuider.v.setStep(stepLinkIndex);
							}
						});
					}
					if($.iGuider.opt.tourMap.clickable == 'ready'){
						$(document).on('click','[data-hindex]',function(){
							if(!$('html').is('.g-preloader')){
								var stepLink = $(this);
								if(stepLink.is('.g-step-success') || stepLink.prev().is('.g-step-success')){
									var stepLinkIndex = stepLink.attr('data-hindex');
									$.iGuider.v.setStep(stepLinkIndex);
								}
							}
						});
					}
					
					
                }
                
                /**/
                /*This function off tour*/
                /**/
                if($.iGuider.opt.overlayClickable){
                    $(document).on($.iGuider.v.clickEvent+'.iGuider',function(e){
						if($.iGuider){
							if(!$.iGuider.v.design){
								if (touchMoving) return false;

								if($(e.target).is('html')){
									$.iGuider.v.end();    
									$.iGuider.v.abort();    
									$.iGuider.v.debug(new Error().lineNumber+ ' Click "overlay" (HTML) and Destroy');    
									$.fn.iGuider('destroy');
								}
							}
						}
                    });
                }
                
                /**/
                /*Tour map toggle*/
                /**/
                $.iGuider.v.modalMap.on('click',function(){
                    if($('html').is('.g-map-open')){
                        $('html').removeClass('g-map-open');
                        $.iGuider.opt.tourMap.open = false;
                    }else{
                        $('html').addClass('g-map-open');    
                        $.iGuider.opt.tourMap.open = true;
                    }
                });
                $.iGuider.v.hHide.on('click',function(){
                    if($('html').is('.g-map-open')){
                        $('html').removeClass('g-map-open'); 
						$.iGuider.opt.tourMap.open = false;						
                    }else{
                        $('html').addClass('g-map-open'); 
						$.iGuider.opt.tourMap.open = true;
                    }
                });
				
				$.iGuider.v.hToggle.on('click',function(){
					iGuider('map','toggle');
                });
                
                /*Change target for message*/
                var changeMsgPos = function(indexShape){
                    if(indexShape != $.iGuider.v.indexActive){
                        $.iGuider.v.indexActive = indexShape;
                        var modalDataItem = $.iGuider.v.modalData[indexShape];
                        $.iGuider.v.modalPos
                        .css({
                            left:modalDataItem.left,
                            top:modalDataItem.top
                        })
                        .attr({
                            'data-pos':modalDataItem.dataPos,
                            'data-cone':modalDataItem.dataCone,
                            'data-cont':modalDataItem.dataCont
                        });
						$.iGuider.v.debug(new Error().lineNumber+ ' posCorrect func - 3');							
                        $.iGuider.v.posCorrect(modalDataItem.dataPos,modalDataItem.dataCone,modalDataItem.dataCont);
                        $.iGuider.v.modalPosShow(0);
                    }
                };
                
                $(document).on('mouseenter.iGuider','.iGuider-highlight',function(){
                    if($('.iGuider-highlight').length > 1){
                        var shapeEl = $(this);
                        var indexShape = $('.iGuider-highlight').index(shapeEl);
                        changeMsgPos(indexShape);
                    }
                });
                $(document).on('mouseenter.iGuider','.g-shape',function(){
                    if($('.g-shape').length > 1){
                        var shapeEl = $(this);
                        var indexShape = $('.g-shape').index(shapeEl);
                        changeMsgPos(indexShape);
                    }
                });
				
				$(document).on('mouseenter','.gErrorMessage',function(){
					clearTimeout($.iGuider.v.messageErrorId);
				}).on('mouseleave','.gErrorMessage',function(){
					$.iGuider.v.messageErrorHide();
				});
				
				$(document).on('mouseenter','.gEventMessage',function(){
					clearTimeout($.iGuider.v.messageEventId);
				}).on('mouseleave','.gEventMessage',function(){
					$.iGuider.v.messageEventHide();
				});
				
				$(document).on('click','.g-timer-controll',function(){
					if($.iGuider.v.timerState == 'pause'){
						 $.fn.iGuider('timerState','play');						
					}else{
						 $.fn.iGuider('timerState','pause');
					}
					return false;
				});
				
				/**/
                /*Set timer state*/
                /**/  
				var timerStateDef = 'play';
				$.iGuider.v.timerStateDefault = function(){
					$.fn.iGuider('timerState',timerStateDef);
				};
				
				if(localStorage.getItem('iGuider_timer')){ 
					$.fn.iGuider('timerState',localStorage.getItem('iGuider_timer'));
				}else{
					$.iGuider.v.timerStateDefault();
				}  
				
				
				
				/**/
				/*This function display intro modal window*/
				/**/
				$.iGuider.v.windowIntro = function(){
					
					$.iGuider.v.debug(new Error().lineNumber+ ' Start generate intro window');							
					clearTimeout($.iGuider.v.storageDetectId);
					$.iGuider.v.debug(new Error().lineNumber+ ' Start intro content installation');							
					$.iGuider.v.modalImage.empty();
					if($.trim($.iGuider.opt.intro.cover)){									
						
						var coverEl = $('<img>').hide()
						.attr('src',$.iGuider.opt.intro.cover)
						.addClass('hTourCover')
						.on('load',function(){
							coverEl.show();
						});
						coverEl.appendTo($.iGuider.v.modalImage);
						$.iGuider.v.coverShow();
					}else{
						$.iGuider.v.modalImage.empty();	
						$.iGuider.v.coverHide();
					}
					
					if($.iGuider.opt.intro.title && $.iGuider.opt.intro.title != ''){
						$.iGuider.v.modalHeader.html($.iGuider.opt.intro.title);
						$.iGuider.v.modalTitleShow();
					}else{
						$.iGuider.v.modalTitleHide();
					}
					
					if($.iGuider.opt.intro.content && $.iGuider.opt.intro.content != ''){
						$.iGuider.v.modalBody.html($.iGuider.opt.intro.content);
						$.iGuider.v.modalContShow();
					}else{
						$.iGuider.v.modalContHide();
					}
					
					
					$.iGuider.v.modalCloseIntro.html($.iGuider.opt.lang.introDialogBtnCancel);
					$.iGuider.v.modalStart.html($.iGuider.opt.lang.introDialogBtnStart);
					
					/*Set Width of Message Block*/
					$.iGuider.v.debug(new Error().lineNumber+ ' Start intro width installation');							
					var widthVal = '';
					var widthPar = $.iGuider.opt.intro.width || $.iGuider.opt.width;
					if(widthPar){
						widthVal = widthPar;
						widthVal = widthVal.toString();
						if(widthVal.search('%') != -1 || widthVal.search('vw') != -1){
							widthVal = widthVal.replace('%','vw');
						}else{
							widthVal = parseFloat(widthVal);
						}
					}
					$.iGuider.v.modalSize.css({minWidth:widthVal});
					$.iGuider.v.debug(new Error().lineNumber+ ' Start intro style installation');							
					/*Set Background of Message Block*/
					var bgColorPar = $.iGuider.opt.intro.bgColor || $.iGuider.opt.bgColor;
					if(bgColorPar){
						
						$.iGuider.v.modalSize.css({background:bgColorPar});
					}else{
						$.iGuider.v.modalSize.css({background:''});
					}
					
					
					/*Set Title Color of Message Block*/
					var titleColorPar = $.iGuider.opt.intro.titleColor || $.iGuider.opt.titleColor;
					if(titleColorPar){
						
						$.iGuider.v.modalHeader.css({color:titleColorPar});
					}else{
						$.iGuider.v.modalHeader.css({color:''});
					}
					
					/*Set Content Color of Message Block*/
					var modalContentColorPar = $.iGuider.opt.intro.modalContentColor || $.iGuider.opt.modalContentColor;
					if(modalContentColorPar){
						
						$.iGuider.v.modalBody.css({color:modalContentColorPar});
					}else{
						$.iGuider.v.modalBody.css({color:''});
					}
					
					/*Set Modal Type Color of Message Block*/
					var modalTypeColorPar = $.iGuider.opt.intro.modalTypeColor || $.iGuider.opt.modalTypeColor;
					if(modalTypeColorPar){
						$.iGuider.v.modalType.css({color:modalTypeColorPar});
					}else{
						$.iGuider.v.modalType.css({color:''});
					}
					
					/*Set Buttons Color of Message Block*/
					var btnColorPar = $.iGuider.opt.intro.btnColor || $.iGuider.opt.btnColor;
					if(btnColorPar){
						$('#btnColorStyle').remove();
						$('<style id="btnColorStyle">').html('.g-modal-pos .gBtn {color:'+btnColorPar+'}').appendTo('html');
					}else{
						$('#btnColorStyle').remove();
					}
					
					/*Set Buttons Hover Color of Message Block*/
					var btnHoverColorPar = $.iGuider.opt.intro.btnHoverColor || $.iGuider.opt.btnHoverColor;
					if(btnHoverColorPar){
						$('#btnHoverColorStyle').remove();
						$('<style id="btnHoverColorStyle">').html('.g-modal-pos .gBtn:hover {color:'+btnHoverColorPar+'}').appendTo('html');
					}else{
						$('#btnHoverColorStyle').remove();
					}
					$.iGuider.v.debug(new Error().lineNumber+ ' Start intro position installation');							
					$.iGuider.v.modalPos.css({left:'50%',top:'50%'}).attr({
						'data-pos':'c',
						'data-cone':'c',
						'data-cont':'c'
					});
					
					/**/
					/*Position correction*/
					/**/
					$.iGuider.v.debug(new Error().lineNumber+ ' posCorrect func - 4');							
					$.iGuider.v.posCorrect('c','c','c');
					$.iGuider.v.debug(new Error().lineNumber+ ' Start intro overlay installation');							
					$.iGuider.v.tCanvas.tColor = $.iGuider.v.correctColor($.iGuider.opt.intro.overlayColor);
					$.iGuider.v.tCanvas.tOpacity = $.iGuider.opt.intro.overlayOpacity;
					$.iGuider.v.tCanvas.saveColor = $.iGuider.v.tCanvas.tColor;
					$.iGuider.v.tCanvas.saveOpacity = $.iGuider.v.tCanvas.tOpacity;
					$.iGuider.v.createOverlayLayer();
					
					$.iGuider.v.debug(new Error().lineNumber+ ' Start intro block display installation');							
					$.iGuider.v.modalPrevHide();
					$.iGuider.v.modalNextHide();
					$.iGuider.v.modalStepHide();
					$.iGuider.v.modalPosShow(0);
					$.iGuider.v.modalMapHide();
					$.iGuider.v.modalContinueHide();
					$.iGuider.v.modalIntroShow();
					$.iGuider.v.timerHide();
					$('.g-modal-type').html($.iGuider.opt.lang.modalIntroType).show();
					

					if(!$.iGuider.opt.steps){
						$.iGuider.v.debug(new Error().lineNumber+ ' Parameter "steps" is not set.');							
						$.iGuider.v.modalStartHide();
					}else{
						if(!$.iGuider.opt.steps.length){
							$.iGuider.v.debug(new Error().lineNumber+ ' Parameter "steps" is empty.');							
							$.iGuider.v.modalStartHide();
						}else{
							$.iGuider.v.modalStartShow();
							$.iGuider.v.debug(new Error().lineNumber+ ' Run Steps');							
						}
					}
					
				};
				
				
                
                
                /**/
                /*If steps is more then 0*/
                /**/
                if($.iGuider.opt.steps.length === 0){
                    $.iGuider.v.debug(new Error().lineNumber+ ' Mess: All target elements is absent.');
                    $.iGuider.v.debug(new Error().lineNumber+ ' Council: Check the "Steps" parameter.');
                    $.fn.iGuider('destroy');
                }else{
				
                    /**/
                    /*Creating intro message*/
                    /**/
                    if ($.iGuider.opt.intro){

                        if ($.iGuider.opt.intro.enable && localStorage.getItem('iGuider_event') != 'start'){
                            if($.iGuider.goFlag){
                                storageDetect();
                            }else{
								/*display modal window*/
								$.iGuider.v.windowIntro();
                            }
                        }else{
                            storageDetect();
                        }        
                    }
                }
				
				$.iGuider.v.clearData = function(type){
				
					$.iGuider.v.design = type;
					localStorage.removeItem('iGuider_event');
					localStorage.removeItem('iGuider_restored');
					localStorage.removeItem('iGuider_opt');
					localStorage.removeItem('iGuider_step');
					localStorage.removeItem('iGuider_go');
					localStorage.removeItem('iGuider_timer');
					localStorage.removeItem('iGuider_data-'+$.iGuider.opt.tourID);
				};
				
				$.iGuider.v.create();
				
            }else{
                console.log('Warning! \nDetected re-initialization of plugin. Check the code calling the plugin!');
            }
        },
		
		timerState: function(state){
			if($.iGuider && $.iGuider.v){
				if(state == 'pause'){
					if($.iGuider.v.timerState !== 'pause'){
						$.iGuider.v.timerState = 'pause';
						localStorage.setItem('iGuider_timer','pause');
						$.iGuider.v.modalTimerControll.removeClass('g-timer-pause').addClass('g-timer-play');
						$('html').removeClass('g-state-play').addClass('g-state-pause');
						$.iGuider.v.stopTimer();
						$.iGuider.v.pause();
					}
				}
				if(state == 'play'){
					if($.iGuider.v.timerState !== 'play'){
						$.iGuider.v.timerState = 'play';
						localStorage.setItem('iGuider_timer','play');
						$.iGuider.v.modalTimerControll.removeClass('g-timer-play').addClass('g-timer-pause');
						$('html').removeClass('g-state-pause').addClass('g-state-play');
						if($.iGuider.v.timeSave){
							$.iGuider.v.startTimer($.iGuider.v.timeSave);
						}
						$.iGuider.v.play();
					}
				}
			}
		},
		
		getStep: function (){
            return localStorage.getItem('iGuider_step') || false;
        },
		
		setStep: function (num){
			
            if($.iGuider && $.iGuider.opt){
				
                var stepNeed = parseFloat(num);
				$.iGuider.v.setStep(stepNeed-1);
				
            }
        },
        
        prev: function (){
            if($.iGuider && $.iGuider.opt){			
				if(parseFloat($.iGuider.v.startIndex) > 0){
					if($('html').is('.g-modal-prev-show')){
						$.iGuider.v.modalPrev.trigger('click');
					}
				}     
            }
        },
        
        next: function (flag){
            if($.iGuider && $.iGuider.opt){	

				if((parseFloat($.iGuider.v.startIndex)+1) < $.iGuider.opt.steps.length || flag){

					if($('html').is('.g-modal-next-show')){
						$.iGuider.v.modalNext.trigger('click');
					}else{
						if($.iGuider.opt.steps[$.iGuider.v.startIndex].keyboardEvent){
							var eventVal = $.iGuider.opt.steps[$.iGuider.v.startIndex].event;
							if(typeof eventVal == 'string'){
								$.iGuider.v.targetEl.trigger(eventVal);
							}
							if(typeof eventVal == 'object'){
								$(eventVal[1]).trigger(eventVal[0]);
							}
						}else{
							//message
							var eventMessage = $('<div>').addClass('gEventMessage').text($.iGuider.opt.steps[$.iGuider.v.startIndex].eventMessage || $.iGuider.opt.stepsDef[0].eventMessage);
							$('.gEventMessage').remove();
							$('.gFooter').after(eventMessage);
							
							$.iGuider.v.posCorrect();
							$.iGuider.v.messageEventHide();
						}
					}
					
				}     
            }
        },
        
        update: function (){
            if($.iGuider && $.iGuider.opt){
                $(window).trigger('scroll.iGuider');
            }
        },
        
        map: function (position){
            if($.iGuider && $.iGuider.opt){
				if(position == 'toggle'){
					if($('.g-map-pos-right').length){
						position = 'left';
					}else{
						position = 'right';
					}
				}
				
				$.iGuider.opt.tourMap.position = position;
				$('.g-map-pos-left, .g-map-pos-right').removeClass('g-map-pos-left g-map-pos-right');
				$('.g-map-pos').addClass('g-map-pos-'+position);
				var iGuider_opt = {
					opt:$.iGuider.v.toStringObj($.iGuider.opt)
				};																	
				localStorage.setItem('iGuider_opt',JSON.stringify(iGuider_opt));
            }
        },
		
		design: function(type){
			
			if($.iGuider && $.iGuider.opt){
				if(type == parseFloat(type)){
					type = parseFloat(type);
				}
				if(type == 'intro'){
					$.iGuider.v.clearData(type);
					$.iGuider.v.windowIntro();
				}
				if(type == 'continue'){
					$.iGuider.v.clearData(type);
					$.iGuider.v.windowContinue();
				}
				if(typeof type == 'number'){
					if(type-1 < $.iGuider.opt.steps.length){
						$.iGuider.v.clearData(type);
						iGuider('setStep',type);
					}
				}
				
				if(!$.iGuider.v.design){
					return false;
				}

			}else{
				return false;
			}
		},
		
		button:function(data,position){
			if(typeof data == 'object'){

				$.iGuiderItemAdd = function(optItem,i){
					var tourlistItem = $('<div>').addClass('tourlist-item').attr('id',i).appendTo('.iguider-btnCont').animate({opacity:1},300);
					var tourTitleEl = '';
					var tourSubtitle = '';
					if(optItem.tourTitle){
						tourTitleEl = $('<div>').addClass('tourlist-item-title').html(optItem.tourTitle).appendTo(tourlistItem);
					}
					if(optItem.tourSubtitle){
						tourSubtitle = $('<div>').addClass('tourlist-item-subtitle').html(optItem.tourSubtitle).appendTo(tourlistItem);
					}
				};
	
				$.iGuiderBtnAdd = function(){
					$(document).off('click','.iguider-btn');
					$('.iguider-btn').remove();
					var iguiderBtn = $('<div>')
						.addClass('iguider-btn')
						.html('<div class="iguider-btn-shape"><span class="iguider-btn-icon" style="color:#fff"></span></div><div class="iguider-btnCont"></div>')
						.appendTo('body');
					if(position){
						iguiderBtn.css({
							'inset':position
						})
					}
				};
			
				if(Array.isArray(data)){
					//Array
					if(data.length > 0){
						if(data.length > 1){
							$(document).off('click.iguiderbtn');
							$(document).off('click','.tourlist-item');
							//create button
							$.iGuiderBtnAdd();
							//create tour list
							$('.iguider-btnCont').empty();
							for(var i = 0; i < data.length; i++){
								var optItem = data[i];
								$.iGuiderItemAdd(optItem,i);
							}
							//create open event for button
							$(document).on('click','.iguider-btn',function(){
								$('html').removeClass('g-tour-list-right g-tour-list-left');
								if($('.iguider-btn').position().left < 320){
									$('html').addClass('g-tour-list-right');
								}else{
									$('html').addClass('g-tour-list-left');
								}
	
								$('html').toggleClass('g-tour-list-show'); 
								return false;
							});
							/* Close list if out click */
							$(document).on('click.iguiderbtn',function(e){
								if(!$(e.target).is('.iguider-btn') && !$('.iguider-btn').find(e.target).length){
									$('html').removeClass('g-tour-list-show');
								}
							});
							//create start event for list items
							$(document).on('click','.tourlist-item',function(){
								var tItem = $(this);
								var id = parseFloat(tItem.attr('id'));
								iGuider(data[id]);
								return false;
							});	
						}else{
							//create button
							$.iGuiderBtnAdd();
							//create start event for button
							$(document).on('click','.iguider-btn',function(){
								iGuider(data[0]);
							});
						}
					}else{
						console.log('Options array is empty');
					}
					
				}else{
					//Object
					//create button
					$.iGuiderBtnAdd();
					//create start event for button
					$(document).on('click','.iguider-btn',function(){
						iGuider(data);
					});
					
				}
				}else{
				console.log('Parameters passed in wrong format');
			} 
		},
		
		set:function(data){
			if(!$.iGuiderSet){
				$.iGuiderSet = {};
			}
			if(typeof data == 'object'){				
				if(Array.isArray(data)){
					//Array
					if(data.length > 0){
						for(var i = 0; i < data.length; i++){
							var dataItem = data[i];
							var dataItemId = dataItem.tourID;
							if(dataItemId){
								$.iGuiderSet[dataItemId] = dataItem;
							}
						}
					}else{
						console.log('Options array is empty');
					}
				}else{
					//Object
					var tourId = data.tourID;
					if(tourId){
						$.iGuiderSet[tourId] = data;
					}					
				}
			}else{
				console.log('Parameters passed in wrong format');
			} 
		},
		
		run:function(id){
			if($.iGuiderSet){
				var optItem = $.iGuiderSet[id];
				if(optItem){
					iGuider('destroy');
					iGuider(optItem);
				}
			}else{
				console.log('The parameter set is missing');
			}
			
		},
		
		setTitle: function(text){
			$('.g-modal-header').html(text);
			$('.g-step-item.hCur .g-step-item-text').html(text);
		},
		
		setContent: function(text){
			$('.g-modal-body').html(text);
		},
		       
        /**/
        /*Destroe Method*/
        /**/
        destroy: function (arg) {
            if($.iGuider && $.iGuider.opt){
				clearTimeout($.iGuider.v.storageDetectId);
                clearTimeout($.iGuider.v.stepTimerId);
				clearTimeout($.iGuider.v.messageErrorId);
				clearTimeout($.iGuider.v.delayAfterId);
				clearTimeout($.iGuider.v.delayBeforeId);
				clearTimeout($.iGuider.v.changeDelayId);
				
				$.iGuider.v.modalPos.stop(true);
				$.iGuider.v.modalTimer.stop(true);
				$.iGuider.v.scrollDoc.stop(true);
				
                
				localStorage.removeItem('iGuider_event');
				localStorage.removeItem('iGuider_restored');
				localStorage.removeItem('iGuider_opt');
				localStorage.removeItem('iGuider_step');
                localStorage.removeItem('iGuider_go');
				localStorage.removeItem('iGuider_timer');
				
				$('#timerColorStyle').remove();
				$('#btnColorStyle').remove();
				$('#btnHoverColorStyle').remove();
				
				
				$('#listBtnColorStyle').remove();
				$('#listBtnHoverColorStyle').remove();
				$('#itemNumColorStyle').remove();
				$('#itemColorStyle').remove();
				$('#itemHoverColorStyle').remove();
				$('#itemActiveColorStyle').remove();
				$('#itemActiveBgStyle').remove();
				$('#checkColorStyle').remove();
				$('#checkReadyColorStyle').remove();
				$('#paginationColorStyle').remove();
				
                $.iGuider.goFlag = false;
                $.iGuider.v.timeSave = false;
                
                $('.iGuider-highlight').removeClass('iGuider-highlight');
                $('html').removeAttr('data-g-stepid');
				$('html').removeAttr('data-g-step');
                /**/
                /*Return style*/
                /**/
                $('html').removeClass('g-map-open');
                $('html').removeClass('hNav-disable');
                $('html').removeClass('g-map-no-clickable');
                $('html').removeClass('g-modal-step-num-show g-modal-step-num-hide');
                $('html').removeClass('g-modal-prev-show g-modal-prev-hide');
                $('html').removeClass('g-modal-next-show g-modal-next-hide');
				
				$('html').removeClass('g-modal-timer-line g-modal-timer-circle');
				$('html').removeClass('g-modal-close-show g-modal-close-hide');
				$('html').removeClass('g-state-play g-state-pause');
				$('html').removeClass('g-modal-title-show g-modal-title-hide');
				$('html').removeClass('g-modal-cont-show g-modal-cont-hide');
				$('html').removeClass('g-modal-continue-show g-modal-continue-hide');
				$('html').removeClass('g-timer-hide g-timer-show');
				$('html').removeClass('g-modal-map-show g-modal-map-hide');
				$('html').removeClass('g-modal-intro-show g-modal-intro-hide');
				$('html').removeClass('g-modal-cover-show g-modal-cover-hide');
				$('html').removeClass('g-modal-step-show g-modal-step-hide');
				$('html').removeClass('g-timer-progress-show g-timer-progress-hide');
				$('html').removeClass('g-tour-list-right g-tour-list-left');

                $('[data-uid]').removeAttr('data-uid');

                /**/
                /*Delete plugin elements*/
                /**/
				$($.iGuider.v.gLoader).remove();
                $($.iGuider.v.modalPos).remove();
                $($.iGuider.v.overlays).remove();
                $($.iGuider.v.gMapContent).remove();
                $($.iGuider.v.gMapPos).remove();
                $($.iGuider.v.introDialog).remove();
                $('#g-overlay-wrap').remove();
				
                
                /**/
                /*Clear Canvas*/
                $.iGuider.v.deleteOverlayLayer();
                /**/
                
                /**/
                /*Events off*/
                /**/
				$(document).off('click','.g-timer-controll');
                $(document).off('click','.g-modal-begin-first');
                $(document).off('click','.g-modal-begin-continue');
                $(document).off('click','.g-modal-next');
                $(document).off('click','.g-modal-prev');
                $(document).off('click','.g-modal-start');
                $(document).off($.iGuider.v.clickEvent+'.iGuider');
                $(document).off('mouseenter.iGuider','.iGuider-highlight');
				$(document).off('mousemove.iGuider','.iGuider-highlight');
                $(document).off('mouseenter.iGuider','.g-shape');
                $(window).off('resize.iGuider');
                $(window).off('scroll.iGuider');
                $(document).off('mouseenter.iGuider','.gWidget, .g-shape, .iGuider-highlight');
                $(document).off('mouseleave.iGuider','.gWidget, .g-shape, .iGuider-highlight'); 

				
				
                if($.iGuider.opt.steps[$.iGuider.v.startIndex]){
                    if($.iGuider.v.targetEl){
                        $.iGuider.v.targetEl.off($.iGuider.opt.steps[$.iGuider.v.startIndex].event+'.iGuider');
                    }
                }

                $(document).off($.iGuider.v.customEvent+'.iGuider',$.iGuider.v.customTargetSelector);
                
                if($.iGuider.v.customTargetSelector){
                    $($.iGuider.v.customTargetSelector).off($.iGuider.v.customEvent+'.iGuider');
                }
                
                $(document).off('click','.g-modal-close');
                $.iGuider.v.hHide.off('click');
				$.iGuider.v.hToggle.off('click');
                $(document).off('click','.hOverlay');
                $(document).off('click','[data-hindex]');
                $(document).off('keydown.iGuider');
                $.iGuider.v.modalMap.off('click');
                $.iGuider.v = null;
                /**/
                /*Delete data*/
                /**/
                if(!arg){
					if($.iGuider.opt.debug){
						console.log('All plugin data is destroyed.');							
					}
					$.iGuider.opt = null;
                    delete $.iGuider;
                }
            }else{
                console.log('Warning! \nDetected call of method Destroy for an element that is not associated with plugin. Check the code!');    
            }
        }
    };
    $.fn.iGuider = function (method) {		
		if (typeof(Storage) !== 'undefined'){
			if (methods[method]) {
				return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
			} else if (typeof method === 'object' || !method) {
				if(Array.isArray(method)){
					return methods.set.apply(this, arguments);
				}else{
					return methods.init.apply(this, arguments);
				}
			} else {
				$.error("Method " + method + " in jQuery.iGuider doesn't exist");
			}
		}else{
			console.log('Sorry! No Web Storage support.');
		}
    };
    iGuider = $.fn.iGuider;

    $(window).on('load',function(){
		$(document).on('click','[data-iguider]',function(){
			var tourID = $(this).attr('data-iguider');
			iGuider('run', tourID);
		});
		
		var escapeRe = function (value) {
			return value.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&"); 
		};

        if (typeof(Storage) !== 'undefined'){
            if(localStorage){
                if(localStorage.getItem('iGuider_go')){
                    if(!$.iGuider){
                        $.iGuider = {};
                    }
					if(!$.iGuider.v){
                        $.iGuider.v = {};
                    }
                    $.iGuider.goFlag = true;
                    $.iGuider.v.iGuider_go = $.parseJSON(localStorage.getItem('iGuider_go'));
                    var opt = $.iGuider.v.iGuider_go.opt;
					$.fn.iGuider(opt);
                }else{			
					if(localStorage.getItem('iGuider_event') == 'start' && localStorage.getItem('iGuider_opt')){
						
						console.log('Interrupted tour detected.');
						
						if(!$.iGuider){
							$.iGuider = {};
						}
						var temp_opt = $.parseJSON(localStorage.getItem('iGuider_opt'));
						var restoreObject = temp_opt.opt;

						localStorage.setItem('iGuider_restored','1');
						var targetIndex = parseFloat(localStorage.getItem('iGuider_step'));
						var continueObj = $.extend(restoreObject,{startStep:targetIndex});

						/*NEW*/
						var nowLoc = location.href;
						var targetLoc = nowLoc;					
						/**/
						/*Check presence of next step */
						/**/
						if((targetIndex-1) < continueObj.steps.length){
							targetLoc = continueObj.steps[targetIndex-1].loc; 
							if(continueObj.debug){
								console.log('Recovery step title: '+continueObj.steps[targetIndex-1].title);
								console.log('Recovery step loc: '+targetLoc);
							}
						}
						
						targetLoc = targetLoc.split('?')[0];
						
						/*START PAST 7*/
						if(!$.iGuider){
							$.iGuider = {};
						}
						if(!$.iGuider.v){
							$.iGuider.v = {};
						}
						$.iGuider.v.compareLoc7 = function(nowLoc7){
							if(nowLoc7 !== targetLoc){
								localStorage.setItem('iGuider_event','abort');
								localStorage.setItem('iGuider_restored','0');
								localStorage.removeItem('iGuider_opt');
								localStorage.removeItem('iGuider_step');
							}else{                                
								$.fn.iGuider(continueObj);	
							}	
						};
						
						if(!continueObj.baseurl){
							/*only for absolute path URL*/
							$.iGuider.v.compareLoc7(nowLoc);
						}else{
							/*only for relative path URL*/
							var relativeNowLoc = nowLoc.split(continueObj.baseurl)[1].split('#')[0];
							$.iGuider.v.compareLoc7(relativeNowLoc);
						}
						/*END PAST*/
						
					}	
				}
            }                    
        }else{
			console.log('Sorry! No Web Storage support.');
		}
    });
})(jQuery);