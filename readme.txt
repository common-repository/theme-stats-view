=== Theme Stats View ===
Contributors: Katsushi Kawamori
Donate link: https://shop.riverforest-wp.info/donate/
Tags:  block, Thems, themes, Stats, stats
Requires at least: 4.7
Requires PHP: 8.0
Tested up to: 6.6
Stable tag: 2.03
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The stats of theme is displayed by block or shortcode.

== Description ==

The stats of theme is displayed by block or shortcode.

* Sibling plugin -> [Plugin Stats View](https://wordpress.org/plugins/plugin-stats-view/).

= How it works =
[youtube https://youtu.be/hrjUy621WT4]

== Installation ==

1. Upload `theme-stats-view` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

How to use

= Shortcode =

Please add new Page. Please write a short code.

Examples for single theme
[tsview slug="twentytwenty"]
[tsview slug="twentytwenty" view="simple" link="https://test.com/%slug%/"]

* slug		Specifies the theme slug.
* view		View style. Choose normal(Standard display), card(Card display) or simple(Simple display). Default: view="normal"
* link		You can specify the link destination of the theme name. If not specified, this is the theme homepage link. Can insert a slug tag in the URL of the link. Default: link=null Tag: %slug%
* open		Description & Tags style for normal view. Select true(View Description & Tags) or false(Hide Description & Tags). Default: open=false

Examples for multi themes
[taview slug="twentytwenty,twentynineteen,twentyseventeen"]
[taview slug="twentytwenty,twentynineteen,twentyseventeen" link="https://test.com/%slug%/"]
* slug		Specify the slugs of multiple themes separated by a comma.
* link		You can specify the link destination of the theme name. If not specified, this is the theme homepage link. Can insert a slug tag in the URL of the link. Default: link=null Tag: %slug%
* totalonly Total graph only. Select true(View Total only) or false(View Full). Default: totalonly=false

= WP-CLI =

Can delete and regenerate the cache with the following WP-CLI command. It would be beneficial to register it with the server's cron.
* `wp tsview_refresh`

== Frequently Asked Questions ==

none

== Screenshots ==

1. Screen image for single theme
2. Mobile screen image for single theme
3. Block for single theme
4. Shortcode for single theme
5. Screen image for multi themes
6. Block for multi themes
7. Shortcode for multi themes
8. Settings

== Changelog ==

= [2.03] 2024/06/10 =
* Fix - Issues with getting site information for WP-CLI.

= [2.02] 2024/06/02 =
* Fix - Issues with getting site information for WP-CLI.
* Added - The user agent for retrieving site information was set to "Theme Stats View; %url%" for WP-CLI.
* Fix - The number of redirects for site information getting was reduced from 5 to 0 for WP-CLI.

= [2.01] 2024/05/27 =
* Fix - active installs count for multi plugins.
* Fix - Download count for multi plugins.

= [2.00] 2024/05/27 =
* Added - Customization by template files.

= [1.13] 2024/05/18 =
* Added - WP-CLI command to delete and regenerate caches.
* Added - Uninstall script.

= [1.12] 2024/05/15 =
* Fix - Change in the way css are loaded.
* Added - totalonly attribute.

= 1.11 =
Rebuilt blocks.

= 1.10 =
Rebuilt blocks.

= 1.09 =
Supported WordPress 6.4.
PHP 8.0 is now required.

= 1.08 =
Added escaping process.

= 1.07 =
Supported WordPress 6.1.

= 1.06 =
Supported WordPress 6.0.

= 1.05 =
Rebuilt blocks.

= 1.04 =
Supported WordPress 5.6.

= 1.03 =
Added card display.

= 1.02 =
Fixed problem of mobile display.

= 1.01 =
Added multi themes view.
Can insert a slug tag in the URL of the link.
The total number of reviews can be displayed.

= 1.00 =
Initial release.

== Upgrade Notice ==

= 1.00 =

