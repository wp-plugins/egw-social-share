<?php
if ( !class_exists('EGW_Social_meta' ) ):
class EGW_Social_meta {
	function __construct() {
		add_filter('language_attributes',array( $this, 'add_opengraph_nameser' ));
		add_action('wp_head',array( $this, 'fb_opengraph_meta' ));
	  }
	  
	  //Facebook and Open Graph nameservers
	function add_opengraph_nameser( $output ) {
		return $output . '
		xmlns:og="http://opengraphprotocol.org/schema/"
		xmlns:fb="http://www.facebook.com/2008/fbml"';
	}
	
	// Facebook Open Graph
	function fb_opengraph_meta() {
		
		 global $post;
		 if(get_the_post_thumbnail($post->ID, 'thumbnail')) {
			 $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', '' );
			 $src = $src[0];
		 } else {
			$src=$this->catch_that_image();
		 }
		 //$description = get_bloginfo('description');
		 $description = $this->my_excerpt( $post->post_content);
		 $description = strip_tags($description);
		 $description = str_replace('"', "'", $description);
		 $btn_options=get_option(EGWSOCIALBTN); 
		 $btn=$btn_options['egw_button_options'];
		 if($btn['facebook']!=""):
		?>
        <meta property="og:title" content="<?php the_title(); ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:image" content="<?php echo $src; ?>" />
        <meta property="og:url" content="<?php the_permalink(); ?>" />
        <meta property="og:description" content="<?php echo $description ?>" />
        <meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>" />
		<?php
		 endif;
		 if($btn['twitter']!=""):
		?>
        <meta name="twitter:card" content="<?php bloginfo('name'); ?>" >
        <meta name="twitter:url" content="<?php the_permalink(); ?>">
        <meta name="twitter:title" content="<?php the_title(); ?>" >
        <meta name="twitter:description" content="<?php echo $description ?>" >
        <meta name="twitter:image" content="<?php echo $src; ?>" >
        <?php
		endif;
		
	}

	function my_excerpt($content){
		$content = strip_tags($content);
		$spliting=wordwrap($content,150,'spliting');
		$split=split('spliting',$spliting);
		return $split[0];
					
	}
	function catch_that_image() {
		global $post, $posts;
		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		$first_img = $matches[1][0];
		if(empty($first_img)){
				$first_img = "/images/default.jpg";
			}
		return $first_img;
	}
}
$options=get_option(EGWGENERALSETTING);
if($options['open_graph']=='on'){
	$social_btn_display=new EGW_Social_meta();
}
endif;