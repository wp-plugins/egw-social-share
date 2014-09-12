<?php
	header("Content-type: text/css");
	$absolute_path = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
	$wp_load = $absolute_path[0] . 'wp-load.php';
	require_once($wp_load);
	$options=get_option(EGWGENERALSETTING);
	$btn=get_option(EGWSOCIALBTN); 

	if(trim($btn['custom_btn_size'])!=""){
		$btn['btn_size']=$btn['custom_btn_size'];
	}
?>
.egw_social_share_box li{
	width:<?php echo $btn['btn_size']+5;?>px;
	margin-right:<?php echo ($btn['btn_size']/11);?>px!important;
}
<?php if($btn['button_style']=="item_5"||$btn['button_style']=="item_4" ||$btn['button_style']=="item_6"):?>
.egw_social_share_box li{
	padding:3px!important;
}
<?php endif;?>
<?php if($options['bgcolor']!="" || $options['bordercolor']!=""):?>
.egw_social_share_box{
		display:block;
		background:<?php echo $options['bgcolor'];?>;
		border:1px solid <?php echo $options['bordercolor'];?>;
		padding:<?php echo $options['bar_padding'];?>px;
		-webkit-border-radius:<?php echo $options['border_radius'];?>px; 
		-moz-border-radius:<?php echo $options['border_radius'];?>px;
		border-radius:<?php echo $options['border_radius'];?>px;
		margin:0px;
	}
 <?php endif;?>
.egw_btn{
		width:<?php echo $btn['btn_size'];?>px;
		height:<?php echo $btn['btn_size'];?>px;
		font-size:<?php echo ($btn['btn_size']/2)-4;?>px;
		line-height:<?php echo ($btn['btn_size']);?>px;
}
<?php if($btn['egw_button_options']['facebook']!=""):?>
#facebook.item_4,#facebook.item_5,#facebook.item_6{
        -webkit-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['facebook_color'];?>; 
        -moz-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['facebook_color'];?>;
        box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['facebook_color'];?>;
       background:<?php echo $btn['egw_button_options']['facebook_color'];?>
}
#facebook:hover span{
	 background:<?php echo hex2RGB($btn['egw_button_options']['facebook_color']);?>;
}
#facebook.egw_effect_7:hover{
	color:<?php echo $btn['egw_button_options']['facebook_color'];?>!important;
}
#facebook.egw_effect_2:hover span{
        -moz-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['facebook_color']);?>;
        -webkit-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['facebook_color']);?>;
        box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['facebook_color']);?>;
}
#facebook.item_1,#facebook.item_2,#facebook.item_3{
	background:<?php echo $btn['egw_button_options']['facebook_color'];?>;
}
<?php endif;?>

<?php if($btn['egw_button_options']['twitter']!=""):?>
#twitter.item_4,#twitter.item_5,#twitter.item_6{
        -webkit-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['twitter_color'];?>; 
        -moz-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['twitter_color'];?>;
        box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['twitter_color'];?>;
       background:<?php echo $btn['egw_button_options']['twitter_color'];?>
}
#twitter:hover span{
	 background:<?php echo hex2RGB($btn['egw_button_options']['twitter_color']);?>;
}
#twitter.egw_effect_2:hover span{
        -moz-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['twitter_color']);?>;
        -webkit-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['twitter_color']);?>;
        box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['twitter_color']);?>;
}
#twitter.egw_effect_7:hover{
	color:<?php echo $btn['egw_button_options']['twitter_color'];?>!important;
}
#twitter.item_1,#twitter.item_2,#twitter.item_3{
	background:<?php echo $btn['egw_button_options']['twitter_color'];?>;
}
<?php endif;?>
<?php if($btn['egw_button_options']['linkedin']!=""):?>
#linkedin.item_4,#linkedin.item_5,#linkedin.item_6{
        -webkit-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['linkedin_color'];?>; 
        -moz-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['linkedin_color'];?>;
        box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['linkedin_color'];?>;
       background:<?php echo $btn['egw_button_options']['linkedin_color'];?>
}
#linkedin:hover span{
	 background:<?php echo hex2RGB($btn['egw_button_options']['linkedin_color']);?>;
}
#linkedin.egw_effect_2:hover span{
        -moz-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['linkedin_color']);?>;
        -webkit-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['linkedin_color']);?>;
        box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['linkedin_color']);?>;
}
#linkedin.egw_effect_7:hover{
	color:<?php echo $btn['egw_button_options']['linkedin_color'];?>!important;
}
#linkedin.item_1,#linkedin.item_2,#linkedin.item_3{
	background:<?php echo $btn['egw_button_options']['linkedin_color'];?>;
}
<?php endif;?>
<?php if($btn['egw_button_options']['google']!=""):?>
#google.item_4,#google.item_5,#google.item_6{
        -webkit-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['google_color'];?>; 
        -moz-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['google_color'];?>;
        box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['google_color'];?>;
       background:<?php echo $btn['egw_button_options']['google_color'];?>
}
#google:hover span{
	 background:<?php echo hex2RGB($btn['egw_button_options']['google_color']);?>;
}
#google.egw_effect_2:hover span{
        -moz-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['google_color']);?>;
        -webkit-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['google_color']);?>;
        box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['google_color']);?>;
}
#google.egw_effect_7:hover{
	color:<?php echo $btn['egw_button_options']['google_color'];?>!important;
}
#google.item_1,#google.item_2,#google.item_3{
	background:<?php echo $btn['egw_button_options']['google_color'];?>;
}
<?php endif;?>
<?php if($btn['egw_button_options']['pinterest']!=""):?>
#pinterest.item_4,#pinterest.item_5,#pinterest.item_6{
        -webkit-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['pinterest_color'];?>; 
        -moz-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['pinterest_color'];?>;
        box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['pinterest_color'];?>;
       background:<?php echo $btn['egw_button_options']['pinterest_color'];?>
}
#pinterest:hover span{
	 background:<?php echo hex2RGB($btn['egw_button_options']['pinterest_color']);?>;
}
#pinterest.egw_effect_2:hover span{
        -moz-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['pinterest_color']);?>;
        -webkit-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['pinterest_color']);?>;
        box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['pinterest_color']);?>;
}
#pinterest.egw_effect_7:hover{
	color:<?php echo $btn['egw_button_options']['pinterest_color'];?>!important;
}
#pinterest.item_1,#pinterest.item_2,#pinterest.item_3{
	background:<?php echo $btn['egw_button_options']['pinterest_color'];?>;
}
<?php endif;?>
<?php if($btn['egw_button_options']['digg']!=""):?>
#digg.item_4,#digg.item_5,#digg.item_6{
        -webkit-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['digg_color'];?>; 
        -moz-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['digg_color'];?>;
        box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['digg_color'];?>;
       background:<?php echo $btn['egw_button_options']['digg_color'];?>
}
#digg:hover span{
	 background:<?php echo hex2RGB($btn['egw_button_options']['digg_color']);?>;
}
#digg.egw_effect_2:hover span{
        -moz-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['digg_color']);?>;
        -webkit-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['digg_color']);?>;
        box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['digg_color']);?>;
}
#digg.egw_effect_7:hover{
	color:<?php echo $btn['egw_button_options']['digg_color'];?>!important;
}
#digg.item_1,#digg.item_2,#digg.item_3{
	background:<?php echo $btn['egw_button_options']['digg_color'];?>;
}
<?php endif;?>
<?php if($btn['egw_button_options']['buffer']!=""):?>
#buffer.item_4,#buffer.item_5,#buffer.item_6{
        -webkit-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['buffer_color'];?>; 
        -moz-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['buffer_color'];?>;
        box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['buffer_color'];?>;
       background:<?php echo $btn['egw_button_options']['buffer_color'];?>
}
#buffer:hover span{
	 background:<?php echo hex2RGB($btn['egw_button_options']['buffer_color']);?>;
}
#buffer.egw_effect_2:hover span{
        -moz-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['buffer_color']);?>;
        -webkit-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['buffer_color']);?>;
        box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['buffer_color']);?>;
}
#buffer.egw_effect_7:hover{
	color:<?php echo $btn['egw_button_options']['buffer_color'];?>!important;
}
#buffer.item_1,#buffer.item_2,#buffer.item_3{
	background:<?php echo $btn['egw_button_options']['buffer_color'];?>;
}
<?php endif;?>
<?php if($btn['egw_button_options']['delicious']!=""):?>
#delicious.item_4,#delicious.item_5,#delicious.item_6{
        -webkit-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['delicious_color'];?>; 
        -moz-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['delicious_color'];?>;
        box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['delicious_color'];?>;
       background:<?php echo $btn['egw_button_options']['delicious_color'];?>
}
#delicious:hover span{
	 background:<?php echo hex2RGB($btn['egw_button_options']['delicious_color']);?>;
}
#delicious.egw_effect_2:hover span{
        -moz-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['delicious_color']);?>;
        -webkit-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['delicious_color']);?>;
        box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['delicious_color']);?>;
}
#delicious.egw_effect_7:hover{
	color:<?php echo $btn['egw_button_options']['delicious_color'];?>!important;
}
#delicious.item_1,#delicious.item_2,#delicious.item_3{
	background:<?php echo $btn['egw_button_options']['delicious_color'];?>;
}
<?php endif;?>
<?php if($btn['egw_button_options']['reddit']!=""):?>
#reddit.item_4,#reddit.item_5,#reddit.item_6{
        -webkit-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['reddit_color'];?>; 
        -moz-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['reddit_color'];?>;
        box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['reddit_color'];?>;
       background:<?php echo $btn['egw_button_options']['reddit_color'];?>
}
#reddit:hover span{
	 background:<?php echo hex2RGB($btn['egw_button_options']['reddit_color']);?>;
}
#reddit.egw_effect_2:hover span{
        -moz-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['reddit_color']);?>;
        -webkit-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['reddit_color']);?>;
        box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['reddit_color']);?>;
}
#reddit.egw_effect_7:hover{
	color:<?php echo $btn['egw_button_options']['reddit_color'];?>!important;
}
#reddit.item_1,#reddit.item_2,#reddit.item_3{
	background:<?php echo $btn['egw_button_options']['reddit_color'];?>;
}
<?php endif;?>
<?php if($btn['egw_button_options']['stumbleupon']!=""):?>
#stumbleupon.item_4,#stumbleupon.item_5,#stumbleupon.item_6{
        -webkit-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['stumbleupon_color'];?>; 
        -moz-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['stumbleupon_color'];?>;
        box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['stumbleupon_color'];?>;
       background:<?php echo $btn['egw_button_options']['stumbleupon_color'];?>
}
#stumbleupon:hover span{
	 background:<?php echo hex2RGB($btn['egw_button_options']['stumbleupon_color']);?>;
}
#stumbleupon.egw_effect_2:hover span{
        -moz-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['stumbleupon_color']);?>;
        -webkit-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['stumbleupon_color']);?>;
        box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['stumbleupon_color']);?>;
}
#stumbleupon.egw_effect_7:hover{
	color:<?php echo $btn['egw_button_options']['stumbleupon_color'];?>!important;
}
#stumbleupon.item_1,#stumbleupon.item_2,#stumbleupon.item_3{
	background:<?php echo $btn['egw_button_options']['stumbleupon_color'];?>;
}
<?php endif;?>
<?php if($btn['egw_button_options']['tumblr']!=""):?>
#tumblr.item_4,#tumblr.item_5,#tumblr.item_6{
        -webkit-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['tumblr_color'];?>; 
        -moz-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['tumblr_color'];?>;
        box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['tumblr_color'];?>;
       background:<?php echo $btn['egw_button_options']['tumblr_color'];?>
}
#tumblr:hover span{
	 background:<?php echo hex2RGB($btn['egw_button_options']['tumblr_color']);?>;
}
#tumblr.egw_effect_2:hover span{
        -moz-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['tumblr_color']);?>;
        -webkit-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['tumblr_color']);?>;
        box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['tumblr_color']);?>;
}
#tumblr.egw_effect_7:hover{
	color:<?php echo $btn['egw_button_options']['tumblr_color'];?>!important;
}
#tumblr.item_1,#tumblr.item_2,#tumblr.item_3{
	background:<?php echo $btn['egw_button_options']['tumblr_color'];?>;
}
<?php endif;?>

<?php if($btn['egw_button_options']['e_mail']!=""):?>
#e_mail.item_4,#e_mail.item_5,#e_mail.item_6{
        -webkit-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['e_mail_color'];?>; 
        -moz-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['e_mail_color'];?>;
        box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['e_mail_color'];?>;
       background:<?php echo $btn['egw_button_options']['e_mail_color'];?>
}
#e_mail:hover span{
	 background:<?php echo hex2RGB($btn['egw_button_options']['e_mail_color']);?>;
}
#e_mail.egw_effect_2:hover span{
        -moz-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['e_mail_color']);?>;
        -webkit-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['e_mail_color']);?>;
        box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['e_mail_color']);?>;
}
#e_mail.egw_effect_7:hover{
	color:<?php echo $btn['egw_button_options']['e_mail_color'];?>!important;
}
#e_mail.item_1,#e_mail.item_2,#e_mail.item_3{
	background:<?php echo $btn['egw_button_options']['e_mail_color'];?>;
}
<?php endif;?>
<?php if($btn['egw_button_options']['print']!=""):?>
#print.item_4,#print.item_5,#print.item_6{
        -webkit-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['print_color'];?>; 
        -moz-box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['print_color'];?>;
        box-shadow: 0px 0px 0px 2px <?php echo $btn['egw_button_options']['print_color'];?>;
       background:<?php echo $btn['egw_button_options']['print_color'];?>
}
#print:hover span{
	 background:<?php echo hex2RGB($btn['egw_button_options']['print_color']);?>;
}
#print.egw_effect_2:hover span{
        -moz-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['print_color']);?>;
        -webkit-box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['print_color']);?>;
        box-shadow: inset 0px 0px 0px 19px <?php echo hex2RGB($btn['egw_button_options']['print_color']);?>;
}
#print.egw_effect_7:hover{
	color:<?php echo $btn['egw_button_options']['print_color'];?>!important;
}
#print.item_1,#print.item_2,#print.item_3{
	background:<?php echo $btn['egw_button_options']['print_color'];?>;
}
<?php endif;?>

<?php
function hex2RGB($hexStr, $seperator = ',') {
    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
    $rgbArray = array();
    if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
        $colorVal = hexdec($hexStr);
        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        $rgbArray['blue'] = 0xFF & $colorVal;
    } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
    } else {
        return false; //Invalid hex color code
    }
    $rgbArray['red']=$rgbArray['red']-70;
	 $rgbArray['green']=$rgbArray['green']-70;
	  $rgbArray['blue']=$rgbArray['blue']-70;
	return "rgb(".implode($seperator, $rgbArray).")" ; 
}

?>
