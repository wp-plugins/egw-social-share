 jQuery(document).ready(function($) {
                //Initiate Color Picker
              $('.wp-color-picker-field').wpColorPicker();
				 
				 function hex2Rgb(hex){
					  var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})|([a-f\d]{1})([a-f\d]{1})([a-f\d]{1})$/i.exec(hex);
					  return result ? {        
						r: parseInt(hex.length <= 4 ? result[4]+result[4] : result[1], 16),
						g: parseInt(hex.length <= 4 ? result[5]+result[5] : result[2], 16),
						b: parseInt(hex.length <= 4 ? result[6]+result[6] : result[3], 16),
						toString: function() {
						  var arr = [];
						  arr.push(this.r-70);
						  arr.push(this.g-70);
						  arr.push(this.b-70);
						  return "rgb(" + arr.join(",") + ")";
						}
					  } : null;
					};
				  //alert(hex2Rgb('#066') );
					
				   $('.wp-social-icon-color-field').wpColorPicker({
						hide: true,
						change: function(event, ui) {
							var iconbox=$(this).parents('fieldset ').children('.egw_icon_btn');
							iconbox.css('background-color',$(this).val());
							if(iconbox.is('.item_4') || iconbox.is('.item_5') || iconbox.is('.item_6')){
								iconbox.css('outline-color',$(this).val());
							}							
						}
				  
				  });
					 function rgbtohex(rgb){
						rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
						return('rgb('+(parseInt(rgb[1],10)-70)+','+(parseInt(rgb[2],10)-70)+','+(parseInt(rgb[3],10)-70)+")");
					}
					
					$('.egw_icon_btn .ch-info').each(function() {
                    	 //$(this).css({"background-color": rgbtohex($(this).parent('.egw_icon_btn').css('background-color')}));
							$( this ).css({
								"background-color": rgbtohex($(this).parents('.egw_icon_btn').css('background-color')),
								"opacity": "0.8"
							});
                    });
					
					$('.effect_item_1').each(function() {
                    	$(this).children('.ch-info').css('outline-color',rgbtohex($(this).css('background-color')));	
                    });
					$('.effect_item_2').hover(function(){
							$(this).css({
								'-webkit-box-shadow':'inset 0px 0px 0px 19px '+rgbtohex($(this).css('background-color')),
								'-moz-box-shadow':'inset 0px 0px 0px 19px' +rgbtohex($(this).css('background-color')) ,
								'box-shadow':'inset 0px 0px 0px 19px '+rgbtohex($(this).css('background-color'))
							});	
						},function(){
							$(this).css({
								'-webkit-box-shadow':'inset 0px 0px 0px 0px '+rgbtohex($(this).css('background-color')),
								'-moz-box-shadow':'inset 0px 0px 0px 0px' +rgbtohex($(this).css('background-color')) ,
								'box-shadow':'inset 0px 0px 0px 0px '+rgbtohex($(this).css('background-color'))
							});	

						});
					$('.effect_item_4,.effect_item_5').each(function() {
                    	$(this).css({
								'-webkit-box-shadow':'0px 0px 0px 2px '+$(this).css('background-color'),
								'-moz-box-shadow':'0px 0px 0px 2px' +$(this).css('background-color') ,
								'box-shadow':'0px 0px 0px 2px '+$(this).css('background-color')
							});		
                    });
					
					$('.effect_item_7').hover(function(){
							$(this).css({
								'color':$(this).css('background-color')
							});	
						},function(){
							$(this).css({
								'color':'#fff'
							});	

						});
					
								
				//.css({ boxShadow: '1px 3px 6px #444' })
			
					
				//$('.wp-color-picker-field').colpick();
                // Switches option sections
                $('.group').hide();
                var activetab = '';
                if (typeof(localStorage) != 'undefined' ) {
                    activetab = localStorage.getItem("activetab");
                }
                if (activetab != '' && $(activetab).length ) {
                    $(activetab).fadeIn();
                } else {
                    $('.group:first').fadeIn();
                }
                $('.group .collapsed').each(function(){
                    $(this).find('input:checked').parent().parent().parent().nextAll().each(
                    function(){
                        if ($(this).hasClass('last')) {
                            $(this).removeClass('hidden');
                            return false;
                        }
                        $(this).filter('.hidden').removeClass('hidden');
                    });
                });

                if (activetab != '' && $(activetab + '-tab').length ) {
                    $(activetab + '-tab').addClass('nav-tab-active');
                }
                else {
                    $('.nav-tab-wrapper a:first').addClass('nav-tab-active');
                }
                $('.nav-tab-wrapper a').click(function(evt) {
                    $('.nav-tab-wrapper a').removeClass('nav-tab-active');
                    $(this).addClass('nav-tab-active').blur();
                    var clicked_group = $(this).attr('href');
                    if (typeof(localStorage) != 'undefined' ) {
                        localStorage.setItem("activetab", $(this).attr('href'));
                    }
                    $('.group').hide();
                    $(clicked_group).fadeIn();
                    evt.preventDefault();
                });
				
				 $(".egw_social_form td").fancyfields();
            });