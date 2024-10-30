<?php
/*
Plugin Name: Bit.ly shared links
Plugin URI: http://onlinevortex.com/projects/bitly-share-links/
Description: Automatically creates a bit.ly link for your posts and pages.
Version: 0.9.2
Author: Carlos Mendoza
Author URI: http://onlinevortex.com/

Copyright 2009 Carlos Mendoza (cmendoza@onlinevortex.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

// register options
add_action('admin_init', 'bitlypostlinks_options_init' );
function bitlypostlinks_options_init(){
    register_setting( 'bitlypostlinks_options', 'bitlypostlinks' );
}

/**
 * Add the bitlypostlinks menu to the Settings menu
 */
function bitlypostlinks_admin_menu() {
	add_options_page('Bit.ly Shared links', 'Bit.ly Shared links', 8, 'Bit.ly_postlinks', 'bitlypostlinks_submenu');
}
add_action('admin_menu', 'bitlypostlinks_admin_menu');

function bitlypostlinks_submenu() {
?>
<form method="post" action="options.php">
<?php settings_fields('bitlypostlinks_options'); ?>
<?php
$bitlypostlinksoptions = get_option('bitlypostlinks');
//code to update the options for users of the previous version
$bitlypostlinks_bitly_key = get_option('bitlypostlinks_bitly_key');
if ($bitlypostlinks_bitly_key) {
    $bitlypostlinksoptions['bitly_key'] = $bitlypostlinks_bitly_key;
    delete_option('bitlypostlinks_bitly_key');
}
$bitlypostlinks_bitly_login = get_option('bitlypostlinks_bitly_login');
if ($bitlypostlinks_bitly_login) {
    $bitlypostlinksoptions['bitly_login'] = $bitlypostlinks_bitly_login;
    delete_option('bitlypostlinks_bitly_login');
}
$bitlypostlinks_sharelinks = get_option('bitlypostlinks_sharelinks');
if ($bitlypostlinks_sharelinks) {
    $bitlypostlinksoptions['sharelinks'] = $bitlypostlinks_sharelinks;
    delete_option('bitlypostlinks_sharelinks');
}
$bitlypostlinks_targetblank = get_option('bitlypostlinks_targetblank');
if ($bitlypostlinks_targetblank) {
    $bitlypostlinksoptions['targetblank'] = $bitlypostlinks_targetblank;
    delete_option('bitlypostlinks_targetblank');
}
$bitlypostlinks_sharelink_url = get_option('bitlypostlinks_sharelink_url');
if ($bitlypostlinks_targetblank) {
    $bitlypostlinksoptions['sharelink_url'] = $bitlypostlinks_sharelink_url;
    delete_option('bitlypostlinks_sharelink_url');
}
?>

<div class="wrap">
	<?php screen_icon(); ?>
	<h2><?php _e("Bit.ly Shared Links Options", 'bitlypostlinks'); ?></h2>
	<table class="form-table">
	<tr>
		<th scope="row" valign="top">
			<?php _e("Bit.ly API data", "bitlypostlinks"); ?>
		</th>
		<td>
			<?php _e("Enter your login and API key in the fields below.", 'bitlypostlinks'); ?><br/>
			<?php _e("You can find your API key in <a href=\"http://bit.ly/account/\" target=\"_blank\">your Bit.ly account page</a>.", 'bitlypostlinks'); ?><br/>
                        <label for="bitly_login">Login :</label><input size="25" type="text" name="bitlypostlinks[bitly_login]" value="<?php echo attribute_escape(stripslashes($bitlypostlinksoptions['bitly_login'])); ?>" /><br/>
                        <label for="bitly_key">API key :</label><input size="40" type="text" name="bitlypostlinks[bitly_key]" value="<?php echo attribute_escape(stripslashes($bitlypostlinksoptions['bitly_key'])); ?>" />
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top">
			<?php _e("Display links to share?", "bitlypostlinks"); ?>
		</th>
		<td>
			<?php _e("You can choose to display links to share your content in the common social networks.", 'bitlypostlinks'); ?><br/>
			<input type="checkbox" name="bitlypostlinks[replaceshortlink]" <?php checked('on', $bitlypostlinksoptions['replaceshortlink'] ); ?> /> <?php _e("Add rel=\"shortlink\" tag? ( <a href=\"http://microformats.org/wiki/rel-shortlink\" target=\"_blank\">more info</a> )", "bitlypostlinks"); ?><br/>
			<input type="checkbox" name="bitlypostlinks[sharelinks]" <?php checked('on', $bitlypostlinksoptions['sharelinks'] ); ?> /> <?php _e("Display links to share? (enable this to include short URLs when the sociable plugin is active)", "bitlypostlinks"); ?><br/>
                        <input type="checkbox" name="bitlypostlinks[targetblank]" <?php checked('on', $bitlypostlinksoptions['targetblank'] ); ?> /> <?php _e("Use <code>target=_blank</code> on links? (Forces links to open a new window)", "bitlypostlinks"); ?><br/>
                        <input type="radio" name="bitlypostlinks[sharelink_url]" value="bit.ly" <?php checked( $bitlypostlinksoptions['sharelink_url'], 'bit.ly', true ); ?> /> <?php _e("use bit.ly", "bitlypostlinks"); ?><br/>
			<input type="radio" name="bitlypostlinks[sharelink_url]" value="j.mp" <?php checked( $bitlypostlinksoptions['sharelink_url'], 'j.mp', true ); ?> /> <?php _e("use j.mp", "bitlypostlinks"); ?><br/>
			
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<span class="submit"><input name="save" value="<?php _e("Save Changes", 'bitlypostlinks'); ?>" type="submit" /></span>
		</td>
	</tr>
</table>

<h2><?php _e('Do you like this plugin?','bitlypostlinks'); ?></h2>
<p><?php // _e('Why not do any of the following:','bitlypostlinks'); ?></p>
<ul class="bitlypostlinks_menu">
	<li><?php _e('Link to it so other Wordpress users can find out about it.','bitlypostlinks'); ?></li>
	<li><?php _e('<a href="http://wordpress.org/extend/plugins/bitly-shared-links/">Give it a good rating</a> on WordPress.org.','bitlypostlinks'); ?></li>
	<li><?php _e('<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8245725">Donate a token of your appreciation</a>.','bitlypostlinks'); ?></li>
</ul>
<h2><?php _e('Need support?','bitlypostlinks'); ?></h2>
<p><?php _e('If you have any problems or good ideas, please send an email to <a mailto="plugins@onlinevortex.com">plugins@onlinevortex.com</a>.', 'bitlypostlinks'); ?></p>

<h2><?php _e('Credits','bitlypostlinks'); ?></h2>
<p><?php _e('<a href="http://onlinevortex.com/projects/bitly-shared-links/">Bitly shared links</a> was developed by <a href="http://bitmapped.onlinevortex.com/">Carlos Mendoza</a>. It\'s released under the GNU GPL version 2.','bitlypostlinks'); ?></p>


</div>
</form>
<?php
}


/**
 * Update message, used in the admin panel to show messages to users.
 */
function bitlypostlinks_message($message) {
	echo "<div id=\"message\" class=\"updated fade\"><p>$message</p></div>\n";
}

/**
 * Displays a checkbox that allows users to disable the links on a
 * per post or page basis.
 */
function bitlypostlinks_meta() {
	global $post;
	$bitlypostlinksoff = false;
	if (get_post_meta($post->ID,'_bitlypostlinksoff',true)) {
		$bitlypostlinksoff = true;
	}
	?>
        <p>Checking this will disable the share of links.</p>
	<label for="bitlypostlinksoff"><?php _e('Disable Bit.ly shared links? ','bitlypostlinks') ?></label><input type="checkbox" id="bitlypostlinksoff" name="bitlypostlinksoff" <?php checked($bitlypostlinksoff); ?>/>
	<?php
}

/**
 * Add the checkbox defined above to post and page edit screens.
 */
function bitlypostlinks_meta_box() {
	add_meta_box('bitlypostlinks','Bit.ly shared links','bitlypostlinks_meta','post','side');
	add_meta_box('bitlypostlinks','Bit.ly shared links','bitlypostlinks_meta','page','side');
}
add_action('admin_menu', 'bitlypostlinks_meta_box');

/**
 * Displays a checkbox that allows users to disable the links on a
 * per post or page basis.
 */
function bitlypostlink_stats_meta() {
	global $post;
	$bitlypostlink4stats = false;
	if ($bitly_hash = get_post_meta($post->ID,'_bitly_link',true)) {
            $bitlypostlink4stats = true;
	    $bitlypostlinksoptions = get_option('bitlypostlinks');
            $bitly_username = trim(attribute_escape(stripslashes($bitlypostlinksoptions['bitly_login'])));
            $bitly_key = trim(attribute_escape(stripslashes($bitlypostlinksoptions['bitly_key'])));
            $urlBitly = 'http://api.bit.ly/stats?version=2.0.1&login='.$bitly_username.'&apiKey='.$bitly_key.'&hash='.$bitly_hash;
            $output = file_get_contents($urlBitly);
            $json = json_decode($output, true);
            if ($json && $json['errorCode'] == '0') {
                $new_url = $json['results'][$permalink]['userHash'];
                echo "Total Clicks : ".$json['results']['clicks'];
                echo "<br/>User Clicks : ".$json['results']['userClicks'];
            }
            echo "<br/><a href=\"http://bit.ly/".$bitly_hash."+\" target=\"_blank\">View the stats at Bit.ly</a>";
	} else {
            ?>
            <p>No stats for this link yet.</p>
            <?php
        }
}

/**
 * Add the checkbox defined above to post and page edit screens.
 */
function bitlypostlinks_stats_meta_box() {
	add_meta_box('bitlypostlinkstats','Bit.ly link quick stats','bitlypostlink_stats_meta','post','side');
	add_meta_box('bitlypostlinkstats','Bit.ly link quick stats','bitlypostlink_stats_meta','page','side');
}
add_action('admin_menu', 'bitlypostlinks_stats_meta_box');

/**
 * set the option for the links off setting.
 */
function bitlypostlinks_insert_post($post_ID) {
    if (!$bitly_hash = get_post_meta($post_ID,'_bitly_link',true)) {
	$bitlypostlinksoptions = get_option('bitlypostlinks');
        $bitly_username = trim(attribute_escape(stripslashes($bitlypostlinksoptions['bitly_login'])));
        $bitly_key = trim(attribute_escape(stripslashes($bitlypostlinksoptions['bitly_key'])));
        $permalink = get_permalink($post_ID);
        $urlBitly = 'http://api.bit.ly/shorten?version=2.0.1&login='.$bitly_username.'&apiKey='.$bitly_key.'&longUrl='.$permalink;
        $output = file_get_contents($urlBitly);
        $json = json_decode($output, true);
        if ($json && $json['errorCode'] == '0') {
            $new_url = $json['results'][$permalink]['userHash'];
            update_post_meta($post_ID, '_bitly_link', $new_url);
        }
    }
    if (isset($_POST['bitlypostlinksoff'])) {
            if (!get_post_meta($post_ID,'_bitlypostlinksoff',true))
                    add_post_meta($post_ID, '_bitlypostlinksoff', true, true);
    } else {
            if (get_post_meta($post_ID,'_bitlypostlinksoff',true))
                    delete_post_meta($post_ID, '_bitlypostlinksoff');
    }
}
add_action('publish_post', 'bitlypostlinks_insert_post');


function bitlypostlinks_admin_warnings() {
//	global $bitlypostlinks_api_key;
	$bitlypostlinksoptions = get_option('bitlypostlinks');

	if ( !$bitlypostlinksoptions['bitly_key'] && !isset($_POST['submit']) ) {
		function bitlykey_warning() {
			echo "
			<div id='bitlykey-warning' class='updated fade'><p><strong>".__('Bit.ly post links plugin is almost ready.')."</strong> ".sprintf(__('You must <a href="%1$s">enter your Bit.ly API key</a> for it to work.'), "options-general.php?page=Bit.ly_postlinks")."</p></div>
			";
		}
		add_action('admin_notices', 'bitlykey_warning');
		return;
	}
}

function bitly_modify_link($link = '') {
    global $post;
    $bitly_hash = get_post_meta($post->ID,'_bitly_link',true);
    $bitlypostlinksoptions = get_option('bitlypostlinks');
    $bitly_url = $bitlypostlinksoptions['sharelink_url'];
    $share_url  = urlencode("http://".$bitly_url."/".$bitly_hash);
    $permalink = urlencode(get_permalink($post->ID));
    if ($bitly_hash) {
        $link = str_replace($permalink, $share_url, $link);
    }
    return $link;
}

$display_bitlylinks = get_option('bitlypostlinks');

if ($display_bitlylinks['sharelinks'] == 'on') {
        add_filter('the_content', 'bitlylinks_display');
	function bitlylinks_display($content='') {
            global $post;
            $display_bitlylinks = get_post_meta($post->ID,'_bitlypostlinksoff',true);
            if (!get_post_meta($post->ID,'_bitlypostlinksoff',true)) {
                if (function_exists('sociable_html')) {
                    add_filter('sociable_link', 'bitly_modify_link');
                    return $content;
                } else {
                    $bitly_links_html = bitlylinks_html();
                    $content .= $bitly_links_html . "<br/><br/>";
                    return $content;
                }
            }
            return $content;
	}
}

bitlypostlinks_admin_warnings();

/**
 * array containing the sites that the plugin supports
 */
$sites = Array(

	'Facebook' => Array(
                'sitename'  => 'Facebook',
		'favicon' => 'facebook.png',
		'url' => 'http://www.facebook.com/share.php?u=PERMALINK&amp;t=TITLE',
	),

	'FriendFeed' => Array(
                'sitename' => 'Friendfeed',
		'favicon' => 'friendfeed.png',
		'url' => 'http://www.friendfeed.com/share?title=TITLE&amp;link=PERMALINK',
	),

	'Posterous' => Array(
                'sitename' => 'Posterous',
		'favicon' => 'posterous.png',
		'url' => 'http://posterous.com/share?linkto=PERMALINK&amp;title=TITLE&amp;selection=EXCERPT',
	),

	'Tumblr' => Array(
                'sitename' => 'Tumblr',
		'favicon' => 'tumblr.png',
		'url' => 'http://www.tumblr.com/share?v=3&amp;u=PERMALINK&amp;t=TITLE&amp;s=EXCERPT',
	),

	'Twitter' => Array(
                'sitename' => 'Twitter',
		'favicon' => 'twitter.png',
		'url' => 'http://twitter.com/home?status=TITLE%20-%20PERMALINK',
	),

);

function bitlylinks_html() {
	global $sites, $wp_query, $post;

	if (get_post_meta($post->ID,'_bitlypostlinksoff',true)) {
		return "";
	}

        $bitly_hash = get_post_meta($post->ID,'_bitly_link',true);
        if (empty($bitly_hash))
            return "";
	$bitlypostlinksoptions = get_option('bitlypostlinks');
        $bitly_url  = $bitlypostlinksoptions['sharelink_url'];
        $share_url  = urlencode("http://".$bitly_url."/".$bitly_hash);
	$title 		= str_replace('+','%20',urlencode($post->post_title));

        $html = "\n<div class=\"bitly_links\">\n";
        $html .= "<div class=\"bitly_linkstext\">\n";
	$html .= "Share this on : ";
	$html .= "\n</div>";
	$html .= "\n<ul>\n";

	$i = 0;
	$totalsites = count($sites);
	foreach($sites as $sitename) {
		$site = $sitename[0];

		$url = $sitename['url'];
		$url = str_replace('TITLE', $title, $url);
		$url = str_replace('RSS', $rss, $url);
		$url = str_replace('BLOGNAME', $blogname, $url);
		$url = str_replace('EXCERPT', $excerpt, $url);
		$url = str_replace('FEEDLINK', $blogrss, $url);

		if (isset($sitename['description']) && $sitename['description'] != "") {
			$description = $sitename['description'];
		} else {
			$description = $sitename['sitename'];
		}

		$url = str_replace('PERMALINK', $share_url, $url);

		if ($i == 0) {
			$link = '<li class="bitly_linksfirst">';
		} else if ($totalsites == ($i+1)) {
			$link = '<li class="bitly_linkslast">';
		} else {
			$link = '<li>';
		}

		/**
		 * Start building the link, nofollow it to make sure Search engines don't follow it,
		 * and optionally add target=_blank to open in a new window if that option is set in the
		 * backend.
		 */
		$link .= '<a rel="nofollow"';
		$link .= ' id="'.esc_attr(strtolower($sitename['sitename'])).'"';
		$targetblank = get_option('bitlypostlinksoptions');
		if ($targetblank['targetblank']== 'on') {
			$link .= " target=\"_blank\"";
		}
		$link .= " href=\"javascript:window.location='".urlencode($url)."';\" title=\"$description\">";

		$link .= $description;
		$link .= "</a></li>";

		$html .= "\t".$link."\n";
		$i++;
	}

	$html .= "</ul>\n</div>\n";

	return $html;
}

/*
 * Shortlink rel stuff
 */
function get_shortlink( $post_id, $force_numeric = false ) {
	if (get_post_meta($post_id,'_bitlypostlinksoff',true)) {
		return "";
	}

        $bitly_hash = get_post_meta($post_id,'_bitly_link',true);
        if (empty($bitly_hash))
            return "";
	$bitlypostlinksoptions = get_option('bitlypostlinks');
        $bitly_url  = $bitlypostlinksoptions['sharelink_url'];
        $short_link  = "http://".$bitly_url."/".$bitly_hash;

        return $short_link;
}

function replace_shortlink_wp_head() {
	global $wp_query;

	if ( ! ( is_singular() || is_front_page() ) )
		return;

	if (get_post_meta($wp_query->get_queried_object_id(),'_bitlypostlinksoff',true)) {
		return;
	}

        $bitly_hash = get_post_meta($wp_query->get_queried_object_id(),'_bitly_link',true);
        if (empty($bitly_hash))
            return;
	$bitlypostlinksoptions = get_option('bitlypostlinks');
        $bitly_url  = $bitlypostlinksoptions['sharelink_url'];
        $short_link  = "http://".$bitly_url."/".$bitly_hash;
	echo '<link rel="shortlink" href="' . $short_link . '" />';
}

function replace_shortlink_header() {
	global $wp_query;

	if ( headers_sent() )
		return;

	if ( ! ( is_singular() || is_front_page() ) )
		return;

	if (get_post_meta($wp_query->get_queried_object_id(),'_bitlypostlinksoff',true)) {
		return;
	}

        $bitly_hash = get_post_meta($wp_query->get_queried_object_id(),'_bitly_link',true);
        if (empty($bitly_hash))
            return;
	$bitlypostlinksoptions = get_option('bitlypostlinks');
        $bitly_url  = $bitlypostlinksoptions['sharelink_url'];
        $short_link  = "http://".$bitly_url."/".$bitly_hash;
	header('Link: <' . $short_link . '>; rel=shortlink');
}

//remove actions from wp stats plugin (http://wp.me/*)
remove_action('wp_head', 'shortlink_wp_head', 99);
remove_action('wp', 'shortlink_header', 99);

if ($display_bitlylinks['replaceshortlink'] == 'on') {
  add_action('wp_head', 'replace_shortlink_wp_head', 99);
  add_action('wp', 'replace_shortlink_header', 99);
}
?>
