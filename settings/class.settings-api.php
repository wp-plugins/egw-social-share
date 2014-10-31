<?php
if ( !class_exists( 'EGW_Settings_API' ) ):
class EGW_Settings_API {

    /**
     * settings sections array
     *
     * @var array
     */
    private $settings_sections = array();

    /**
     * Settings fields array
     *
     * @var array
     */
    private $settings_fields = array();

    /**
     * Singleton instance
     *
     * @var object
     */
    private static $_instance;

    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		
    }

    /**
     * Enqueue scripts and styles
     */
    function admin_enqueue_scripts() {
       wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_style( 'thickbox' );
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'media-upload' );
		wp_register_script( 'fancyfields-js', plugins_url( '/js/fancyfields.js', __FILE__ ),true );
		wp_enqueue_script( 'fancyfields-js' );
		wp_enqueue_style( 'egw_stylesheet', plugins_url( '/css/fancyfields.css', __FILE__ ) );
		wp_enqueue_style( 'egwSocialShare_stylesheet', plugins_url( '/css/admin.css', __FILE__ ) );
		wp_enqueue_style( 'egwSocialShare_effects', plugins_url( '/css/effects.css', __FILE__ ) );
		
		wp_register_script( 'common-js', plugins_url( '/js/egw-common.js', __FILE__ ),true );
		wp_enqueue_script( 'common-js',true);
		
		
    }

    /**
     * Set settings sections
     *
     * @param array   $sections setting sections array
     */
    function set_sections( $sections ) {
        $this->settings_sections = $sections;

        return $this;
    }

    /**
     * Add a single section
     *
     * @param array   $section
     */
    function add_section( $section ) {
        $this->settings_sections[] = $section;

        return $this;
    }

    /**
     * Set settings fields
     *
     * @param array   $fields settings fields array
     */
    function set_fields( $fields ) {
        $this->settings_fields = $fields;

        return $this;
    }

    function add_field( $section, $field ) {
        $defaults = array(
            'name' => '',
            'label' => '',
            'desc' => '',
            'type' => 'text'
        );

        $arg = wp_parse_args( $field, $defaults );
        $this->settings_fields[$section][] = $arg;

        return $this;
    }

    /**
     * Initialize and registers the settings sections and fileds to WordPress
     *
     * Usually this should be called at `admin_init` hook.
     *
     * This function gets the initiated settings sections and fields. Then
     * registers them to WordPress and ready for use.
     */
    function admin_init() {
        //register settings sections
        foreach ( $this->settings_sections as $section ) {
            if ( false == get_option( $section['id'] ) ) {
                //add_option( $section['id'] );
            }

            if ( isset($section['desc']) && !empty($section['desc']) ) {
                $section['desc'] = '<div class="inside">'.$section['desc'].'</div>';
                $callback = create_function('', 'echo "'.str_replace('"', '\"', $section['desc']).'";');
            } else {
                $callback = '__return_false';
            }

            add_settings_section( $section['id'], $section['title'], $callback, $section['id'] );
        }

        //register settings fields
        foreach ( $this->settings_fields as $section => $field ) {
            foreach ( $field as $option ) {

                $type = isset( $option['type'] ) ? $option['type'] : 'text';

                $args = array(
                    'id' => $option['name'],
                    'desc' => isset( $option['desc'] ) ? $option['desc'] : '',
                    'name' => $option['label'],
                    'section' => $section,
                    'size' => isset( $option['size'] ) ? $option['size'] : null,
                    'options' => isset( $option['options'] ) ? $option['options'] : '',
                    'std' => isset( $option['default'] ) ? $option['default'] : '',
                    'sanitize_callback' => isset( $option['sanitize_callback'] ) ? $option['sanitize_callback'] : '',
                );
                add_settings_field( $section . '[' . $option['name'] . ']', $option['label'], array( $this, 'callback_' . $type ), $section, $section, $args );
            }
        }

        // creates our settings in the options table
        foreach ( $this->settings_sections as $section ) {
            register_setting( $section['id'], $section['id'], array( $this, 'sanitize_options' ) );
        }
    }

    /**
     * Displays a text field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_text( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

        $html = sprintf( '<input type="text" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
        $html .= sprintf( '<span class="description"> %s</span>', $args['desc'] );

        echo $html;
    }
	 function callback_text_disabled( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

        $html = sprintf( '<input type="text" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s" disabled="disabled"/>', $size, $args['section'], $args['id'], $value );
        $html .= sprintf( '<span class="description"> %s</span>', $args['desc'] );
 		$html .= sprintf( '<span class="description" style="color:#F00"> Unlock premium options by upgrading to a PRO version. <a href="http://www.codegrape.com/item/wordpress-css3-animation-social-share-plugins/3003?ref=proscriptsell" target="_blank">buy now only at $5</a></span>');
        echo $html;
    }
	 /**
     * Displays a text field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_readonly( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

        $html = sprintf( '<input type="text" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s" readonly="readonly" style="width:320px;"/>', $size, $args['section'], $args['id'], $value );
        $html .= sprintf( '<span class="description"> %s</span>', $args['desc'] );

        echo $html;
    }


    /**
     * Displays a checkbox for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_checkbox( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );

        $html = sprintf( '<input type="hidden" name="%1$s[%2$s]" value="off" />', $args['section'], $args['id'] );
        $html .= sprintf( '<input type="checkbox" class="checkbox" id="%1$s[%2$s]" name="%1$s[%2$s]" value="on"%4$s />', $args['section'], $args['id'], $value, checked( $value, 'on', false ) );
        $html .= sprintf( '<label for="%1$s[%2$s]"> %3$s</label>', $args['section'], $args['id'], $args['desc'] );

        echo $html;
    }
	 function callback_checkbox_disabled( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );

        $html = sprintf( '<input type="hidden" name="%1$s[%2$s]" value="off" />', $args['section'], $args['id'] );
        $html .= sprintf( '<input type="checkbox" class="checkbox" id="%1$s[%2$s]" name="%1$s[%2$s]" value="on"%4$s disabled="disabled" />', $args['section'], $args['id'], $value, checked( $value, 'on', false ) );
        $html .= sprintf( '<label for="%1$s[%2$s]"> %3$s</label>', $args['section'], $args['id'], $args['desc'] );
 		 $html .= sprintf( '<span class="description" style="color:#F00"> Unlock premium options by upgrading to a PRO version. <a href="http://www.codegrape.com/item/wordpress-css3-animation-social-share-plugins/3003?ref=proscriptsell" target="_blank">buy now only at $5</a></span>');
        echo $html;
    }

    /**
     * Displays a multicheckbox a settings field
     *
     * @param array   $args settings field args
     */
    function callback_multicheck( $args ) {

        $value = $this->get_option( $args['id'], $args['section'], $args['std'] );

        $html = '<div style="width:60%;">';
        foreach ( $args['options'] as $key => $label ) {
            $checked = isset( $value[$key] ) ? $value[$key] : '1';
		
            $html .= sprintf( '<div class="multiwrp"><input type="checkbox" class="checkbox" id="%1$s[%2$s][%3$s]" name="%1$s[%2$s][%3$s]" value="%3$s"%4$s />', $args['section'], $args['id'], $key, checked( $checked, $key, false ) );
            $html .= sprintf( '<label for="%1$s[%2$s][%4$s]"> %3$s</label></div>', $args['section'], $args['id'], $label, $key );
        }
        $html .= sprintf( '<span class="description"> %s</label>', $args['desc'] );

        echo $html.'</div>';
    }
	

	
	function callback_multicheck_pro( $args ) {

        $value = $this->get_option( $args['id'], $args['section'], $args['std'] );

        $html = '<div style="width:60%;" disabled="disabled">';
        foreach ( $args['options'] as $key => $label ) {
            $checked = isset( $value[$key] ) ? $value[$key] : '1';
		
            $html .= sprintf( '<div class="multiwrp"><input type="hidden" value="%3$s"%4$s" name="%1$s[%2$s][%3$s]" />
			<input checked="checked" disabled="disabled" type="checkbox" class="checkbox" id="%1$s[%2$s][%3$s]" name="%1$s[%2$s][%3$s]" value="%3$s"%4$s />', $args['section'], $args['id'], $key, checked( $checked, $key, false ) );
            $html .= sprintf( '<label for="%1$s[%2$s][%4$s]"> %3$s</label></div>', $args['section'], $args['id'], $label, $key );
        }
        $html .= sprintf( '<span class="description"> %s</label>', $args['desc'] );
 $html .='<div style="clear:both"></div><span class="description" style="color:#F00"> Unlock premium options by upgrading to a PRO version. <a href="http://www.codegrape.com/item/wordpress-css3-animation-social-share-plugins/3003?ref=proscriptsell" target="_blank">buy now only at $5</a></span></div>';
        echo $html.'</div>';
		
    }
	
	
	
	 
 	/**
     * Displays a multicheckbox a settings field
     *
     * @param array   $args settings field args
     */
    function callback_buttoneffect( $args ) {

        $value = $this->get_option( $args['id'], $args['section'], $args['std'] );
		$options=get_option(EGWSOCIALBTN);
		$btnstyle=isset($options['button_style'])?$options['button_style']:'';
		
        $html = '';
		$i=0;
        foreach ( $args['options'] as $key => $label ) {
			$i++;
			if($i==1){
            $html .= sprintf( '<div class="btn_effect"><input type="radio" class="radio" id="%1$s[%2$s][%3$s]" name="%1$s[%2$s]" value="%3$s"%4$s />', $args['section'], $args['id'], $key, checked( $value, $key, false ) );
			}else{
				 $html .= sprintf( '<div class="btn_effect"><input type="radio" class="radio" id="%1$s[%2$s][%3$s]" name="%1$s[%2$s]" value="%3$s"%4$s  disabled="disabled" />', $args['section'], $args['id'], $key, checked( $value, $key, false ) );
			}
				if($i==6){
					 $html .= '<ul>
					 	<li><div id="facebook" class="egw_icon_btn effect_item_'.$key.' '.$btnstyle.'">
							<div class="ch-info '.$btnstyle.'">
							</div>
						</div></li>
						<li><div id="twitter" class="egw_icon_btn effect_item_'.$key.' '.$btnstyle.'">
							<div class="ch-info '.$btnstyle.'">
							</div>
						</div></li>
						<li><div id="linkedin" class="egw_icon_btn effect_item_'.$key.' '.$btnstyle.'">
							<div class="ch-info '.$btnstyle.'">
							</div>
						</div></li>
						<li><div id="google" class="egw_icon_btn effect_item_'.$key.' '.$btnstyle.'">
							<div class="ch-info '.$btnstyle.'">
							</div>
						</div></li>
						</ul>
						';
				}else{
		   		 $html .= '<div id="facebook" class="egw_icon_btn effect_item_'.$key.' '.$btnstyle.'">
							<div class="ch-info '.$btnstyle.'">
							</div>
						</div>
						<div id="twitter" class="egw_icon_btn effect_item_'.$key.' '.$btnstyle.'">
							<div class="ch-info '.$btnstyle.'">
							</div>
						</div>
						<div id="linkedin" class="egw_icon_btn effect_item_'.$key.' '.$btnstyle.'">
							<div class="ch-info '.$btnstyle.'">
							</div>
						</div>
						<div id="google" class="egw_icon_btn effect_item_'.$key.' '.$btnstyle.'">
							<div class="ch-info '.$btnstyle.'">
							</div>
						</div>';
				}
						
			  $html .='<div style="clear:both"></div><span class="description" style="color:#F00"> Unlock premium options by upgrading to a PRO version. <a href="http://www.codegrape.com/item/wordpress-css3-animation-social-share-plugins/3003?ref=proscriptsell" target="_blank">buy now only at $5</a></span></div>';
        }
      

        echo $html;
    }
	
    /**
     * Displays a multicheckbox a settings field
     *
     * @param array   $args settings field args
     */
    function callback_radio( $args ) {

        $value = $this->get_option( $args['id'], $args['section'], $args['std'] );

        $html = '';
        foreach ( $args['options'] as $key => $label ) {
            $html .= sprintf( '<div class="multiwrp"><input type="radio" class="radio" id="%1$s[%2$s][%3$s]" name="%1$s[%2$s]" value="%3$s"%4$s />', $args['section'], $args['id'], $key, checked( $value, $key, false ) );
            $html .= sprintf( '<label for="%1$s[%2$s][%4$s]"> %3$s</label></div>', $args['section'], $args['id'], $label, $key );
        }
        $html .= sprintf( '<span class="description"> %s</label>', $args['desc'] );

        echo $html;
    }
	
 function callback_radio_free( $args ) {

        $value = $this->get_option( $args['id'], $args['section'], $args['std'] );

        $html = '';
        foreach ( $args['options'] as $key => $label ) {
            $html .= sprintf( '<div class="multiwrp"><input disabled="disabled" type="radio" class="radio" id="%1$s[%2$s][%3$s]" name="%1$s[%2$s]" value="%3$s"%4$s />', $args['section'], $args['id'], $key, checked( $value, $key, false ) );
            $html .= sprintf( '<label for="%1$s[%2$s][%4$s]"> %3$s</label></div>', $args['section'], $args['id'], $label, $key );
        }
        $html .= sprintf( '<input type="hidden" checked="checked" value="32" name="egw_social_btn[btn_size]"><span class="description"> %s</label><span class="description" style="color:#F00"> Unlock premium options by upgrading to a PRO version. <a href="http://www.codegrape.com/item/wordpress-css3-animation-social-share-plugins/3003?ref=proscriptsell" target="_blank">buy now only at $5</a></span>', $args['desc'] );

        echo $html;
    }

    /**
     * Displays a selectbox for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_select( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';
		$html = sprintf( '<div id="%2$s_%3$s">', $size, $args['section'], $args['id'] );
        $html .= sprintf( '<select class="%1$s" name="%2$s[%3$s]" id="%2$s[%3$s]">', $size, $args['section'], $args['id'] );
		$i=0;
        foreach ( $args['options'] as $key => $label ) {
			$i++;
            $html .= sprintf( '<option value="%s"%s class="item_'.$i.'">%s</option>', $key, selected( $value, $key, false ), $label );
        }
        $html .= sprintf( '</select>' );
        $html .= sprintf( '<span class="description"> %s</span>', $args['desc'] );
		$html .='</div>';
        echo $html;
    }
	
	
	 function callback_select_disabled( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';
		$html = sprintf( '<div id="%2$s_%3$s">', $size, $args['section'], $args['id'] );
        $html .= sprintf( '<select class="%1$s" name="%2$s[%3$s]" id="%2$s[%3$s]" disabled="disabled">', $size, $args['section'], $args['id'] );
		$i=0;
        foreach ( $args['options'] as $key => $label ) {
			$i++;
            $html .= sprintf( '<option value="%s"%s class="item_'.$i.'">%s</option>', $key, selected( $value, $key, false ), $label );
        }
        $html .= sprintf( '</select>' );
        $html .= sprintf( '<span class="description" style="color:#F00"> Unlock premium options by upgrading to a PRO version. <a href="http://www.codegrape.com/item/wordpress-css3-animation-social-share-plugins/3003?ref=proscriptsell" target="_blank">buy now only at $5</a></span>', $args['desc'] );
		$html .='</div>';
        echo $html;
    }

    /**
     * Displays a textarea for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_textarea( $args ) {

        $value = esc_textarea( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

	  $html = sprintf( '<textarea rows="5" cols="55" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]">%4$s</textarea>', $size, $args['section'], $args['id'], $value );
        $html .= sprintf( '<br><span class="description"> %s</span>', $args['desc'] );

        echo $html;
    }

    /**
     * Displays a textarea for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_html( $args ) {
        echo $args['desc'];
    }

    /**
     * Displays a rich text textarea for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_wysiwyg( $args ) {

        $value = wpautop( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : '500px';

        echo '<div style="width: ' . $size . ';">';

        wp_editor( $value, $args['section'] . '[' . $args['id'] . ']', array( 'teeny' => true, 'textarea_rows' => 10 ) );

        echo '</div>';

        echo sprintf( '<br><span class="description"> %s</span>', $args['desc'] );
    }

    /**
     * Displays a file upload field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_file( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';
        $id = $args['section']  . '[' . $args['id'] . ']';
        $js_id = $args['section']  . '\\\\[' . $args['id'] . '\\\\]';
        $html = sprintf( '<input type="text" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
        $html .= '<input type="button" class="button wpsf-browse" id="'. $id .'_button" value="Browse" />
        <script type="text/javascript">
        jQuery(document).ready(function($){
            $("#'. $js_id .'_button").click(function() {
                tb_show("", "media-upload.php?post_id=0&amp;type=image&amp;TB_iframe=true");
                window.original_send_to_editor = window.send_to_editor;
                window.send_to_editor = function(html) {
                    var url = $(html).attr(\'href\');
                    if ( !url ) {
                        url = $(html).attr(\'src\');
                    };
                    $("#'. $js_id .'").val(url);
                    tb_remove();
                    window.send_to_editor = window.original_send_to_editor;
                };
                return false;
            });
        });
        </script>';
        $html .= sprintf( '<span class="description"> %s</span>', $args['desc'] );

        echo $html;
    }

    /**
     * Displays a password field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_password( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

        $html = sprintf( '<input type="password" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
        $html .= sprintf( '<span class="description"> %s</span>', $args['desc'] );

        echo $html;
    }

	/**
     * Displays a multicheckbox a settings field
     *
     * @param array   $args settings field args
     */
    function callback_button_options( $args ) {
			$default_color=array(
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
			);
			$options=get_option(EGWSOCIALBTN);
			$btnstyle=isset($options['button_style'])?$options['button_style']:'';
		
       $value = $this->get_option( $args['id'], $args['section'], $args['std'] );
		
        $html = '';
		$i=0;
        foreach ( $args['options'] as $key => $label ) { $i++;
			//echo $key;
			$html .=' <fieldset class="egw_btn_wrp"><legend><b>&nbsp;'.$label.'&nbsp;</b></legend>';
            $checked = isset( $value[$key] ) ? $value[$key] : '0';
			
			 $color = isset( $value[$key.'_color'] ) ? $value[$key.'_color'] : $default_color[$key.'_color'];
            $html .= sprintf( '<input type="checkbox" class="checkbox" id="%1$s[%2$s][%3$s]" name="%1$s[%2$s][%3$s]" value="%3$s"%4$s />', $args['section'], $args['id'], $key, checked( $checked, $key, false ) );
            
			$html .= '<span class="egw_icon_btn '.$btnstyle.'" id="'.$key.'" style="background:'.$color.' ; outline-color:'.$color.'"></span>';
			 $html .= sprintf( '<input type="text" class="wp-social-icon-color-field" id="%1$s[%2$s][%3$s]" name="%1$s[%2$s][%3$s]" value="%4$s"  data-default-color="%5$s"/>',  $args['section'], $args['id'], $key.'_color',$color,$default_color[$key.'_color']);
			
			$html .='</fieldset>';
        }
        

        echo $html;
    }
	
	
    
    /**
     * Displays a Icon   Custom field for a settings field
     *007
     * @param array   $args settings field args
     */
   function callback_color( $args ) {
		
        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

        $html = sprintf( '<input type="text" class="%1$s-text wp-color-picker-field" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s" data-default-color="%5$s" />', $size, $args['section'], $args['id'], $value, $args['std'] );
        $html .= sprintf( '<span class="description" style="display:block;"> %s</span>', $args['desc'] );

        echo '<div class="hide_input">'.$html.'</div>';
    }

    /**
     * Sanitize callback for Settings API
     */
    function sanitize_options( $options ) {
        foreach( $options as $option_slug => $option_value ) {
            $sanitize_callback = $this->get_sanitize_callback( $option_slug );

            // If callback is set, call it
            if ( $sanitize_callback ) {
                $options[ $option_slug ] = call_user_func( $sanitize_callback, $option_value );
                continue;
            }

            // Treat everything that's not an array as a string
            if ( !is_array( $option_value ) ) {
                $options[ $option_slug ] = sanitize_text_field( $option_value );
                continue;
            }
        }
        return $options;
    }

    /**
     * Get sanitization callback for given option slug
     *
     * @param string $slug option slug
     *
     * @return mixed string or bool false
     */
    function get_sanitize_callback( $slug = '' ) {
        if ( empty( $slug ) )
            return false;
        // Iterate over registered fields and see if we can find proper callback
        foreach( $this->settings_fields as $section => $options ) {
            foreach ( $options as $option ) {
                if ( $option['name'] != $slug )
                    continue;
                // Return the callback name
                return isset( $option['sanitize_callback'] ) && is_callable( $option['sanitize_callback'] ) ? $option['sanitize_callback'] : false;
            }
        }
        return false;
    }

    /**
     * Get the value of a settings field
     *
     * @param string  $option  settings field name
     * @param string  $section the section name this field belongs to
     * @param string  $default default text if it's not found
     * @return string
     */
    function get_option( $option, $section, $default = '' ) {

        $options = get_option( $section );

        if ( isset( $options[$option] ) ) {
            return $options[$option];
        }

        return $default;
    }

    /**
     * Show navigations as tab
     *
     * Shows all the settings section labels as tab
     */
    function show_navigation() {
        $html = '<h2 class="nav-tab-wrapper">';
		
        foreach ( $this->settings_sections as $tab ) {
            $html .= sprintf( '<a href="#%1$s" class="nav-tab" id="%1$s-tab">%2$s</a>', $tab['id'], $tab['title'] );
        }

        $html .= '</h2>';

        echo $html;
    }

    /**
     * Show the section settings forms
     *
     * This function displays every sections in a different form
     */
    function show_forms() {
        ?>
    
        <div class="metabox-holder">
            <div class="postbox">
                <?php foreach ( $this->settings_sections as $form ) { ?>
                    <div id="<?php echo $form['id']; ?>" class="group">
                        <form method="post" action="options.php" class="egw_social_form">

                            <?php do_action( 'wsa_form_top_' . $form['id'], $form ); ?>
                            <?php settings_fields( $form['id'] ); ?>
                            <?php do_settings_sections( $form['id'] ); ?>
                            <?php do_action( 'wsa_form_bottom_' . $form['id'], $form ); ?>

                            <div style="padding-left: 10px">
                                <?php submit_button(); ?>
                            </div>
                        </form>
                       
                    </div>
                    
                <?php } ?>
            </div>
        </div>
<div class="round-block">

<div class="box"><img title="PSD to Wordpress" src="[live_url]/wp-content/themes/script-sell/images/ps.png" alt="" />
<h3>PSD to Wordpress $200 </h3>
I’m a freelance WordPress developer and web designer based in bangladesh, Dhaka. I started freelancing in 2007 and have worked for a wide range of personal clients and agencies.<br /><br />

I can make your website look and function stunning using our PSD to Wordpress Theme Conversion and Customization Services.
<br /><br />
Contact Me: &nbsp; &nbsp;  skype: proscriptsell  &nbsp; &nbsp; & &nbsp; &nbsp; email:proscriptsell@gmail.com<br />

<br /><br />
</div>
<h3>Please help me a bit  (Donate with Moneybookers)</h3>

<form action="https://www.moneybookers.com/app/payment.pl" method="post" id="myfrom" target="_blank">
<fieldset >

<input type="hidden" name="pay_to_email" value="e2getway@gmail.com">
Please enter the amount you would like to give...<br>
<input type="hidden" name="language" value="EN">
<select name="currency" size="1">
<option value="USD" selected="selected">US dollar</option>
<option value="GBP">GB pound</option>
<option value="EUR">Euro</option>
<option value="JPY">Yen</option>
<option value="CAD">Canadian $</option>
<option value="AUD">Australian $</option>
</select>
<input type="text" name="amount" value="5" size="10" />
<input type="submit" alt="Click here to make donation" value="Donate!" />
<!?lt;input type="hidden" name="amount" value="5.00?">

<input type="hidden" name="detail1_description" value="Your donations keep your blog scriptsell.net.">

<input type="hidden" name="detail1_text" value="donation to help support Development Plugin of scriptsell.net">
<br>
</fieldset>
</form>

<div class="clearfix"></div>
</div>
        <?php
    }

   

} 
endif;
