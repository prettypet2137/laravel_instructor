/* Template "neon" for iGuider plugin. */

//Modal window template
modalTpl =						
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
	
'</div>'

//Tour Map template
mapTpl =  							
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
'</div>'