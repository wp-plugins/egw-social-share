<?php	
require_once dirname( __FILE__ ) . '/class.settings-api.php';

if ( !class_exists('EGW_Settings' ) ):
class EGW_Settings {

    private $settings_api;

    function __construct() {
        $this->settings_api = new EGW_Settings_API;
        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
		add_action( 'add_meta_boxes', array( $this, 'meta_box' ),10,1);
		add_action( 'save_post', array( $this, 'meta_save'),10,2 );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        
		add_menu_page( 'EGW Social Share', 'Social Share', 'manage_options','egw_soical_setting', array($this, 'plugin_page'),plugins_url('css/images/egw.png',__FILE__ ));

		
    }
	
	
    function get_settings_sections() {
		 //var_dump(get_option('egw_general_settings'));
        $sections = array(
            array(
                'id' =>EGWGENERALSETTING,
                'title' => __( 'General Settings', 'EGW' )
            ),
            array(
                'id' =>EGWSOCIALBTN,
                'title' => __( 'Social Buttons', 'EGW' )
            ),
            array(
                'id' =>EGWEFFECTS,
                'title' => __( 'Buttons Effect', 'wpuf' )
            )
        );
        return $sections;
    }

 /**
     * Returns all the Post fields
     *
     * @return array settings fields
     */
		function post_type_list(){
			$args = array(
				'public'   => true,
				'_builtin' => false
			);
		$post_types = get_post_types($args);
		$post_types['post']='Posts';
		$post_types['page']='Page';
		return $post_types;
		}

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
		
		
        $settings_fields = array(
            EGWGENERALSETTING => array(
			    
				array(
                    'name' => 'pagename',
                    'label' => __( 'Show buttons in these pages:', 'EGW' ),
                    'desc' => __( 'Check all those that you wish to show your share buttons.<br />Note: You can alos show/hide your button on each post', 'EGW' ),
                    'type' => 'multicheck_pro',
                    'options' =>$this->post_type_list(),
                ),
				
				array(
                    'name' => 'sections',
                    'label' => __( 'Scope:', 'EGW' ),
					'type' => 'multicheck',
                    'options' =>array( 
						'home' =>'Home page',
						'single' =>'Single posts/Page',
						'pages' =>'Pages',
						'tags' =>'Tags',
						'categories' =>'Categories',
						'author_archives' =>'Author archives', 
						'search_results' =>'Search results', 
						'archives' =>'Archives',      
					)       
                ),   
				 array(
                    'name' => 'position',
                    'label' => __( 'Choose where your bar displays', 'EGW' ),
                    'desc' => __( '', 'EGW' ),
                    'type' => 'select',
                    'default' => 'top',
                    'options' => array(
                        'top' => 'Above the post',
						'bottom' => 'Below the post',
                        'both' => 'Above and Below the post',
						
                    )
                ),
				
               array(
                    'name' => 'specific_post',
                    'label' => __( 'Page/Post Specific Social Share', 'EGW' ),
                    'desc' => __( '', 'EGW' ),
                    'type' => 'checkbox'
                ),
              
                array(
                    'name' => 'bgcolor',
                    'label' => __( 'Wrapper Background color', 'EGW' ),
                    'desc' => __( '', 'EGW' ),
                    'type' => 'color',
					 'desc' => __( 'To inactive background color, Please click on (Select Color ) button and clear color.', 'EGW' ),
                    'default' => ''
                ),
				array(
                    'name' => 'bordercolor',
                    'label' => __( 'Wrapper Border color', 'EGW' ),
                    'desc' => __( '', 'EGW' ),
                    'type' => 'color',
                    'default' => '',
					'desc' => __( 'To inactive Border color, Please click on (Select Color ) button and clear color.', 'EGW' )
                ),
				array(
                    'name' => 'border_radius',
                    'label' => __( 'Wrapper Border radius', 'EGW' ),
                    'desc' => __( 'add radius value like as 10,px will be auto load', 'EGW' ),
                    'type' => 'text',
                    'default' => '15'
                ),
				array(
                    'name' => 'bar_padding',
                    'label' => __( 'Wrapper Padding', 'EGW' ),
                    'desc' => __( 'add padding value like as 10,px will be auto load', 'EGW' ),
                    'type' => 'text',
                    'default' => '15'
                ),
			 array(
                    'name' => 'share_type',
                    'label' => __( 'Share Page Open', 'EGW' ),
                    'desc' => __( '', 'EGW' ),
                    'type' => 'select_disabled',
                    'default' => 'top',
                    'options' => array(
                        'popup' => 'Popup windows',
						'new_page' => 'New Tab Page',
                       
						
                    )
                ),
				 array(
                    'name' => 'open_graph',
                    'label' => __( 'Active open graph', 'EGW' ),
                    'desc' => __( '', 'EGW' ),
                    'type' => 'checkbox_disabled'
                ),
				 array(
                    'name' => 'readOnly',
                    'label' => __( 'Button Shortcode', 'EGW' ),
                    'desc' => __( 'Set style And effect attributes like as  [egwSocialShare style="1"] , [egwSocialShare effect="2"] , [egwSocialShare style="4" effect="2"]  ', 'EGW' ),
                    'type' => 'readonly',
					'default' => '[egwSocialShare]'
					
                )
				
				
            ),
            EGWSOCIALBTN => array(
				array(
                    'name' => 'btn_size',
                    'label' => __( 'Social Buttons Size', 'EGW' ),
                    'desc' => __( '', 'EGW' ),
                    'type' => 'radio_free',
					 'desc' => __( ' ', 'EGW' ),
					'default' => '32',
                    'options' => array(
                        '24' => '24px',
                        '32' => '32px',
						'48' => '48px',
						'64' => '64px',
						'80' => '80px',
                    )
                ),
				array(
                    'name' => 'custom_btn_size',
                    'label' => __( 'Custom Buttons Size', 'EGW' ),
                    'desc' => __( ' If you add custom button size . default button size will be inactive ,px will be auto load', 'EGW' ),
                    'type' => 'text_disabled',
                   
                ),
				 array(
                    'name' => 'button_style',
                    'label' => __( 'Choose Button Style', 'EGW' ),
                    'desc' => __( '', 'EGW' ),
                    'type' => 'select',
					'default' => 'item_1',
                    'options' => array(
                        'item_1' => 'style 1',
                        'item_2' => 'style 2',
						'item_3' => 'style 3',
						'item_4' => 'style 4',
						'item_5' => 'style 5',
						'item_6' => 'style 6'
                    )
                ),
			
			
			 array(
                    'name' => 'egw_button_options',
                    'label' => __( 'Button Options', 'EGW' ),
                    'desc' => __( '', 'EGW' ),
                    'type' => 'button_options',
					'default' => '2',
                    'options' => array(
                        'facebook' => 'Facebook',
                        'twitter' => 'Twitter',
						'linkedin' => 'linkedin',
						'google' => 'Google plus',
						'pinterest' => 'Pinterest',
						'digg' => 'Digg',
						'buffer' => 'Buffer',
						'delicious' => 'Delicious',
						'reddit' => 'Reddit',
						'stumbleupon' => 'Stumbleupon',
						'tumblr' => 'Tumblr',
						'e_mail' => 'Email',
						'print' => 'Print'
                    )
                )
            ),
			
            EGWEFFECTS => array(
             	 array(
                    'name' => 'btn_effect',
                    'label' => __( 'Choose buttons effecs', 'EGW' ),
                    'desc' => __( '', 'EGW' ),
                    'type' => 'buttoneffect',
					'default' => '1',
                    'options' => array(
                        '1' => '1',
                        '2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
						'7' => '7',
						'8' => '8',
                    )
                ),
            )
        );

        return $settings_fields;
    }

    function plugin_page() {
		
		
        echo '<div class="wrap">
		<div class="egw_header">
			<h2>EGW Social Buttons Settings</h2>
			Please  save each data after Click each tab section .
		</div>
		';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
	
    }

	/**
	 * Adds the meta box container.
	 */
	public function meta_box( $post_type ) {
         
			$post_types=array();
			$options=get_option(EGWGENERALSETTING);
			if($options['specific_post']=='on'){
				if(count($options['pagename'])>0&& $options['pagename']!=""){
					$i=0;
					foreach($options['pagename'] as $key=>$val){
						$i++;
						 $post_types[$i]=$key;
					}
				}
				if ( in_array( $post_type, $post_types )) {
					add_meta_box(
						'egw_social_share_meta_box'
						,__( 'Specific Social Share')
						,array( $this, 'render_meta_box_content' )
						,$post_type
						,'side'
						,'high'
					);
				}
			}
	}
	/**
	 * Render Meta Box content.
	 *
	 */
	public function render_meta_box_content( $post ) {
		 echo '<input type="hidden" name="mytheme_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
		 
		// Use get_post_meta to retrieve an existing value from the database.
		$value = get_post_meta( $post->ID, EGWEHIDESPECIFIC, true );
			if($value==1){
				$checked='checked="checked"';
			}else{
				$checked='';	
			}
		// Display the form, using the current value.
		echo '<input type="checkbox" name="'.EGWEHIDESPECIFIC.'" value="1" style="float:left; margin-right:10px;" '.$checked.'/>';
		_e( 'Hide social share buttons on this post / page');
		echo '<div style="clear:both"></div>';
	
	}
	function meta_save($post_id) {
		// Verify that the nonce is valid.
			global $meta_box;
		
			if (!wp_verify_nonce($_POST['mytheme_meta_box_nonce'], basename(__FILE__))) {
				return $post_id;
			}
			
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
				return $post_id;
			}
			if($_POST[EGWEHIDESPECIFIC]==1){
				update_post_meta( $post_id, EGWEHIDESPECIFIC, $_POST[EGWEHIDESPECIFIC] );
			}else{
				update_post_meta( $post_id, EGWEHIDESPECIFIC,0);
			}
			
	}
	

}
endif;

$settings = new EGW_Settings();