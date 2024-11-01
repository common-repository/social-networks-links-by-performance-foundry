=== Social Networks Links by Performance Foundry ===
Contributors: performancefoundry, ricardocorreia
Donate link: https://performancefoundry.com/
Tags: social networks, links, widget
Requires at least: 4.6
Tested up to: 5.6
Stable tag: 0.3.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Easily add any links to your social networks accounts to your website, using a widget, shortcode or adding a function to your template.

== Description ==

Easily add links to your social networks accounts to your website, using a widget, shortcode or adding a function to your template.

This plugin uses Font Awesome Icons to illustrate the social networks links, you can disable it completely and use your own icons adding a custom class to the link or disable font awesome loading from the plugin if it already exists in your theme.

= Basic Usage =
**Widget**

* Go to Appearance->Widgets screen
* Add **Foundry Social Networks Links** to the desired Widget Area
* Set the widget title and check if you want to display the social network name along with it's icon

**Shortcode**

* Add the shortcode `[foundry_social_links display_name="false"]`
* Display Name parameter accepts two option `true` for displaying the social network name and `false` to hide it.

**Function**

* Add `foundry_the_social_networks( $display_name )` to echo the social networks HTML, you can set `$display_name` to `true` or `false`
* Add `foundry_get_social_networks()` to return an array of the available social networks and its settings

= Available Plugin Settings =

**General Settings**

* Enable/Disable the usage of Font Awesome Icons
* Enable/Disable the usage of Font Awesome 5 Icons (using external stylesheet) - FA5 library is not included in the plugin, use this option if your theme or another plugins uses FA5.
* Enable/Disable the usage of plugin's own Font Awesome Stylesheet and font
* Enable/Disable the usage of plugin's own stylesheet
* Enable/Disable the links open in the same window

**Social Network Links Settings**

For each Social network you can configure:

* Name (Insert any text you want)
* Font Awesome Icon to show (Select a Font Awesome icon using a picker)
* Custom Class (Define a custom class for each social network)
* Color (Define the Background color for each link)
* URL (Define the URL for the social network)


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/foundry-social-networks-links` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->Social Links screen to configure your social network links and plugin settings.
4. Use one of the available methods ( Widget, Shortcode, function ) to display the link within your website.


== Frequently Asked Questions ==

= How many links can I setup? =

There's no limit to the number of social networks to display.

= Can I add a link to any social network? =

You can add any link you want and select from the full Font Awesome icon library a icon to illustrate it, if it doesn't exist you can define a custom class and add the icon to your theme CSS.

== Screenshots ==

1. Settings Screen Overview
2. Settings Screen Social Network Repeater

== Changelog ==
= 0.3.0 =
Adds Font Awesome 5 support using external stylesheets
Start opening links in a new window by default
Add option to allow opening links in the same window

= 0.2.2 =
Remove old CMB2 files
Fix SVN files

= 0.2.1 =
Update plugin banners and logo

= 0.2.0 =
Adds support to WordPress 5.6
Update CMB2 framework to latest stable verison
Fix WPCS and PHP warnings

= 0.1.1 =
Fix call to min stylesheet.

= 0.1.0 =
First public plugin release version.
