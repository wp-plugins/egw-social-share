<?php
/*
Plugin Name: EGW Social Share 
Plugin URI: http://scriptsell.net/
Description:EGW CSS3 transitions Animation Social Social share buttons display on post or page or custom post,.
Author: Saif Sohel(proscriptsell@gmail.com)
Version:1.4
Author URI: http://scriptsell.net/
Tags:  Facebook, Like, LinkedIn, Share, Google, Plus, +1, Pinterest, Google+, Twitter, Tweet, Follow, StumbleUpon, Stumble, Tumblr, Delicious, Digg, Reddit, Myspace, Hyves, YouTube, button, icon, image, Share, social, social share, Social-share-button, widget, zm-tech, deaviantART, App.net, mail, Gmail, AOL, Evernote, Hotmail, Instapaper, Mail.ru, Pocket, Sonico, vkontakte, Weibo, Yahoo Mail, Yammer, RSS, feed, connect, recommend, social, sharing, widget, shortcode, page, post, button, counter, icon, bitly, Open Graph
*/

define('EGWGENERALSETTING','egw_general_settings');
define('EGWSOCIALBTN','egw_social_btn');
define('EGWEFFECTS','egw_soc_btn_effect');
define('EGWEHIDESPECIFIC','egw_specific_page');
 
/*--------- Global variable -***/


/* Function check if plugin is compatible with current WP version  */
$plugin			=	plugin_basename( __FILE__ );
if ( ! function_exists ( 'egw_version_check' ) ) {
	function egw_version_check() {
		global $wp_version, $egw_plugin_info;
		$require_wp		=	"3.0"; /* Wordpress at least requires version */
		$plugin			=	plugin_basename( __FILE__ );
		
	 	if ( version_compare( $wp_version, $require_wp, "<" ) ) {
			if ( is_plugin_active( $plugin ) ) {
				deactivate_plugins( $plugin );
				wp_die( "<strong>" . $egw_plugin_info['Name'] . " </strong> " . __( 'requires', 'gallery' ) . " <strong>WordPress " . $require_wp . "</strong> " . __( 'or higher, that is why it has been deactivated! Please upgrade WordPress and try again.', 'gallery') . "<br /><br />" . __( 'Back to the WordPress', 'egw_social_share') . " <a href='" . get_admin_url( null, 'plugins.php' ) . "'>" . __( 'Plugins page', 'egw_social_share') . "</a>." );
			}
		}
	}
}
add_action( 'admin_init', 'egw_version_check' );
/* Function check if plugin is compatible with current WP version  */
function post_type_list(){
		$args = array(
			'public'   => true,
			'_builtin' => false
		);
	$post_types = get_post_types($args);
	$post_types['post']='post';
	$post_types['page']='page';
	return $post_types;
}

// run the activation function upon acitvation of the plugin
register_activation_hook( __FILE__,'egw_social_btn_activate');
if(!function_exists(egw_social_btn_activate)):
function egw_social_btn_activate(){
	$egw_gen_set=array(
		'pagename' =>post_type_list(),
		'position'  => 'top',
		'specific_post'  =>'on',
		'bgcolor'  => '',
		'bordercolor'  => '',
		'border_radius'  => '15',
		'bar_padding'  => '15',
		'border_radius'  => '8',	
		'bar_padding'  => '10',
		'share_type'  => 'popup',
		'open_graph'  =>'on',
		'sections' =>array(
				'home' =>'home',
				'single' =>'single',
				'pages' =>'pages',
				'tags' =>'tags',
				'categories' =>'categories',
				'author_archives' =>'author_archives', 
				'search_results' =>'search_results', 
				'archives' =>'archives', 
		),
	
	);
	add_option(EGWGENERALSETTING, $egw_gen_set);
	$btn_set=array(
		'btn_size'  =>'48',	
		'button_style'  =>'item_1',
		'egw_button_options'  => array(
						'facebook' => 'facebook',
                        'twitter' => 'twitter',
						'linkedin' => 'linkedin',
						'google' => 'google',
						'pinterest' => 'pinterest',
						'digg' => 'digg',
						'buffer' => 'buffer',
						'delicious' => 'delicious',
						'reddit' => 'reddit',
						'stumbleupon' => 'stumbleupon',
						'tumblr' => 'tumblr',
						'e_mail' => 'e_mail',
						'print' => 'print',
						'facebook_color'=>'#086dd9',
						'twitter_color'=>'#00b7fa',
						'linkedin_color'=>'#4393bb',
						'google_color'=>'#f96542',
						'pinterest_color'=>'#d62d34',
						'digg_color'=>'#094883',
						'buffer_color'=>'#e60303',
						'delicious_color'=>'#3399ff',
						'stumbleupon_color'=>'#37c446',
						'reddit_color'=>'#729ac3',
						'tumblr_color'=>'#304d6b',
						'e_mail_color'=>'#dfb906',
						'print_color'=>'#bcbcbc'
		)
	);
	add_option(EGWSOCIALBTN, $btn_set);
	$effects=array('btn_effect'=>'1');
	add_option(EGWEFFECTS, $effects);
	
}
endif;

// register deactivation hook
register_uninstall_hook(__FILE__,'egw_social_btn_uninstall');
if(!function_exists(egw_social_btn_uninstall)):
function egw_social_btn_uninstall(){
	//if uninstall not called from WordPress exit
	if (defined('WP_UNINSTALL_PLUGIN')) {
		exit();
	}
	// delete all options
	delete_option(EGWGENERALSETTING);
	delete_option(EGWSOCIALBTN);
	delete_option(EGWEFFECTS);

	
}
endif;


/*Load Admin Page  */
require_once (dirname (__FILE__) . '/settings/settings.php');

/*Load frontend Funtions  */
require_once (dirname (__FILE__) . '/frontend/display.php');

/*Load frontend Funtions  */
require_once (dirname (__FILE__) . '/opengraph/opengraph.php');


?>