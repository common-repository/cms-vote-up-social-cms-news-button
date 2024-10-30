<?php
/*
Plugin Name: CMS Vote Up Social CMS News Button
Plugin URI: http://www.cmsvoteup.com
Description: A must have social CMS website news button for Wordpress user (blogger). This button will enable your visitor to vote for your website's article post up on CMSVoteUp community, which is made for online community & people to discover and share content from anywhere on the Internet, by submitting links and stories, and voting up and commenting on submitted links and stories. A great way to increase online popularity for your website and blog.
Version: 1.1
Author: Leon Wood
Author URI: CMSVoteUp.com
License:  http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/



define("cms_vote_up_social_news_button","1.0",false);

function cms_vote_up_social_news_button_url( $path = '' ) {
	global $wp_version;
	if ( version_compare( $wp_version, '2.8', '<' ) ) { // Using WordPress 2.7
		$folder = dirname( plugin_basename( __FILE__ ) );
		if ( '.' != $folder )
			$path = path_join( ltrim( $folder, '/' ), $path );

		return plugins_url( $path );
	}
	return plugins_url( $path, __FILE__ );
}

function activate_cms_vote_up_social_news_button() {
	global $cms_vote_up_social_news_button_options;
	$cms_vote_up_social_news_button_options = array('position_button'=>'after',
							   'style'=>'horizontal', 
							   'own_css'=>'float: right;');
	add_option('cms_vote_up_social_news_button_options',$cms_vote_up_social_news_button_options);
}	

global $cms_vote_up_social_news_button_options;	

$cms_vote_up_social_news_button_options = get_option('cms_vote_up_social_news_button_options');		
	  
register_activation_hook( __FILE__, 'activate_cms_vote_up_social_news_button' );

function add_cms_vote_up_social_news_button_automatic($content){ 
 global $cms_vote_up_social_news_button_options, $post;
 
 $p_title = get_the_title($post->ID);
 $voteUrl = get_permalink( $post->ID ).'&title='.str_replace(' ','+',$p_title).'&referenceUrl='.get_bloginfo( 'url' );
 $style = $cms_vote_up_social_news_button_options['style'];
 $own_css = $cms_vote_up_social_news_button_options['own_css'];

  switch($style){	
	case "sharecount_vertical":		
		$htmlCode .= "<div style=\"$own_css\">";
		$htmlCode .= "<script type=\"text/javascript\" src=\"http://cmsvoteup.com/socialbuttons/2/vote-up.js\"></script>\n";
		$htmlCode .= "</div>";		
		break;
	case "sharecount_horizontal":
		$htmlCode .= "<div style=\"$own_css\">";
		$htmlCode .= "<script type=\"text/javascript\" src=\"http://cmsvoteup.com/socialbuttons/1/vote-up.js\"></script>\n";
		$htmlCode .= "</div>";		
		break;
	}		
  
	$cms_vote_up_social_news_button = $htmlCode;
	if($cms_vote_up_social_news_button_options['position_button'] == 'before' ){
		$content = $cms_vote_up_social_news_button . $content;
	}
	else if($cms_vote_up_social_news_button_options['position_button'] == 'after' ){
		$content = $content . $cms_vote_up_social_news_button;
	} else  if($cms_vote_up_social_news_button_options['position_button'] == 'before_and_after' ){
		$content = $cms_vote_up_social_news_button. $content. $cms_vote_up_social_news_button;
	}
	return $content;
}

if ($cms_vote_up_social_news_button_options['position_button'] != 'manual'){
	add_filter('the_content','add_cms_vote_up_social_news_button_automatic'); 
}

function add_cms_vote_up_social_news_button(){
	global $cms_vote_up_social_news_button_options, $post;
	$p_title = get_the_title($post->ID);
 $voteUrl = get_permalink( $post->ID ).'&title='.str_replace(' ','+',$p_title).'&referenceUrl='.get_bloginfo( 'url' );
 $style = $cms_vote_up_social_news_button_options['style'];
 $own_css = $cms_vote_up_social_news_button_options['own_css'];

  switch($style){	
	case "sharecount_vertical":		
		$htmlCode .= "<div style=\"$own_css\">";
		$htmlCode .= "<script type=\"text/javascript\" src=\"http://cmsvoteup.com/socialbuttons/2/vote-up.js\"></script>\n";
		$htmlCode .= "</div>";		
		break;
	case "sharecount_horizontal":
		$htmlCode .= "<div style=\"$own_css\">";
		$htmlCode .= "<script type=\"text/javascript\" src=\"http://cmsvoteup.com/socialbuttons/1/vote-up.js\"></script>\n";
		$htmlCode .= "</div>";		
		break;
	}			
			
	$cms_vote_up_social_news_button = $htmlCode;

	echo $cms_vote_up_social_news_button;
}

// function for adding settings page to wp-admin
function cms_vote_up_social_news_button_settings() {
	add_options_page('CMS Vote Up Button', 'CMS Vote Up Button', 9, basename(__FILE__), 'cms_vote_up_social_news_button_options_form');
}

function cms_vote_up_social_news_button_options_form(){ 
	global $cms_vote_up_social_news_button_options;
?>

<div class="wrap">

<div id="poststuff" class="metabox-holder has-right-sidebar" style="float:right;width:30%;"> 
   <div id="side-info-column" class="inner-sidebar"> 
			<div class="postbox"> 
			  <h3 class="hndle"><span>About this Plugin:</span></h3> 
			  <div class="inside">
                <ul>
					<li><a href="http://www.cmsvoteup.com" title="Vote Up your Wordpress Website" >CMS Vote Up!</a></li>
					<li><a href="http://www.dontclickon.com" title="Follow all latest malware & scam in Facebook, Twitter & other social networks" >Dont Click On</a></li>
					<li><a href="http://community.cmsvoteup.com/download-2" title="Download other plugins from same author">Plugin Homepage</a></li>					
                </ul> 
              </div> 
			</div> 
     </div>
 </div> <!--end of poststuff --> 


<form method="post" action="options.php">

<?php settings_fields('cms_vote_up_social_news_button_options_group'); ?>

<h2>CMS Vote Up Social News Buttons Options</h2> 

<table class="form-table" style="clear:none;width:70%;">

<tr valign="top">
<th scope="row">Button Styles</th>
<td>
<select name="cms_vote_up_social_news_button_options[style]" id="style" >
	<option value="sharecount_vertical" <?php if ($cms_vote_up_social_news_button_options['style'] == "sharecount_vertical"){ echo "selected";}?> >ShareCount Vertical</option>
	<option value="sharecount_horizontal" <?php if ($cms_vote_up_social_news_button_options['style'] == "sharecount_horizontal"){ echo "selected";}?>>ShareCount Horizontal</option>	
</select>
</td>
</tr>

<tr valign="top">
<th scope="row">Where CMS Vote Up Button will be displayed:</th>
<td><select name="cms_vote_up_social_news_button_options[position_button]" id="position_button" >
<option value="before" <?php if ($cms_vote_up_social_news_button_options['position_button'] == "before"){ echo "selected";}?> >Before Content</option>
<option value="after" <?php if ($cms_vote_up_social_news_button_options['position_button'] == "after"){ echo "selected";}?> >After Content</option>
<option value="before_and_after" <?php if ($cms_vote_up_social_news_button_options['position_button'] == "before_and_after"){ echo "selected";}?> >Before and After</option>
<option value="manual" <?php if ($cms_vote_up_social_news_button_options['position_button'] == "manual"){ echo "selected";}?> >Manual Insertion</option>
</select><br/>
<b>Note:</b> &nbsp;You can also use this tag <code>add_cms_vote_up_social_news_button();</code> for manually insert button to any of your post item.
</td>
</tr>

<tr valign="top">
<th scope="row">Custom CSS for &lt;div&gt; (i.e. float: right;):</th>
<td><input id="own_css" name="cms_vote_up_social_news_button_options[own_css]" value="<?php echo $cms_vote_up_social_news_button_options['own_css']; ?>"></td>
</td>
</tr>


</table>

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

</form>

</div>
<?php }

// Hook for adding admin menus
if ( is_admin() ){ // admin actions
  add_action('admin_menu', 'cms_vote_up_social_news_button_settings');
  add_action( 'admin_init', 'register_cms_vote_up_social_news_button_settings' ); 
} 
function register_cms_vote_up_social_news_button_settings() { // whitelist options
  register_setting( 'cms_vote_up_social_news_button_options_group', 'cms_vote_up_social_news_button_options' );
}

?>