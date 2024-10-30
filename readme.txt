=== Bitly shared links ===
Contributors: carlosmendoza
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8245725
Tags: social bookmarks, social bookmarking, social, bookmarks, bookmarking, share, short url, statistics
Requires at least: 2.8.x
Tested up to: 2.9.2
Stable tag: 0.9.2

Bitly shared links generates a short url using bit.ly or j.mp to share your posts in social networks.

== Description ==

Automatically generates a short url using your account at [bit.ly](http://bit.ly) and insert links to share it at the bottom of your
posts and pages, you can also disable the links to appear in specific posts/pages.

On each post page in the backend, you can also keep track of the clicks for each post with a link to extended statistics
in the [bit.ly](http://bit.ly) page.

If you have the sociable plugin activated, this plugin will replace the default link with the short url automatically.

== Installation ==

* Upload the file and extract it in the `/wp-content/plugins/` directory
* Activate the plugin through the 'Plugins' menu in WordPress
* Go to Settings -> Bit.ly share links and enter your bit.ly login and API key
* Select of the links should be added at the bottom of each post and if the links should open a new page
* Save the changes, now each time you create a new post the short link will be created automatically

== Frequently Asked Questions ==

= My posts created before installing this plugin do not have short url =

Edit the post and update it, the plugin will create the short url if it is missing.

= How can I use the short url in other places? =

The short url hash is stored in a custom field, if you want to display it in a custom place in your template you can
retrieve it with `<?php echo get_post_meta($post->ID,'_bitly_link',true); ?>`

== Screenshots ==

1. Bit.ly share links options page
2. Post page with options and statistics for the short link

== Changelog ==

= 0.9.2 =
* Changed variable name (small typo)

= 0.9.1 =
* Changed function call to request short link from bitly only when the post is published

= 0.9 =
* Fixed bug in the options page
* Added rel="shortlink" tag support

= 0.8 =
* Initial release of the plugin.

== Upgrade Notice ==

= 0.9.2 =
Fixed issue when the short link was requested on post autosave. Now the shortlink is requested only when the post is published.
