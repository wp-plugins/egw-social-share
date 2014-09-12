<?php
if ( !class_exists('EGW_Social_btn_display' ) ):
class EGW_Social_btn_display {
  function __construct() {
    add_filter( 'the_content', array( $this, 'the_content' ) );
	add_filter( 'the_excerpt', array( $this, 'the_content' ) );
	add_action('wp_enqueue_scripts', array( $this, 'enqueue_scripts' ));
	add_action( 'template_redirect', array( $this, 'getTemplate' ), 5 );
	 add_action('wp_head', array( $this, 'hook_javascript' ));
	 add_shortcode('egwSocialShare',array( $this, 'egw_social_share' ));
  }
 
  function the_content($content) {
		global $post;
		$options=get_option(EGWGENERALSETTING);
		if ($options['pagename']!="" && in_array( $post->post_type, $options['pagename']) && $_GET['print']=="") {
			$output=$this->display_social_btn_box();
			if (is_home() && !empty($options['sections']['home'])){
				if(get_post_meta(get_the_id(), EGWEHIDESPECIFIC, true )==1 && $options['specific_post']=='on')
					return $content;
				if($options['position']=='top')
					return $output.$content;
				if($options['position']=='bottom')
					return $content.$output;
				if($options['position']=='both')
					return $output.$content.$output;
			}
			if (is_single() && !empty($options['sections']['single'])){
				if(get_post_meta(get_the_id(), EGWEHIDESPECIFIC, true )==1 && $options['specific_post']=='on')
					return $content;
				if($options['position']=='top')
					return $output.$content;
				if($options['position']=='bottom')
					return $content.$output;
				if($options['position']=='both')
					return $output.$content.$output;
			}
			if (is_page() && !empty($options['sections']['pages'])){
				if(get_post_meta(get_the_id(), EGWEHIDESPECIFIC, true )==1 && $options['specific_post']=='on')
					return $content;
				if($options['position']=='top')
					return $output.$content;
				if($options['position']=='bottom')
					return $content.$output;
				if($options['position']=='both')
					return $output.$content.$output;
			}
			if (is_category() && !empty($options['sections']['categories'])){
				if(get_post_meta(get_the_id(), EGWEHIDESPECIFIC, true )==1 && $options['specific_post']=='on')
					return $content;
				if($options['position']=='top')
					return $output.$content;
				if($options['position']=='bottom')
					return $content.$output;
				if($options['position']=='both')
					return $output.$content.$output;
			}
			if (is_tag() && !empty($options['sections']['tags'])){
				if(get_post_meta(get_the_id(), EGWEHIDESPECIFIC, true )==1 && $options['specific_post']=='on')
					return $content;
				if($options['position']=='top')
					return $output.$content;
				if($options['position']=='bottom')
					return $content.$output;
				if($options['position']=='both')
					return $output.$content.$output;
			}
			if (is_author() && !empty($options['sections']['author_archives'])){
				if(get_post_meta(get_the_id(), EGWEHIDESPECIFIC, true )==1 && $options['specific_post']=='on')
					return $content;
				if($options['position']=='top')
					return $output.$content;
				if($options['position']=='bottom')
					return $content.$output;
				if($options['position']=='both')
					return $output.$content.$output;
			}
			if (is_search() && !empty($options['sections']['search_results'])){
				if(get_post_meta(get_the_id(), EGWEHIDESPECIFIC, true )==1 && $options['specific_post']=='on')
					return $content;
				if($options['position']=='top')
					return $output.$content;
				if($options['position']=='bottom')
					return $content.$output;
				if($options['position']=='both')
					return $output.$content.$output;
			}
			if (is_date() && !empty($options['sections']['archives'])){
				if(get_post_meta(get_the_id(), EGWEHIDESPECIFIC, true )==1 && $options['specific_post']=='on')
					return $content;
				if($options['position']=='top')
					return $output.$content;
				if($options['position']=='bottom')
					return $content.$output;
				if($options['position']=='both')
					return $output.$content.$output;
			}
			return $content;
			
		}else{
			return $content;
		}
		
  }
	function display_social_btn_box($style=NULL,$effect=NULL){
		$html='';
		$options=get_option(EGWGENERALSETTING);
		$btn_options=get_option(EGWSOCIALBTN); 
		$effects=get_option(EGWEFFECTS);
		$url=wp_get_shortlink(get_the_ID());
		$title=get_the_title();
		 if(get_the_post_thumbnail($post->ID, 'thumbnail')) {
			 $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', '' );
			 $src = $src[0];
		 }
		 $link = add_query_arg( 'print', 1, get_permalink() );
		 if($style!=""){$btn_options['button_style']='item_'.$style;}
		 if($effect!=""){$effects=$effect;}else{$effects=$effects['btn_effect'];}
		
		$class="egw_btn ".$btn_options['button_style'].' egw_effect_'.$effects;
		$btn=$btn_options['egw_button_options'];
		if($options['share_type']=='popup'){
			$click='onclick="centeredPopup(this.href);return false"';
		}
	
		if($style==4 ||$style==5 ||$style==6){
			$paddding='style="padding:3px;"';	
		}
		
		if($btn['facebook']!="")
		$html .='<li '.$paddding.'><a target="_blank" id="facebook" class="'.$class.'" rel="nofollow"
					 href="http://www.facebook.com/sharer.php?u='.$url.'&amp;title='.$title.'" '.$click.'><span></span></a></li>';
		if($btn['twitter']!="")
		$html .='<li '.$paddding.'><a target="_blank" id="twitter" class="'.$class.'" rel="nofollow"
					 href="https://twitter.com/share?url='.$url.'&amp;text='.$title.'" '.$click.'><span></span></a></li>';	
		if($btn['linkedin']!="")
		$html .='<li '.$paddding.'><a target="_blank" id="linkedin" class="'.$class.'" rel="nofollow"
					 href="http://www.linkedin.com/shareArticle?url='.$url.'&title='.$title.'" '.$click.'><span></span></a></li>';	
		if($btn['google']!="")
		$html .='<li '.$paddding.'><a target="_blank" id="google" class="'.$class.'" rel="nofollow"
				href="https://plus.google.com/share?url='.$url.'" '.$click.'><span></span></a></li>';
		if($btn['pinterest']!="")
		$html .='<li '.$paddding.'><a target="_blank" id="pinterest" class="'.$class.'" rel="nofollow"
				href="https://pinterest.com/pin/create/bookmarklet/?media='.$src[0].'&amp;url='.$url.'&amp;description='.$title.'" '.$click.'><span></span></a></li>';
		if($btn['digg']!="")
		$html .='<li '.$paddding.'><a target="_blank" id="digg" class="'.$class.'" rel="nofollow"
				href="http://digg.com/submit?url='.$url.'&amp;title='.$title.'" '.$click.'><span></span></a></li>';
		if($btn['buffer']!="")
		$html .='<li '.$paddding.'><a target="_blank" id="buffer" class="'.$class.'" rel="nofollow"
				href="http://bufferapp.com/add?text='.$title.'&amp;url='.$url.'" '.$click.'><span></span></a></li>';
		if($btn['delicious']!="")
		$html .='<li '.$paddding.'><a target="_blank" id="delicious" class="'.$class.'" rel="nofollow"
				href="https://delicious.com/save?v=5&noui&jump=close&url='.$url.'&amp;title='.$title.'" '.$click.'><span></span></a></li>';
		if($btn['reddit']!="")
		$html .='<li '.$paddding.'><a target="_blank" id="reddit" class="'.$class.'" rel="nofollow"
				href="http://reddit.com/submit?url='.$url.'&amp;title='.$title.'" '.$click.'><span></span></a></li>';
		if($btn['stumbleupon']!="")
		$html .='<li '.$paddding.'><a target="_blank" id="stumbleupon" class="'.$class.'" rel="nofollow"
				href="http://www.stumbleupon.com/submit?url='.$url.'&amp;title='.$title.'" '.$click.'><span></span></a></li>';
		if($btn['tumblr']!="")
		$html .='<li '.$paddding.'><a target="_blank" id="tumblr" class="'.$class.'" rel="nofollow"
				href="http://www.tumblr.com/share/link?url='.$url.'&amp;name='.$title.'" '.$click.'><span></span></a></li>';
		if($btn['e_mail']!="")
		$html .='<li '.$paddding.'><a target="_blank" id="e_mail" class="'.$class.'" rel="nofollow"
				href="mailto:?subject='.$title.'&amp;body='.$url.'" ><span></span></a></li>';
		if($btn['print']!="")
		$html .='<li '.$paddding.'><a target="_blank" id="print" class="'.$class.'" rel="nofollow"
				href="'.$link.'" '.$click.'><span></span></a></li>';	
												
		return  '<div class="egw_social_share_box"><ul>'.$html.'</ul><div style="clear:both"></div></div>';
	}
	
	
	function enqueue_scripts(){
		wp_register_style('egw-social-share', plugins_url('/css/egw_social.css', __FILE__), false, '1.0', false);
		wp_enqueue_style('egw-social-share');
		wp_register_style('egw-dynamic-social-css', plugins_url('/css/egw_social.php', __FILE__), false, '1.0', false);
		wp_enqueue_style('egw-dynamic-social-css');
	}

	function getTemplate()
	{
		if ( $_GET['print']!=""&&$_GET['print']) {
			include( plugin_dir_path( __FILE__ ) . 'print/print.php' );
			exit();
		}
	}
	
	function hook_javascript(){
		$options=get_option(EGWGENERALSETTING);
		if($options['share_type']=='popup'){
		echo "<script language='javascript'>
			var popupWindow = null;
			function centeredPopup(url){
				LeftPosition = (screen.width) ? (screen.width-700)/2 : 0;
				TopPosition = (screen.height) ? (screen.height-350)/2 : 0;
				settings =
				'height=350,width=700,top='+TopPosition+',left='+LeftPosition+',scrollbars=yes,resizable'
				popupWindow = window.open(url,'EGW_share_Window',settings)
			}
		</script>";
		}
	}
	function egw_social_share($atts){
		extract(shortcode_atts(array(
	      'style'=>'1',
		  'effect'=>'2'

     ), $atts));

	return $this->display_social_btn_box($style,$effect);
	}

}
$social_btn_display=new EGW_Social_btn_display();
endif;
?>