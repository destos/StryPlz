jQuery(document).ready(function($) {
	
	// --------------------------------------------------------
	// 
	//
	
	$('.story').each(function(){
	
		var $story = $(this);
		var $bar = $( '.info-bar', $story );
		var $parts_list = $bar.append(document.createElement('ul')).find('ul');
		var info = $story.data('info');
		
		//console.log(info);
		// create blank part points
		var i;
		
		for (i = 0; i < info.turns; ++i)  {
			$parts_list.append(document.createElement('li'));
		}
		
		var $dots = $parts_list.find('li');
		
		var $parts = $( 'p > span', $story );
		
		$parts.each(function( part_index ){
		
			var $cur_part = $dots.eq(part_index);
			var part_info = $parts.eq(part_index).data('info');
			
			$cur_part.addClass('has_part').attr({ 'data-tip': "added "+part_info.relative+" ago" , 'data-tip-grav': 'sw'})
			.hover(function(){
				$parts.eq(part_index).addClass('hov');
			},function(){
				$parts.eq(part_index).removeClass('hov');
			});
			
			
		});
		
	});
	
	
	// --------------------------------------------------------
	// 
	//
	
	var tipsy_options = {
		fade: false,
		title: 'data-tip',
		fallback: "couldn't get tip text",
		html: true,
		live: true,
		//gravity: $.fn.tipsy.autoWE
		trigger: 'hover'
	};
		
	// apply tipsy to all items with the data tip attribute
	$('[data-tip]').tipsy( tipsy_options );
	
});

(function($){

	$.fn.tipsy.elementOptions = function(ele, options) {
			
		var is_input = $(ele).is('input');
		
		var binder   = options.live ? 'live' : 'bind',
        eventIn  = !is_input ? 'mouseenter' : 'focus',
        eventOut = !is_input ? 'mouseleave' : 'blur';
    
	  return $.extend({}, options, {
			gravity: $(ele).attr('data-tip-grav') || $.fn.tipsy.autoWE
		});
	
	};
	
})(jQuery);
